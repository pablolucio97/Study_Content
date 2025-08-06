# 🚀 Deploying React Native App to Google Play

---

## 📱 1. Configuring the App Icon

1.1) Open Android Studio → "Open existing project" → Select the Android folder.

1.2) In "Project" view → Open "app" folder → Right-click → New → "Image Asset".

1.3) Foreground layer → Select "Image" → Upload your icon → Trim: "Yes".

1.4) Background layer → Select "Color" → Set your app theme color → Next → Finish.

1.5) To edit the app name → Edit file: `android/app/src/main/res/values/strings.xml`.

1.6) Check if `ic_launcher-playstore.png` is inside the correct drawable folder.

---

## 📸 2. Defining App Screenshots

2.1) Choose a Figma template:
- https://www.figma.com/file/TSbTQaglRp7o1VT2a8krrA/

2.2) Create folder `resources/screenshots` in project root → Set as default in emulator → Take screenshots.

2.3) Edit your Figma template with screenshots.

---

## 💥 3. Configuring Splash Screen

### 3.1) Create `background_splash.xml` in `android/app/src/main/res/drawable`:

```
<?xml version="1.0" encoding="utf-8"?>
<layer-list xmlns:android="http://schemas.android.com/apk/res/android">
  <item android:drawable="@color/splashscreen_bg"/>
  <item
    android:width="100dp"
    android:height="100dp"
    android:drawable="@mipmap/splash_icon"
    android:gravity="center" />
</layer-list>
```

### 3.2) Create `colors.xml` in `res/values`:

```
<resources>
  <color name="splashscreen_bg">#424242</color>
  <color name="app_bg">#424242</color>
</resources>
```

### 3.3) Configure `styles.xml`:

```
<resources>
  <style name="AppTheme" parent="Theme.AppCompat.Light.NoActionBar">
    <item name="android:textColor">#ffffff</item>
    <item name="android:statusBarColor">@color/app_bg</item>
    <item name="android:windowLightStatusBar">false</item>
    <item name="android:windowBackground">@color/app_bg</item>
  </style>
  <style name="SplashTheme" parent="Theme.AppCompat.Light.NoActionBar">
    <item name="android:statusBarColor">@color/splashscreen_bg</item>
    <item name="android:background">@drawable/background_splash</item>
  </style>
</resources>
```

### 3.4) Edit `AndroidManifest.xml` with two `<activity>` (SplashActivity and MainActivity) and correct theme references.

### 3.5) Create `SplashActivity.java`:

```java
public class SplashActivity extends AppCompatActivity {
  @Override
  protected void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    Intent intent = new Intent(this, MainActivity.class);
    startActivity(intent);
    finish();
  }
}
```

### 3.6) Export splash icons in `@1x`, `@2x`, `@3x` format → Place in mipmap folders and rename to `splash_icon.png`.

### 3.7) Install splash lib:

```bash
yarn add react-native-splash-screen
npx react-native link react-native-splash-screen
```

### 3.8) Edit `MainActivity.java`:

```java
@Override
protected void onCreate(Bundle savedInstanceState) {
  SplashScreen.show(this);
  super.onCreate(savedInstanceState);
}
```

### 3.9) Create `launch_screen.xml` in `res/layout`:

```xml
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
  android:layout_width="match_parent"
  android:layout_height="match_parent"
  android:background="@drawable/background_splash"
  android:orientation="vertical"/>
```

### 3.10) In `App.tsx`:

```tsx
useEffect(() => {
  SplashScreen.hide();
}, []);
```

---

## ☑️ 4. Configuring App Info in Google Play Console

4.1) Go to [Play Console](https://play.google.com/console) → "Create App" → Fill details.

4.2) Fill "Store Presence" tab: Name, Description, Icon (512x512), Screenshots, Cover.

4.3) Go to "Inbox" and follow the configuration checklist.

4.4) Go to "Testing" → "Internal test" → "Create Release" → Add testers.

4.5) Login in Expo, download the `.aab` build.

4.6) Upload `.aab` to release → Fill version notes → Save.

4.7) Go to "Production" → Start release to internal testers.

4.8) Copy internal test link → Test your app.

4.9) Go to "Production" → Set "Regions and Countries".

4.10) Create new version → Add library → Fill notes → "Start production release".

---

### 📚 References:

- [Splash Screen Guide on Notion](https://www.notion.so/Splash-Screen-no-Android-8da844d39d834f28bb578e41313ae493)
