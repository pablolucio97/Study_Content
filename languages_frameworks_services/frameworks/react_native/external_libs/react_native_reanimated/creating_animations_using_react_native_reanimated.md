# Creating animations using React Native Reanimated

## Concepts

### useSharedValue

The useSharedValue hook is used to store a value that will be used and can be shared to represent a reactive value that will be used in an animation. Example:

```typescript
 const scaleSharedValue = useSharedValue(1.5)
```

### useAnimatedStyle

The useAnimatedStyle hook is used to handle style animated properties through a function that returns the style object. Example:

```typescript
   const animatedContainerStyle = useAnimatedStyle(() => {
    return{
      transform: [{
        scale: scaleSharedValue.value
      }]
    }
  })
```


### Animated

Is the animation wrapper that will render the React component containing animated properties. Example:

```typescript
      <Animated.View style={
        [
          styles.container,
          animatedContainerStyle
        ]
      }>
        <Text>
          Text
        </Text>
      </Animated.View>
  ```

## Installig React Native Reanimated

1 - Install the reanimated running the command `'react-native-reanimated/plugin',`

2 - Add the Reanimated plugin `'react-native-reanimated/plugin',` to your .babelconfig file.

3 - Restart the Expo server or React Native application running `expo start -c`.


## Animation general configuration

1 - Import the `useSharedValue` from `react-native-reanimated` and assign the initial animation value to it.

2 - Import the `useAnimatedStyle` from `react-native-reanimated` and define the style using values assigned at your useSharedValue.

3 - Import the default `Animated` from `react-native-reanimated and apply the animated style in your Animated.DesiredComponent.

## Using animations examples

In the example below, we are altering the scale to 1.1 value when user press the button in and returning the value to 1 when user press the button out using too the withSpring modifier.

```typescript
import { Pressable, Text } from 'react-native';
import Animated, { useAnimatedStyle, useSharedValue, withSpring } from 'react-native-reanimated';

import { styles } from './styles';

export function Level() {

  const scaleSharedValue = useSharedValue(1)

  const animatedContainerStyle = useAnimatedStyle(() => {
    return {
      transform: [{
        scale: scaleSharedValue.value
      }]
    }
  })

  function handlePressIn() {
    scaleSharedValue.value = withSpring(1.1)
  }

  function handlePressOut() {
    scaleSharedValue.value = withSpring(1)
  }

  return (
    <Pressable
      onPressIn={handlePressIn}
      onPressOut={handlePressOut}
    >
      <Animated.View style={
        [
          styles.container,
          animatedContainerStyle,
        ]
      }>
        <Text>
          Text
        </Text>
      </Animated.View>
    </Pressable>
  );
}
```
In the example below, we are changing from red color to yellow color handled by interpolateColor method when the prop isChecked watched by useEffect changes.

```typescript
import { Pressable, Text, TouchableOpacityProps } from 'react-native';
import Animated, { interpolateColor, useAnimatedStyle, useSharedValue, withTiming } from 'react-native-reanimated';

import { useEffect } from 'react';
import { styles } from './styles';

type Props = TouchableOpacityProps & {
  isChecked?: boolean;
}

export function Level({isChecked = false, ...rest }: Props) {

  const isCheckedSharedValue = useSharedValue(1)

  const animatedCheckStyle = useAnimatedStyle(() => {
    return {
      backgroundColor: interpolateColor(
        isCheckedSharedValue.value,
        //the arrays need to have the same length, here each position represents a color linked a position
        [0, 1],
        ['red', 'yellow']
      )
    }
  })

  useEffect(() => {
    isCheckedSharedValue.value = withTiming(isChecked ? 1 : 0);
  }, [isChecked])

  return (
    <Pressable
      {...rest}>
      <Animated.View style={
        [
          styles.container,
          animatedCheckStyle,
        ]
      }>
        <Text>
          Text
        </Text>
      </Animated.View>
    </Pressable>
  );
}
```


### General tips

- Use the Pressable component instead of TouchableOpacity if you want to apply animations in a button because Pressable has more available events than TouchableOpacity component like onPressIn and onPressOut.
- 



