# Styled Components for React Native introduction course

Styled Components is a library for styling React and React Native applications using tagged template literals. It helps you write actual CSS code to style your components while keeping the concerns of styling and component logic separated.

---

## 🚀 Installation

```bash
yarn add styled-components
yarn add -D @types/styled-components-react-native
```

---

## 🎨 Creating Styled Components

```tsx
import styled from 'styled-components/native';

export const Container = styled.View`
  flex: 1;
  justify-content: center;
  align-items: center;
`;
```

---

## 💡 Using Props in Styled Components

```tsx
interface ButtonProps {
  bgColor: string;
}

export const Button = styled.TouchableOpacity<ButtonProps>`
  background-color: ${({ bgColor }) => bgColor};
  padding: 16px;
  border-radius: 8px;
`;
```

## Defining Themes with Styled Components in React Native

## 1. Create Your Theme

Create your theme inside `themes/theme.ts`.

```ts
export default {
  colors: {
    primary: '#5636D3',

    secondary: '#FF872C',
    secondary_light: 'rgba(255, 135, 44, .3)',

    sucesss: '#12A454',
    sucess_light: 'rgba(18, 164, 85, .5)',

    atention: '#E83F5B',
    atention_light: 'rgba(232, 63, 91, .5)',

    shape: '#FFFFFF',
    title: '#363F5F',
    text: '#969CB2',
    background: '#F0F2F5'
  }
}
```

---

## 2. Create the `styled.d.ts` Declaration

Inside the same folder (`themes`), create a `styled.d.ts` file with:

```ts
import 'styled-components'
import theme from './theme'

declare module 'styled-components' {
  type ThemeType = typeof theme
  export interface DefaultTheme extends ThemeType {}
}
```

---

## 3. Wrap Your App with the Theme Provider

```tsx
import React from 'react';
import { ThemeProvider } from 'styled-components/native';
import { Dashboard } from './src/screens/Dashboard';
import theme from './src/global/styles/theme'

export default function App() {
  return (
    <ThemeProvider theme={theme}>
      <Dashboard />
    </ThemeProvider>
  );
}
```

---

## 4. Access the Theme in Styled Components

```tsx
import styled from 'styled-components/native'

export const Container = styled.View`
  flex: 1;
  justify-content: center;
  align-items: center;
  background-color: ${({theme}) => theme.colors.background};
`

export const Title = styled.Text`
  font-size: 24px;
  font-weight: bold;
  color: ${({theme}) => theme.colors.title};
`
```

> ⚠️ If you need to extend native component props, use parentheses:
```tsx
const Button = styled(TouchableOpacity)``
```

---

# Accessing Props in Styled Components

```tsx
export const HighlightCards = styled.ScrollView.attrs({
  horizontal: true,
  showsHorizontalScrollIndicator: false,
  contentContainerStyle: { paddingHorizontal: 24 },
})``;
```

---

# Returning Native Elements with Custom Types

```tsx
import { FlatList } from 'react-native'

interface User {
  name: string;
  age: number;
}

interface DataListProps {
  id: string;
  user: User[];
}

export const TransactionsList = styled(
  FlatList as new () => FlatList<DataListProps>
).attrs({
  showsVerticalScrollIndicator: false,
  contentContainerStyle: {
    paddingBottom: getBottomSpace()
  },
})``;
```

---

# Using Icons with Styled Components and @expo/vector-icons

## 1. Import the Icon Set

```tsx
import { Feather } from "@expo/vector-icons";
```

## 2. Create a Styled Icon

```tsx
export const PowerIcon = styled(Feather)`
  color: ${({ theme }) => theme.colors.secondary};
  font-size: ${RFValue(24)}px;
`
```

## 3. Use the Icon

```tsx
<PowerIcon name="power" />
```
