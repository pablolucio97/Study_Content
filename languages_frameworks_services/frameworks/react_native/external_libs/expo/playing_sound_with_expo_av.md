# Playing sound with expo av

To play sound with Expo Av you need:

1 Install the Expo Av using the command `npx expo install expo-av`.

2 Put your .mp3 sound files inside the assets folder.

3 Import Audio from 'expo-av', create an async function to play the sound, example:

```typescript
  import { Audio } from 'expo-av';

  async function playSound() {
    //DEFINE THE FILE AUDIO TO PLAY
    const file = require('../../assets/correct.mp3')
    //CREATE AN AUDIO INSTANCE BASED ON THE AUDIO FILE
    const { sound } = await Audio.Sound.createAsync(file, { shouldPlay: true })
    //DEFINE THE AUDIO POSITION TO 0 (STARTS FROM BEGINNING)
    await sound.setPositionAsync(0);
    //PLAY THE SOUND FILE
    await sound.playAsync();
  }
```