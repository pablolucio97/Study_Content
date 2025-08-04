# Crash Tracking with Sentry in Expo/React Native

Crash tracking helps detect and report errors in your app **before** users notice and report them. When an error occurs, it is automatically sent to the development team.

---

## 1. Create a Sentry Project

- Log in to your [Sentry](https://sentry.io) account.
- Go to **Projects > Create Project**.
- Select the technology (e.g., React Native).
- Enable **"Alert me on every new issue"**.
- Provide your app name and click **"Create project"**.

---

## 2. Install Sentry Dependencies

```bash
expo install sentry-expo
expo install expo-application expo-constants expo-device expo-updates @sentry/react-native
```

---

## 3. Configure `app.json`

Add the Sentry hook:

```json
{
  "expo": {
    "plugins": ["sentry-expo"],
    "hooks": {
      "postPublish": [
        {
          "file": "sentry-expo/upload-sourcemaps",
          "config": {
            "organization": "your-org-name",
            "project": "your-project-name",
            "authToken": "your-auth-token"
          }
        }
      ]
    }
  }
}
```

🔗 Generate your auth token at:  
https://sentry.io/settings/account/api/auth-tokens/

---

## 4. Initialize Sentry in `App.tsx`

```tsx
import React, { useEffect } from 'react';
import { Home } from './src/pages/Home';
import * as Sentry from '@sentry/react-native';

export default function App() {
  useEffect(() => {
    Sentry.init({
      dsn: 'https://<your-dsn>@o<org>.ingest.sentry.io/<project-id>',
      enableInExpoDevelopment: true,
    });
  }, []);

  return <Home />;
}
```

---

## 5. Simulate and View Errors

- Trigger an error in your app intentionally.
- Visit your Sentry dashboard.
- See real-time error logs, including stack trace, device info, and app version.

---

**✅ Done! You are now tracking crashes and errors with Sentry.**
