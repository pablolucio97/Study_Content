
# 🔐 Zustand – User Authentication with Persisted Token (Middleware)

Zustand is a minimal state-management library for React.  
In this guide, you'll build an **authentication store** with **login**, **logout**, and **token persistence** using the `persist` middleware.

---

## 1️⃣ Installation

```bash
npm install zustand
# or
yarn add zustand
```

---

## 2️⃣ Create the Auth Store (with `persist` middleware)

📂 `stores/auth.ts`

```ts
import { create } from 'zustand';
import { persist, createJSONStorage } from 'zustand/middleware';

type User = {
  id: string;
  name: string;
  email: string;
};

type AuthState = {
  user: User | null;
  token: string | null;
  login: (payload: { user: User; token: string }) => void;
  logout: () => void;
};

// The `persist` middleware will keep `user` and `token` in localStorage.
export const useAuthStore = create<AuthState>()(
  persist(
    (set) => ({
      user: null,
      token: null,
      login: ({ user, token }) => set({ user, token }),
      logout: () => set({ user: null, token: null }),
    }),
    {
      name: 'auth-storage', // storage key
      version: 1,
      storage: createJSONStorage(() => localStorage),
      // Optional: choose what to persist (whitelist)
      partialize: (state) => ({ user: state.user, token: state.token }),
    }
  )
);
```

> If you're using **Next.js** (SSR), access `localStorage` only on the client. The `createJSONStorage(() => localStorage)` call is evaluated lazily at runtime, which is SSR-safe as long as the store is imported client-side (inside components or `use client` files).

---

## 3️⃣ Use the Store in Components

📂 `components/Login.tsx`

```tsx
import React, { useState } from 'react';
import { useAuthStore } from '../stores/auth';

export function Login() {
  const login = useAuthStore((s) => s.login);
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  async function handleLogin() {
    // Simulated API call
    const user = { id: '1', name: 'Pablo', email };
    const token = 'mocked-jwt-token';

    // Persisted automatically by middleware
    login({ user, token });
  }

  return (
    <div>
      <input placeholder="Email" onChange={(e) => setEmail(e.target.value)} />
      <input
        type="password"
        placeholder="Password"
        onChange={(e) => setPassword(e.target.value)}
      />
      <button onClick={handleLogin}>Login</button>
    </div>
  );
}
```

---

📂 `components/Profile.tsx`

```tsx
import React from 'react';
import { useAuthStore } from '../stores/auth';

export function Profile() {
  const user = useAuthStore((s) => s.user);
  const logout = useAuthStore((s) => s.logout);

  if (!user) return <p>No user logged in</p>;

  return (
    <div>
      <h2>Welcome, {user.name}!</h2>
      <button onClick={logout}>Logout</button>
    </div>
  );
}
```

---

## 4️⃣ App Wiring

📂 `App.tsx`

```tsx
import React, { useEffect } from 'react';
import { useAuthStore } from './stores/auth';
import { Login } from './components/Login';
import { Profile } from './components/Profile';

export default function App() {
  const token = useAuthStore((s) => s.token);
  const login = useAuthStore((s) => s.login);

  useEffect(() => {
    // If you need to "rehydrate" the user from token:
    // In real apps, fetch the user with the token here.
    if (token) {
      const user = { id: '1', name: 'Pablo', email: 'pablo@email.com' };
      // Ensure store has latest user (persist already restored token)
      login({ user, token });
    }
  }, [token, login]);

  return (
    <div>
      <Login />
      <Profile />
    </div>
  );
}
```

> The `persist` middleware **restores `token` and `user` automatically** on refresh.  
> The rehydrate effect above shows how you could fetch the latest user profile when a token exists.

---

## 5️⃣ Optional: Devtools + Immutable Selectors (Advanced)

```ts
import { create } from 'zustand';
import { devtools, persist, createJSONStorage } from 'zustand/middleware';

type User = { id: string; name: string; email: string };
type AuthState = {
  user: User | null;
  token: string | null;
  isAuthenticated: () => boolean;
  login: (payload: { user: User; token: string }) => void;
  logout: () => void;
};

export const useAuthStore = create<AuthState>()(
  devtools(
    persist(
      (set, get) => ({
        user: null,
        token: null,
        isAuthenticated: () => !!get().token,
        login: ({ user, token }) => set({ user, token }, false, 'auth/login'),
        logout: () => set({ user: null, token: null }, false, 'auth/logout'),
      }),
      {
        name: 'auth-storage',
        storage: createJSONStorage(() => localStorage),
        partialize: (s) => ({ user: s.user, token: s.token }),
      }
    ),
    { name: 'auth-store' }
  )
);
```

Use with **selectors** to avoid unnecessary re-renders:

```tsx
import { shallow } from 'zustand/shallow';
const { user, isAuthenticated } = useAuthStore(
  (s) => ({ user: s.user, isAuthenticated: s.isAuthenticated() }),
  shallow
);
```

---

## 6️⃣ General Tips

- ✅ Always select only the **slice of state** you need to minimize re-renders.  
- ✅ Persist only what’s necessary (e.g., `token`, `user`), using `partialize`.  
- ✅ For **Next.js**, import the store only in client components (`"use client"`).  
- ✅ Perform **user refresh** on app start if you rely on a token restored from storage.  
- ✅ Combine `devtools` + `persist` for great DX, but disable devtools in production if needed.

---

## 📚 Resources
- Zustand Docs – Persist Middleware: https://docs.pmnd.rs/zustand/integrations/persisting-store-data
- Zustand GitHub: https://github.com/pmndrs/zustand
