# HOOKS

A special function that allows the use of React features like **state** in a functional component.

---

## **useState()**

Used to manage the state of a functional component.  
Always assigned to a `const` receiving an **array**.  
The initial value is passed as a parameter, and the state change function is the second item in the array.

**Example:**
```javascript
const [number, setNumber] = useState(5)

changeNumber = () => {
  setNumber(3)
}
```

---

## **useEffect()**

Should be used when dealing with **intervals** or the **component lifecycle**.  
If the second parameter of `useEffect` is empty, the function runs only once.

**Example:**
```javascript
import React, { useState, useEffect } from 'react'
import { View, Text, StyleSheet, TouchableOpacity } from 'react-native'

export default function UseStateExample() {
  const [count, setCount] = useState(0)
  const [msg, setMsg] = useState('')

  useEffect(() => {
    setMsg('Changed ' + count + ' times.')
  }, [count])

  function increaseCount() {
    setCount(count + 1)
  }

  return (
    <View style={styles.container}>
      <Text>Use State Example:</Text>
      <TouchableOpacity onPress={increaseCount}>
        <Text>Click-me</Text>
      </TouchableOpacity>
      <Text>{count}</Text>
    </View>
  )
}
```

**With Timer:**
```javascript
import React, { useState, useEffect } from 'react'
import { View, Text, StyleSheet } from 'react-native'

export default function useEffectExamples() {
  const [count, setCount] = useState(0)

  useEffect(() => {
    const interval = setInterval(() => { setCount(count + 1) }, 1000)
    return () => {
      clearInterval(interval)
    }
  })

  return (
    <View style={styles.container}>
      <Text>Count: {count}</Text>
    </View>
  )
}
```

---

## **useCallback()**

Used to **memoize functions** to avoid unnecessary re-creations on re-renders.  
Takes **two arguments**: the function and a dependency array.

**Example:**
```javascript
import React, { useState, useCallback } from 'react'
import { View, Text, Button, StyleSheet } from 'react-native'

const App = () => {
  const store = new Set()
  const [count1, setCount1] = useState(0)
  const [count2, setCount2] = useState(0)

  const increment1 = useCallback(() => setCount1(c => c + 1), [count1])
  const increment2 = useCallback(() => setCount2(c => c + 1), [count2])

  store.add(increment1)
  store.add(increment2)

  return (
    <View style={styles.container}>
      <Text>useCallBack example</Text>
      <Button title='Count1' onPress={increment1} />
      <Button title='Count2' onPress={increment2} />
      <Text>Count1: {count1}</Text>
      <Text>Count2: {count2}</Text>
      <Text>Store: {store.size - 2}</Text>
    </View>
  )
}
```

**Using `useCallback` with `React.memo` to avoid unnecessary renders:**

1. Define the function to store:
```javascript
import React, { useCallback, useState } from 'react';
import Buttons from './Buttons'

function UseCallbackExample() {
  const [count, setCount] = useState(0)

  const changer = useCallback(function (delta) {
    setCount(curr => curr + Number(delta))
  }, [setCount])

  return (
    <div>
      <Buttons changeCount={changer}/>
      <p>{count}</p>
    </div>
  );
}

export default UseCallbackExample;
```

2. Wrap the component with `React.memo`:
```javascript
import React from 'react';

function Buttons(props) {
  console.log('render components...')
  return (
    <div>
      <button onClick={() => props.changeCount(1)}>+1</button>
      <button onClick={() => props.changeCount(-1)}>-1</button>
    </div>
  );
}

export default React.memo(Buttons)
```

---

## **useMemo()**

Memoizes a value and executes a function **only when dependencies change**.

**Example:**
```javascript
import React, { useState, useMemo } from 'react'
import { View, Text, Button, TextInput, Alert } from 'react-native'

export default function App() {
  const [total, setTotal] = useState(0)
  const [x, setX] = useState(0)
  const [y, setY] = useState(0)

  const sumValues = (x, y) => {
    Alert.alert('My title', 'ok')
    return x + y
  }

  const result = useMemo(() => sumValues(x, y), [x, y])

  return (
    <View>
      <Text>useMemo example</Text>
      <TextInput
        keyboardType='numeric'
        onChangeText={valueX => valueX.length ? setX(parseInt(valueX)) : setX(0)}
        value={x.toString(10)}
        textAlign='center'
      />
      <TextInput
        keyboardType='numeric'
        onChangeText={valueY => valueY.length ? setY(parseInt(valueY)) : setY(0)}
        value={y.toString(10)}
        textAlign='center'
      />
      <Text>Result: {total}</Text>
      <Button title='Count2' onPress={() => setTotal(result)} />
    </View>
  )
}
```

---

## **useRef()**

Stores a reference and allows accessing/manipulating it without re-rendering.

**Example:**
```javascript
import React, { useRef } from 'react'
import { View, Text, Button, TextInput } from 'react-native'

export default function App() {
  const refInput = useRef(null)

  const getFocusInput = () => {
    refInput.current.focus();
  }

  return (
    <View>
      <Text>useRef example:</Text>
      <TextInput textAlign='center' ref={refInput} />
      <Button title='Get form focus' onPress={getFocusInput} />
    </View>
  )
}
```

---

## **useRef() Detailed Examples**

**Definition:**  
Used to store a reference and use it later without needing to re-render.

**Example 1: Basic Usage**
```javascript
import React from 'react'
import {View, Text, Button, TextInput} from 'react-native'
import {useRef} from 'react'

export default function App(){
  const refInput = useRef(null)

  const getFocusInput = () => {
    refInput.current.focus();
  }

  return(
    <View>
      <Text>useRef example:</Text>
      <TextInput textAlign='center' ref={refInput} />
      <Button title='Get form focus' onPress={() => {getFocusInput()}} />
    </View>
  )
}
```

**Example 2: Getting Previous State**
```javascript
import React from 'react'
import {View, Text, Button} from 'react-native'
import {useRef, useState, useEffect} from 'react'

function getPreviousState(value){
  const ref = useRef()
  useEffect(() => {
    ref.current = value
  })
  return ref.current
}

export default function App(){
  const [count, setCount] = useState(0)
  const previousState = getPreviousState(count)

  return(
    <View>
      <Text>useRef example:</Text>
      <Text>Previous state:{previousState} Current state:{count}</Text>
      <Button title='Increment' onPress={() => {setCount(count + 1)}} />
    </View>
  )
}
```

**Example 3: Handling a HTML Element Imperatively**
```javascript
const inputRef = useRef<HTMLInputElement>(null)

useEffect(() => {
  inputRef.current?.focus()
}, [])

return (
  <div className="App">
    <input type="type your name" ref={inputRef} />
  </div>
)
```

**Example 4: Avoiding Re-Render for Single Value Change**
```javascript
const inputRef = useRef<HTMLInputElement>(null)

const handleSubmit = useCallback((e: FormEvent) => {
  e.preventDefault()
  inputRef.current?.focus()
  console.log(inputRef.current?.value)
}, [])

return (
  <div className="App">
    <form onSubmit={handleSubmit}>
      <input type="type your name" ref={inputRef} />
      <button type="submit">Sent</button>
    </form>
  </div>
)
```

**Example 5: Handling a Value Without Re-Rendering Entire App**
```javascript
const inputRef = useRef<HTMLInputElement>(null)
const acceptedTerms = useRef({ value: false })

const handleRef = (e: FormEvent) => {
  e.preventDefault()
  const val = inputRef.current?.value
  console.log(val)
  console.log(acceptedTerms.current?.value)
}

const handleAcceptTerms = useCallback(() => {
  acceptedTerms.current.value = !acceptedTerms.current.value
}, [])

return(
  <form onSubmit={handleRef}>
    <p>Hello from refs</p>
    <input name='ref-input' ref={inputRef} placeholder='type your name' type="text" />
    <button type='submit'>Sent ref</button>
    <button type='button' onClick={handleAcceptTerms}>Accept terms</button>
  </form>
)
```

**Example 6: Passing Refs from Parent to Child Component**

*Parent:*
```javascript
import React, { useCallback, useRef, FormEvent } from 'react';
import UserRefChildren from './useRefsChildren'

const UseRef: React.FC = () => {
  const inputRef = useRef<HTMLInputElement>(null)
  const acceptedTerms = useRef({ value: false })

  const handleRef = (e: FormEvent) => {
    e.preventDefault()
    const val = inputRef.current?.value
    console.log(val)
    console.log(acceptedTerms.current?.value)
  }

  const handleAcceptTerms = useCallback(() => {
    acceptedTerms.current.value = !acceptedTerms.current.value
  }, [])

  return (
    <form onSubmit={handleRef}>
      <p>Hello from refs</p>
      <UserRefChildren name='name' title='Your name' ref={inputRef} />
      <button type='submit'>Sent ref</button>
      <button type='button' onClick={handleAcceptTerms}>Accept terms</button>
    </form>
  );
}

export default UseRef;
```

*Child:*
```javascript
import React, { InputHTMLAttributes, forwardRef } from 'react';

interface inputProps extends InputHTMLAttributes<HTMLInputElement>{
  name: string;
  title: string;
}

const UserefChildren: React.ForwardRefRenderFunction<HTMLInputElement, inputProps> = ({name, title, ...rest}, ref) => {
  return (
    <div>
      <label htmlFor={name}>{title}</label>
      <input ref={ref} {...rest} />
    </div>
  );
}

export default forwardRef(UserefChildren);
```

**Example 7: Passing Refs from Child to Parent Component**

*Child:*
```javascript
import React, {forwardRef, useState, useCallback, useImperativeHandle} from 'react';

export interface ModalHandles{
  openModal: () => void
}

const Modal: React.ForwardRefRenderFunction<ModalHandles> = (props, ref) => {
  const [visibleModal, setVisibleModal] = useState(true)

  const openModal = useCallback(() => {
    setVisibleModal(true)
  }, [])

  useImperativeHandle(ref, () => {
    return { openModal }
  })

  const closeModal = useCallback(() => {
    setVisibleModal(false)
  }, [])

  if(!visibleModal){
    return null
  }

  return (
    <div>
      <p>Modal opened</p>
      <button onClick={closeModal}>Close modal</button>
    </div>
  );
}

export default forwardRef(Modal);
```

*Parent:*
```javascript
import React, { useRef, useCallback } from 'react';
import Modal , {ModalHandles} from './hooks/useRefModal'

const App = () => {
  const modalRef = useRef<ModalHandles>(null)

  const handleOpenModal = useCallback(() => {
    modalRef.current?.openModal()
  }, []) 

  return(
    <div>
      <h1>Handling Modal</h1>
      <Modal ref={modalRef}/>
      <button onClick={handleOpenModal}>Open modal</button>
    </div>
  );
}

export default App;
```

---

## **useContext()**

**Step 1: Initialize the context, create a functional component to provide your values (props or state), and a custom hook to use it.**
```javascript
import React, {createContext, useContext, useState} from 'react'

export const CounterContext = createContext()

export default function CountProvider({children}) {
  const [count, setCount] = useState(123424)

  return (
    <CounterContext.Provider value={{count, setCount}}>
      {children}
    </CounterContext.Provider>
  )
}

export function useCounter(){
  const context = useContext(CounterContext)
  const {count, setCount} = context
  return {count, setCount}
}
```

**Step 2: Destructure the props of the hook and use them in a component.**
```javascript
import React from 'react'
import {useCounter} from './context/Countprovider'

export default function Counter() {
  const {count, setCount} = useCounter()

  return (
    <div>
      <p>Count: {count}</p> 
      <button onClick={() => {setCount(count + 1)}}>
        Increase count
      </button>
    </div>
  )
}
```

**Step 3: Import the context provider to wrap your application and use the component with the context.**
```javascript
import React from 'react'
import Counter from './Counter'
import CounterProvider from './context/Countprovider'

export default function App() {
  return (
    <CounterProvider>
      <Counter/>
    </CounterProvider>
  )
}
```

---

## **useReducer (JavaScript)**

The `useReducer` hook is used to update a complex object state, allowing you to change only the desired properties while returning the updated state.  
It receives a reducer function that maps the actions to update the state.

**Example:**
```javascript
import React from 'react';
import { useReducer } from 'react';

function UseReducerExample() {
  const initialState = {
    user: null,
    cart: [],
    products: [],
    number: 0
  }
  
  function reducer(state, action){
    switch(action.type){
      case('addNumber'):
        return {...state, number: state.number + 1}
      case('login'):
        return {...state, login: state.user = action.payload}
      default: 
        return state
    }
  }
  
  const [state, dispatch] = useReducer(reducer, initialState)

  return (
    <div>
      {state.user ? state.user : 'Without user'}
      <p>{state.number}</p>
      <button onClick={() => dispatch({type: 'addNumber'})}>
        Add number
      </button>
      <button onClick={() => dispatch({type: 'login', payload: 'Pablo'})}>
        Login
      </button>
    </div>
  );
}

export default UseReducerExample;
```

---

## **Creating and Consuming Contexts with useContext and useReducer**

**Step 1:** Create a new folder to store your context.  
Example: `PostsContext`.

---

**Step 2:** Create a new file named `data.ts` with your context raw data.
```javascript
export const data = {
  posts: [],
  loading: false
}
```

---

**Step 3:** Create a new file named `types.js` to store your action types.
```javascript
export const POSTS_LOADING = 'POSTS_LOADING'
export const POSTS_SUCCESS = 'POSTS_SUCCESS'
```

---

**Step 4:** Create a new file named `actions.js` to store your actions.  
When working with requests, always clean up unused requests by returning a function to be called in the component.
```javascript
import * as types from './types'

export const loadPosts = async (dispatch) => {
  dispatch({type: types.POSTS_LOADING})

  const postsRaw = await fetch('https://jsonplaceholder.typicode.com/posts')
  const posts = await postsRaw.json()
  return () => dispatch({type: types.POSTS_SUCCESS, payload: posts})
}
```

---

**Step 5:** Create a new file named `context.js` to initialize your context.
```javascript
import { createContext } from "react";

export const PostsContext = createContext()
```

---

**Step 6:** Create the reducer to handle your context.
```javascript
import * as types from './types'

export const reducer = (state, action) => {
  switch(action.type){
    case types.POSTS_SUCCESS:
      return {...state, posts: action.payload, loading: false}
    case types.POSTS_LOADING:
      return {...state, loading: true}
    default:
  }
  return {...state}
}
```

---

**Step 7:** Wrap your whole application with the desired context.
```javascript
import { PostsProvider } from "../context/with_reducer/PostsProvider"
import Posts from '../components/Posts'

const App = () => {
  return (
    <PostsProvider>
      <div>
        <Posts/>
      </div>
    </PostsProvider>
  )
}

export default App
```

---

**Step 8:** Use the context in your components.
```javascript
import { useContext, useEffect, useRef } from 'react'
import { loadPosts } from '../../context/with_reducer/PostsProvider/actions'
import { PostsContext } from '../../context/with_reducer/PostsProvider/context'

export default function Posts() {
  const isMounted = useRef(true)
  const {postState, postDispatch} =  useContext(PostsContext)

  useEffect(() => {
    loadPosts(postDispatch).then(dispatch => {
      if(isMounted.current){
        dispatch()
      }
    })
    return () => {
      isMounted.current = false
    }
  }, [postDispatch])

  return (
    <div>
      {
        postState.loading ?
          <p>Loading</p> :
          postState.posts.map((post) => (
            <p key={post.id}>{post.title}</p>
          ))
      }
    </div>
  )
}
```

---

## **Creating and Consuming Own Hooks**

**Step 1:** Create the hook by assigning a function to it.  
You can use other hooks inside your custom hook and return values/functions.
```javascript
import {useState} from 'react'

export const useCounter = (initialValue = 100) => {
  const [counter, setCounter] = useState(initialValue)

  function inc(){
    return setCounter(counter + 1)
  }

  function dec(){
    return setCounter(counter - 1)
  }

  return [counter, inc, dec]
}
```

---

**Step 2:** Import and destructure your hook.
```javascript
import React from 'react';
import {useCounter} from './useCounter'

function CustomHookExample() {
  const [counter, inc, dec] = useCounter()

  return(
    <div>
      <p>{counter}</p>
      <button onClick={inc}>+</button>
      <button onClick={dec}>-</button>
    </div>
  );
}

export default CustomHookExample;
```

---

## **Creating and Consuming Own Hooks**

**1) Create the hook assigning a function for this (you can use another hooks inside your personal hook) and return your values and functionalities:**
```javascript
import {useState} from 'react'

export const useCounter = (initialValue = 100) => {

  const [counter, setCounter] = useState(initialValue)

  function inc(){
    return setCounter(counter + 1)
  }

  function dec(){
    return setCounter(counter - 1)
  }

  return  [counter, inc, dec]
}
```

**2) Import and destructure your hook.**
```javascript
import React from 'react';
import {useCounter} from './useCounter'

function CustomHookExample() {
  const [counter, inc, dec] = useCounter()

  return(
    <div>
      <p>{counter}</p>
      <button onClick={inc}>+</button>
      <button onClick={dec}>-</button>
    </div>
  );
}

export default CustomHookExample;
```
---

# **GENERAL TIPS**

You can't to use the context directly in your App.js, you need to create a component to use it.

Exists two ways to work with programming with React: Declarative way: The behavior of the elements depend of the state value. Imperative way: You cann to access directly the html element value and atributes to handle your value and props.

All hooks should be types when using typescript.

The component only is renderized after the state value changes.

Create a folder to store your states and manage them trought useReducer when you are working with comlpex applications.

Avoid to set the state directly inside a useEffect hook for not generation infinit loop state changes.

Use a callback function inside the setState method to get the current value of the state. Ex: setCounter((curr) => curr + counter ).

Use a return inside the useEffect to clean events that don't should occour each state change. Example: 

```javascript
function printIt(){
  console.log('El has received a click')
}

useEffect(() => {
  document.querySelector('p').addEventListner('click', printIt)

  return () => {
    document.querySelector('p').removeEventListener('click', printIt)
  }
}, [])
```

Use [] for destructuring props for the value provider when this is an array and {} when is an object.

The useCallback() hook should be used not specific be a function is big and yes because the React crates a new position in the memory for the function every component renderization.

Update a state based on previous state rather that current state. Do a shallow copy of the state using spread operator and then update the state.

Use a callback function to update the state. Ex: prevState => setState(prevState).

- If possible, refact your code reducing the amount of states in your application.

Use the hook useRef for handle imperatively html and native elements like Inputs, TextInputs, CheckBox, and so on.

Avoid creating a state for everything. React state keeps a track of the data. The more states you use, the more data you have to keep track of acorss your application. Always is possible, handle the data from the same state.

Check the useEffects hooks conditionals and dependence array, duplicity, and execution order at facing Unsatisfactory renderization or side effects

Prefer working with object states to handle objects instead creating a state for each prop in the object.
