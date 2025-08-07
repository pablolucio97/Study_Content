# Setting EditorConfig, ESLint, and Prettier Config

---

## 🧩 What They Are

- **EditorConfig**: Ensures consistent editor behavior (e.g., indentation, charset).
- **ESLint**: Enforces code quality and catches coding errors.
- **Prettier**: Handles code formatting (quotes, spacing, semicolons, etc.).

---

## 🛠️ Setting Up EditorConfig

### 1. Install VS Code Extension

Search for and install the **EditorConfig** extension. Reload VS Code.

### 2. Create `.editorconfig`

Place this file in your project root:

```ini
root = true

[*]
indent_style = space
indent_size = 2
end_of_line = lf
charset = utf-8
trim_trailing_whitespace = true
insert_final_newline = true
```

---

## 🛠️ Setting Up ESLint

### 1. Install ESLint Extension for VS Code

Search for and install the **ESLint** extension.

### 2. Install ESLint

```bash
yarn add eslint -D
```

### 3. Initialize ESLint Config

Run:

```bash
npx eslint --init
```

Follow the prompts to define your project style and install necessary dependencies.

> ⚠️ If there are issues with React configs, try:
> - Deleting `node_modules`
> - Deleting `package-lock.json`
> - Reinstalling with `npm install`

### 4. Install Prettier-related ESLint Plugins

```bash
npm i -D prettier eslint-config-prettier eslint-plugin-prettier
```

### 5. Add ESLint Script to `package.json`

```json
"scripts": {
  "lint": "eslint src --ext .ts,.tsx --fix"
}
```

### 6. Create `.eslintrc.js`

```js
module.exports = {
  env: {
    browser: true,
    es2021: true,
    node: true,
    jest: true,
  },
  extends: [
    "eslint:recommended",
    "plugin:react/recommended",
    "plugin:react/jsx-runtime" // Avoid JSX scope warning
  ],
  parserOptions: {
    ecmaFeatures: {
      jsx: true,
    },
    ecmaVersion: 12,
    sourceType: "module",
  },
  plugins: ["react"],
  rules: {
    "react/react-in-jsx-scope": "off",
  },
};
```

### 7. Run ESLint Fix Manually

```bash
npx eslint src/**/*.ts --fix
```

---

## 🛠️ Setting Up Prettier

### 1. Install Prettier

```bash
yarn add prettier -D
```

### 2. Create `.prettierrc.js`

```js
module.exports = {
  semi: true,
  trailingComma: 'all',
  singleQuote: true,
  printWidth: 120,
  tabWidth: 2,
};
```

---

## ✅ General Tips

- Use `"plugin:react/jsx-runtime"` to avoid JSX scope issues.
- Prefer script automation (`lint`) to fix code.
- ESLint config should vary per project type (React, Next.js, React Native, Node, etc.).
