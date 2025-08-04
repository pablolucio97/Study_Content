# 📱 Creating Splash Screen in Expo

## 1. Prepare Your Splash Image

Access the template below and duplicate it.  
Edit the screen with your app logo, **remove the background color**, and export as `.png`.

🔗 [Figma Template](https://www.figma.com/file/ddc0glVeILssZl0Dcn1lSS/App-Icon-%26-Splashedit)

Save it as:

```
assets/splash/logo.png
```

---

## 2. Configure `app.json`

Update your `app.json` to reference the splash image and set a background color that fits your design:

```json
{
  "expo": {
    "name": "rentx",
    "slug": "rentx",
    "version": "1.0.0",
    "orientation": "portrait",
    "icon": "./assets/icon.png",
    "splash": {
      "image": "./assets/splash/logo.png",
      "resizeMode": "contain",
      "backgroundColor": "#1B1B1F"
    },
    "updates": {
      "fallbackToCacheTimeout": 0
    },
    "assetBundlePatterns": ["**/*"],
    "ios": {
      "supportsTablet": true
    },
    "android": {
      "adaptiveIcon": {
        "foregroundImage": "./assets/adaptive-icon.png",
        "backgroundColor": "#FFFFFF"
      }
    },
    "web": {
      "favicon": "./assets/favicon.png"
    }
  }
}
```

---

## 3. Restart the Server

After configuring your splash screen, **restart the development server**:

```bash
npx expo start --clear
```

---

✅ Your splash screen should now appear when the app launches!
