# Implementing Deep Linking

1 - Add a scheme to the application configuration file (`app.json`) within the "Expo" property right below "Slug". Use the same name of the application for the scheme.
Example:

```json
"expo": {
  "slug": "application-name",
  "scheme": "application-name"
}
``````

2 - Run the command `expo prebuild`` to ensure that the configuration is applied.

3 - Install the expo-linking to handle deep linking.

4 - Run the command `npx uri-scheme list` to list your deep linking urls. 

5 - To test if your application is been opened successfully when a deep linking is  called, run the command `npx uri-scheme open your_application_name://your_local_ip:8081 --platform`.

6 - Create your Notification component to be a pressable notification to be show when a notification arrives. Example:
```typescript
import { Ionicons } from '@expo/vector-icons';
import * as Linking from 'expo-linking';
import {
  CloseIcon,
  HStack,
  Icon,
  IconButton,
  Pressable,
  Text
} from 'native-base';
import { OSNotification } from 'react-native-onesignal';

type Props = {
  data: OSNotification;
  onClose: () => void;
}

export function Notification({ data, onClose }: Props) {

  function handleOnPress() {
    if (data.launchURL) {
      Linking.openURL(data.launchURL)
      onClose()
    }
  }

  return (
    <Pressable w="full" p={4} pt={12} bgColor="gray.200" position="absolute" top={0} onPress={handleOnPress}>
      <HStack
        justifyContent="space-between"
      >
        <Icon as={Ionicons} name="notifications-outline" size={5} color="black" mr={2} />
        <Text fontSize="md" color="black" flex={1}>
          {data.title}
        </Text>
        <IconButton
          variant="unstyled"
          _focus={{ borderWidth: 0 }}
          icon={<CloseIcon size="3" />}
          _icon={{ color: "coolGray.600" }}
          color="black"
          onPress={onClose}
        />
      </HStack>
    </Pressable>
  );
}
```

8 - On your desired screen, receive from route.params the resource you want to show dynamically. 

7 - On your idex.tsx routes file, configure your deep linking object according the props each screen of your application must receive and pass it to your navigation provider . Example:

```typescript
import { DefaultTheme, NavigationContainer } from '@react-navigation/native';
import { useTheme } from 'native-base';
import * as Linking from 'expo-linking'
import { useEffect, useState } from 'react';
import OneSignal, { NotificationReceivedEvent, OSNotification } from 'react-native-onesignal';
import { Notification } from '../components/Notification';
import { AppRoutes } from './app.routes';

export interface AppStackRoutes {
  cart: undefined;
  products: undefined;
  details: { productId: string };
}

const deepLinkingConfig = {
  //urls can be recognized as uri schemes
  prefixes: ['igniteshoesapp://', 'com.rocketseat.igniteshoes://'],
  config: {
    screens: {
      //details here is the name of the screen that will be browsed
      details: {
        //details can receive a productId param
        path: 'details/:productId',
        parse: {
          productId: (productId: string) => productId
        }
      }
    }
  }
}

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
    <NavigationContainer theme={theme} linking={deepLinkingConfig}>
      <AppRoutes />
      {
        notification?.title &&
        <Notification data={notification} onClose={() => setNotification(undefined)} />
      }
    </NavigationContainer>
  );
}
```

9 - To call your deep link from One Signal dashboard, paste the url into the "Lauch URL" field at sending a new push. Example: `your_app_uri_scheme://your_screen/resource_id` Example: `igniteshoesapp://productDetails/8`

10 - Now the application in any state (quite, foreground or background) must navigate the user automatically to desired screen passing the specified param.

