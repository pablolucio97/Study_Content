# VITE INTRODUCTION COURSE

Vite is a tool that does the application compilation automatically and uses ESModules by default, where it is not necessary to use another bundler pack like WebPack. This tool is more performant. Vite uses the `<script type="module">` tag inside the `index.html` within the `public` folder to manage ESModules. Vite is an alternative to the common React CRA. It was written in Go and is between 10x and 100x faster than the conventional CRA.

Recently, browsers started importing files by themselves through ESModules to import and export files. To use this feature, it is recommended to create projects using ViteJS because ViteJS already handles the compilation automatically and bundling is not necessary.

## CREATING A PROJECT WITH VITE

1. In the desired directory, run:

```bash
npm create vite@latest
```

Supply the required information for your project (name, template, and template-variant).  
A template using ViteJS with a ViteReact plugin configuration and a `package.json` with all required dependencies will be created.

Shortcut:

```bash
yarn create vite@latest my-app react-ts
```

2. Navigate to the created project and run:

```bash
yarn install
```

To install all dependencies.

3. Run:

```bash
npm run dev
```

To start your project. The default port is **5173**.

## Main Vite's features

---

### 🚀 1. Blazing Fast Startup with Native ESM

- Vite uses native **ES modules** in the browser during development.
- No bundling during dev-time = ultra-fast cold starts.
- Only loads modules on demand.

---

### ⚙️ 2. Lightning-Fast Hot Module Replacement (HMR)

- Updates React components instantly without full reload.
- Maintains state where possible.
- Ideal for rapid development and feedback loops.

---

### 📦 3. Rollup-Based Production Bundling

- Vite uses **Rollup** under the hood for production builds generating highly optimized builds.
- Supports:
  - Code splitting: it breaks the built code into small chunks.
  - Tree-shaking: removes unused code (unused importations, vars and so on)
  - Optimized static output: minifies code before building it

---

### 🧩 4. First-Class React Support

Vite was designed to work seamlessly with React, providing all necessary tooling and performance available installing the React plugin, it will enable:

- JSX/TSX support
- React Fast Refresh
- Dev tools compatibility

---

### 📁 5. Simplified Project Structure

- Uses `index.html` in root as entry point.
- No need for `webpack.config.js`.
- All config goes in `vite.config.ts` or `vite.config.js`.

---

### ⚡ 6. Environment Variables

- Use the `VITE_` prefix to expose to client-side code:
  ```env
  VITE_API_URL=https://api.example.com
  ```
- Supports `.env`, `.env.development`, `.env.production`, etc.

---

### 🌍 7. Built-in Dev Server with HTTPS & Proxy

- Easy to configure API proxying:
  ```ts
  // vite.config.ts
  export default {
    server: {
      proxy: {
        "/api": "http://localhost:3000",
      },
    },
  };
  ```

---

### 📜 8. TypeScript Support Out-of-the-Box

- No extra configuration required.
- Just use `.ts` or `.tsx` files and Vite handles the rest.

---

### 🧪 9. Testing with Vitest (Optional)

- A fast test runner built for Vite projects.
- Supports Jest-like syntax:
  ```bash
  npm install vitest --save-dev
  ```

---

### 🔌 10. Extensible with Plugins

- Vite supports many community and official plugins.
- Compatible with Rollup plugins.
- Popular plugins:
  - `vite-plugin-pwa`
  - `vite-plugin-svgr`
  - `vite-plugin-eslint`
