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


## Sending and showing push notifications with app in foreground  state

1 - Create a React component to show your push notification receiving title and onClose props. Example:

```typescript
import { HStack, Text, IconButton, CloseIcon, Icon } from 'native-base';
import { Ionicons } from '@expo/vector-icons';

type Props = {
  title: string;
  onClose: () => void;
}

export function Notification({ title, onClose }: Props) {
  return (
    <HStack 
      w="full" 
      p={4} 
      pt={12}
      justifyContent="space-between" 
      alignItems="center" 
      bgColor="gray.200"
      position="absolute"
      top={0}
    >
        <Icon as={Ionicons} name="notifications-outline" size={5} color="black" mr={2}/>

        <Text fontSize="md" color="black" flex={1}>
          {title}
        </Text>

      <IconButton 
        variant="unstyled" 
        _focus={{ borderWidth: 0 }} 
        icon={<CloseIcon size="3" />} 
        _icon={{ color: "coolGray.600"}} 
        color="black"
        onPress={onClose}
      />
    </HStack>
  );
}
```

2 - Inside your navigation context file Import and assign a listener to listen to a push when it is received from One Signal dashboard. The listener must to set the notification state passing the notification title available through notification.getNotification(). Example:

```typescript
import { DefaultTheme, NavigationContainer } from '@react-navigation/native';
import { useTheme } from 'native-base';

import { useEffect, useState } from 'react';
import OneSignal, { NotificationReceivedEvent, OSNotification } from 'react-native-onesignal';
import { Notification } from '../components/Notification';
import { AppRoutes } from './app.routes';

export function Routes() {
  const { colors } = useTheme();

  const theme = DefaultTheme;
  theme.colors.background = colors.gray[700];

  const [notification, setNotification] = useState<OSNotification>()

  useEffect(() => {
    const unsubscriber = OneSignal.
      setNotificationWillShowInForegroundHandler((notification: NotificationReceivedEvent) => {
        const notificationMessage = notification.getNotification()
        setNotification(notificationMessage)
      })
    return () => unsubscriber
  }, [])

  return (
    <NavigationContainer theme={theme}>
      <AppRoutes />
      {
        notification?.title &&
        <Notification title={notification.title} onClose={() => setNotification(undefined)} />
      }
    </NavigationContainer>
  );
}
```

3 - Send a new notification on the One Signal dashboard to see it be shown in the app in foreground.

4 - Optionally, if you want to know if user clicked on the notification when the app was in background or quite, add the a listener to the OneSignal.setNotificationOpenedHandler event in your application. Example:

```typescript
  useEffect(() => {
    const unsubscribe = OneSignal.setNotificationOpenedHandler(() => {
      console.log('Notificação aberta');
    })

    return () => unsubscribe
  },[]);
```


### General tips

- Only high priority notifications will be delivered and shown on app foreground state. Any priority notifications will be delivered even with quite or in background.
