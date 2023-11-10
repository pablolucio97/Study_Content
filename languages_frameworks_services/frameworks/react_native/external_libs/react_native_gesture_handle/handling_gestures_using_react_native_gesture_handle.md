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

## Using Swipeable

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

## Handling Gesture Events (Microinteractions)

To handle gestures you need: 

1 - Import the GestureDetector, and  Gesture from 'react-native-gesture-handler'.
2 - Declare a variable assign it to the Gesture method passing the desired gesture to handle with it available events.
3 - Use the variable in the gesture property from the GestureDetector component.
4 - Create a style containing shared and event values to be applied at the Animated component.
5 - If you need to run some function based on an animation event, then you need to call it inside the event callback wrapper by the runOnJs function.

Example:

```typescript
import { GestureDetector, Gesture } from 'react-native-gesture-handler';
import Animated, { 
  useSharedValue, 
  useAnimatedStyle,
  withTiming,
  runOnJS
} from 'react-native-reanimated';

 export function MyScreen(){

 const CARD_INCLINATION = 10
 const CARD_SKIP_AREA = (-200)

 const cardPosition = useSharedValue(0);

   const dragStyles = useAnimatedStyle(() => {
    const rotateZ = cardPosition.value / CARD_INCLINATION;
    return {
      transform: [
        { translateX: cardPosition.value },
        { rotateZ: `${rotateZ}deg` }
      ]
    }
  })

  const onPan =  Gesture
  .Pan()
  //ACTIVATES THE PAN EVENT ONLY AFTER 200 MS
  .activateAfterLongPress(200)
  .onUpdate((event) => {
    cardPosition.value = event.translationX
  })
  .onEnd((event) => {
    if(event.translationX < CARD_SKIP_AREA) {

      runOnJS(handleSkipConfirm)();
    }
    cardPosition.value = withTiming(0)
  })

  return(
    <GestureDetector gesture={onPan}>
      <Animated.View style={useAnimatedStyle}>
        <Question
          key={quiz.questions[currentQuestion].title}
          question={quiz.questions[currentQuestion]}
          alternativeSelected={alternativeSelected}
          setAlternativeSelected={setAlternativeSelected}
        />
      </Animated.View>
    </GestureDetector>
  )
 }
```

## General Tips

- Use RectButton or BorderlessButton instead of TouchableOpacity or wrapping it to improve the user experience doing this component looks with the native button of each platform.
  
- Use the method .activateAfterLongPress(TIME_MS) when two events are running simultaneously (when user is simulating a long press and scrolling the screen for example) and you need some event perform before another one.