# 🔐 Redux Toolkit – User Authentication Context Course

Redux Toolkit (RTK) is the official, recommended way to write Redux logic.  
Here, we’ll build a **user authentication flow** with login, logout, and token persistence.

---

## Concepts

### Reducer

**Definition**:  
A function that takes the **current state** and an **action**, and returns the **new state**.

**Think**: “Given what happened, how should the state change?”

**Example**:

```ts
function counterReducer(state = 0, action) {
  if (action.type === "INCREMENT") return state + 1;
  return state;
}
```

### Slice

**Definition**:  
A _package_ that groups together:

- The **state’s name** (`name`)
- The **initial state**
- All **reducers**
- Automatically generated **action creators**

**Example**:

```ts
import { createSlice } from "@reduxjs/toolkit";

const counterSlice = createSlice({
  name: "counter",
  initialState: 0,
  reducers: {
    INCREMENT: (state) => state + 1,
    DECREMENT: (state) => state - 1,
    ADD_BY_AMOUNT_ACTION: (state, action) => state + action.payload,
  },
});

export const { INCREMENT, DECREMENT, ADD_BY_AMOUNT_ACTION } =
  counterSlice.actions; // actions
export default counterSlice.reducer; // reducer function
```

### Action

**Definition**:  
An object describing **what happened**.  
Has a `type` (required) and can have a `payload` (optional).

**Example**:

```ts
const INCREMENT_ACTION = { type: "INCREMENT_ACTION" };
const ADD_BY_AMOUNT_ACTION = { type: "ADD_BY_AMOUNT_ACTION", payload: 5 };
```

### Payload

**Definition**:  
The extra data sent along with an action.

**Example**:

```ts
// Action with payload
{ type: 'ADD_BY_AMOUNT_ACTION', payload: 5 }
```

## 1. Installation

```bash
npm install @reduxjs/toolkit react-redux
```

---

## 2. Creating the Authentication Slice

📂 `authSlice.ts`

```typescript
import { createSlice, PayloadAction } from "@reduxjs/toolkit";

interface User {
  id: string;
  name: string;
  email: string;
}

interface AuthState {
  user: User | null;
  token: string | null;
}

const initialState: AuthState = {
  user: null,
  token: null,
};

const authSlice = createSlice({
  name: "auth",
  initialState,
  reducers: {
    login: (state, action: PayloadAction<{ user: User; token: string }>) => {
      state.user = action.payload.user;
      state.token = action.payload.token;
    },
    logout: (state) => {
      state.user = null;
      state.token = null;
    },
  },
});

export const { login, logout } = authSlice.actions;
export default authSlice.reducer;
```

---

## 3. Setting Up the Store

📂 `store.ts`

```typescript
import { configureStore } from "@reduxjs/toolkit";
import authReducer from "./authSlice";

export const store = configureStore({
  reducer: {
    auth: authReducer,
  },
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;
```

---


## 4. Providing the Store to the App

📂 `main.tsx`

```tsx
import React from "react";
import ReactDOM from "react-dom/client";
import { Provider } from "react-redux";
import { store } from "./store";
import App from "./App";

ReactDOM.createRoot(document.getElementById("root")!).render(
  <Provider store={store}>
    <App />
  </Provider>
);
```

---

## 5. Using the Authentication State in Components

📂 `Login.tsx`

```tsx
import React, { useState } from "react";
import { useDispatch } from "react-redux";
import { login } from "../authSlice";
import { AppDispatch } from "../store";

export function Login() {
  const dispatch = useDispatch<AppDispatch>();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleLogin = async () => {
    // Simulated API call
    const user = { id: "1", name: "Pablo", email };
    const token = "mocked-jwt-token";
    dispatch(login({ user, token }));
    localStorage.setItem("token", token);
  };

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

📂 `Profile.tsx`

```tsx
import React from "react";
import { useSelector, useDispatch } from "react-redux";
import { RootState, AppDispatch } from "../store";
import { logout } from "../authSlice";

export function Profile() {
  const { user } = useSelector((state: RootState) => state.auth);
  const dispatch = useDispatch<AppDispatch>();

  if (!user) return <p>No user logged in</p>;

  return (
    <div>
      <h2>Welcome, {user.name}!</h2>
      <button onClick={() => dispatch(logout())}>Logout</button>
    </div>
  );
}
```

---

## 6. Restoring the Token on Page Reload

📂 `authSlice.ts` (Update initial state)

```typescript
const savedToken = localStorage.getItem("token");

const initialState: AuthState = {
  user: null,
  token: savedToken ? savedToken : null,
};
```

---

📂 `App.tsx`

```tsx
import React, { useEffect } from "react";
import { useDispatch } from "react-redux";
import { login } from "./authSlice";
import { AppDispatch } from "./store";
import { Login } from "./components/Login";
import { Profile } from "./components/Profile";

export default function App() {
  const dispatch = useDispatch<AppDispatch>();

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (token) {
      // Fetch user with token from API
      const user = { id: "1", name: "Pablo", email: "pablo@email.com" };
      dispatch(login({ user, token }));
    }
  }, [dispatch]);

  return (
    <div>
      <Login />
      <Profile />
    </div>
  );
}
```

---

## 7️⃣ General Tips for Auth with Redux Toolkit

- ✅ Store only **non-sensitive** data in Redux (token in localStorage if needed).
- ✅ Keep authentication logic inside **one slice** for maintainability.
- ✅ Use `createAsyncThunk` for real API calls.
- ✅ Always clear tokens on logout to avoid unauthorized access.

---

## 📚 Resources

- [Redux Toolkit Docs](https://redux-toolkit.js.org/)
- [React Redux Docs](https://react-redux.js.org/)
