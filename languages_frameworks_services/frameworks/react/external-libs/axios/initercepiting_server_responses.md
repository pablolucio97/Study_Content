# Intercepting Server Responses

The server your application is consuming data from can return **specific** or **generic** error messages.  
You can use **Axios interceptors** together with an `AppError` class to intercept the error response from the back-end,  
returning a specific message for known errors and a generic message for other treated errors.

---

## Example

```typescript
import { useAuthenticationStore } from "@/store/auth";
import { showAlertError } from "@/utils/alerts";
import axios, {
  AxiosError,
  AxiosResponse,
  InternalAxiosRequestConfig,
} from "axios";

export const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASEURL,
});

export interface IApiSuccessResponse<T> {
  RES: T;
  STATUS: number;
}

export interface IApiErrorResponse {
  RES: any;
  MSG: {
    message: string;
    error: string;
  };
  SUCCESS: boolean;
  TIMESTAMP: string;
  PATH: string;
  STATUS: number;
}

api.interceptors.request.use((config: InternalAxiosRequestConfig) => {
  const { user } = useAuthenticationStore.getState();
  const token = user?.token;

  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  if (import.meta.env.DEV) {
    console.log(`[${config.method?.toUpperCase()}] - ${config.url}`);
  }

  return config;
});

api.interceptors.response.use(
  (response: AxiosResponse<IApiSuccessResponse<any>>) => {
    if (import.meta.env.DEV) {
      console.log("[RESPONSE SUCCESS] - ", response.data);
    }
    return response;
  },
  (error: AxiosError<IApiErrorResponse>) => {
    if (error.response?.status === 429) {
      showAlertError(
        "Houve um erro ao tentar realizar sua solicitação. Por favor tente novamente dentro de 1 minuto."
      );
    }
    if (error.response && import.meta.env.DEV) {
      console.log("[RESPONSE ERROR] - ", error.response.data);
      return Promise.reject(error.response.data);
    }
    if (error.request && import.meta.env.DEV) {
      console.log("[RESPONSE ERROR] - ", error.request.data);
      return Promise.reject(error.request.data);
    }
  }
);
```
