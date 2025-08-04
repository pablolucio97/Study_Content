# 🖼️ Using SVG in React Native with react-native-svg-transformer

To use SVG images in a React Native project, especially with Expo, you should install and configure the `react-native-svg-transformer` library.

---

## 📦 1. Installation

```bash
yarn add react-native-svg-transformer
```

---

## ⚙️ 2. Configure Metro

Update your `metro.config.js` file:

```js
const { getDefaultConfig } = require("expo/metro-config");

module.exports = (() => {
  const config = getDefaultConfig(__dirname);
  const { transformer, resolver } = config;

  config.transformer = {
    ...transformer,
    babelTransformerPath: require.resolve("react-native-svg-transformer"),
  };
  config.resolver = {
    ...resolver,
    assetExts: resolver.assetExts.filter((ext) => ext !== "svg"),
    sourceExts: [...resolver.sourceExts, "svg"],
  };

  return config;
})();
```

---

## 📁 3. Type Declaration for SVG

Create a file at `src/@types/declarations.d.ts` and add:

```ts
declare module "*.svg" {
  import React from 'react';
  import { SvgProps } from "react-native-svg";
  const content: React.FC<SvgProps>;
  export default content;
}
```

---

## 📥 4. Importing SVGs

You can now import SVG files directly:

```tsx
import React from 'react';
import { Container } from './styles';
import LogoSvg from '../../assets/logo.svg';

export function SignIn() {
  return (
    <Container>
      <LogoSvg width={200} height={200} />
    </Container>
  );
}
```

---

## 🔄 5. Restart the Server

Make sure to restart your Expo/React Native server:

```bash
npx expo start -c
```
