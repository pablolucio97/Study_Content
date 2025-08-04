# 🍎 Apple Authentication with Expo (React Native)

This guide walks you through integrating Apple Sign-In in your Expo React Native app.

---

## 🔧 Step 1: Update `app.json`

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

---

## 📦 Step 2: Install Dependencies

```bash
expo install expo-auth-session expo-random expo-apple-authentication
```

---

## 🧠 Step 3: Create Auth Context

```tsx
import { createContext, ReactNode, useEffect, useState } from 'react';
import * as AppleSession from 'expo-apple-authentication';
import AsyncStorage from '@react-native-async-storage/async-storage';

interface UserProps {
  id: string;
  name: string;
  email: string;
  photo?: string;
}

interface AuthContextProps {
  userInfo: UserProps;
  signInWithApple(): Promise<void>;
}

interface ChildrenProps {
  children: ReactNode;
}

export const AuthContext = createContext({} as AuthContextProps);

export function AuthProvider({ children }: ChildrenProps) {
  const [user, setUser] = useState<UserProps>({} as UserProps);

  async function signInWithApple() {
    try {
      const credentials = await AppleSession.signInAsync({
        requestedScopes: [
          AppleSession.AppleAuthenticationScope.FULL_NAME,
          AppleSession.AppleAuthenticationScope.EMAIL,
        ],
      });

      if (credentials) {
        const userLogged = {
          id: String(credentials.user),
          email: credentials.email!,
          name: credentials.fullName!.givenName!,
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
      const userStoraged = await AsyncStorage.getItem('@user');
      if (userStoraged) {
        const userLogged = JSON.parse(userStoraged) as UserProps;
        setUser(userLogged);
      }
    }
    loadUserStorageData();
  }, []);

  return (
    <AuthContext.Provider value={{ userInfo: user, signInWithApple }}>
      {children}
    </AuthContext.Provider>
  );
}
```

---

## 🔁 Step 4: Create useAuth Hook

```ts
import { useContext } from 'react';
import { AuthContext } from '../contexts/AuthContext';

export function useAuth() {
  return useContext(AuthContext);
}
```

---

## 📲 Step 5: Use it in your SignIn Page

```tsx
import React from 'react';
import { Alert } from 'react-native';
import AppleSvg from '../../assets/apple.svg';
import { Container } from './styles';
import { SignInSocialButton } from '../../components/SignInSocialButton';
import { useAuth } from '../../hooks/auth';

export function SignIn() {
  const { signInWithApple } = useAuth();

  async function handleSignInWithApple() {
    try {
      await signInWithApple();
    } catch (error) {
      console.log(error);
      Alert.alert('Erro ao conectar com Apple.');
    }
  }

  return (
    <Container>
      <SignInSocialButton
        title="Entrar com Apple"
        svg={AppleSvg}
        onPress={handleSignInWithApple}
      />
    </Container>
  );
}
```

---

## 🔄 Step 6: Restart the Expo Server

```bash
expo start -c
```

---

**Done! 🎉 Now you can authenticate users via Apple Sign-In!**





