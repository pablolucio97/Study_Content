
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

### General Tips

- Use `tabBarBadge` to show data in tab.
- Disable back gesture on iOS with `gestureEnabled: false`.
- Use `<Group screenOptions={{ gestureEnabled: false }}>` to apply screenOptions to multiple screens.
