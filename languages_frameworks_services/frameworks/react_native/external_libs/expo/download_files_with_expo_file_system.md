# 📥 Downloading Files in React Native using `expo-file-system`

This tutorial will walk you through how to download files in a React Native app using the `expo-file-system` API, including saving files on Android using Storage Access Framework.

---

## 🛠️ Installation

If you're using Expo, install the required packages:

```bash
expo install expo-file-system
```

> For Android file access, we’ll also use the `StorageAccessFramework` which is included in `expo-file-system`.

---

## 📁 Creating the Download Utility

### Step 1: Import Required Modules

```tsx
import * as FileSystem from 'expo-file-system';
import { Platform, Alert } from 'react-native';
```

---

### Step 2: Define Helper Function to Ensure Directory (optional for iOS)

```tsx
const ensureDirAsync = async (dir: string): Promise<void> => {
  const dirInfo = await FileSystem.getInfoAsync(dir);
  if (!(dirInfo.exists && dirInfo.isDirectory)) {
    await FileSystem.makeDirectoryAsync(dir, { intermediates: true });
  }
};
```

---

### Step 3: Download File and Save on Android Using SAF

```tsx
const downloadFile = async (fileUrl: string) => {
  try {
    const fileName = fileUrl.split('/').pop();
    const downloadPath = FileSystem.documentDirectory + fileName;

    const downloadResumable = FileSystem.createDownloadResumable(
      fileUrl,
      downloadPath
    );

    const { uri } = await downloadResumable.downloadAsync();

    if (Platform.OS === 'android') {
      await saveAndroidFile(uri, fileName!);
    } else {
      Alert.alert('Download complete', `Saved to ${uri}`);
    }
  } catch (error) {
    console.error('Download failed', error);
  }
};
```

---

### Step 4: Saving Files on Android using StorageAccessFramework

```tsx
const saveAndroidFile = async (fileUri: string, fileName: string) => {
  try {
    const base64 = await FileSystem.readAsStringAsync(fileUri, {
      encoding: FileSystem.EncodingType.Base64,
    });

    const permissions = await FileSystem.StorageAccessFramework.requestDirectoryPermissionsAsync();

    if (!permissions.granted) {
      Alert.alert('Permission required');
      return;
    }

    const uri = await FileSystem.StorageAccessFramework.createFileAsync(
      permissions.directoryUri,
      fileName,
      'application/octet-stream'
    );

    await FileSystem.writeAsStringAsync(uri, base64, {
      encoding: FileSystem.EncodingType.Base64,
    });

    Alert.alert('Success', 'File saved successfully');
  } catch (error) {
    console.error('Save failed', error);
  }
};
```

---

## ✅ Example Usage

```tsx
<Button title="Download PDF" onPress={() =>
  downloadFile('https://example.com/sample.pdf')
} />
```

---

## 📌 Notes

- SAF is required to write files to public storage on Android 10+.
- For iOS, files are saved within the app sandbox and are not accessible from the Files app unless shared.
