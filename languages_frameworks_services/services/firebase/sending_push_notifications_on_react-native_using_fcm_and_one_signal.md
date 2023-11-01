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

One Signal is a web platform that through a dashboard is used to send push notifications on iOS, Android, and more. Through One Signal platform is possible to: 

- Send push notification based on user email, user actions (first session, purchase, time out of the application), and so on. 
- Send push notification to a single user registering the user email in a tag and sending the push notification to this tag.
- Send push notifications based on variables and conditions.
- Schedule push notifications based o a specific time or based on Intelligent delivery (One Signal option that deliveries the push notification based on the hours/moments that user usually uses the app).

## Implementing Push Notifications on React Native - Android using FCM and One Signal

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
import  OneSignal  from 'react-native-onesignal';
import { Routes } from './src/routes';

export default function App() {
  const [fontsLoaded] = useFonts({ Roboto_400Regular, Roboto_700Bold });

    OneSignal.setAppId('3d87f45c-ed4c-4d2a-96b8-009dbb742be7')

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

## Sending a notification on Android

1 - At the One Signal dashboard, select your Android application, click on "New Message", and the on "New Push", type a name for your message and write it. Click on "Send Test Push", "Add Test Users", select your emulator device and click on "Add Test User" informing a name for this Test User.

2 - Click on "Refresh testers list", select your device user test, and the click on "Send Test Push".

3 - Check if the push notification is arriving correctly on Android (you must be authenticated on a Google Account).

## Implementing Push Notifications on React Native - iOS using APN and One Signal


1 - Create a new application selecting Apple iOS APN on One Signal dashboard and provide a name for the application.

2 - Open the .xcodeproj file of your React Native application on XCode and select your developer team on Signing & Capabilities tab, you need to do this for your application target and OneSignalNotifications target. Check at developer.apples.com if your application identifier is listed on Identifiers tab.

3 - On Mac OS open the application KeyChain Access on fullscreen, access the option Certificate Assistant => Request a Certificate from Certificate Authority. In the new window opened, type your developer email address, your name, select the option "Save to disk", click on Next, save and rename it as your_aplication_name_aps_ceritficate.certSigningRequest.

4 - On your Apple developer account, under Certificates tab, click on add new Certificate plus button, select the option "Apple Push Notification service SSL" that is under Services, click on Next, select your application id, click on Next, select the .certSigningRequest file, click on Next and now you can download the new added Apple certificate.

5 - Double click on the downloaded certificate to be open using KeyChain application, click with right button, and click on Export "the_certificate_name", and select a destination to be exported as .p12 certificate and reame it as your_aplication_name_aps_ceritficate.p12.

6 - At One Signal dashboard, select the .p12 exported certificate, provide your password, click on Next, select the React Native/Expo environment e click on Next.

7 - On your App.tsx file, call the OneSignal.initialize function passing your app id key as param based on the current platform, and call the `promptForPushNotificationsWithUserResponse` function to be sure user has been notified about push notifications using APN on iOS. Example: 

```typescript
import { Roboto_400Regular, Roboto_700Bold, useFonts } from '@expo-google-fonts/roboto';
import OneSignal from 'react-native-onesignal';
import { Platform } from 'react-native'
import { Routes } from './src/routes';

export default function App() {
  const [fontsLoaded] = useFonts({ Roboto_400Regular, Roboto_700Bold });

  const oneSignalAppIdKey = Platform.os === 'android' ? 'your_one_signal_app_id_key_android' : 'your_one_signal_app_id_key_ios'

  OneSignal.setAppId(oneSignalAppIdKey)

  OneSignal.promptForPushNotificationsWithUserResponse(response => {
  console.log(`Has prompt for push notification request: `response);
  })

  return (
    </Routes>
  );
}
```

8 - Run `pod install` at the application ios folder to be sure all pods are installed.

9 - Plug your iphone in your mac and run the command `npx expo run:ios --device 'iphone de Fulano'` to install the application on the real device, after run the command `npx expo start --dev-client --tunnel` to launch the application on your real device passing your local ip to test One Signal push notification APN on iOS.

10 - Click on "Check Subscribed Users" on the One Signal dashboard to check if all integration is right, and then click on "Done".

