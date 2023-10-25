# Implementing Refresh Token strategy

Refresh token strategy is used when the application has a token with a short expiration period (generally until 1 day) and we need a refresh token with a longer expiration period (generally 7 until 15 days) to revalidate the original token and maintain the user able to consume application features.

## Refresh token flow

1 - After first authentication, user send the request with the token within the header.
2 - Back-end validates if the request contains a valid token or not.
3 - Front-end intercepts the back-end response returning if there is error or not based on the back-end validation. Here we need to distinguish between if the error type, if it's an invalid token or another back-end validation error.
4 - If the error is about invalid token, we need to put the user request inside a request queue getting the current user invalid token there was stored into user device sending it to a back-end route that will return a new updated valid token.
5 - After the new valid token was returned by back-end, we need intercept all new requests informing the new token.
6 - Now we need to process each request that was queued with the new token.
7 - If something went wrong into this process, we need to sign user out forcing him to sign in again.

[image](https://i.ibb.co/bsLtZYf/Screenshot-2023-10-23-at-06-32-19.png)

## Code implementation

The expected code implementation result is automatically generate a new token when the old one is invalid without sign user out while the refresh_token is valid. User must be signed out only if the refresh_token is valid or something went wrong during this process.

ApiService.ts file:
```typescript
import {
  storageAuthTokenGet
} from "@storage/storageAuth";
import { AppError } from "@utils/AppError";
import axios, { AxiosError, AxiosInstance } from "axios";

type SignOut = () => void;

type APIInstanceProps = AxiosInstance & {
  registerInterceptTokenManager: (signOut: SignOut) => () => void;
};

type PromiseType = {
  onSuccess: (token: string) => void;
  onFailed: (error: AxiosError) => void;
};

const api = axios.create({
  baseURL: "http://192.168.2.170:3333",
}) as APIInstanceProps;

let failedRequestsQueue: PromiseType[] = [];
let isRefreshing = false;

// registerInterceptTokenManager WAS CREATED TO API HAVE ACCESS TO THE CONTEXT SIGN OUT FUNCTION RECEIVING SIGN OUT FUNCTION AS PARAM  TO BE CALLED INSIDE THE APPLICATION CONTEXT

api.registerInterceptTokenManager = (signOut) => {
  const intercepTokenManager = api.interceptors.response.use(
    (response) => response,
    async (requestError) => {
        //CHECK IF THE ERROR IS RELATED TO TOKEN VALIDATION
      if (requestError?.response?.status === 401) {
        if (
          requestError.response?.data?.message === "token.expired" ||
          requestError.response?.data?.message === "token.invalid"
        ) {
          //GENERATES NEW TOKEN IF THE TOKEN WAS EXPIRED IF THERE IS AN AVAILABLE REFRESH TOKEN
          const { refresh_token } = await storageAuthTokenGet();
          if (!refresh_token) {
            signOut();
            return Promise.reject(requestError);
          }

          const originalRequest = requestError.config;

          //ADD REQUESTS TO REQUESTS QUEUE WHILE TOKEN IS NOT UPDATED
          if (isRefreshing) {
            return new Promise((resolve, reject) => {
              failedRequestsQueue.push({
                onSuccess: (token: string) => {
                  originalRequest.headers = {
                    Authorization: `Bearer ${token}`,
                  };
                },
                onFailed: (error: AxiosError) => {
                  reject(error);
                },
              });
            });
          }

          isRefreshing = true;

          //RETRIEVING A NEW TOKEN
          return new Promise(async (resolve, reject) => {
            try {
              const { data } = await api.post("/sessions/refresh-token", {
                refresh_token,
              });

              //UPDATE THE QUEUED REQUESTS WITH THE NEW TOKEN
              if (originalRequest.data) {
                originalRequest.data = JSON.parse(originalRequest.data);
              }

              originalRequest.headers = {
                Authorization: `Bearer ${data.token}`,
              };
              api.defaults.headers.common[
                "Authorization"
              ] = `Bearer ${data.token}`;

              failedRequestsQueue.forEach((request) => {
                request.onSuccess(data.token);
              });

              resolve(api(originalRequest));
            } catch (error: any) {
              //FAILS ALL REQUEST IF TOKEN IS NOT VALID
              failedRequestsQueue.forEach((request) => {
                request.onFailed(error);
              });
              //SING USER OUT IF THE ERROR IS NOT RELATED TO TOKEN
              signOut();
              reject(error);
            } finally {
              isRefreshing = false;
            }
          });
        }
      }
      //RETURNS DIFFERENT MESSAGES BASED ON THE TYPE OF ERROR RETURNED BY THE SERVER (NOT RELATED TOKEN ERRORS
      //THE SERVER CAN RETURN GENERIC OU SPECIFICS MESSAGE ERRORS
      if (requestError.response && requestError.response.data) {
        return Promise.reject(new AppError(requestError.response.data.message));
      } else {
        return Promise.reject(new AppError(requestError));
      }
    }
  );
  //MUST EJECT/CLEAN THE INTERCEPTOR AFTER THE INTERCEPTION
  return () => {
    api.interceptors.response.eject(intercepTokenManager);
  };
};

export { api };
```

AuthContext.ts
```typescript
import { UserDTO } from '@dtos/UserDto';
import { api } from '@services/api';
import { storageAuthTokenGet, storageAuthTokenRemove, storageAuthTokenSave } from '@storage/storageAuth';
import { ReactNode, createContext, useEffect, useState } from 'react';
import { storageGetUser, storageRemoveUser, storageSaveUser } from '../storage/storageUser';

export type AuthContextProps = {
    user: UserDTO;
    signIn: (email: string, password: string) => Promise<void>;
    updateUserProfile: (userUpdated: UserDTO) => Promise<void>;
    signOut: () => Promise<void>;
    isStorageLoadingUserData: boolean;
}

type AuthContextProvider = {
    children: ReactNode
}


export const AuthContext = createContext<AuthContextProps>({} as AuthContextProps)

export function AuthContextProvider({ children }: AuthContextProvider) {

    const [user, setUser] = useState<UserDTO>({} as UserDTO)
    const [isStorageLoadingUserData, setIsStorageLoadingUserData] = useState(false)

    async function userAndTokenUpdate(userData: UserDTO, token: string) {
        // SETTING THE TOKEN OF AUTHENTICATE USER IN ALL REQUESTS
        api.defaults.headers.common['Authorization'] = `Bearer ${token}`
        setUser(userData)
    }

    async function storageUserAndTokenSave(userData: UserDTO, token: string, refresh_token: string) {
        try {
            setIsStorageLoadingUserData(true)
            await storageSaveUser(userData)
            await storageAuthTokenSave({ token, refresh_token });
        } catch (error) {
            throw error
        } finally {
            setIsStorageLoadingUserData(false)
        }
    }

    async function signIn(email: string, password: string) {
        try {
            setIsStorageLoadingUserData(true);
            const { data } = await api.post('/sessions', { email, password })

            if (data.user && data.token && data.refresh_token) {
                await storageUserAndTokenSave(data.user, data.token, data.refresh_token)
                userAndTokenUpdate(data.user, data.token)
            }
        } catch (error) {
            throw error
        } finally {
            setIsStorageLoadingUserData(false);
        }
    }

    async function loadUserData() {
        setIsStorageLoadingUserData(true)
        try {
            const userData = await storageGetUser()
            const { token } = await storageAuthTokenGet()
            if (token && userData) {
                userAndTokenUpdate(userData, token)
            }
        } catch (error) {
            throw error
        } finally {
            setIsStorageLoadingUserData(false)
        }
    }

    async function updateUserProfile(userUpdated: UserDTO) {
        try {
            setUser(userUpdated);
            await storageSaveUser(userUpdated);
        } catch (error) {
            throw error;
        }
    }

    async function signOut() {
        setIsStorageLoadingUserData(true)
        try {
            await storageRemoveUser()
                .then(() => {
                    setUser({} as UserDTO)
                })
            await storageAuthTokenRemove()
        } catch (error) {
            throw error
        } finally {
            setIsStorageLoadingUserData(false)
        }
    }

    useEffect(() => {
        loadUserData()
    }, [])


    useEffect(() => {
        //HERE registerInterceptTokenManager IS CALLED TO MANAGER TOKEN WHEN signOut FUNCTION IS CALLED
        const subscriber = api.registerInterceptTokenManager(signOut)
        //CLEANING subscriber function
        return () => {
            subscriber()
        }
    }, [signOut])


    return (
        <AuthContext.Provider value={{
            user,
            signIn,
            isStorageLoadingUserData,
            updateUserProfile,
            signOut
        }}>
            {children}
        </AuthContext.Provider>
    )
}
```

