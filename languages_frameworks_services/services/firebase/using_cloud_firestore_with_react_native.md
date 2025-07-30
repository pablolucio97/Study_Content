# Using Firebase and Cloud Firestore with React Native

This guide outlines how to integrate Firebase and Firestore in your React Native app using `@react-native-firebase`.

---

## Creating a New Firebase Project

### 1.1 Create Project in Firebase Console
Go to [Firebase Console](https://console.firebase.google.com/) and create a new project.

### 1.2 Install Firebase Core for React Native
Run:  
`yarn add @react-native-firebase/app`

### 1.3 Register Android App in Firebase
- Click "Android" in project settings
- Use package name from `MainActivity.java` (e.g., `com.yourname`)
- Use `./gradlew signingReport` to get the SHA-1 from `debugAndroidTest`
- Paste SHA-1 into the form and register the app

### 1.4 Download `google-services.json`
Place it in `android/app/` directory.

### 1.5 Modify `android/build.gradle`
Add this line under `buildscript > dependencies`:  
`classpath("com.google.gms:google-services:4.3.10")`

### 1.6 Modify `android/app/build.gradle`
After: `apply plugin: "com.android.application"`  
Add: `apply plugin: "com.google.gms.google-services"`  
Also add:  
`implementation platform("com.google.firebase:firebase-bom:29.2.1")`  
`implementation "com.google.firebase:firebase-analytics"`

### 1.7 Finalize
- Click "Next" and "Continue" in Firebase Console
- Restart app using: `yarn android`  
> Note: Firebase does not work with Expo Go.

---

## Configuring Cloud Firestore Database

### 2.1 Enable Firestore
- In Firebase Console: Click **Firestore Database** > **Create Database**
- Choose **Start in test mode**, region as `nam5 (us-central)`, click **Enable**

### 2.2 Add Collection
- Click **Start collection**
- Add documents with auto ID and fill fields, then click **Save**

### 2.3 Install Firestore SDK
Run:  
`yarn add @react-native-firebase/firestore`  
For iOS:  
`cd ios && pod install`

---

## Handling Documents and Collections in Code

### Insert Document
```ts
async function handleAddProduct(){
  const customId = String(Date.now())
  firestore().collection('products')
    .doc(customId)
    .set({
      description,
      quantity,
      done: false,
      createdAt: firestore.FieldValue.serverTimestamp()
    }).then(() => {
      Alert.alert('Product has been added successfully')
    })
}
```

### Get All Documents Once
```ts
useEffect(() => {
  firestore().collection('products').get()
    .then(response => {
      const data = response.docs.map(doc => ({
        id: doc.id,
        ...doc.data()
      }));
      setProducts(data as ProductProps[]);
    });
}, []);
```

### Get One Document
```ts
useEffect(() => {
  firestore().collection('products').doc('1648812096812').get()
    .then(response => console.log(response.data()));
}, []);
```

### Realtime Document Subscription
```ts
useEffect(() => {
  const subscribe = firestore().collection('products')
    .onSnapshot(querySnapshot => {
      const data = querySnapshot.docs.map(doc => ({
        id: doc.id,
        ...doc.data()
      }));
      setProducts(data as ProductProps[]);
    });
  return () => subscribe();
}, []);
```

### Filtering Documents
```ts
useEffect(() => {
  const subscribe = firestore().collection('products')
    .where("quantity", ">=", 2)
    .onSnapshot(querySnapshot => {
      const data = querySnapshot.docs.map(doc => ({
        id: doc.id,
        ...doc.data()
      }));
      setProducts(data as ProductProps[]);
    });
  return () => subscribe();
}, []);
```

### Limiting Queries
```ts
useEffect(() => {
  const subscribe = firestore().collection('products')
    .limit(5)
    .onSnapshot(querySnapshot => {
      const data = querySnapshot.docs.map(doc => ({
        id: doc.id,
        ...doc.data()
      }));
      setProducts(data as ProductProps[]);
    });
  return () => subscribe();
}, []);
```

### Ordering Queries
```ts
useEffect(() => {
  const subscribe = firestore().collection('products')
    .orderBy('description', 'desc')
    .onSnapshot(querySnapshot => {
      const data = querySnapshot.docs.map(doc => ({
        id: doc.id,
        ...doc.data()
      }));
      setProducts(data as ProductProps[]);
    });
  return () => subscribe();
}, []);
```

### Range Filtering with Ordering
```ts
useEffect(() => {
  const subscribe = firestore().collection('products')
    .orderBy('quantity')
    .startAt(2)
    .endAt(4)
    .onSnapshot(querySnapshot => {
      const data = querySnapshot.docs.map(doc => ({
        id: doc.id,
        ...doc.data()
      }));
      setProducts(data as ProductProps[]);
    });
  return () => subscribe();
}, []);
```

### Update Document
```ts
function handleDoneToggle(){
  firestore().collection('products').doc(data.id).update({
    done: !data.done,
  });
}
```

### Delete Document
```ts
function handleDeleteProduct(){
  firestore().collection('products').doc(data.id).delete();
}
```

---

## References
- Firestore Docs: https://firebase.google.com/docs/firestore
