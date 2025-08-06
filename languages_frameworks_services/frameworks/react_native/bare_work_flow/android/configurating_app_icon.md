# 📱 CONFIGURING APP ICON

## 1. Open Android Project in Android Studio

- Launch **Android Studio Code**.
- Click on **"Open existing project"**.
- Navigate to your app folder and select the **Android** folder.

---

## 2. Navigate to Image Asset

- In Android Studio, select the **Project** view.
- Open your app folder.
- Right-click the **app** folder.
- Click **New > Image Asset**.

---

## 3. Configure Foreground Layer

- In the **Foreground Layer** tab:
  - Choose the **Image** option.
  - Upload your desired app icon image.
  - Set **Trim** to **Yes**.

---

## 4. Configure Background Layer

- Go to the **Background Layer** tab:
  - Select **Color**.
  - Set your app theme color as the background.
- Click **Next**, then **Finish**.

> ✅ Android Studio will replace the default Android icon with your custom icon.

---

## 5. (Optional) Change App Name

- Navigate to:
  ```
  your_app/android/app/src/main/res/values/strings.xml
  ```
- Edit the following:
  ```xml
  <string name="app_name">Your App Name</string>
  ```

---

## 6. Verify Icon Generation

- Make sure the file below exists:
  ```
  android/app/src/main/res/mipmap-anydpi-v26/ic_launcher-playstore.png
  ```
