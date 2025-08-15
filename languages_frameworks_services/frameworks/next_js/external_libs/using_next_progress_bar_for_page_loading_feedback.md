# Using Next Progress Bar for page loading feedback

Next ProgressBar is a feature used for give feedback for the user when a page is loading. 

## How to use it

1. Install the NextProgress running yarn add nextjs-progressbar.

2. Import and use it in your _app.tsx file. Example:

```typescript
import React from 'react'
import NextNprogress from 'nextjs-progressbar'

export default function App({ Component, pageProps }) {
  return (
    <>
        <NextNprogress
          color="#29D"
          startPosition={0.3}
          stopDelayMs={200}
          height={3}
          showOnShallow={true}
        />
        <Component {...pageProps} />
    </>
  )
}
```