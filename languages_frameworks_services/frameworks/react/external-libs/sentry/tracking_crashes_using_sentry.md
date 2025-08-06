
# 🐛 Doing Crash Tracking with Sentry (React Native)

Crash tracking is the action of tracking errors and being aware of them before the user finds and reports them. When an error occurs, it also is reported to the developer's team immediately.

---

## 1. Create a Project on Sentry

- Login to your [Sentry](https://sentry.io) account
- Go to **Projects** → **Create project**
- Select the technology (React Native)
- Check the box “Alert me on every new issue”
- Provide your app name and click **Create project**

---

## 2. Install Sentry SDK

```bash
yarn add @sentry/react-native
```

---

## 3. Run the Sentry Wizard

```bash
yarn sentry-wizard -i reactNative -p ios android
```

- This will sync your local project with the Sentry project
- Select the correct project when prompted

---

## 4. Configure Sentry in App.tsx

```tsx
import React, { useEffect } from 'react'
import { Home } from './src/pages/Home'
import * as Sentry from '@sentry/react-native'

export default function App() {
    useEffect(() => {
        Sentry.init({
            dsn: "https://db686fb0ce79483591ae7b2a7d68c4a7@o1167557.ingest.sentry.io/4534533"
        })
    }, [])

    return (
        <Home />
    )
}
```

---

## 5. Simulate an Error

- Throw a fake error in your app to test reporting:

```tsx
useEffect(() => {
    throw new Error("This is a test crash");
}, [])
```

- You should see the error appear in your [Sentry dashboard](https://sentry.io)

---

✅ Done! You now have real-time crash reporting for your React Native app.
