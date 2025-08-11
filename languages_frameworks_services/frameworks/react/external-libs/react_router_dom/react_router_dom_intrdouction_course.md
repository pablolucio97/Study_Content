
# React Router DOM Introduction Course

React Router DOM is the standard routing library for React applications running in the browser.  
It enables navigation between different views without full page reloads.

---

## 1. Installation

```bash
npm install react-router-dom
# or
yarn add react-router-dom
```

---

## 2. Core Components

### **2.1 BrowserRouter**
- Wraps the application to enable routing.
- Uses the browser's history API.
```jsx
import { BrowserRouter } from 'react-router-dom';

<BrowserRouter>
  <App />
</BrowserRouter>
```

---

### **2.2 Routes & Route**
- `Routes` replaces the old `Switch` in v6+.
- Each `Route` maps a path to an element.
```jsx
import { Routes, Route } from 'react-router-dom';

<Routes>
  <Route path="/" element={<Home />} />
  <Route path="/about" element={<About />} />
</Routes>
```

---

### **2.3 Link & NavLink**
- **Link**: Navigation without page reload.
- **NavLink**: Like `Link` but adds an active style/class.
```jsx
<Link to="/about">About</Link>
<NavLink to="/about" className={({ isActive }) => isActive ? "active" : ""}>About</NavLink>
```

---

### **2.4 useNavigate**
- Programmatic navigation hook.
```jsx
import { useNavigate } from 'react-router-dom';

const navigate = useNavigate();
navigate('/dashboard');
```

---

### **2.5 useParams**
- Access route parameters.
```jsx
<Route path="/users/:id" element={<User />} />

const { id } = useParams();
```

---

### **2.6 useSearchParams**
- Manage URL query parameters.
```jsx
const [searchParams, setSearchParams] = useSearchParams();
searchParams.get('page');
setSearchParams({ page: 2 });
```

---

### **2.7 Outlet**
- Renders child routes in nested routing.
```jsx
<Route path="/dashboard" element={<Dashboard />}>
  <Route path="settings" element={<Settings />} />
</Route>

// Dashboard.jsx
<Outlet />
```

---

### **2.8 Navigate**
- Component for redirecting.
```jsx
import { Navigate } from 'react-router-dom';
<Navigate to="/login" replace />
```

## Creating Basic Routes

1. Create a new folder named `routes` with the file `routes.tsx`:

```tsx
import React from 'react';
import { Switch, Route, BrowserRouter } from 'react-router-dom';

import Dashboard from '../pages/Dashboard';
import Main from '../pages/List';

const AppRoutes: React.FC = () => (
    <BrowserRouter>
        <Switch>
            <Route path='/dashboard' component={Dashboard} exact />
            <Route path='/main' component={Main} />
        </Switch>
    </BrowserRouter>
);

export default AppRoutes;
```

---

2. Use in your application passing the URL in the `Link` component:

```tsx
import React from "react";
import "./styles.css";
import { Link } from "react-router-dom";

export default function Menu() {
  return (
    <>
        <ul>
          <li>
            <Link to="/">
              Dashboard
            </Link>
          </li>
          <li>
            <Link to="/main">
              Main
            </Link>
          </li>
        </ul>
    </>
  );
}
```

## Creating Routes with Params

1. Create the basic file with the route:

```tsx
import React from 'react';
import { Switch, Route, BrowserRouter } from 'react-router-dom';

import Dashboard from '../pages/Dashboard';
import List from '../pages/List';

const AppRoutes: React.FC = () => (
    <BrowserRouter>
        <Switch>
            <Route path='/list/:type' component={List} />
        </Switch>
    </BrowserRouter>
);

export default AppRoutes;
```

2. Create an interface to access the match of the React Router DOM:

```ts
interface IRouteParamTypes {
    match: {
        params: {
            type: string;
        };
    };
}
```

3. Use the params with the interface through a `useMemo` function:

```tsx
import React, { useMemo } from 'react';

const List: React.FC<IRouteParamTypes> = ({ match }) => {
    const { type } = match.params;

    const title = useMemo(() => {
        return type === 'entrances' ? 'Entrances' : 'Budgets';
    }, [type]);

    return (
        <Container title={title} />
    );
}
```

## Consuming Props from Another Screens

1. Define the route with param:

```tsx
import React from 'react';
import { Switch, Route, BrowserRouter } from 'react-router-dom';

import Dashboard from '../pages/Dashboard';
import List from '../pages/List';

const AppRoutes: React.FC = () => (
    <BrowserRouter>
        <Switch>
            <Route path='/page/:id' component={List} />
        </Switch>
    </BrowserRouter>
);

export default AppRoutes;
```

2. Consume the param:

```tsx
import React from 'react';
import { useParams } from 'react-router-dom';

export default function Param() {
    const { id } = useParams<{ id: string }>();

    return (
        <div>
            <p>You are in the page {id}</p>
        </div>
    );
}
```

## Defining a Not Found Page

1. Create the NotFound component:

```tsx
import React from 'react';

export default function NotFound() {
  return (
      <div>
          <h1>404 - Page not found...</h1>
      </div>
  );
}
```

2. Pass the path route as '*' to redirect to the not found page:

```tsx
import React from 'react';
import { Switch, Route, BrowserRouter } from 'react-router-dom';

import NotFound from '../pages/NotFound';

const AppRoutes: React.FC = () => (
    <BrowserRouter>
        <Switch>
            <Route path='*' component={NotFound} />
        </Switch>
    </BrowserRouter>
);

export default AppRoutes;
```

3. Define any link to access the route:

```tsx
import React from "react";
import "./styles.css";
import { Link } from "react-router-dom";

export default function Menu() {
  return (
    <>
        <ul>
          <li>
            <Link to="/notfound">
                Not Found
            </Link>
          </li>
        </ul>
    </>
  );
}
```

## General tips

### Best Practices & Tricks
- Always **wrap your routes inside `<BrowserRouter>`** (or `<HashRouter>` if you need hash-based routing) at the **root of your app**.
- Use **`Routes` instead of `Switch`** in v6+, as `Switch` was removed.
- Use **`replace` in `<Navigate>`** when redirecting after login or logout to prevent users from navigating back to the login page.
- Use **`NavLink`** instead of `Link` when you need active link styles.
- Prefer **relative paths** for nested routes, it makes the code more reusable and portable.
- Use `useParams()` for **dynamic segments** and `useSearchParams()` for **query strings** instead of manually parsing `window.location`.
- Wrap expensive components with **`React.lazy` and `Suspense`** for lazy loading routes and better performance.

---

### Common Mistakes to Avoid
- ❌ Forgetting to wrap routes in `<BrowserRouter>` — will cause undefined errors when trying to use hooks like `useNavigate`.
- ❌ Using `component` or `render` props in `<Route>` — these were replaced with the `element` prop in v6.
- ❌ Declaring routes without `element` or passing JSX without wrapping in `{}`.
- ❌ Using absolute paths unnecessarily for nested routes, causing unexpected navigation.
- ❌ Forgetting the `key` prop when dynamically generating `<Route>` components.
- ❌ Not handling `404` routes — always include a `*` route to catch unknown paths.
- ❌ Not wrapping lazy-loaded routes with `<Suspense>` — will cause runtime errors.
- ❌ Using `window.location` for navigation — use `useNavigate` instead for SPA navigation.

---

### Things to Pay Attention To
- **Order of routes matters** when using dynamic segments (e.g., `/users/new` vs `/users/:id`).
- Ensure **auth checks happen before rendering protected routes** to prevent flickering.
- Be careful with **wildcard routes (`*`)** — they catch all paths and must be placed last.
- When using `replace` in navigation, remember it **removes the current page from history**.
- Use `Outlet` correctly in **nested routing**; without it, child routes won't render.
- Test **deep linking** (navigating directly to a nested URL) to ensure routes work without manual redirects.
- If using query params for state, ensure they’re synced with `useSearchParams` to avoid inconsistent behavior.

