# React Native Basic Course

## 📱 What React Native Does

Without React Native, mobile apps are built separately for each platform:

- **iOS** apps are written in **Swift or Objective-C**, generating a `.ipa` file.
- **Android** apps are written in **Kotlin or Java**, generating a `.apk` file.

With **React Native**, you write your app **once using JavaScript and React**, and it runs on **both platforms**.

> 🔧 React Native **does not convert JavaScript into Swift or Kotlin**.  
Instead, it uses a **JavaScript bridge** to communicate with **native modules**. These native modules render native UI components and access device capabilities, while your logic stays in JavaScript.

So, **the UI is native**, and the **logic is JavaScript**, making it possible to write cross-platform apps with near-native performance

**Core Components** are pre-built, cross-platform components provided by React Native. They serve as the building blocks for UI development and render native widgets under the hood.

### Common Core Components:

- `View`: A container that supports layout with Flexbox, styling, and touch handling.
- `Text`: For displaying text.
- `Image`: For rendering images.
- `TextInput`: For capturing text input from the user.
- `ScrollView`: A scrollable container for nested content.
- `TouchableOpacity`: A touchable wrapper that responds to user interaction.

**Native components** in React Native are components that:

- Are **implemented using native platform languages**:  
  - **Java/Kotlin** for Android  
  - **Objective-C/Swift** for iOS
- Are **bridged to JavaScript** using React Native’s Native Modules system.

They **don't exist in JavaScript by default** like Core Components (`View`, `Text`, `ScrollView`, etc.).

---

## 🔍 Why `Camera` and `MapView` Are Native

### 1. `react-native-camera` (`<RNCamera />`)

- Internally calls Android’s `Camera2` API and iOS’s `AVCaptureSession`.
- JavaScript only acts as a UI layer — **all logic like autofocus, frame capture, and barcode scanning happens natively**.

## Typography and Text in React Native

Typography in React Native is primarily handled through the `Text` component. It allows you to render and style text on the screen with flexibility similar to HTML/CSS.

---

### 📝 Basic Text Usage

```tsx
import { Text } from 'react-native';

<Text>Hello, React Native!</Text>
```

- All text content must be wrapped in a `Text` component.
- You can nest `Text` components to apply inline styles.

---

### 🎨 Styling Text

Text styling is applied using the `style` prop with properties similar to CSS.

```tsx
<Text style={{ fontSize: 20, fontWeight: 'bold', color: 'blue' }}>
  Styled Text
</Text>
```

#### Common style properties:
- `fontSize`
- `fontWeight` (`normal`, `bold`, `100–900`)
- `color`
- `textAlign` (`left`, `center`, `right`, `justify`)
- `lineHeight`
- `fontFamily` (custom fonts require linking)
- `textDecorationLine` (`underline`, `line-through`, etc.)

---

### 🧱 Nesting Text

You can apply different styles to parts of the same sentence using nested `Text` components:

```tsx
<Text>
  This is <Text style={{ fontWeight: 'bold' }}>bold</Text> and
  this is <Text style={{ fontStyle: 'italic' }}>italic</Text>.
</Text>
```

---

### 🔡 Uppercase, Lowercase, Capitalize

Use `textTransform` to control casing:

```tsx
<Text style={{ textTransform: 'uppercase' }}>Hello</Text> // Outputs: HELLO
```

Options:
- `none`
- `uppercase`
- `lowercase`
- `capitalize`

## Types of Inputs in React Native

In React Native, inputs allow users to enter and manipulate data. The framework provides several input components to handle text, touch, gestures, and form interaction.

---

### 📝 1. Text Input

Used for typing plain text, numbers, passwords, etc.

```tsx
import { TextInput } from 'react-native';

<TextInput
  placeholder="Enter your name"
  onChangeText={(text) => console.log(text)}
  style={{ borderWidth: 1, padding: 10 }}
/>
```

#### Props of interest:
- `placeholder`
- `secureTextEntry` (for passwords)
- `keyboardType` (e.g., `numeric`, `email-address`)
- `onChangeText`
- `value`

---

### 👆 2. Touchable Inputs

Used for interaction through touch. These components respond to user gestures.

#### a. `TouchableOpacity`

```tsx
<TouchableOpacity onPress={() => alert('Pressed!')}>
  <Text>Tap Me</Text>
</TouchableOpacity>
```

#### b. `Pressable` (more flexible than Touchable)

```tsx
<Pressable onPressIn={() => console.log('Pressed')}>
  <Text>Pressable Text</Text>
</Pressable>
```

---

### ✅ 3. Switch (Boolean Input)

Represents an on/off toggle switch.

```tsx
import { Switch } from 'react-native';

<Switch
  value={isEnabled}
  onValueChange={setIsEnabled}
/>
```

---

### 🔘 4. Picker / Dropdowns

Used for selecting one option from a list. In modern apps, libraries like `react-native-picker-select` or `@react-native-picker/picker` are used.

```tsx
import { Picker } from '@react-native-picker/picker';

<Picker selectedValue={selected} onValueChange={(value) => setSelected(value)}>
  <Picker.Item label="JavaScript" value="js" />
  <Picker.Item label="TypeScript" value="ts" />
</Picker>
```

---

### 📆 5. Date/Time Pickers

Used to select dates and times. Libraries like `@react-native-community/datetimepicker` are commonly used.

```tsx
<DateTimePicker
  value={new Date()}
  mode="date"
  display="default"
  onChange={(_, date) => setDate(date)}
/>
```

---

### 📌 Summary Table

| Type         | Component           | Purpose                        |
|--------------|---------------------|--------------------------------|
| Text         | `TextInput`         | Input plain text               |
| Boolean      | `Switch`            | Toggle on/off state            |
| Press        | `TouchableOpacity` / `Pressable` | Respond to touch     |
| Select       | `Picker`            | Select one from many options   |
| Date/Time    | `DateTimePicker`    | Choose date or time            |

## Types of Views and Lists in React Native

In React Native, a **view** is a container that supports layout with Flexbox, styling, and touch handling. There are several types of views that help structure and display your UI.

---

### 📦 1. View

The most basic container for components. It supports styling, layout, and nesting.

```tsx
import { View, Text } from 'react-native';

<View style={{ padding: 20, backgroundColor: '#eee' }}>
  <Text>Hello inside a View</Text>
</View>
```

Use cases:
- Grouping components
- Applying layout styles
- Creating rows or columns

---

### 📜 2. ScrollView

A view that allows scrolling if its content is larger than the screen. Great for smaller lists or forms.

```tsx
import { ScrollView, Text } from 'react-native';

<ScrollView>
  <Text>Scrollable content goes here</Text>
</ScrollView>
```

Use cases:
- Forms
- Articles or long text
- Basic scrollable pages

---

### 🪜 3. FlatList

An optimized scrollable list view for rendering long lists efficiently. Only renders items in view.

```tsx
import { FlatList, Text } from 'react-native';

<FlatList
  data={[{ id: '1', name: 'Item 1' }, { id: '2', name: 'Item 2' }]}
  keyExtractor={(item) => item.id}
  renderItem={({ item }) => <Text>{item.name}</Text>}
/>
```

Use cases:
- Long lists of data
- Chat messages
- Product listings

---

### 🎯 4. SectionList

Like FlatList but supports grouped sections of data.

```tsx
import { SectionList, Text } from 'react-native';

<SectionList
  sections={[
    { title: 'Fruits', data: ['Apple', 'Banana'] },
    { title: 'Vegetables', data: ['Carrot', 'Lettuce'] }
  ]}
  renderItem={({ item }) => <Text>{item}</Text>}
  renderSectionHeader={({ section }) => <Text>{section.title}</Text>}
/>
```

Use cases:
- Categorized data
- Grouped lists
- Directory structures

---

### 📌 Summary Table

| View Type    | Description                            | Best Use Case                          |
|--------------|----------------------------------------|----------------------------------------|
| `View`       | Basic layout container                 | Grouping and layout                    |
| `ScrollView` | Scrollable container for small content | Forms, articles                        |
| `FlatList`   | Efficient scrollable list              | Long dynamic lists                     |
| `SectionList`| Grouped list with headers              | Categorized or hierarchical data       |

Each view type serves a specific need. Understanding when to use each ensures performance and clarity in your UI layout.

## Handling Images in React Native

Displaying images is a common task in mobile apps, and React Native provides the `Image` component to do this effectively. It supports both local and remote images.

---

### 🖼️ Basic Usage

```tsx
import { Image } from 'react-native';

<Image
  source={{ uri: 'https://example.com/image.png' }}
  style={{ width: 200, height: 200 }}
/>
```

To display an image:
- Always set `width` and `height` explicitly via `style`
- Use the `source` prop with a remote `uri` or a local `require()`

## Touchable Components in React Native

Touchables are components that respond to user interactions like taps and gestures. React Native provides several touchable components that offer feedback and flexibility.

---

### 👆 1. TouchableOpacity

Decreases opacity when pressed, giving a fade effect.

```tsx
import { TouchableOpacity, Text } from 'react-native';

<TouchableOpacity onPress={() => alert('Pressed!')}>
  <Text>Tap Me</Text>
</TouchableOpacity>
```

- Simple and commonly used
- Good for buttons and icons

---

### 📌 2. TouchableHighlight

Darkens or highlights the background when pressed.

```tsx
import { TouchableHighlight, Text } from 'react-native';

<TouchableHighlight
  onPress={() => alert('Pressed!')}
  underlayColor="#DDDDDD"
>
  <Text>Highlight Me</Text>
</TouchableHighlight>
```

- Good for lists or cards
- Allows background color feedback

---

### ⚡ 3. TouchableWithoutFeedback

Doesn’t display any visual feedback when touched.

```tsx
import { TouchableWithoutFeedback, Keyboard, View } from 'react-native';

<TouchableWithoutFeedback onPress={Keyboard.dismiss}>
  <View>{/* dismisses keyboard on tap */}</View>
</TouchableWithoutFeedback>
```

- Useful for custom gestures
- Commonly used to dismiss the keyboard

---

### 🧩 4. Pressable (Modern and Flexible)

The recommended modern alternative with better control over press behavior and styling.

```tsx
import { Pressable, Text } from 'react-native';

<Pressable
  onPress={() => alert('Pressed!')}
  style={({ pressed }) => [
    {
      backgroundColor: pressed ? 'lightgray' : 'white',
      padding: 10
    },
  ]}
>
  <Text>Press Me</Text>
</Pressable>
```

- Provides detailed control over press states
- Preferred for complex gestures or feedback

---

### ✅ Summary Table

| Component              | Visual Feedback   | Use Case                            |
|------------------------|-------------------|-------------------------------------|
| `TouchableOpacity`     | Fade effect       | Buttons, icons                      |
| `TouchableHighlight`   | Background color  | List items, cards                   |
| `TouchableWithoutFeedback` | None         | Custom interactions, dismiss input |
| `Pressable`            | Customizable      | Modern, flexible touch handling     |

Choosing the right Touchable component improves user experience and provides consistent interaction feedback.

## Handling the Keyboard in React Native

Managing the on-screen keyboard is crucial for building smooth and accessible forms in React Native. The framework offers APIs and components to handle keyboard behavior properly.

---

### 🎯 Dismissing the Keyboard

You can dismiss the keyboard manually using the `Keyboard` API:

```tsx
import { Keyboard, TextInput, Button } from 'react-native';

<>

  <TextInput placeholder="Type here" style={{ borderWidth: 1, marginBottom: 10 }} />

  <Button title="Dismiss Keyboard" onPress={Keyboard.dismiss} />

</>
```

---

### 🧤 Using `TouchableWithoutFeedback` to Dismiss on Outside Press

Wrap your screen in `TouchableWithoutFeedback` to hide the keyboard when the user taps outside of the input:

```tsx
import { Keyboard, KeyboardAvoidingView, Platform, TouchableWithoutFeedback, View, TextInput } from 'react-native';

<TouchableWithoutFeedback onPress={Keyboard.dismiss}>
  <KeyboardAvoidingView
    behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
    style={{ flex: 1 }}
  >
    <View style={{ flex: 1, justifyContent: 'center', padding: 20 }}>
      <TextInput placeholder="Enter text" style={{ borderWidth: 1, padding: 10 }} />
    </View>
  </KeyboardAvoidingView>
</TouchableWithoutFeedback>
```

---

### ⌨️ Listening to Keyboard Events

You can detect when the keyboard shows/hides using event listeners:

```tsx
import { useEffect } from 'react';
import { Keyboard } from 'react-native';

useEffect(() => {
  const showSub = Keyboard.addListener('keyboardDidShow', () => {
    console.log('Keyboard is visible');
  });

  const hideSub = Keyboard.addListener('keyboardDidHide', () => {
    console.log('Keyboard is hidden');
  });

  return () => {
    showSub.remove();
    hideSub.remove();
  };
}, []);
```

---

### ✅ Best Practices for Keyboard Handling

| Practice                                 | Reason                                                                 |
|------------------------------------------|------------------------------------------------------------------------|
| Use `KeyboardAvoidingView`              | Prevents inputs from being hidden behind the keyboard                  |
| Wrap screen with `TouchableWithoutFeedback` | Allows dismissing keyboard when tapping outside the input             |
| Avoid fixed heights in form containers  | Helps ensure inputs are not pushed off-screen                         |
| Combine with `ScrollView` for long forms | Makes inputs scrollable when the keyboard is active                    |
| Always clean up event listeners         | Prevents memory leaks or multiple handlers being active                |

---

### 💡 Extra Tip: `react-native-keyboard-aware-scroll-view`

For complex forms, you can use:

```bash
npm install react-native-keyboard-aware-scroll-view
```

It automatically adjusts the scroll position when the keyboard is active.

```tsx
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';

<KeyboardAwareScrollView>
  <TextInput placeholder="Input 1" />
  <TextInput placeholder="Input 2" />
</KeyboardAwareScrollView>
```

---

Mastering keyboard handling improves user experience and form usability, especially on smaller screens or when using multiple input fields.

## Most Important and Commonly Used Native APIs in React Native

React Native provides several built-in **Native APIs** that give you access to platform-specific device features without writing native code.

---

### 📱 1. Linking

Used to interact with URLs (e.g., open a web page, dial a number, or deep link into another app).

```tsx
import { Linking } from 'react-native';

Linking.openURL('https://example.com');
```

---

### 🧭 2. Platform

Allows conditional logic based on the platform (iOS or Android).

```tsx
import { Platform } from 'react-native';

const instructions = Platform.OS === 'ios' ? 'Use iOS instructions' : 'Use Android instructions';
```

---

### ⌨️ 3. Keyboard

Controls the on-screen keyboard (e.g., dismiss, handle events).

```tsx
import { Keyboard } from 'react-native';

Keyboard.dismiss(); // Closes the keyboard
```

---

### 📏 4. Dimensions

Provides screen width and height values.

```tsx
import { Dimensions } from 'react-native';

const { width, height } = Dimensions.get('window');
```

Useful for responsive layouts.

---

### 🌓 5. Appearance

Detects and responds to light/dark mode.

```tsx
import { Appearance } from 'react-native';

const colorScheme = Appearance.getColorScheme(); // 'light' or 'dark'
```

---

### 📦 6. AsyncStorage (deprecated, moved to `@react-native-async-storage/async-storage`)

Used for persistent key-value storage.

```tsx
import AsyncStorage from '@react-native-async-storage/async-storage';

await AsyncStorage.setItem('user', 'Pablo');
const user = await AsyncStorage.getItem('user');
```

---

### 🧪 7. Vibration

Triggers device vibration (Android and iOS with limitations).

```tsx
import { Vibration } from 'react-native';

Vibration.vibrate(1000); // Vibrates for 1 second
```

---

### 🔄 8. BackHandler

Handles the hardware back button on Android.

```tsx
import { BackHandler } from 'react-native';

BackHandler.addEventListener('hardwareBackPress', () => {
  // custom logic
  return true; // prevent default behavior
});
```

---

### ✅ Summary Table

| API             | Purpose                                | Platforms |
|------------------|----------------------------------------|-----------|
| `Linking`        | Open URLs, dial phone numbers          | iOS/Android |
| `Platform`       | Detect platform                        | iOS/Android |
| `Keyboard`       | Manage on-screen keyboard              | iOS/Android |
| `Dimensions`     | Get screen width/height                | iOS/Android |
| `Appearance`     | Detect dark/light mode                 | iOS/Android |
| `AsyncStorage`   | Key-value persistent storage           | iOS/Android |
| `Vibration`      | Vibrate device                         | Android (limited on iOS) |
| `BackHandler`    | Handle Android hardware back button    | Android |

## General Tips

This guide provides practical, battle-tested tips for improving your React Native development experience, performance, and code quality.

---

### Styling and Layout

- Use `StyleSheet.create()` to declare and reuse style variables. This enables autocomplete and type safety.
- All React Native components default to `display: flex` and `flexDirection: column`.
- Use `flexShrink` to prevent text from pushing components. Use `flexGrow` to occupy available space.
- Use `position: 'absolute'` directly without needing `relative` on the parent.
- Use HTML character entities to render special characters.

---

### Inputs and Keyboard

- Wrap your entire screen with `TouchableWithoutFeedback onPress={Keyboard.dismiss}` to dismiss the keyboard when tapping outside inputs.
- Use `KeyboardAvoidingView` with `enabled` and `behavior='position'` to prevent the keyboard from overlapping content.
- Use `react-native-keyboard-aware-scroll-view` with `extraHeight` for a better keyboard experience:

```tsx
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';

<KeyboardAwareScrollView extraHeight={300}>
  {/* your content */}
</KeyboardAwareScrollView>
```

---

### Lists and Performance

- Use `FlatList` for rendering large lists. Prefer `map()` only for short, static lists.
- `FlatList` only renders visible items, improving performance.

---

### Navigation and Lifecycle

- Use `useFocusEffect` + `useCallback` from `@react-navigation/native` to load or refresh data on screen focus:

```tsx
useFocusEffect(
  useCallback(() => {
    loadTransactions();
  }, [])
);
```

- Disable gestures on iOS and back button on Android for Home screens:

```tsx
// iOS
<Screen name="Home" component={Home} options={{ gestureEnabled: false }} />

// Android
useEffect(() => {
  BackHandler.addEventListener('hardwareBackPress', () => true);
}, []);
```

---

### Data Handling

- Use `async/await` when working with file storage like AsyncStorage or filesystem.
- Use `react-native-uuid` to generate IDs:

```tsx
import uuid from 'react-native-uuid';
const id = uuid.v4();
```

- Always check for internet connection with NetInfo before fetching data.
- Avoid setting state after a component has unmounted to prevent memory leaks.

---

### Media and Images

- Use UI Avatars API when iOS doesn’t provide a user photo:

```
https://ui-avatars.com/api/?name=${user.fullName}
```

- Use `defaultBackground` on images to load them faster.
- Use `fill` prop when working with `react-native-svg`. Make sure SVGs don’t include `color` attributes.

---

### Configuration and Setup

- For issues with libraries, try manual linking:

```bash
yarn react-native link <library-name>
```

- When using JSON Server with Expo, use your local IP as host:

```json
"server": "json-server src/services/server.json --host 192.168.2.128 --port 3333"
```

---

### Routing

- Type your route sets (`AppRoutes`, `AuthRoutes`) separately.
- Export interfaces extending navigation props and use them in your screens.

---

