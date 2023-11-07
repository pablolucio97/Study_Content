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

### Using default animations

You can use default animations like ZoomIn, FadeOut, and so on to apply default animations in your components. Example:

```typescript
import Animated, { ZoomIn, FadeOut } from 'react-native-reanimated';
import { useState } from 'react'
import { styles } from './styles';

function MyScreen(){

  const [isButtonVisible, setIsButtonVisible] = useState(false)
  const AnimatedTouchable = Animated.createAnimatedComponent(TouchableOpacity as never)

  return(
    <>
    <TouchableOpacity
        onPress={() => setIsButtonVisible(prevState => !prevState)}
      >
        <Text>Click me</Text>
      </TouchableOpacity>

      {
        isButtonVisible &&
        <AnimatedTouchable
          entering={ZoomIn.duration(1000)}
          exiting={FadeOut.duration(100)}
          style={styles.buttonAnimation}
        >
        <Text>Aimation</Text>
        </AnimatedTouchable>
      }
    </>
  )
}
```

### Applying animations on FlatLists

To apply animations on FlatLists the secret is to multiply its index by the animation value. Example:


```typescript

import { TouchableOpacity, TouchableOpacityProps, Text, View } from 'react-native';
import Animated, {FadeIn}from 'react-native-reanimated'

import { styles } from './styles';
import { THEME } from '../../styles/theme';

import { LevelBars } from '../LevelBars';
import { QUIZZES } from '../../data/quizzes';

type Props = TouchableOpacityProps & {
  data: typeof QUIZZES[0];
  index: number;
}

export function QuizCard({ data, index, ...rest }: Props) {
  const Icon = data.svg;

  const AnimatedTouchableOpacity = Animated.createAnimatedComponent(TouchableOpacity as never)

  return (
    <AnimatedTouchableOpacity
      style={styles.container}
      entering={FadeIn.delay(index * 100)}
      {...rest}
    >
      <View style={styles.header}>
        <View style={styles.iconContainer}>
          {Icon && <Icon size={24} color={THEME.COLORS.GREY_100} />}
        </View>

        <LevelBars level={data.level} />
      </View>

      <Text style={styles.title}>
        {data.title}
      </Text>
    </AnimatedTouchableOpacity>
  );
}
```
```typescript

export function MyScreen(){
  return(
    <>
       <FlatList
        data={quizzes}
        keyExtractor={item => item.id}
        renderItem={({ item, index }) => (
          <QuizCard
            data={item}
            index={index}
            onPress={() => navigate('quiz', { id: item.id })}
          />
    </>
  )
}

```


### General tips

- Use the Pressable component instead of TouchableOpacity if you want to apply animations in a button because Pressable has more available events than TouchableOpacity component like onPressIn and onPressOut.
  
- When rendering FlatLists, multiply the rendered element index by an animation value receiving the index as props to have an programed animated FlatList.




