# Handling gestures using React Native Gesture Handler

## Concepts

### Microinteractions

Microinteractions are functional details that can improve the user experience in a mobile application. User interactions can be done generally through gestures.

### Gestures

The most common type of gestures are: 
- **Tap**: A single touch on the screen to interact with elements like buttons or links.
- **Double Tap**: Two quick consecutive taps to zoom in or out on content like maps and images.
- **Long Press**: Pressing and holding on an element to reveal additional options or to start a drag-and-drop action.
- **Swipe**: A quick slide of the finger in any direction to scroll through content or switch between screens.
- **Drag**: Touching and moving an element to reposition it.
- **Pinch and Spread (Pinch to Zoom)**: Using two fingers to zoom in by spreading them apart or zoom out by pinching them together.
- **Rotate**: Turning two or more fingers around a central point to rotate an element.
- **Flick**: A quicker and lighter swipe to scroll rapidly through content.
- **Pull Down / Pull Up**: Dragging a finger vertically down or up to open a search bar, control center, or to refresh content.
- **Edge Swipe**: Swiping from the edge of the screen towards the center to open menus or navigate to previous screens.

## Handling gestures

1 - Install the react-native-gesture-handle running `expo install react-native-gesture-handler`.

2 - Wrap your application with the react-native-gesture-handle: Example:

```javascript
import { GestureHandlerRootView } from 'react-native-gesture-handler';

export default function App() {
  return (
    <GestureHandlerRootView style={{ flex: 1 }}>
      {/* content */}
    </GestureHandlerRootView>
  );
}
```

3 - Use the components from React Native GestureHandler. Example:

```typescript
import { Trash } from 'phosphor-react-native';
import { Pressable, View } from 'react-native';
import { Swipeable } from 'react-native-gesture-handler';
import { HistoryCard } from '../../components/HistoryCard';
import { THEME } from '../../styles/theme';
import { styles } from './styles';

export function History() {

  ...code

  return (
    <View style={styles.container}>
        {
          history.map((item) => (
            <Swipeable
              overshootLeft={false}
              containerStyle={styles.swipeableContainer}
              renderLeftActions={() => (
                <Pressable style={styles.swipeableRemove}>
                  <Trash size={32} color={THEME.COLORS.GREY_100} />
                </Pressable>
              )}
            >
              <HistoryCard data={item} />
            </Swipeable>
          ))
        }
    </View>
  );
}
```



## General Tips

- Use RectButton or BorderlessButton instead of TouchableOpacity or wrapping it to improve the user experience doing this component looks with the native button of each platform.