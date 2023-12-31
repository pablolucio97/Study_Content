# SAVING COOKIES WITH NOOKIES

Nookies is a third-party JavaScript library that facilitates handling cookies with NextJS. It's essential to create cookies in a context to ensure their availability throughout the application.

### Step 1: Install Nookies
Run the following command to add nookies to your project:

### Step 2: Set Up Context
In your context file, import `setCookie`, `parseCookies`, and `destroyCookie` from nookies. Use these methods to store data, read the cookie when available, and destroy the cookie at sign out. Implement functions for signing in and out and export these from your context.

Example context setup:
```javascript
import { createContext, ReactNode, useContext, useEffect, useState } from 'react';
import { api } from '../services/api';
import Router from 'next/router';
import { setCookie, parseCookies, destroyCookie } from 'nookies';

// User type and context properties
type User = {
  email: string;
  permissions: string[];
  roles: string[];
};

type SignInCredentialsProps = {
  email: string;
  password: string;
};

type AuthContextProps = {
  signIn(credentials: SignInCredentialsProps): Promise<void>;
  isAuthenticated: boolean;
  user: User;
};

type ChildrenProps = {
  children: ReactNode;
};

export const AuthContext = createContext({} as AuthContextProps);

// Sign out function
export function signOut() {
  destroyCookie(undefined, "nextauth.token");
  destroyCookie(undefined, "nextauth.refreshToken");
  Router.push('/');
}

// Auth provider component
export const AuthProvider = ({ children }: ChildrenProps) => {
  // ...implementation details...
};

export const useSignIn = () => {
  return useContext(AuthContext);
};

import axios, { AxiosError } from 'axios';
import { parseCookies, setCookie } from 'nookies';
import { signOut } from '../context/AuthContext';

let cookies = parseCookies();
let isRefreshing = false;
let failedRequestQueue = [];

export const api = axios.create({
  baseURL: 'http://localhost:3333',
  headers: {
    Authorization: `Bearer ${cookies['nextauth.token']}`,
  },
});

api.interceptors.request.use(
  (response) => {
    return response;
  },
  (error: AxiosError) => {
    // ...handling token expiration and refreshing logic...
  }
);
``````

## Step 3: Implement Request Queue with Axios
Create a request queue using axios to handle token refreshing. If no token is available, trigger sign out.

```javascript

import axios, { AxiosError } from 'axios';
import { parseCookies, setCookie } from 'nookies';
import { signOut } from '../context/AuthContext';

let cookies = parseCookies();
let isRefreshing = false;
let failedRequestQueue = [];

export const api = axios.create({
  baseURL: 'http://localhost:3333',
  headers: {
    Authorization: `Bearer ${cookies['nextauth.token']}`,
  },
});

api.interceptors.request.use(
  (response) => {
    return response;
  },
  (error: AxiosError) => {
    // ...handling token expiration and refreshing logic...
  }
);
```