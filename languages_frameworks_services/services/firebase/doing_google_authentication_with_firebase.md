# Doing Sign-In with Google using Firebase

This guide walks you through integrating Google Sign-In using Firebase in a React application.

---

## 1. Create Firebase Project

Go to `https://firebase.google.com/` and create a new project.

---

## 2. Enable Google Sign-In

- Navigate to **Authentication > Get Started**
- Enable **Google** sign-in provider
- Supply your project name and email, then save

---

## 3. Create Realtime Database

- Go to **Realtime Database**
- Click **Create Database**
- Choose **Start in secure mode**, then save

---

## 4. Enable Firebase for Web

- Go to **Project Overview**
- Click the **Web (</>) icon** to add a new web app

---

## 5. Install Firebase

Run the following:

`yarn add firebase`

---

## 6. Create Firebase Service File

- Create a folder named `services`
- Inside it, create `firebase.ts`

---

## 7. Configure Firebase

Paste your Firebase config and set up instances:

```
import firebase from 'firebase'
import 'firebase/auth'
import 'firebase/database'

const firebaseConfig = {
  apiKey: process.env.REACT_APP_API_KEY,
  authDomain: process.env.REACT_APP_AUTH_DOMAIN,
  projectId: process.env.REACT_APP_PROJECT_ID,
  databaseURL: process.env.REACT_APP_DATABASE_URL,
  storageBucket: process.env.REACT_APP_STORAGE_BUCKET,
  messagingSenderId: process.env.REACT_APP_MESSAGING_SENDER_ID,
  appId: process.env.REACT_APP_APP_ID,
  measurementId: process.env.REACT_APP_MEASUREMENT_ID,
};

firebase.initializeApp(firebaseConfig)

const auth = firebase.auth();
const database = firebase.database();

export { auth, database }
```

---

## 8. Create Environment File

Create a `.env.local` file to store your variables and reference them in your config.

---

## 9. Create Context for Authentication

```
import { useState, useEffect, createContext, ReactNode } from 'react'
import { auth } from '../services/firebase'
import firebase from 'firebase'

type UserProps = {
    id: string;
    name: string;
    avatar: string;
}

type ChildrenProps = {
    children: ReactNode;
}

type AuthContextProps = {
    user: UserProps | undefined;
    signInWithGoogleFirebase: () => Promise<void>;
}

export const AuthContext = createContext({} as AuthContextProps)

export const AuthProvider = ({ children }: ChildrenProps) => {
    const [user, setUser] = useState<UserProps>()

    useEffect(() => {
        const unsubscribe = auth.onAuthStateChanged(user => {
            if (user) {
                const { displayName, photoURL, uid } = user
                if (!displayName || !photoURL) {
                    throw new Error('Missing information from Google account.')
                }

                setUser({
                    id: uid,
                    name: displayName,
                    avatar: photoURL
                })
            }
        })

        return () => { unsubscribe() }
    }, [])

    async function signInWithGoogleFirebase() {
        const provider = new firebase.auth.GoogleAuthProvider();
        const result = await auth.signInWithPopup(provider)

        if (result.user) {
            const { displayName, photoURL, uid } = result.user

            if (!displayName || !photoURL) {
                throw new Error('Missing information from Google account.')
            }

            setUser({
                id: uid,
                name: displayName,
                avatar: photoURL
            })
        }
    }

    return (
        <AuthContext.Provider value={{ user, signInWithGoogleFirebase }}>
            {children}
        </AuthContext.Provider>
    )
}
```
