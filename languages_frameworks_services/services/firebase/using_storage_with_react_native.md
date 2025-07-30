# Using Firebase Cloud Storage with React Native

This guide helps you integrate Firebase Cloud Storage into your React Native application using `@react-native-firebase/storage`.

---

## 1. Set Up Firebase Storage

Go to the **Firebase Console**, select your project, and click on **Storage** > **Rules**.

---

## 2. Set Initial Rules

Update the rules and click **Publish**:

```
rules_version = '2';
service firebase.storage {
  match /b/{bucket}/o {
    match /{allPaths=**} {
      allow read, write;
    }
  }
}
```

---

## 3. Install Dependencies

Install Firebase core (if not already installed) and the Storage module:

`yarn add @react-native-firebase/app`  
`yarn add @react-native-firebase/storage`

---

## 4. Prepare for Uploads

In your Firebase Storage panel, create a folder (e.g., `images`) to organize your uploads.  
Use **Expo Image Picker** or similar tool to select images in your app.

---

## Uploading Files

```ts
const [image, setImage] = useState('');

async function handleUpload() {
  try {
    const fileName = new Date().getTime();
    const reference = storage().ref(`/images/${fileName}.png`);
    reference.putFile(image)
      .then(() => console.log('Upload complete'));
  } catch (error) {
    console.log(error);
  }
}
```

---

## Upload with Progress Tracking

```ts
const [image, setImage] = useState('');
const [transferredBytes, setTransferredBytes] = useState('');
const [progress, setProgress] = useState('0');

async function handleUpload() {
  try {
    const fileName = new Date().getTime();
    const reference = storage().ref(`/images/${fileName}.png`);
    const uploadTask = reference.putFile(image);

    uploadTask.on('state_changed', snapShot => {
      const percent = ((snapShot.bytesTransferred / snapShot.totalBytes) * 100).toFixed(0);
      setTransferredBytes(`${snapShot.bytesTransferred} of ${snapShot.totalBytes}`);
      setProgress(percent);
    });

    uploadTask.then(() => console.log('Upload completed'));
  } catch (error) {
    console.log(error);
  }
}
```

---

## Listing Files from Storage

```ts
const [photos, setPhotos] = useState<FileProps[]>([]);

useEffect(() => {
  storage().ref('/images').list()
    .then(result => {
      const files: FileProps[] = result.items.map(file => ({
        name: file.name,
        path: file.fullPath
      }));
      setPhotos(files);
    });
}, []);
```

---

## Getting File Details

```ts
const [currentPhotoView, setCurrentPhotoView] = useState('');
const [currentPhotoInfo, setCurrentPhotoInfo] = useState('');

async function handleShowImage(path: string) {
  const photo = await storage().ref(path).getDownloadURL();
  setCurrentPhotoView(photo);

  const info = await storage().ref(path).getMetadata();
  setCurrentPhotoInfo(`Uploaded at ${info.timeCreated}`);
}
```

---

## Deleting Files

```ts
async function deleteImage(path: string) {
  await storage().ref(path).delete()
    .then(() => console.log('Deleted image successfully'));
}
```

---

## References

- [Firebase Storage Docs](https://firebase.google.com/docs/storage/web/upload-files)
