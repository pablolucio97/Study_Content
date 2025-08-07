# 🖋️ Using Google Fonts in Your React Project

Follow these steps to import and use a Google Font in your React application:

---

## 1. Choose a Font

- Go to [Google Fonts](https://fonts.google.com)
- Click on the font you want to use.

---

## 2. Select Font Style

- Choose the desired weight/style (e.g., Regular 400, Bold 700).
- Click **"Select this style"**.

---

## 3. Get the `@import` Link

- In the **"Embed"** tab, switch to **`@import`**.
- Copy the `@import` line and paste it at the top of your main CSS file.  
  _Example:_

```css
@import url('https://fonts.googleapis.com/css2?family=Comic+Neue&display=swap');
```

---

## 4. Set the Font-Family

- In your CSS file, set the `font-family`:

```css
body {
  font-family: 'Comic Neue', cursive;
}
```

---

## 5. Import Your CSS in React

- In your `App.js` or main component, import your CSS file:

```js
import './App.css';
```

---

✅ Done! Your project is now using the selected Google Font.
