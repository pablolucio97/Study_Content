# Monitoring Users behaviors with Google Analytics

---

## 1. Install Firebase

Use the following command:

```bash
yarn add firebase
```

---

## 2. Configure Firebase

Create a file named `firebase.ts` inside the `services` folder and initialize Firebase and Analytics:

```ts
import firebase from "firebase";
import "firebase/analytics";

const firebaseConfig = {
  apiKey: process.env.REACT_APP_API_KEY,
  authDomain: process.env.REACT_APP_AUTH_DOMAIN,
  projectId: process.env.REACT_APP_PROJECT_ID,
  messagingSenderId: process.env.REACT_APP_MESSAGING_SENDER_ID,
  appId: process.env.REACT_APP_APP_ID,
  measurementId: process.env.REACT_APP_MEASUREMENT_ID,
};

firebase.initializeApp(firebaseConfig);

const analytics = firebase.analytics();

export { firebase, analytics };
```

---

## 3. Create Analytics Service

Create a file named `analytics.js` inside the `services` folder:

```js
import { analytics } from "./firebase";

const analyticsEvents = (event, params) => {
  analytics.logEvent(event, params);
};

export { analyticsEvents };
```

---

## 4. Track Page Views

In your `routes.ts`, create a listener component to monitor route changes:

```tsx
import { useEffect } from 'react';
import {
  Route,
  BrowserRouter,
  Switch,
  useLocation
} from 'react-router-dom';

import Login from '../pages/Login/Index';
import Home from '../pages/Home/Index';
import { analytics } from '../services/firebase';

const RoutesListener = () => {
  const location = useLocation();

  useEffect(() => {
    analytics.setCurrentScreen(location.pathname);
  }, [location]);

  return <></>;
};

const Routes = () => {
  return (
    <BrowserRouter>
      <RoutesListener />
      <Switch>
        <Route path='/' exact component={Login} />
        <Route path='/home' component={Home} />
      </Switch>
    </BrowserRouter>
  );
};

export default Routes;
```

---

## 5. Test Your Integration

Run your application and navigate between routes. Google Analytics will begin tracking screen views automatically.
