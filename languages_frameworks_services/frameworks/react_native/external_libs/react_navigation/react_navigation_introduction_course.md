
## React Navigation Introduction Course

### Creating a Stack Navigator

```
import * as React from 'react';
import { View, Text } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';

function HomeScreen() {
  return (
    <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
      <Text>Home Screen</Text>
    </View>
  );
}

function DetailsScreen() {
  return (
    <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
      <Text>Details Screen</Text>
    </View>
  );
}

const Stack = createStackNavigator();

function App() {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Details">
        <Stack.Screen name="Home" component={HomeScreen} />
        <Stack.Screen name="Details" component={DetailsScreen} />
      </Stack.Navigator>
    </NavigationContainer>
  );
}

export default App;
```

### Creating Mixed Navigators

```
import React from 'react'
import {createStackNavigator} from '@react-navigation/stack'
import {createDrawerNavigator} from '@react-navigation/drawer'
import {NavigationContainer} from '@react-navigation/native'

import Home from './assets/screens_obra_calc/Home'
import Walls from './assets/screens_obra_calc/Walls'
import Floors from './assets/screens_obra_calc/Floors'
import Concrete from './assets/screens_obra_calc/Concrete'
import Login from './assets/screens_obra_calc/login'

export default function App() {

  const Stack = createStackNavigator()
  const Drawer = createDrawerNavigator()

  function DrawerNav() {
    return(
    <Drawer.Navigator>
        <Drawer.Screen name='Home' component={Home}/>
        <Drawer.Screen name='Walls' component={Walls} />
        <Drawer.Screen name='Floors' component={Floors} />
        <Drawer.Screen name='Concrete' component={Concrete} />
    </Drawer.Navigator>
    )
  }

  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName='Login'>
        <Stack.Screen name='DrawerNav' component={DrawerNav}/>
        <Stack.Screen  name='Login' component={Login}/>
      </Stack.Navigator>
    </NavigationContainer>
  )
}
```

### Navigating Between Screens

```
import * as React from 'react';
import { Button, View, Text } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';

function HomeScreen({ navigation }) {
  return (
    <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
      <Text>Home Screen</Text>
      <Button
        title="Go to Details"
        onPress={() => navigation.navigate('Details')}
      />
    </View>
  );
}

function DetailsScreen({ navigation }) {
  return (
    <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
      <Text>Details Screen</Text>
      <Button
        title="Go to Details... again"
        onPress={() => navigation.push('Details')}
      />
      <Button
        title="Go back to first screen in stack"
        onPress={() => navigation.popToTop()}
      />
    </View>
  );
}

const Stack = createStackNavigator();

function App() {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Home">
        <Stack.Screen name="Home" component={HomeScreen} />
        <Stack.Screen name="Details" component={DetailsScreen} />
      </Stack.Navigator>
    </NavigationContainer>
  );
}

export default App;
```

### Passing Data Between Screens

**HomeScreen:**
```
import * as React from 'react';
import {useState} from 'react'
import { Button, View, Text } from 'react-native';

function HomeScreen({ navigation }) {
    const [name, setName] = useState('Ken');
    const handleState = () => {
        setName('Guile')
    }

    return (
      <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
        <Text>Home Screen</Text>
        <Button
          title="Go to Profile"
          onPress={() => navigation.navigate('ProfileScreen', {getname: name})}
        />
        <Text>My prefered char is {name}</Text>
        <Button
          title="Prefered char"
          onPress={handleState}
        />
      </View>
    );
}

export default HomeScreen;
```

**ProfileScreen:**
```
import * as React from 'react';
import { Button, View, Text } from 'react-native';

function ProfileScreen( {navigation, route} ) {
    return (
      <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
        <Text>Details Screen</Text>
        <Text>Prefered char: {route.params?.getname}</Text>
        <Button
          title='Go to Home'
          onPress={ () => navigation.navigate('HomeScreen')}
        />
      </View>
    );
}

export default ProfileScreen;
```

### Setting Screen Options

```
<TouchableOpacity style={styles.button} onPress={() => {
  navigation.setOptions({
    headerStyle: {
      backgroundColor: '#55ff'
    }
  })
}}>
  <Text style={{color: '#fff', fontSize: 22, textAlign: 'center'}}>EXPLORE</Text>
</TouchableOpacity>
```

### Setting Options Globally

```
<Stack.Navigator
  screenOptions={{
    headerStyle: { backgroundColor: '#f4511e' },
    headerTintColor: '#fff',
  }}>
  <Stack.Screen
    name="Home"
    component={HomeScreen}
    options={{ title: 'My home' }}
  />
</Stack.Navigator>
```
---

## Typing Routes Group in React Navigation

Typing a set of routes (e.g., `AppRoutes` and `AuthRoutes`) separately, exporting an interface extending its navigation props, and using this type in your screens is a good practice. It allows TypeScript to know your route names and properties.

---

## ✅ Bottom Tabs Example

```tsx
import { createBottomTabNavigator, BottomTabNavigationProp } from '@react-navigation/bottom-tabs'

type AppRoutes = {
    home: undefined;
    history: undefined;
    profile: undefined;
    exercise: undefined;
}

export type AppRoutesBottomTabNavigationProps = BottomTabNavigationProp<AppRoutes>

const BottomTab = createBottomTabNavigator<AppRoutes>()
```

### 🧭 Usage in a Screen

```tsx
import { useNavigation } from '@react-navigation/native'
import { AppRoutesBottomTabNavigationProps } from './path-to-your-types'

const navigation = useNavigation<AppRoutesBottomTabNavigationProps>()

function handleOpenExerciseDetails() {
    navigation.navigate('exercise')
}
```

---

## ✅ Stack Example

```tsx
import { createStackNavigator, StackNavigationProp } from '@react-navigation/stack'

type AuthRoutes = {
    signUp: undefined;
    signIn: undefined;
}

export type AuthNavigationRoutesProps = StackNavigationProp<AuthRoutes>

const Stack = createStackNavigator<AuthRoutes>()
```

### 🧭 Usage in a Screen

```tsx
import { useNavigation } from '@react-navigation/native'
import { AuthNavigationRoutesProps } from './path-to-your-types'

const navigation = useNavigation<AuthNavigationRoutesProps>()

function handleGoToSignUp() {
    navigation.navigate('signUp')
}
```

## Using SVG as Icon in React Native with React Navigation

1. Organize and Clean Your SVG File

Place your `.svg` file in a folder named `assets/` and **remove the `fill` attributes** from the `<svg>` and `<path>` tags to enable dynamic coloring from props.

2. Use Your SVG as a Tab Icon

Import the SVG and use it inside the screen options for each route.

```tsx
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs'

import CarSvg from '../../assets/car.svg'
import PeopleSvg from '../../assets/people.svg'

import { MyCars } from '../screens/MyCars'
import { Profile } from '../screens/Profile'
import theme from '../theme/theme'

export function TabPrivateRoutes() {
  const { Navigator, Screen } = createBottomTabNavigator()

  return (
    <Navigator
      screenOptions={{
        headerShown: false,
        tabBarActiveTintColor: theme.colors.main,
        tabBarInactiveTintColor: theme.colors.text_detail,
        tabBarShowLabel: false,
      }}
    >
      <Screen
        name='Profile'
        component={Profile}
        options={{
          tabBarIcon: ({ color }) => (
            <PeopleSvg fill={color} width={24} height={24} />
          ),
        }}
      />
      <Screen
        name='MyCars'
        component={MyCars}
        options={{
          tabBarIcon: ({ color }) => (
            <CarSvg fill={color} width={24} height={24} />
          ),
        }}
      />
    </Navigator>
  )
}
```



### General Tips

- Use `tabBarBadge` to show data in tab.
- Disable back gesture on iOS with `gestureEnabled: false`.
- Use `<Group screenOptions={{ gestureEnabled: false }}>` to apply screenOptions to multiple screens.
- Ensure you have `react-native-svg` and `@svgr/cli` or use `expo install react-native-svg` if you're in an Expo environment.
- To transform SVGs into usable components, use libraries like `react-native-svg-transformer`.
