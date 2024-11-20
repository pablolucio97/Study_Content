# VueJS Introduction Course

## **What is Vue.js?**

- A **progressive JavaScript framework** for building user interfaces.
- Key benefits:
  - Integrates with legacy systems by allowing gradual adoption, what is not possible using another frameworks, like React.
  - Works for new systems with modern architecture.
- **MVC Architecture**: Vue handles the **View layer** for building reactive user interfaces.

## **Core Concepts**

1. **Everything is a Component**:
   - Each UI element is a reusable, modular component (e.g., buttons, dashboards, forms).
2. **Reactivity**:
   - Changes to variables automatically propagate to all components using them.
3. **Speed and Performance**:
   - Vue.js is lightweight and optimized for high performance.

## **Key Features**

- **Single File Components (SFC)**:
  - Combines HTML (template), JavaScript (logic), and CSS (styles) in a single file.
  - Facilitates maintainability and portability.
- **Directives**:
  - Built-in functionality like `v-if`, `v-for`, and `v-bind`.
- **Events**:
  - Event handling using `v-on` or `@`.
- **Two-Way Data Binding**:
  - Syncs form inputs and variables with `v-model`.

## **Vue Ecosystem Tools**

1. **Vue DevTools**:
   - Browser extension for debugging Vue applications.
2. **Vue CLI**:
   - Tool for scaffolding and managing Vue projects.
3. **Vue Router**:
   - Handles navigation and routing within the app.
4. **Vuex**:
   - State management library for managing global application state.
5. **Optional Tools for Advanced Projects**:
   - **Nuxt.js**: Framework for creating server-side rendered and static sites with Vue.
   - **Quasar**: Build responsive apps for web, mobile, and desktop.

## Applying VueJS on legacy projects

1. Include the Vue.js script tag from the CDN in your HTML file.
2. Create a container element with a specific `id`.
3. Use Vue.js to control and render content dynamically inside that `id`.

**Example:**

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Vue.js via CDN</title>
  </head>
  <body>
    <script src="https://unpkg.com/vue@3"></script>
    <script>
      const app = Vue.createApp({
        data() {
          return {
            message: "Hello Vue!",
          };
        },
      });
      app.mount("#app");
    </script>
    <div id="app">{{ message }}</div>
  </body>
</html>
```

## Creating a new VueJS project:

1. Install the Vue CLI running ` create-vue@3.12.1` 
2. Run `npm create vue@latest` to create a new Vue project. The CLI will guide you:
✔ Project name: … <your-project-name>
✔ Add TypeScript? … No / Yes
✔ Add JSX Support? … No / Yes
✔ Add Vue Router for Single Page Application development? … No / Yes
✔ Add Pinia for state management? … No / Yes
✔ Add Vitest for Unit testing? … No / Yes
✔ Add an End-to-End Testing Solution? … No / Cypress / Nightwatch / Playwright
✔ Add ESLint for code quality? … No / Yes
✔ Add Prettier for code formatting? … No / Yes
✔ Add Vue DevTools 7 extension for debugging? (experimental) … No / Yes