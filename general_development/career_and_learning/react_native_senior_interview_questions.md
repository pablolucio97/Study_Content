# Most Asked Senior React Native Interview Questions (With Answers)

---

## 1) What are the biggest differences between React (web) and React Native?

**Answer:**
- React Native renders to native views (UIView/Android View) instead of the DOM.
- No CSS cascade (inheriting through DOM) — styling uses `StyleSheet` or inline objects.
- Navigation, gestures, and animations use native libraries (react-navigation, gesture-handler, reanimated).
- Platform divergence: `Platform.select`, `.ios.tsx`/`.android.tsx` files.
- Uses Metro bundler, Hermes engine, and native build tools (Xcode/Gradle).

**What interviewers look for:** Understanding that RN = React + native platform concepts.

---

## 2) How do you optimize performance in React Native?

**Answer:**
- Use `FlatList`/`SectionList` with `getItemLayout`, `windowSize`, `removeClippedSubviews` instead using map method.
- Memoization: `React.memo`, `useCallback`, `useMemo`.
- Avoid inline functions/objects in lists.
- Use Reanimated 2+ for 60fps animations.
- Offload heavy work using JSI/TurboModules or native modules.
- Enable Hermes to improve performance on low-end devices.

**What they want:** Practical, specific optimizations + tooling knowledge.

---

## 3) Explain the new architecture: Fabric, TurboModules, JSI.

**Answer:**
- **JSI:** C++ interface allowing JS to call native directly (no JSON serialization).
- **TurboModules:** Lazy-loaded native modules via JSI for faster, type-safe calls.
- **Fabric:** New rendering system for sync and concurrent rendering.

**Benefits:** Lower latency, better performance, modern React features.

---

## 4) When would you use Hermes? Any trade-offs?

**Pros:**
- Faster startup.
- Lower memory usage.

**Cons:**
- Some native libs may be incompatible.
- Slightly larger binary if not optimized.

**Use Hermes for:** Most production apps, especially low-end Android.

---

## 5) How do you handle complex navigation at scale?

**Answer:**
- Use `react-navigation` with `native-stack` for performance.
- Use deep linking + universal links.
- Lazy load screens.
- Pass IDs (not large objects) in params and fetch data.
- Organize navigation in modules.

**What they want:** Architecture + performance awareness.

---

## 6) State Management: Redux vs Zustand vs Recoil vs Context?

**Answer:**
- UI/local state → Component state.
- Cross-screen local state → Zustand or Redux Toolkit.
- Server cache & async data → React Query.
- Avoid overusing Context (re-render issues).

**What they want:** Right tool for the right job.

---

## 7) How do you implement offline-first and data sync?

**Answer:**
- Persist data via AsyncStorage, SQLite, Realm, or WatermelonDB.
- Queue mutations offline using some interceptor; replay when online using a for to map over the queue.
- Use optimistic updates with rollbacks through manipulating mutations based on succeed and error response. Example:

```const prev = state.items;
setState(applyLocalChange());

api.mutate(change)
  .then(res => setState(commit(res)))     // keep
  .catch(() => setState({ items: prev })); // rollback
```

**What they want:** Real-world offline experience.

---

## 8) How to avoid jank in large lists with images?

**Answer:**
- Use `FastImage` for caching.
- Use `getItemLayout` when working with fixed length list to avoid layout thrashing.
- Memoize row components (`React.memo`).
- Avoid inline handlers in renderItem.
- Predefine image dimensions to avoid layout shifts.

---

## 9) How do you write and structure tests?

**Answer:**
- Unit Tests: Jest + @testing-library/react-native.
- Mock native modules with `jest.mock`.
- Component Tests: Test accessibility roles, interactions.
- E2E Tests: Detox or Maestro.

**What they want:** Practical, layered testing strategy.

---

## 10) How do you create native modules / bridge features?

**Answer:**
**New Architecture Approach:**
- Define TS spec → Generate code → Implement in Swift/Kotlin.

**Old Architecture:**
- Android: `@ReactMethod`
- iOS: `RCT_EXPORT_MODULE`

**Event Emitters:** Use `NativeEventEmitter` or `RCTDeviceEventEmitter`.

**What they want:** Confidence crossing JS ↔ Native.

---

## 11) Animations: Reanimated vs Animated?

**Reanimated 2+**
- Runs on UI thread.
- Perfect for gestures, parallax, complex animations.

**Animated (core)**
- JS thread.
- Good for simple animations.

**Best practice:** Use Reanimated + Gesture Handler for anything interactive.

---

## 12) Common memory leaks or crashes and prevention?

**Causes:**
- Not clearing subscriptions/timers in useEffect.
- Unremoved event listeners (AppState, Dimensions).
- Huge closures capturing large objects.
- Unbounded image caches.
- Multiple stacked navigators or modals.

**Prevention:** Clean up, profile with Flipper, Xcode, Android Profiler.

---

## 13) How do you secure a React Native app?

**Answer:**
- Store sensitive tokens on SecureAsyncStorage (not AsyncStorage).
- Installing a library for handling Root/jailbreak detection and block the screen when jailbreak detected.

**What they want:** Mobile security awareness.

---

## 14) CI/CD and Over-The-Air (OTA) Updates?

**CI:**
- Run lint, typecheck, Jest, Detox on PRs.

**CD:**
- Use Fastlane / GitHub Actions.
- Automate builds to Play Console & TestFlight using EAS through eas cli.
- Use version + build numbers.

**OTA Updates:**
- Use Expo Updates for JS changes.
- Execute rollbacks if needed.

---

## 15) How do you reduce bundle size and speed startup?

**Answer:**
- Enable Hermes.
- Code-splitting: dynamic import, lazy screens.
- Remove unused polyfills/dependencies.
- Compress assets, use SVG or WebP.
- Use `InteractionManager.runAfterInteractions` for heavy logic.
- Avoid unnecessary large libraries.

---

## 16) How do you handle deep linking and universal links?

**Answer:**
- Use `react-navigation` linking config.
- Define URL patterns in `config.screens`.
- For iOS: Associate Domains (`applinks:` in apple-app-site-association).
- For Android: `intent-filter` with `<data android:host="..." android:scheme="https" />`.
- Test with `npx uri-scheme open`.
- Handle fallback if app is closed.
- If using Expo Router

**What they want:** Understanding of setup across both platforms.

---

## 17) How do you deal with different screen sizes and safe areas?

**Answer:**
- Use `SafeAreaView` or `react-native-safe-area-context`.
- Use `Dimensions`, `useWindowDimensions`, or `react-native-responsive-fontsize`.
- Create responsive styles with percentage or flex.
- Use Breakpoints or custom hooks for form-factor.
- Avoid absolute positions when possible.

**What they want:** Responsive layout mastery.

---

## 18) How do you manage app themes and dark mode?

**Answer:**
- Use `Appearance` or `useColorScheme()` hook.
- Provide theme via Context or Zustand.
- Use design tokens (colors, spacing).
- Persist user preference if manually switched.
- Style components based on theme dynamically.

---

## 19) How do you debug React Native apps effectively?

**Answer:**
- Use Flipper (network, logs, React DevTools, Layout Inspector).
- Use `console.log`, breakpoints in VSCode.
- Android Studio/Xcode logs for native crashes.
- Inspect layout with Inspector (Cmd+D/Ctrl+M).

**What they want:** Multi-layer debugging skills.

---

## 20) How do you handle push notifications?

**Answer:**
- iOS: APNs; Android: FCM; often via Firebase Cloud Messaging.
- Use libraries: `react-native-push-notification` or `@react-native-firebase/messaging`.
- Request permission on iOS.
- Handle foreground/background/tapped states.
- Manage device tokens and register with backend.
- Use channels and priorities on Android.

---

## 21) How do you improve app startup time?

**Answer:**
- Enable Hermes.
- Lazy-load heavy modules.
- Avoid large synchronous work in `App` component.
- Preload fonts/assets asynchronously.
- Use splash screen wisely (expo-splash-screen or react-native-bootsplash).
- Defer API calls via `InteractionManager`.

---

## 22) How do you persist data securely?

**Answer:**
- Non-sensitive: AsyncStorage, MMKV.
- Sensitive: Keychain (iOS), Keystore (Android) via `react-native-keychain` or `expo-secure-store`.
- Encrypt local DB (WatermelonDB/Realm with encryption).

**What they want:** Security + practicality.

---

## 23) Explain how bridging works under the hood in old architecture.

**Answer:**
- JS thread sends messages to native via a queue (batched).
- Data serialized as JSON.
- Bridge listens on native thread, executes methods.
- Callbacks/events go back to JS.

**Limitations:** Async, JSON cost, threading overhead.

---

## 24) How do you reduce over-rendering in React Native?

**Answer:**
- Split large components.
- Use `React.memo`, `useCallback`, `useMemo`.
- Use `keyExtractor` consistently.
- Avoid creating new objects/styles inline.
- Use batched state updates.
- Use selectors in Redux/Zustand.

---

## 25) How do you implement biometric authentication?

**Answer:**
- Using `expo-local-authentication`, modules.
- Check availability (`hasHardwareAsync`, `isEnrolledAsync`).
- Prompt with FaceID/TouchID.
- Store token in Keychain or ExpoSecureStore.
- Fallback to PIN/password.

---

## 26) How do you handle accessibility (a11y) in React Native?

**Answer:**
- Use `accessible`, `accessibilityLabel`, `accessibilityRole` props.
- Use semantic components (Button, Switch).
- Enable VoiceOver/TalkBack testing.
- Ensure touch targets >= 44x44dp.
- Manage focus (`accessibilityHint`, `importantForAccessibility`).

**What they want:** Inclusive design knowledge.

---

## 27) How do you deal with different environments (dev/staging/prod)?

**Answer:**
- Use `.env` files with libraries like `react-native-config` or `expo-constants`.
- Separate API keys/URLs.
- Use build types (debug/release, flavors).
- Automate with CI/CD (different bundles).

---

## 28) How do you handle file uploads/downloads?

**Answer:**
- Use `react-native-document-picker` or `expo-document-picker`.
- Use `react-native-fs` or `fetch` for uploads/downloads.
- Monitor progress via `XMLHttpRequest`.
- Handle background transfers with native modules.
- Manage file permissions (Android storage).

---

## 29) How do you manage internationalization (i18n) and localization?

**Answer:**
- Use `react-native-localize` to detect locale.
- Use i18n libraries: `i18next`, `react-intl`, `expo-localization`.
- Extract strings to JSON.
- Handle RTL with `I18nManager`.
- Lazy-load language files.

---

## 30) How do you handle background tasks?

**Answer:**
- **iOS:** Background fetch, BGTaskScheduler, silent push.
- **Android:** Headless JS, WorkManager, foreground services.
- Libraries: `react-native-background-fetch`, `expo-task-manager`.
- Must declare capabilities in Info.plist/Manifest.

**What they want:** Platform limitations understanding.

## 31) How do you ensure consistent design across the app?

**Answer:**
- Create design system: spacing, colors, fonts, components.
- Build UI library/shared components.
- Use TypeScript for prop typing.
- Dark/light mode support.

---


## 32) How do you create a React component following the SOLID pattern?

S — Single Responsibility: One reason to change. Split UI, data-fetch, and state into component + hook + service.

O — Open/Closed: Add features via props/children/composition, not edits. Avoid if (type==='x') branches.

L — Liskov Substitution: Accept abstractions (interfaces). Any variant component/hook can replace another without breaking callers.

I — Interface Segregation: Keep small prop interfaces; avoid giant “god props”. Prefer multiple tiny components/hooks.

D — Dependency Inversion: Inject dependencies (APIs, formatters) via props/context; don’t import concrete singletons deep inside UI.

---

## 33) What is Expo Dev Client and when to use it?

A custom development build of your app (your own Expo Go). It’s a native binary (iOS/Android) compiled with your config plugins and native modules.

- Should be use when you want a stable, team-wide dev binary that matches production native code.

---

## 34) How do you manage environment variables in RN?

**Answer:**
- Use `react-native-config`, `expo-constants`, or `.env` with babel plugin.
- Separate `.env.development`, `.env.staging`, `.env.production`.
- Reference in build.gradle / Info.plist if needed.
- Don’t ship secrets — use backend-proxy or secure storage.