# Working with Authentication using `@react-native-firebase/auth`

## Installation

Run:

```
yarn add @react-native-firebase/auth
```

> ⚠️ If you haven't already, also install `@react-native-firebase/app`.

---

## 🔐 Anonymous Authentication

### Step 1: Enable in Firebase Console

1. Navigate to Firebase Console
2. Select your project → **Authentication** → **Get Started**
3. Under **Sign-in method**, enable **Anonymous**

### Step 2: Code Example

```
import auth from '@react-native-firebase/auth';

async function handleAnonymousSignIn() {
  const { user } = await auth().signInAnonymously();
  console.log(user);
}
```

---

## 📧 Email/Password Authentication

### Step 1: Enable in Firebase Console

1. Navigate to Firebase Console
2. Go to **Authentication** → **Sign-in method**
3. Enable **Email/Password**

---

### Step 2: Register a New User

```
import auth from '@react-native-firebase/auth';
import { useState } from 'react';
import { Alert } from 'react-native';

const [email, setEmail] = useState('');
const [password, setPassword] = useState('');

async function handleEmailPasswordRegistering() {
  try {
    await auth()
      .createUserWithEmailAndPassword(email, password)
      .then(() => console.log('User registered successfully'))
      .catch(error => {
        switch (error.code) {
          case 'auth/email-already-in-use':
            return Alert.alert('Auth Error', 'Email already in use.');
          case 'auth/invalid-email':
            return Alert.alert('Auth Error', 'Invalid email address.');
          case 'auth/weak-password':
            return Alert.alert('Auth Error', 'Password should be at least 6 characters.');
        }
        console.log(error.code);
      });
  } catch (error) {
    console.log(error);
  }
}
```

---

### Step 3: Sign In

```
async function handleEmailPasswordSignIn() {
  try {
    auth()
      .signInWithEmailAndPassword(email, password)
      .then(({ user }) => console.log(user.email))
      .catch(error => {
        if (
          error.code === 'auth/user-not-found' ||
          error.code === 'auth/wrong-password'
        ) {
          return Alert.alert('Auth Error', 'Invalid email or password.');
        }
      });
  } catch (error) {
    console.log(error);
  }
}
```

---

## 👤 Get Authenticated User

```
import { useEffect, useState } from 'react';
import auth from '@react-native-firebase/auth';

interface UserProps {
  uid: string;
}

const [user, setUser] = useState<UserProps | null>(null);

useEffect(() => {
  const subscriber = auth().onAuthStateChanged(userInfo => {
    setUser(userInfo);
  });
  return subscriber;
}, []);
```

---

## 🚪 Logout User

```
async function handleLogout() {
  try {
    await auth().signOut();
  } catch (error) {
    console.log(error);
  }
}
```
