
# Google Authentication with Expo

## 1. Configure `app.json`

```json
{
  "expo": {
    "name": "gofinances",
    "slug": "gofinances",
    "scheme": "gofinances",
    "version": "1.0.0",
    "assetBundlePatterns": [
      "**/*"
    ]
  },
  "name": "gofinances"
}
```

## 2. Set up Google Cloud Project

- Visit [Expo Authentication Guide](https://docs.expo.dev/guides/authentication/#google)
- Create a Google Cloud project.

## 3. OAuth Consent Screen Setup

- Select External type.
- Fill in app name, support email, logo.
- Add OAuth Scopes (email, profile).
- Publish the app.

## 4. Set up Credentials

- Go to **Credentials > Create Credentials > OAuth Client ID**.
- Choose "Web Application".
- Add:
  - Authorized JS origins: `https://auth.expo.io`
  - Authorized Redirect URI: `https://auth.expo.io/@your-username/your-project-slug`

## 5. Store Credentials

- Create a `.env` file:
```env
GOOGLE_CLIENT_ID=your_google_client_id
REDIRECT_URI=https://auth.expo.io/@your-username/your-project-slug
```

## 6. Install Packages

```bash
yarn add babel-plugin-inline-dotenv
expo install expo-auth-session expo-random
```

## 7. Babel Config

Update `babel.config.js`:
```js
module.exports = function(api) {
  api.cache(true);
  return {
    presets: ['babel-preset-expo'],
    plugins: ['inline-dotenv']
  };
};
```

## 8. Authentication Context Setup

```tsx
// AuthContext.tsx
import { createContext, ReactNode, useState, useEffect } from 'react';
import * as AuthSession from 'expo-auth-session';
import AsyncStorage from '@react-native-async-storage/async-storage';

interface UserProps {
  id: string;
  name: string;
  email: string;
  photo?: string;
}

interface AuthContextProps {
  userInfo: UserProps;
  signInWithGoogle(): Promise<void>;
}

export const AuthContext = createContext({} as AuthContextProps);

export function AuthProvider({ children }: { children: ReactNode }) {
  const [user, setUser] = useState<UserProps>({} as UserProps);

  async function signInWithGoogle() {
    try {
      const { GOOGLE_CLIENT_ID, REDIRECT_URI } = process.env;
      const RESPONSE_TYPE = 'token';
      const SCOPE = encodeURI('profile email');
      const authUrl = `https://accounts.google.com/o/oauth2/v2/auth?client_id=${GOOGLE_CLIENT_ID}&redirect_uri=${REDIRECT_URI}&response_type=${RESPONSE_TYPE}&scope=${SCOPE}`;

      const { type, params } = await AuthSession.startAsync({ authUrl }) as any;

      if (type === 'success') {
        const userInfo = await fetch(\`https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token=\${params.access_token}\`).then(res => res.json());

        const userLogged = {
          id: userInfo.id,
          email: userInfo.email,
          name: userInfo.given_name,
          photo: userInfo.picture
        };

        setUser(userLogged);
        await AsyncStorage.setItem('@user', JSON.stringify(userLogged));
      }
    } catch (error) {
      throw new Error(String(error));
    }
  }

  useEffect(() => {
    async function loadUserStorageData() {
      const storaged = await AsyncStorage.getItem('@user');
      if (storaged) setUser(JSON.parse(storaged));
    }
    loadUserStorageData();
  }, []);

  return (
    <AuthContext.Provider value={{ userInfo: user, signInWithGoogle }}>
      {children}
    </AuthContext.Provider>
  );
}
```

## 9. Create Hook

```ts
// useAuth.ts
import { useContext } from 'react';
import { AuthContext } from '../contexts/AuthContext';

export function useAuth() {
  return useContext(AuthContext);
}
```

## 10. Using in Component

```tsx
import React from 'react';
import { Alert } from 'react-native';
import { Container } from './styles';
import { useAuth } from '../../hooks/auth';
import { SignInSocialButton } from '../../components/SignInSocialButton';
import GoogleSvg from '../../assets/google.svg';

export function SignIn() {
  const { signInWithGoogle } = useAuth();

  async function handleSignInWithGoogle() {
    try {
      await signInWithGoogle();
    } catch (error) {
      console.log(error);
      Alert.alert('Failed to sign in with Google');
    }
  }

  return (
    <Container>
      <SignInSocialButton
        title="Entrar com Google"
        svg={GoogleSvg}
        onPress={handleSignInWithGoogle}
      />
    </Container>
  );
}
```

---

✅ Restart your Expo project after setup.
