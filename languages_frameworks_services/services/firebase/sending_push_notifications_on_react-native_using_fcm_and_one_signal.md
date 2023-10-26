# Sending Push Notifications on React Native using FCM and One Signal
## Concepts

### Push Notifications

Are messages that are sent from an external server to be received and shown on assigner mobile device, even the application is not opened or running. Push notifications can be used to alert user about deals, notices and so on.

### Device states

Foreground: App is open and active.
Background: App is open but not active.
Terminated: App is closed.

The behavior of the notification can vary based on these states:

Foreground: Notification might not display automatically but can be handled programmatically.
Background: Notification appears in the notification shade. Tapping it can bring the app to the foreground.
Terminated: Similar to background, but app initialization might differ if launched from a notification.

### Firebase Cloud Messaging

FCM is a cloud solution for messages on iOS, Android, and web applications. It's a part of the Firebase platform provided by Google.

### One Signal

One Signal is a web platform that through a dashboard is used to send push notifications on iOS, Android, and more.

## Implementing Push Notifications on React Native using FCM and One Signal

1 - Access the Firebase Console and create a new application (must be the same name of your application on app.json). In this process, you can chose or not using Analytics.

2 - After created the project, active the Cloud messaging clicking on Project Settings => and on the tab Cloud Messaging => Activate.

3 - Again on Firebase Consoled, under  Project Settings, click on Service accounts tab and on "Generate new private key", download it.

4 - Log into your One Signal account and create a new project, upload the json private key download from FCM, click on Save and Continue,  select ReactNative/Expo platform, copy and store an env variable your One Signal App ID. 

5 - Run ```expo install onesignal-expo-plugin``` to install the One Signal configuration plugin for it do the plugin configuration by itself. In the sequence install the One Signal running ```npm install react-native-one-signal```

6 - Add the onesignal-expo-plugin to your plugins array on app.json, ex:

```json
    "plugins": [
      [
        "onesignal-expo-plugin",
        {
          "mode": "development"
        }
      ]
    ]
```

7 - In your App.tsx file, import the OneSign from 'react-native-one-signal' and initialize it passing the app-id. Example:

```typescript
import { Roboto_400Regular, Roboto_700Bold, useFonts } from '@expo-google-fonts/roboto';
import { OneSignal } from 'react-native-onesignal';
import { Routes } from './src/routes';

export default function App() {
  const [fontsLoaded] = useFonts({ Roboto_400Regular, Roboto_700Bold });

  OneSignal.initialize('your_app_id_key')

  return (
    </Routes>
  );
}
```

8 - Finally, on your One Signal project, at the least step, click on "Checked Subscribed Users" to test if your application and code are communicating correctly.

Obs: If you got the error "Missing 'ios.bundleIdentifier' in app config", add a bundle identifier for your ios on app.json, example :

```json
    "ios": {
      "supportsTablet": true,
      "bundleIdentifier": "com.pscode.igniteshoes"
    },
```