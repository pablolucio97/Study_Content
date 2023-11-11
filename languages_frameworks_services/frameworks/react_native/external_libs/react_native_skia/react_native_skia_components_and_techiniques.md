# React Native Skia Components and Techniques examples

## Component examples

### View with blur:

```typescript
import { Canvas, Rect, Blur } from '@shopify/react-native-skia'
import { View, useWindowDimensions } from 'react-native'

type OverlayFeedback = {
    color: string
}

export function OverlayFeedback({ color }: OverlayFeedback) {
    const { width, height } = useWindowDimensions()
    return (
        <View style={{ width, height, position: 'absolute' }}>
            <Canvas
                style={{ flex: 1 }}
            >
                <Rect
                    x={0}
                    y={0}
                    width={width}
                    height={height}
                    color={color}
                >
                    <Blur blur={32} mode='decal'/>
                </Rect>
            </Canvas>
        </View>
    )
}

// USAGE IN A SCREEN:

<OverlayFeedback color='red'/>

```

### Animated CheckboxOptionCard

```typescript
import {
  Canvas,
  Circle,
  Path,
  Skia,
  runTiming,
  useValue
} from '@shopify/react-native-skia';
import { useEffect } from 'react';
import {
  Text,
  TouchableOpacity,
  TouchableOpacityProps
} from 'react-native';
import { THEME } from '../../styles/theme';
import { styles } from './styles';

type Props = TouchableOpacityProps & {
  checked: boolean;
  title?: string;
}

const CHECK_SIZE = 28;
const CHECK_STROKE = 2;
const RADIUS = (CHECK_SIZE - CHECK_STROKE) / 2
const CENTER_CIRCLE = RADIUS / 2

const circlePath = Skia.Path.Make()
circlePath.addCircle(CHECK_SIZE, CHECK_SIZE, RADIUS)

export function Option({ checked, title, ...rest }: Props) {

  const animatedPercentage = useValue(0)
  const animatedCircle = useValue(0)

  useEffect(() => {
    if (checked) {
      runTiming(animatedPercentage, 1, { duration: 640 })
      runTiming(animatedCircle, CENTER_CIRCLE, { duration: 400 })
    } else {
      runTiming(animatedPercentage, 0, { duration: 640 })
      runTiming(animatedCircle, 0, { duration: 400 })
    }
  }, [checked])

  return (
    <TouchableOpacity
      style={
        [
          styles.container,
          checked && styles.checked
        ]
      }
      {...rest}
    >
      <Text style={styles.title}>
        {title}
      </Text>

      <Canvas style={{ height: CHECK_SIZE * 2, width: CHECK_SIZE * 2 }}>
        <Path
          path={circlePath}
          color={THEME.COLORS.GREY_500}
          style="stroke"
          strokeWidth={CHECK_STROKE}
        />
        <Circle
          cx={CHECK_SIZE}
          cy={CHECK_SIZE}
          r={animatedCircle}
          color={THEME.COLORS.BRAND_LIGHT}
        />
        <Path
          path={circlePath}
          color={THEME.COLORS.BRAND_LIGHT}
          style="stroke"
          strokeWidth={CHECK_STROKE}
          start={0}
          end={animatedPercentage}
        />
      </Canvas>
    </TouchableOpacity >
  );
}

```

## Animating Svg

To animate SVG you need to import the Path from react-native-skia, pass your svg file path code to the path property of the Path component, create a blink animation using the useLoop hook, and apply this hook to the opacity Path component property. Example:

```typescript
import {
    Canvas,
    Easing,
    LinearGradient,
    Path,
    useLoop
} from "@shopify/react-native-skia";
import { View } from "react-native";
import { THEME } from "../../styles/theme";
import { styles } from "./styles";

export function AnimatedStar() {

  const animationBlink = useLoop({
    duration: 2400,
    easing: Easing.bounce
  })

  return (
    <View style={styles.container}>
      <Canvas style={styles.canvas}>
      <Path 
        opacity={animationBlink}
        path="M232.405 231.922C232.005 231.922 231.648 231.666 231.52 231.287C229.729 225.979 228.387 224.638 223.079 222.846C222.7 222.718 222.444 222.362 222.444 221.961C222.444 221.561 222.7 221.204 223.079 221.076C228.388 219.285 229.729 217.943 231.52 212.635C231.648 212.255 232.004 212 232.405 212C232.806 212 233.162 212.255 233.29 212.635C235.082 217.943 236.423 219.284 241.731 221.076C242.11 221.204 242.366 221.561 242.366 221.961C242.366 222.362 242.11 222.718 241.731 222.846C236.423 224.638 235.082 225.979 233.29 231.287C233.162 231.666 232.806 231.922 232.405 231.922Z"
        color={THEME.COLORS.WARNING_LIGHT}
      />
         </Canvas>
    </View>
  )
}
```