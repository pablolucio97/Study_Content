# Configuring CI/CD with App Center (MS) and Expo

## 🚀 Continuous CI/CD Flow Overview

1. Developer pushes changes to GitHub.
2. App Center detects changes and triggers a build.
3. The new build is automatically sent to Google Play and/or Apple Store.

---

## 🛠️ Setting up CI with App Center and Expo

### 1. Create an Organization
- Go to [App Center](https://appcenter.ms/)
- Create a new organization to group your apps.

### 2. Add Apps to the Org
- Click "Add App"
- Provide app name, select:
  - Platform: React Native
  - OS: Android or iOS
  - Release Type: Production
- Add both Android and iOS apps if needed.

### 3. Configure GitHub Repo
- Open the App
- Go to **Build**
- Connect to GitHub and choose repo and branch
- Click **Configure build**

### 4. Set Build Configurations
- `Project`: path to package.json
- `Build Variant`: release
- `Node version`: stable
- Enable:
  - Build this branch on every push
  - Build Android App Bundle
  - Automatically increment version code
- Format: Build ID

### 5. Enable Signing
- Enable **Sign builds**
- Select "My Gradle settings are entirely set to handle signing automatically"
- Edit `android/app/build.gradle`:
```gradle
// Comment this line:
signingConfig signingConfigs.debug
```
- If using Bare workflow:
  - Upload your `.keystore` file
  - File path: `android/app/production-android.keystore`

### 6. Enable Advanced Options
- Copy badge status URL
- Click **Save and Build**

---

## 🚀 Setting up CD to Google Play

### 1. Google Play Console
- Go to Google Play Console → Settings → API Access
- Click **Create new project** and wait until ready

### 2. Google Cloud Platform
- Open the new GCP project
- Go to **IAM & Admin** → **Service Accounts** → **Create Service Account**
- Assign role: **Project / Owner**

### 3. Create Key for Service Account
- Click "Manage Keys" → "Add Key" → "Create new key"
- Select **JSON**, save to `resources/` folder

### 4. Link in Google Play Console
- In API Access → Click **Update Service Account**
- Grant all permissions → Invite user

### 5. Link in App Center
- App → Distribute → Stores → **Google Play**
- Upload your JSON key file
- Enter your package name (`com.yourappname`) → Click **Assign**

### 6. Automate Store Distribution
- App → Build → Configuration
- Enable **Distribute builds**
- Select **Store: Production**
- Write release notes
- Click **Save**

---

## 👥 Setup Testers for CD Approval

### 1. Create Staging Branch
- Create a `staging` branch in your repo
- Push some changes

### 2. Add Testers Group
- App → Distribute → Groups → **Add Group**
- Add emails and name

### 3. Configure Staging Branch
- App → Builds → Select `staging` branch → **Configure**
- Same configs as production
- Enable:
  - **Sign builds**
  - **Distribute builds**
  - Group: select the testers group
- Click **Save**

Testers will be notified when new builds are available.

---

_Last updated: 2025-08-04_
