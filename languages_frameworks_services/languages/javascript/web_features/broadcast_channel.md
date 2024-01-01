# BroadcastChannel API

BroadcastChannel is a native API that allows communication data between 
the currently opened tabs in the browser. Through this API, it is possible 
to do actions that will be reflected in all current tabs opened. 

In this example written using React, all currently opened tabs will see 
if the user is logged in or not:

```javascript
import { useEffect } from 'react'

export default function Home() {

  let authChannel : BroadcastChannel

  function signIn() {
    authChannel.postMessage('login')
  }
  
  function signOut() {
    authChannel.postMessage('logout')
  }
  
  useEffect(() => {
    authChannel = new BroadcastChannel('auth')
    authChannel.onmessage = (message) => {
      switch(message.data){
        case 'login':
          return console.log('User is logged')
        case 'logout':
          return console.log('User not is logged')
        default:
          break
      }
    }
  }, [])

  return (
    <div>
      <h1>Hello from Home</h1>
      <button onClick={signIn}>Login</button>
      <button onClick={signOut}>Logout</button>
    </div>
  )

}
