# Setting Up Service Worker and Manifest for PWA

---

## 1. Create Service Worker

Create a file named `serviceWorker.js` inside the `src` folder of your project and paste the following code from your repository:

🔗 [serviceWorker.js](https://github.com/your_user/your_repo/blob/master/src/serviceWorker.js)

---

## 2. Edit `manifest.json`

Update your app information for mobile device loading inside the file `public/manifest.json`:

🔗 [manifest.json](https://github.com/your_user/your_repo/blob/master/public/manifest.json)

---

## 3. Link Manifest and Theme Color in HTML

In your `public/index.html`, add:

```html
<link rel="manifest" href="manifest.json">
<meta name="theme-color" content="#FF526C">
```

---

## 4. Validate Configuration

- Open Chrome DevTools → **Application** tab and check the **Manifest** and **Service Workers** sections.
- Test app performance at:
  - Chrome DevTools → **Lighthouse** → **Generate Report**
  - [https://webpagetest.org](https://webpagetest.org)