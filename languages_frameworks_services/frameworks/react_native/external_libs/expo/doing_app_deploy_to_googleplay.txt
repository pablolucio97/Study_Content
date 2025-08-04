
# Doing App Deploy to Google Play

## Creating Splash Screen

### 1.1) Create Your Splash

Access the template through the link below, duplicate the template, edit the screen of your splash screen containing your app logo, remove the color fund, and export as .png.

[🔗 Splash Template on Figma](https://www.figma.com/file/ddc0glVeILssZl0Dcn1lSS/App-Icon-%26-Splashedit)

### 1.2) Configure the Splash in `app.json`

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
    "ios": { "supportsTablet": true },
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

### 1.3) Restart the server

---

## Generating Build on Android with Expo

### 2.1) Export logo.png from Figma.

### 2.2) Edit `app.json`

```json
{
  "expo": {
    "name": "gofinances",
    "slug": "gofinances",
    "scheme": "gofinances",
    "version": "1.0.0",
    "icon": "./assets/icon.png",
    "assetBundlePatterns": ["**/*"],
    "ios": {
      "bundleIdentifier": "com.gofinances",
      "buildNumber": "1.0.0"
    },
    "android": {
      "package": "com.gofinances",
      "versionCode": 1
    }
  }
}
```

### 2.3) Build App Bundle

```bash
yarn eas build -p android
```

### 2.4) Open Expo DevTools and click "Publish App".

### 2.5) Visit your Expo account to download the app.

---

## Configuring App Info on Google Play

### 3.1) Create App in Google Play Console

Provide name, type, accept terms.

### 3.2) Fill App Store Presence

- Name
- Descriptions
- App icon (512x512 PNG)
- Screenshots
- Cover image

### 3.3) Configure Inbox Flow

Follow steps including privacy policy link.

### 3.4) Create Internal Test

Create a test release and inform tester emails.

### 3.5) Download App Bundle from Expo.

### 3.6) Upload App Bundle

Upload to test release, fill release notes.

### 3.7) Release to Testers

Go to "General Versions" > "Advance" > "Start release to Internal testers".

### 3.8) Share Link

Get link to download test version via Google Play.

---

## Final Production Deploy

### 3.9) Add Regions and Countries

Go to "General Versions" > "Production" > Add target regions.

### 3.10) Add Version and Release

- Select uploaded bundle
- Fill notes
- Save > Avaliate > Start Production Release

Wait 1–2 days for Play Store publication.
