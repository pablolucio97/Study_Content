# Using Custom Fonts with Expo and Styled Components

## 1. Install the Required Packages

Install Expo Font, AppLoading, and the desired font families:

```bash
npx expo install expo-font expo-app-loading
npx expo install @expo-google-fonts/poppins
```

---

## 2. Configure Font Loading in `App.tsx`

Import and configure the font loading using `useFonts`. While fonts load, render a fallback (`AppLoading` or return `null`):

```tsx
import React from 'react';
import { ThemeProvider } from 'styled-components/native';
import AppLoading from 'expo-app-loading';
import {
  useFonts,
  Poppins_400Regular,
  Poppins_500Medium,
  Poppins_700Bold
} from '@expo-google-fonts/poppins';

import theme from './src/global/styles/theme';
import { Dashboard } from './src/screens/Dashboard';

export default function App() {
  const [fontsLoaded] = useFonts({
    Poppins_400Regular,
    Poppins_500Medium,
    Poppins_700Bold,
  });

  if (!fontsLoaded) {
    return <AppLoading />;
  }

  return (
    <ThemeProvider theme={theme}>
      <Dashboard />
    </ThemeProvider>
  );
}
```

---

## 3. Define Fonts in the Theme

Add the font family names to your custom theme:

```ts
export default {
  colors: {
    title: '#363F5F',
    background: '#F0F2F5',
    shape: '#FFFFFF',
    // ...
  },
  fonts: {
    regular: 'Poppins_400Regular',
    medium: 'Poppins_500Medium',
    bold: 'Poppins_700Bold',
  },
};
```

---

## 4. Use Fonts in Styled Components

Apply the font styles in your styled-components:

```tsx
import styled from 'styled-components/native';

export const Title = styled.Text`
  font-size: 24px;
  font-weight: bold;
  color: ${({ theme }) => theme.colors.title};
  font-family: ${({ theme }) => theme.fonts.bold};
`;
```

---

## Notes

- Always match the font names exactly as defined by `@expo-google-fonts`.
- You can use other fonts like `Archivo`, `Roboto`, etc., by replacing the `useFonts` import.
- `expo-app-loading` is deprecated in SDK 50+. Use `SplashScreen` or conditional returns in the `App` component if you're on a newer version.
