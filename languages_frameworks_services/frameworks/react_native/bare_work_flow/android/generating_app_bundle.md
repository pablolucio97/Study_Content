# 📦 Generating App Bundle for React Native

This guide will help you generate a signed Android App Bundle for production release.

---

## 1. Generate the Keystore

```bash
keytool -genkeypair -v -storetype PKCS12 -keystore production-android.keystore \
-alias production-android -keyalg RSA -keysize 2048 -validity 10000
```

The `.keystore` file will be created in your `android/` folder.

---

## 2. Create `gradle.properties`

```bash
code ~/.gradle/gradle.properties
```

Add the following variables (use your real password):

```properties
MYAPP_UPLOAD_STORE_FILE=production-android.keystore
MYAPP_UPLOAD_KEY_ALIAS=production-android
MYAPP_UPLOAD_STORE_PASSWORD=yourpassword
MYAPP_UPLOAD_KEY_PASSWORD=yourpassword
```

---

## 3. Configure `build.gradle`

Open `android/app/build.gradle` and configure the `signingConfigs` and `buildTypes`:

```groovy
signingConfigs {
    debug {
        storeFile file('debug.keystore')
        storePassword 'android'
        keyAlias 'androiddebugkey'
        keyPassword 'android'
    }

    release {
        if (project.hasProperty('MYAPP_UPLOAD_STORE_FILE')) {
            storeFile file(MYAPP_UPLOAD_STORE_FILE)
            storePassword MYAPP_UPLOAD_STORE_PASSWORD
            keyAlias MYAPP_UPLOAD_KEY_ALIAS
            keyPassword MYAPP_UPLOAD_KEY_PASSWORD
        }
    }
}

buildTypes {
    debug {
        signingConfig signingConfigs.release
        if (nativeArchitectures) {
            ndk {
                abiFilters nativeArchitectures.split(',')
            }
        }
    }
    release {
        signingConfig signingConfigs.release
        minifyEnabled enableProguardInReleaseBuilds
        proguardFiles getDefaultProguardFile("proguard-android.txt"), "proguard-rules.pro"
    }
}
```

---

## 4. Update Config Values

Also in the same file:

```groovy
def enableSeparateBuildPerCPUArchitecture = false
def enableProguardInReleaseBuilds = true

project.ext.react = [
    enableHermes: true,
]
```

---

## 5. Build the App Bundle

Navigate to the `android/` folder and run:

```bash
./gradlew bundleRelease
```

The `.aab` bundle will be located at:

```
android/app/build/outputs/bundle/release/app-release.aab
```

---

## 🔗 References

- [React Native: Signed APK Android](https://reactnative.dev/docs/signed-apk-android)
