# Creating an Installable PWA with Next.js

1. **Develop Your Next.js Project:**
   - Create and develop your Next.js project with a focus on responsiveness, as it will be used on mobile devices.

2. **Install Progressive Web App Dependency:**
   - Run `npm i next-pwa --legacy-peer-deps` to install the PWA dependency without Next.js dependency conflicts.

3. **Prepare Application Icons:**
   - Provide four sizes of icons (192x192, 256x256, 384x384, and 512x512) for your application.
   - Place these PNG images in the `public` folder.

4. **Create manifest.json File:**
   - In the `public` folder, create a `manifest.json` file with necessary properties to make the app installable. Example:
     ```json
     {
         "theme_color": "#55FF",
         "background_color": "#DDDDDD",
         "display": "standalone",
         "scope": "/",
         "start_url": "/",
         "name": "PWA Model Advice App",
         "short_name": "AdviceAppPWAModel",
         "description": "PWA model advice app",
         "icons": [
             {
                 "src": "/icon-192x192.png",
                 "sizes": "192x192",
                 "type": "image/png"
             },
             // ... other icons
         ]
     }
     ```

5. **Configure _document.tsx File:**
   - The `<Head>` of `_document.tsx` should contain link tags pointing to the `manifest.json` file. Example:
     ```tsx
     import { Html, Head, Main, NextScript } from "next/document";

     export default function Document() {
       return (
         <Html>
           <Head>
             <link rel="manifest" href="/manifest.json" />
             <link rel="apple-touch-icon" href="/icon.png"></link>
             <meta name="theme-color" content="#fff" />
           </Head>
           <body>
             <Main />
             <NextScript />
           </body>
         </Html>
       );
     }
     ```

6. **Configure next.config.js File:**
   - Import `next-pwa` in `next.config.js`. It should be like:
     ```javascript
     const withPWA = require('next-pwa')({
       dest: 'public',
       register: true,
       skipWaiting: true,
       disable: process.env.NODE_ENV === 'development'
     });

     module.exports = withPWA({
       reactStrictMode: true,
     });
     ```

7. **Build Your Application:**
   - Run `npm run build` to generate your application build. The PWA installer should be visible in production.

8. **Deploy on Vercel:**
   - Push your code to GitHub and deploy it on the Vercel platform. Your installable PWA application should now be ready for use.
