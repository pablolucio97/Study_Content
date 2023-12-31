# Using Next with Styled Components

This guide provides steps to create a Next.js application with Styled Components, ensuring a smooth setup for your project.

### Step 1: Create a New Next.js App
Use the following command to create a new Next.js application pre-configured with Styled Components:

### Step 2: Update Dependencies
To update your project's dependencies:

1. Visit the [Next.js GitHub repository](https://github.com/vercel/next.js/tree/canary/examples/with-styled-components).
2. Copy the `dependencies` and `devDependencies` from the `package.json` file in the repository.
3. Run `npm install` in your project directory to install the updated packages.

### Step 3: Babel Configuration
Create a new file named `.babelrc` in your project root with the following configuration:
```json
{
  "presets": ["next/babel"],
  "plugins": [["styled-components", { "ssr": true }]]
}
``````

### Step 4: Update Core Files
Replace your _app.jsx and _document.jsx files with the versions from the repository mentioned in Step 2. These files are specifically configured to work with Styled Components.

### Step 5: Implement Custom Document
In your _document.jsx file, import necessary modules and declare the render method. Here’s an example:

```typescript
import Document, { Html, Head, Main, NextScript } from 'next/document';

class MyDocument extends Document {
  render() {
    return (
      <Html lang='pt-BR'>
        <Head/>
        <body>
          <Main/>
          <NextScript/>
        </body>
      </Html>
    );
  }
}

export default MyDocument;
```