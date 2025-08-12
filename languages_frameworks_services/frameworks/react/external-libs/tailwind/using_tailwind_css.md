# TailwindCSS Course

A utility-first CSS framework packed with classes that can be composed to build any design, directly in your markup.

### Why using Tailwind
- **Fast iteration:** style inline, no context‑switch to a CSS file.
- **Predictable:** no cascade surprises; the **last class wins** when there are conflicts.
- **Portable:** styles live with the markup; components are easy to move and reuse.
- **Scalable:** responsive and state variants (`sm:`, `hover:`, `focus:`) are built in.

## Installation
Visit [Tailwind official doc](https://tailwindcss.com/docs/installation/using-vite) to proceed with the installation.

## Styling with Utility Classes

**Idea:** Tailwind gives you small, single‑purpose classes (utilities) like `p-4`, `text-center`, `bg-blue-500`. You compose them directly in `class` to style elements without writing custom CSS.

## Configuring and Applying Dark Mode
TailwindCSS supports **Dark Mode** to switch styles based on user preference or a toggle in your app.

### Enabling Dark Mode
In your `tailwind.config.js` file, set the `darkMode` option to either:
- `"media"`: Uses the user's OS-level dark mode preference.
- `"class"`: Uses a `dark` class on a parent element (commonly `html` or `body`) to enable dark mode.

Example (`tailwind.config.js`):
```javascript
module.exports = {
  darkMode: 'class', // or 'media'
  // other configs...
}
```

### Usage
When enabled, you can prefix any class with `dark:` to apply it only in dark mode.
Example:
```html
<div class="bg-white text-black dark:bg-black dark:text-white">
  This text changes in dark mode
</div>
```
## Theme Variables

Tailwind uses **theme variables** — CSS custom properties defined with the `@theme` directive — that drive the availability of utility classes and variant APIs.

### What They Are
When you define something like `--color-mint-500` via `@theme`, Tailwind automatically generates utilities like `bg-mint-500`, `text-mint-500`, or `fill-mint-500`.

You can also reference these as CSS variables in arbitrary values:
```css
@import "tailwindcss";
@theme { --color-mint-500: #3cb371; }
```

```html
<div class="bg-mint-500"></div>
```

### Use Cases
- **Add custom fonts:** `--font-poppins` → `font-poppins` utility.
- **Custom breakpoints:** `--breakpoint-3xl` → support `3xl:` variants.
- Many other token namespaces: `--spacing-8`, `--radius-lg`, `--shadow-md`, `--animate-spin`, and more.

### Useful CSS class utilities
- **Spacing & sizing:** `p-4`, `px-2`, `m-6`, `w-1/2`, `h-10`
- **Typography:** `text-sm`, `font-semibold`, `leading-tight`, `tracking-wide`
- **Layout:** `flex`, `grid`, `items-center`, `justify-between`, `gap-4`
- **Color:** `bg-blue-500`, `text-zinc-700`, `border-red-300`
- **Borders & radius:** `border`, `border-2`, `rounded`, `rounded-lg`
- **Effects:** `shadow`, `ring-2`, `ring-offset-2`, `opacity-75`
- **Dark mode** `bg-white dark:bg-gray-800`
- **Responsive variants:** `sm:`, `md:`, `lg:`, `xl:` – e.g., `p-4 md:p-6`
- **State & mode:** `hover:`, `focus:`, `active:`, `disabled:`, `dark:` – e.g., `hover:bg-blue-600`, `dark:text-white`
- **Arbitrary values (escape hatch):** `w-[420px]`, `bg-[rgb(34,197,94)]` when a token isn’t in your theme.

### Tiny examples
```html
<!-- Card -->
<div class="p-4 md:p-6 bg-white rounded-lg shadow text-zinc-800">
  <h2 class="text-lg font-semibold mb-2">Title</h2>
  <p class="text-sm leading-relaxed">Short description.</p>
</div>
```

```html
<!-- Button with states & responsive padding -->
<button class="px-3 py-2 md:px-4 md:py-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white rounded transition-colors">
  Save
</button>
```

```html
<!-- Dark mode + arbitrary width -->
<section class="w-[320px] p-4 bg-zinc-100 dark:bg-zinc-800 dark:text-zinc-100 rounded">
  Content
</section>
```

## General Tips
- If class strings get long, split lines or use a helper like `clsx`/`tailwind-merge` to compose conditionally (we’ll cover patterns later).
- The last class utility will that class that will be applied.
