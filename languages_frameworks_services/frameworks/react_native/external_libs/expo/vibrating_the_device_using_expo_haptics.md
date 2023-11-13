# Vibrating the device with Expo Haptics

To vibrate the device with Expo Haptics you need:

1 - Install the Expo Av using the command `npx expo install expo-haptics`.

2 - Put your .mp3 sound files inside the assets folder.

3 - Import * as Haptics from 'expo-haptics', and create an async function to vibrate the device, example:

```typescript
  async function vibrateDevice() {
    await Haptics.notificationAsync(Haptics.NotificationFeedbackType.Error)
  }
```