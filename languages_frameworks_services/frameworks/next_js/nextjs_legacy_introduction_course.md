# Next.js Legacy Introduction Course

## Creating a New Next Project

1. Run the command:
   ```bash
   yarn create next-app name-of-application
   ```

2. Install TypeScript and dependencies:
   ```bash
   yarn add typescript @types/react @types/react-dom @types/node -D
   ```

3. Rename the files `_app.js` and `index.js` to `_app.tsx` and `index.tsx` inside the **pages** folder.

4. If present, remove the import of `globalstyles.css` and delete the file.

5. Run:
   ```bash
   yarn dev
   ```
   to start the application.

6. To use Styled Components:
   ```bash
   yarn add styled-components
   ```

7. Install Babel for Styled Components:
   ```bash
   yarn add babel-plugin-styled-components -D
   ```
   Create a `.babelrc` file in the root with:
   ```json
   {
     "presets": ["next/babel"],
     "plugins": ["styled-components"]
   }
   ```

8. Replace the content of `_app` and `_document.js` with the ones from:
   [Next.js Styled Components Example](https://github.com/vercel/next.js/tree/canary/examples/with-styled-components)  
   Rename `.js` files to `.tsx` except `_document.js`.

---

## Generating Static Sites

1. After finishing your site:
   ```bash
   yarn next build
   ```
   This generates a build log (needs a server to preview).

2. Add a command to `package.json`:
   ```json
   "export": "next export"
   ```

3. Run:
   ```bash
   npm run export
   ```
   This creates an `out` folder for static export (no server required).

4. Open your exported files locally.

---

## Getting Data with `getStaticProps` (TypeScript)

**Static Indexed Pages:**
```ts
import { GetStaticProps } from "next";

export const getStaticProps: GetStaticProps = () => {
  return {
    props: {
      name: 'Pablo'
    }
  };
};

type Naming = {
  name: string;
};

export default function Home({ name }: Naming) {
  return <p>Hello, {name}</p>;
}
```

---

## `getStaticProps` with Dynamic Files (`getStaticPaths`)

Used for dynamic routes (e.g., `/challenges`):

```ts
import { GetStaticProps, GetStaticPaths } from "next";

export const getStaticProps: GetStaticProps = () => {
  return {
    props: { name: 'Pablo' }
  };
};

export const getStaticPaths: GetStaticPaths = () => {
  return {
    paths: [{ params: { slug: 'challenges' } }],
    fallback: false
  };
};

export default function Slug({ name }: { name: string }) {
  return <p>Hello, {name}</p>;
}
```

---

## Generating Static Pages from API Resources

Example for `/users/[id]`:

```ts
import axios from "axios";

export async function getStaticProps(context) {
  const response = await axios.get('https://jsonplaceholder.typicode.com/users', {
    params: { id: context.params.id }
  });

  const user = response.data[0];

  return { props: { user } };
}

export async function getStaticPaths() {
  const response = await axios.get('https://jsonplaceholder.typicode.com/users');
  const users = response.data;

  const paths = users.map(user => ({
    params: { id: String(user.id) }
  }));

  return { paths, fallback: false };
}

export default function Users({ user }) {
  return (
    <div>
      <h1>Hello from users</h1>
      <h3>Current user: {user.id}</h3>
    </div>
  );
}
```

---

## Accessing Dynamic Routes from Props

```ts
import Axios from "axios";
import Link from "next/link";

export async function getStaticProps() {
  const response = await Axios.get('https://jsonplaceholder.typicode.com/users');
  const data = response.data;

  return { props: { data } };
}

export default function Users({ data }) {
  return (
    <div>
      <h1>Hello from Users</h1>
      {data.map(user => (
        <Link key={user.id} href="users/[id]" as={`/users/${user.id}`} passHref>
          <p>{user.name}</p>
        </Link>
      ))}
    </div>
  );
}
```

---

## Dynamic Imports (for Browser-Only Libraries)

```ts
import dynamic from "next/dynamic";

const Chart = dynamic(() => import("react-apexcharts"), { ssr: false });
```

---

## General Tips

- Use `"trailingSlash": true` in `next.config.json` to enable static navigation after build.
- Next.js matches routes to files; unmatched URLs go to slugs or 404 pages.
- Always `export default function` components.
- Use `router.isFallback` with `fallback: true` for loading states.
- **`getStaticProps`**: for static pages with universal content.  
  **`getServerSideProps`**: for dynamic server-rendered content.  
  **`useEffect`**: for client-only fetching.
- Avoid `fallback: true` for SEO; prefer `fallback: false` or `blocking`.
- `getStaticPaths` is only for dynamic files (`[slug].tsx`).
- Handle `"window is not defined"` errors with `dynamic()` imports.
- Import `"regenerator-runtime/runtime"` in `[...nextauth].ts` for performance improvements.
- Format and sanitize third-party API data before using it in components.
- Use `.env`, `.env.local`, `.env.production`, `.env.development` appropriately.

---
