# Publishing React Components on NPM

1) Visit [npm.com](https://www.npmjs.com/) and search for your library’s name to ensure it’s not already taken.

---

2) Create a new directory, navigate into it, and initialize it with `npm init -y` to generate your `package.json`.

---

3) Add the necessary devDependencies for the project. For this example:
   - `@types/react @types/react-dom babel-core babel-runtime react@17.0.2 rollup rollup-plugin-typescript2 typescript`

---

4) Use **RollUp** as your bundler to compile the component, generate a `dist` folder, and watch for changes. In `package.json`, add these scripts:
   - `"build": "rollup -c"`
   - `"start": "rollup -c -w"`

---

5) Create a `tsconfig.json` file with the following configuration:

   `{ "compilerOptions": { "outDir": "dist", "module": "esnext", "target": "es5", "lib": ["es6", "dom", "es2016", "es2017"], "sourceMap": true, "allowJs": false, "jsx": "react", "declaration": true, "moduleResolution": "node", "forceConsistentCasingInFileNames": true, "noImplicitReturns": true, "noImplicitThis": true, "noImplicitAny": true, "strictNullChecks": true, "suppressImplicitAnyIndexErrors": true, "noUnusedLocals": true, "noUnusedParameters": true }, "include": ["src"], "exclude": ["node_modules", "dist", "example", "rollup.config.js"] }`

---

6) Add `rollup.config.js` with the following configuration:

   `import sass from "rollup-plugin-sass"; import typescript from "rollup-plugin-typescript2"; import pkg from "./package.json"; export default { input: "src/index.tsx", output: [ { file: pkg.main, format: "cjs", exports: "named", sourcemap: true, strict: false, }, ], plugins: [ sass({ insert: true }), typescript({ objectHashIgnoreUnknownHack: true }), ], external: ["react", "react-dom"], };`

---

7) Create a `src` folder with an `index.tsx` file. Write and export your component here.

---

8) Run `yarn start` to start the RollUp watcher, and use `yarn link` to make your package available for testing in another project.

---

9) In a different project, run `yarn link "your_created_package_name"` to test your newly created package.
