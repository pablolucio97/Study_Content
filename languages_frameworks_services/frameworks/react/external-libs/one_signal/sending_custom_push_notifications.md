# Sending custom push notifications using One Signal

## Sending push notifications to all users included in a tag:

Sending push notifications to all users included in a tag we can send a Push Notification to a single user, or all users included in a tag, or even another custom filters.
In this example we'll set the user email on One Signal after user is authenticated to be notified further.

1 - Set the user email on One Signal in the moment user is logged in your application. Example:

```typescript
import OneSignal from "react-native-onesignal";

function createEmailTag(email: string) {
  return OneSignal.sendTag("user_email", email);
}

export { createEmailTag };
```

2 - Import it in your application (can be on app start, or authentication flow) calling the function to embed this tag to the user device. Example:

```typescript
import { Roboto_400Regular, Roboto_700Bold, useFonts } from '@expo-google-fonts/roboto';
import { NativeBaseProvider } from 'native-base';
import { StatusBar } from 'react-native';
import OneSignal  from 'react-native-onesignal';
import { Routes } from './src/routes';

import { Loading } from './src/components/Loading';
import { THEME } from './src/theme';

import { CartContextProvider } from './src/contexts/CartContext';
import { createEmailTag } from './src/utils/OneSignalNotifications';

export default function App() {
  const [fontsLoaded] = useFonts({ Roboto_400Regular, Roboto_700Bold });

  OneSignal.setAppId('3d87f45c-ed4c-4d2a-96b8-009dbb742be7')
  //CALL IT WHEN USER SIGN IN PASSING USER EMAIL
  createEmailTag("test@gmail.com")

  return (
    <NativeBaseProvider theme={THEME}>
      <StatusBar
        barStyle="light-content"
        backgroundColor="transparent"
        translucent
      />
      <CartContextProvider>
        {fontsLoaded ? <Routes /> : <Loading />}
      </CartContextProvider>
    </NativeBaseProvider>
  );
}
```

3 - The Tag now will be assigned to the user on your Subscriptions at One Signal dashboard. At the One Signal Dashboard, add a new Segment selecting "User Tag" passing the value of the registered email tag.

4 - At sending a new Push, select the option "Send to particular segment(s)" and select the segment created on step 3.
