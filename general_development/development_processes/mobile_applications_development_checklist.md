# Web Applications Development Checklist

This checklist should be used to check the following requirements before pushing your code to grant quality, scalability, accessibility, and good practices.

## Components and UI
- Create and use flexible and reusable components.
- Try to follow the "Perfect Pixel" concept at building components and pages from a prototype.
- Always have a hook file for each screen that needs to work with states and makes server requests. Keep the UI in a separate file, try to keep this file as clean as possible.

## TypeScript and Code Quality
- Use TypeScript accordingly for typing elements, components, functions, hooks, and variables using Type, Interface, Records correctly. Avoid `any`; prefer strict typing for props, state, hooks, functions, and API responses.
- Ensure using a professional code structure.
- Use meaningful variable names. 
- Avoid magic numbers when performing calculations or comparisons.

## 🎨 UI & Accessibility
- Use **React Native components** appropriately (`<ScrollView>`, `<FlatList>`, `<TouchableOpacity>`).  
- Follow **accessibility best practices**:  
  - Add `accessibilityLabel` and `accessible` props for blind or decreased capabilities persons listen to the content when hoovering hover the element when exploring them with a screen reader (VoiceOver on iOS, TalkBack on Android).  
  - Ensure all touchable areas are at least **44x44px** (WCAG standard).  
- Use **semantic RN equivalents**: `Pressable` instead of `View` for clickable items. Use it when the visible text or icon is not enough (or missing).
- Ensure **dark mode** support and **dynamic font scaling** (`allowFontScaling`).  
- Always define a **SafeAreaProvider** on new screens to prevent overlapping with system bars.  
- Use `useSafeAreaInsets` to calculate dynamic paddings for headers and footers.

## State Management and Async Handling
- Show **feedback indicators** (ActivityIndicator, skeleton, shimmer) while loading.  
- Always disable action buttons when some async process is running.
- At working with React, check for correct hooks dependencies and duplicated hooks/calls.
- Prefer `useMemo` and `useCallback` for expensive computations or stable references.
- Avoid using React's context api because it rerenders all React Dom. Prefer using Zustand or Redux Tool Kit.

## 🌍 Performance & Scalability
- Use **FlatList/SectionList** instead of mapping large arrays manually.  
- Apply **lazy loading** and **dynamic imports** where possible.  
- Use **React.memo** for pure UI components.  
- Optimize images with **Expo Image** and caching strategies.  
- Avoid unnecessary re-renders with proper **state management** (`Zustand`, `Redux Toolkit`, or Context API).  

## Error Handling and Messaging
- Always apply the most appropriate error message according to the server response.

## Constants and Utilities
- Always store constant data in a single source in the application. Avoid duplicating constant values like Brazilian CPF length, storage keys, and so on.
- Keep your utility functions reusable under a utilities folder. Do not write the same function twice.

## Logging and Debugging
- Verify and remove loose `console.log` in the code.

## Linting and Formatting
- Use ESLint for code patterns and Prettier for correct formatting.

## Testing
- Write unit and integration tests for critical logic and components.

## Imports and Tree-Shaking
- Only import from third-party libraries (tree-shakable libs) the code you really need. Avoid generic imports, e.g., `import * as MUI from "@mui/material";`

## Code quality
- Avoid magic numbers at performing some calc or comparison.
- Verify and remove loose console.log in the code.
- Use Eslint for code patterns and Prettier for formatting correctly.
- Ensure using a professional code structure.
- Write unit and integration tests for critical logic and components.
- Only imports from third libraries (tree shakable libs) the code you really need. Avoid generic imports, e.g. `import * as MUI from "@mui/material"; `
  