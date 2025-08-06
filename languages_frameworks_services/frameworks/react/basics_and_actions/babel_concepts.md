# Babel Concepts

Babel is a compiler that allows the compilation of JSX to JavaScript and is useful to standardize the application code between different browsers. It converts modern JavaScript (ES2015+) to older browsers.

**Example:**

```js
[1, 2, 3].map(n => n + 1);

// Babel Output: ES5 equivalent
[1, 2, 3].map(function(n) {
  return n + 1;
});
```

---

## Babel Main Tooling Packs

All tooling packs should be installed through a package manager and have additional options that can be checked in the official documentation.

### `@babel/parser`

This package is responsible for parsing the JavaScript code. It provides support for JSX, Flow, and TypeScript. It optionally allows using imports anywhere, among other features.

[Documentation](https://babeljs.io/docs/en/babel-parser#options)

---

### `@babel/core`

This is the Babel compilation core.

---

### `@babel/runtime`

A library that contains Babel runtime helpers. It is used to reuse code injected by Babel in the output file. It improves application performance.

---

### `@babel/types`

This module provides methods to help manually build code and check types in your code.

---

## Understanding Babel Config

To configure Babel in your project, create a `babel.config.js` file in the root of your project.

**Example:**

```js
module.exports = function (api) {
  api.cache(true);
  return {
    presets: ["next/babel"],
    plugins: [
      ["styled-components", { ssr: true }]
    ]
  };
};
```

- `api.cache(true)`: Used to optimize the evaluation of the configuration process and reuse the cache to do it faster.
- `presets`: A set of useful plugins. You can pass options by wrapping the name and an options object in an array inside your config.
- `plugins`: Responsible for the actual code transformations. You can pass options the same way as presets.

---

## Execution Order

Plugins run **before** presets. Plugins are read **in order**, whereas presets are read **in reverse order**.

**Example:**

```json
{
  "presets": ["@babel/preset-env", "@babel/preset-react"],
  "plugins": ["transform-decorators-legacy", "styled-components"]
}
```

**Execution Order:**

1. transform-decorators-legacy  
2. styled-components  
3. @babel/preset-react  
4. @babel/preset-env

---

## Presets

Presets in Babel are a set of useful plugins (to avoid installing each plugin separately) that should be configured in your `babel.config.js` file. Each preset should be installed via a package manager. Additional options can be found in the official documentation.

### Common Preset Examples

- **`@babel/preset-env`**: Compiles ES2015+ syntax and reduces the JavaScript bundle size.
- **`@babel/preset-react`**: Contains all plugins needed to run React projects.
- **`@babel/preset-typescript`**: Recommended for TypeScript projects.
- **`@babel/preset-flow`**: Used in Flow projects (similar to TypeScript).
- **`next/babel`**: Includes all plugins needed to compile React applications and server-side code in Next.js.

To extend plugins in Next.js projects, refer to:  
[Next.js Babel Configuration](https://nextjs.org/docs/advanced-features/customizing-babel-config)