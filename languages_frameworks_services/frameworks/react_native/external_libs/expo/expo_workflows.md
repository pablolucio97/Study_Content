# TYPES OF EXPO WORKFLOWS

## Manager Workflow
Is the most simple and managed flow where it's possible to use only APIs that don't require native code management.

---

## Bare Workflow
Workflow where the native code is exposed, but it's necessary to set up manually to use more APIs that require native code management.

---

## Expo Prebuild
Is used to automatically handle the native configuration on libraries that require native configuration. These alterations are done through the installed plugins declared in `app.json`. Expo Prebuild converts the project to Bare Workflow at its first execution, or runs automated configurations based on plugins in subsequent executions.

---

## Development Builds (expo-dev-client)
Is used to create a custom compilation for development (an installable application in development yet). You need to create a development client and install it on the device whenever you need to implement APIs that require native code configuration. You must use the script `expo start --dev-client` to start a development compilation managed by Expo Go, but to do this, you need to run `npx expo run:android` or `npx expo run:ios` at least once.

# GENERAL TIPS

- Don't alter the native code if you're using expo prebuild, because the expo prebuild will overwrite these alterations.
- Expo prebuild only watches the plugins declared in `app.json`.
- When running the command `expo prebuild`, the native folder can be generated again with the respective changes.
- If you're doing the native configurations manually, use `expo-dev-client`. Do not mix `expo prebuild` with `expo-dev-client`. You must choose between using `expo prebuild` or doing the native configuration manually. Do not use these two approaches together.
- It's preferred to use `expo prebuild` instead of `expo-dev-client` because `expo prebuild` will handle the native configurations based on plugins.
- You can use plugins with `expo prebuild` to handle all native code instead of doing it manually.
