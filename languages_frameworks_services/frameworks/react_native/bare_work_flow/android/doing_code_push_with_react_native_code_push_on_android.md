# 📦 Doing CodePush OTA in React Native

Code Push OTA (Over-The-Air) allows you to send updates to your app directly to users without needing to go through the app stores, **as long as no native code is changed**.

---

## ✅ 1. Installation

```bash
yarn add react-native-code-push
yarn global add appcenter-cli
```

---

## ⚙️ 2. Configure `android/settings.gradle`

Add at the end of the file:

```gradle
include ':app', ':react-native-code-push'
project(':react-native-code-push').projectDir = new File(rootProject.projectDir, '../node_modules/react-native-code-push/android/app')
```

---

## ⚙️ 3. Configure `android/app/build.gradle`

Below `project.ext.react`:

```gradle
apply from: "../../node_modules/react-native/react.gradle"
apply from: "../../node_modules/react-native-code-push/android/codepush.gradle"
```

---

## 🧠 4. Configure `MainApplication.java`

Add:

```java
import com.microsoft.codepush.react.CodePush;
```

Override:

```java
@Override
protected String getJSBundleFile() {
  return CodePush.getJSBundleFile();
}
```

---

## 🧱 5. Insert Deployment Keys

In `android/app/build.gradle` under `buildTypes`:

```gradle
buildTypes {
  debug {
    resValue "string", "CodePushDeploymentKey", '""'
  }

  releaseStaging {
    resValue "string", "CodePushDeploymentKey", '"<STAGING_KEY>"'
    matchingFallbacks = ['release']
  }

  release {
    resValue "string", "CodePushDeploymentKey", '"<PRODUCTION_KEY>"'
  }
}
```

---

## 🌐 6. Get Your Deployment Keys

Login to [AppCenter](https://appcenter.ms), create a project, go to **Distribute > CodePush**, click on the edit icon and copy the **Staging** and **Production** keys.

---

## 🧩 7. Wrap the App with CodePush

In your `App.tsx` or `App.js`:

```tsx
import React, { useEffect } from 'react';
import codePush from 'react-native-code-push';

function App() {
  useEffect(() => {
    codePush.sync({ installMode: codePush.InstallMode.IMMEDIATE });
  }, []);

  return <Home />;
}

export default codePush({
  checkFrequency: codePush.CheckFrequency.ON_APP_RESUME,
})(App);
```

---

## 🔐 8. Authenticate with App Center

```bash
appcenter login
```

Complete via browser.

---

## 🚀 9. Push the Release

```bash
appcenter codepush release-react -a yourOrganization/appName -d Production
```

This uploads your JavaScript bundle and assets.

---

## 🔗 Reference

https://github.com/microsoft/react-native-code-push/blob/master/docs/setup-android.md
