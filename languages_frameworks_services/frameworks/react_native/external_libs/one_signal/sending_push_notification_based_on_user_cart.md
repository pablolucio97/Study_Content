# Sending Push Notifications based on user cart context

1 - On the utils/OneSignalNotifications file create a function to create a new tag on One Signal to send the context total cart items. Example:

```typescript
import OneSignal from "react-native-onesignal";

export function tagCartUpdate(itemsCount: string) {
  OneSignal.sendTag('cart_items_count', itemsCount)
}

export { tagCartUpdate };
```

2 - On your cart context file, add the `tagCartUpdate function` to your add and remove cart items context functions passing the current cart items count.

3 - On One Signal dashboard, create a new segment for the cart passing the 'cart_items_count' tag. and applying the filters. Example:

[image](https://i.ibb.co/crQ58xx/Screenshot-2023-11-04-at-09-15-47.png)

4 - Send a new push notification selecting the created segment for cart context.

