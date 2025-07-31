# TypeScript Config Options

The `tsconfig.json` file allows you to configure all desired options to manage TypeScript behavior in your project. Below are the main options:

## `lib`
Allow using support for types definitions for objects present in the specified libs.  
**Most common values**: `"dom"`, `"dom.iterable"`, `"esnext"`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#lib)

---

## `target`
Defines which JavaScript version TypeScript should compile your code to.  
**Most common values**: `"es5"`, `"es6"`, `"es2017"`, `"esnext"`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#target)

---

## `jsx`
Defines how JSX code is transformed.  
**Most common values**: `"react"`, `"react-native"`, `"preserve"`  
📘 [Reference](https://www.typescriptlang.org/docs/handbook/jsx.html)

---

## `allowJs`
Allows JavaScript and TypeScript files to work together.  
**Most common value**: `true`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#allowJs)

---

## `noEmit`
Uses TypeScript as a type checker only, without emitting output.  
**Most common value**: `true`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#noEmit)

---

## `module`
Sets the module system for output.  
**Most common values**: `"commonjs"`, `"es6"`, `"esnext"`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#module)

---

## `moduleResolution`
Specifies the module resolution strategy.  
**Most common value**: `"node"`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#moduleResolution)

---

## `isolatedModules`
Enables stricter checks for single-file transpilation (like Babel).  
**Most common value**: `true`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#isolatedModules)

---

## `resolveJsonModule`
Allows importing JSON files as modules.  
**Most common value**: `true`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#resolveJsonModule)

---

## `strict`
Enables all strict type-checking options.  
**Most common value**: `true`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#strict)

---

## `incremental`
Enables incremental compilation for faster rebuilds.  
**Most common value**: `true`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#incremental)

---

## `allowSyntheticDefaultImports`
Allows default imports from modules with no default export.  
**Most common value**: `true`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#allowSyntheticDefaultImports)

---

## `forceConsistentCasingInFileNames`
Ensures that file imports match the casing on disk.  
**Most common value**: `true`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#forceConsistentCasingInFileNames)

---

## `skipLibCheck`
Skips type checking of declaration files.  
**Most common value**: `true`  
📘 [Reference](https://www.typescriptlang.org/tsconfig#skipLibCheck)

---

## `noImplicitAny`
Raise error on expressions and declarations with an implied `any` type.  
**Most common value**: `false` (when working with untyped third-party libs)  
📘 [Reference](https://www.typescriptlang.org/tsconfig#noImplicitAny)

---

## `include`
Defines which files should be included.  
📘 [Reference](https://www.typescriptlang.org/tsconfig#include)

---

## `exclude`
Defines which files/folders to ignore.  
📘 [Reference](https://www.typescriptlang.org/tsconfig#exclude)

---

# General Tips

- Set `"noImplicitAny": false` if you're dealing with third-party libs with no type declarations.
- If you're struggling with `import * as x from 'lib'`, add `"esModuleInterop": true` to use `import x from 'lib'`.
