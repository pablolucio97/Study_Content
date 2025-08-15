# NextJS Introduction Course

Next.js is a React framework for building full-stack web applications. You use React Components to build user interfaces, and Next.js for additional features and optimizations.

## Core Concepts

### Folder Structure

A typical Next.js project follows a specific folder and file organization that helps maintain scalability and clarity.

```
my-next-app/
├── public/               # Static files (images, fonts, etc.)
├── src/                  # Source code (optional but recommended)
│   ├── app/              # App Router (Next.js 13+), contains page components and layouts
│   │   ├── layout.tsx    # Root layout (shared UI like header, footer)
│   │   ├── page.tsx      # Default home page
│   │   └── about/
│   │       └── page.tsx  # Example About page
│   ├── components/       # Reusable UI components
│   ├── styles/           # Global and modular styles (CSS, SCSS, etc.)
│   ├── lib/              # Utility functions and helpers
│   ├── hooks/            # Custom React hooks
│   ├── context/          # React context providers
│   └── services/         # API service functions
├── node_modules/         # Installed npm packages
├── .env.local            # Local environment variables
├── package.json          # Project dependencies and scripts
├── tsconfig.json         # TypeScript configuration (if using TS)
└── next.config.js        # Next.js configuration
```

#### Notes:
- **`public/`**: Assets in this folder are served directly from `/`.
- **`app/`** (or `pages/` in older versions): Defines routes and page components.
- **`components/`**: Keep UI components modular and reusable.
- **`styles/`**: Organize your styling, can include CSS Modules or global styles.
- **`services/`**: Centralize API calls or business logic.

This structure helps **separate concerns** and keeps your codebase organized, making it easier to scale.

---

### Layouts and Pages

In Next.js (especially from version 13+ with the App Router), **layouts** and **pages** play a central role in defining the structure and navigation of your app.

#### 1. Pages
- A **page** is any React component inside the `app/` (or `pages/` in older versions) directory that exports a default component.
- The file path inside the `app/` folder determines the **route URL**.

**Example:**
```
app/
 ├── page.tsx        --> `/`
 └── about/
     └── page.tsx    --> `/about`
```

```typescript
// app/about/page.tsx
export default function AboutPage() {
  return <h1>About Us</h1>;
}
```

#### 2. Layouts
- **Layouts** are special components that wrap pages and persist across navigation.
- Useful for elements like headers, sidebars, and footers.
- In Next.js 13+, you can have **nested layouts** for different sections of your app.

**Example:**
```
app/
 ├── layout.tsx      # Root layout for the whole app
 ├── dashboard/
 │    ├── layout.tsx # Layout specific to dashboard pages
 │    └── page.tsx
 └── about/
      └── page.tsx
```

```typescript
// app/layout.tsx
export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en">
      <body>
        <header>My App Header</header>
        <main>{children}</main>
        <footer>My App Footer</footer>
      </body>
    </html>
  );
}
```

#### Key Points:
- Layouts **wrap** pages and stay mounted during navigation.
- Pages are replaced during navigation, but layouts persist.
- You can nest layouts for sections like `/dashboard`, `/settings`, etc.

**Why use layouts?**
- Reduces duplication (no need to repeat header/footer in every page).
- Improves performance since layouts are not re-rendered on navigation.


### Linking and Navigating

Navigation in Next.js is handled using the built-in `Link` component from `next/link` or programmatically using `useRouter`.

#### 1. Using the `Link` Component
- Allows **client-side navigation** between routes without a full page reload.
- Improves performance by reusing existing page layouts and components.

**Example:**
```typescript
import Link from 'next/link';

export default function HomePage() {
  return (
    <nav>
      <Link href="/">Home</Link>
      <Link href="/about">About</Link>
      <Link href="/contact">Contact</Link>
    </nav>
  );
}
```

#### 2. Programmatic Navigation
- Use `useRouter` from `next/navigation` (App Router) or `next/router` (Pages Router).
```typescript
'use client';
import { useRouter } from 'next/navigation';

export default function NavigateButton() {
  const router = useRouter();
  return <button onClick={() => router.push('/about')}>Go to About</button>;
}
```

#### Key Points:
- `Link` is preferred for static navigation elements.
- `useRouter` is useful when navigation happens after an action (e.g., form submit).

---

### Streaming and Prefetching

#### 1. Streaming
- Streaming allows the server to **send parts of the UI to the client as they are generated**.
- Useful for faster **Time-to-First-Byte (TTFB)** and improving perceived performance.
- In the App Router, components can start rendering **before all data is ready**.
- Commonly combined with **Suspense** for loading states.

**Example:**
```typescript
// app/page.tsx
import { Suspense } from 'react';
import Posts from './posts';

export default function Page() {
  return (
    <div>
      <h1>Welcome</h1>
      <Suspense fallback={<p>Loading posts...</p>}>
        <Posts />
      </Suspense>
    </div>
  );
}
```

#### 2. Prefetching
- Next.js automatically **prefetches** pages linked with the `Link` component **when they are visible in the viewport**.
- This makes navigation **instant** when the user clicks the link.
- Prefetching can be disabled if needed:
```typescript
<Link href="/about" prefetch={false}>About</Link>
```
- You can also **manually prefetch**:
```typescript
'use client';
import { useRouter } from 'next/navigation';

export default function PrefetchExample() {
  const router = useRouter();
  router.prefetch('/about');
  return null;
}
```

#### Key Points:
- **Streaming** improves load experience by sending UI chunks progressively.
- **Prefetching** makes navigation instant by loading resources in advance.
- Both features aim to improve **performance and user experience**.

---


### Server Components

In Next.js (App Router), **Server Components** are the default type of components.  
They run **only on the server** and never ship their JavaScript to the client.

#### Key Characteristics
- **Default in `app/` directory** unless explicitly marked as `use client`.
- Can directly access **server-side resources** (databases, files, environment variables).
- No client-side JavaScript bundle is sent for them → smaller bundle size.
- Can import **Server-only modules** (e.g., `fs` or database clients).
- Cannot use browser APIs or React hooks like `useState`, `useEffect`.

#### Example: Server Component
```typescript
// app/users/page.tsx
async function getUsers() {
  const res = await fetch('https://jsonplaceholder.typicode.com/users');
  return res.json();
}

export default async function UsersPage() {
  const users = await getUsers();
  return (
    <div>
      <h1>Users</h1>
      <ul>
        {users.map((user: any) => (
          <li key={user.id}>{user.name}</li>
        ))}
      </ul>
    </div>
  );
}
```

✅ This code runs **entirely on the server** and sends only the rendered HTML to the client.

#### When to Use Server Components
- Data fetching from a database or external API.
- Rendering large UI pieces that don’t need interactivity.
- Reducing JavaScript sent to the browser.

#### Combining with Client Components
- If you need interactivity, use a **Client Component** inside a Server Component.
- Mark client components with `"use client"` at the top of the file.

**Example:**
```typescript
// app/components/Counter.tsx
'use client';
import { useState } from 'react';

export default function Counter() {
  const [count, setCount] = useState(0);
  return <button onClick={() => setCount(count + 1)}>Count: {count}</button>;
}
```

```typescript
// app/page.tsx (Server Component)
import Counter from './components/Counter';

export default function Page() {
  return (
    <div>
      <h1>Server Component Page</h1>
      <Counter />
    </div>
  );
}
```

#### Key Points
- Server Components improve performance by reducing JavaScript bundle size.
- Use them for **non-interactive UI** and data fetching.
- Client Components are required for interactivity.

### Client Components

In Next.js (App Router), **Client Components** are components that run in the browser and can use browser APIs, interactivity, and React client-side hooks.

#### Key Characteristics
- Must include `"use client"` at the top of the file.
- Can use React hooks like `useState`, `useEffect`, `useRef`, etc.
- Can interact with browser APIs (e.g., `localStorage`, `document`, `window`).
- Ship JavaScript to the client, so they increase the bundle size.
- Can import **other Client Components** or **Server Components**.

#### Example: Client Component
```typescript
// app/components/ThemeSwitcher.tsx
'use client';
import { useState } from 'react';

export default function ThemeSwitcher() {
  const [theme, setTheme] = useState<'light' | 'dark'>('light');

  return (
    <div>
      <p>Current theme: {theme}</p>
      <button onClick={() => setTheme(theme === 'light' ? 'dark' : 'light')}>
        Toggle Theme
      </button>
    </div>
  );
}
```

✅ This component can use `useState` and handle click events because it runs on the client.

#### Using Client Components in Server Components
You can import Client Components into Server Components to add interactivity.

**Example:**
```typescript
// app/page.tsx (Server Component)
import ThemeSwitcher from './components/ThemeSwitcher';

export default function HomePage() {
  return (
    <div>
      <h1>Welcome</h1>
      <ThemeSwitcher />
    </div>
  );
}
```

#### When to Use Client Components
- When you need **interactivity** (buttons, forms, animations).
- When you use **React hooks** like `useState` or `useEffect`.
- When you access **browser APIs**.

#### Best Practices
- Keep Client Components as **small and focused** as possible.
- Lift data fetching to Server Components and pass data as props to Client Components.
- Use them **only when necessary** to minimize JavaScript sent to the browser.

#### Key Differences from Server Components
| Feature | Server Component | Client Component |
|---------|-----------------|------------------|
| Runs on | Server only | Browser (and server for initial HTML render) |
| Uses React hooks | ❌ No | ✅ Yes |
| Browser APIs | ❌ No | ✅ Yes |
| JavaScript sent to client | ❌ No | ✅ Yes |
| Access server-side resources directly | ✅ Yes | ❌ No |

### Server Functions

In Next.js (App Router), **Server Functions** are functions that run only on the server and can be called from Client Components.  
They allow you to execute server-side logic (like database queries or API calls) **securely** without exposing sensitive code to the browser.

#### Key Characteristics
- Only available in **Next.js 13+ App Router**.
- Declared with the `"use server"` directive at the top of the function file or inside the function body.
- Can be imported and called **directly** from Client Components.
- Keep **API keys and credentials safe** since they never run in the browser.
- Can return values to Client Components.
- Server Functions are **not** accessible via a public URL like API routes. They can only be imported and used inside your Next.js project.

#### Example: Creating and Using a Server Function

**Server Function:**
```typescript
// app/actions/getTime.ts
'use server';

export async function getServerTime() {
  return new Date().toISOString();
}
```

**Using in a Client Component:**
```typescript
// app/components/ShowTime.tsx
'use client';
import { useState } from 'react';
import { getServerTime } from '../actions/getTime';

export default function ShowTime() {
  const [time, setTime] = useState<string | null>(null);

  async function handleClick() {
    const serverTime = await getServerTime();
    setTime(serverTime);
  }

  return (
    <div>
      <button onClick={handleClick}>Get Server Time</button>
      {time && <p>Server Time: {time}</p>}
    </div>
  );
}
```

#### When to Use Server Functions
- Fetching data securely from a database or external API.
- Performing sensitive operations (e.g., payment processing, authentication).
- Avoiding API routes for simple server-to-client calls.

---

## Fetching and updating data

### Fetching Data Using Server Components

Since Server Components run entirely on the server, they are ideal for **secure** and **fast** data fetching.  
They can directly access databases, API keys, and private APIs without exposing them to the client.

#### Example: Fetching from an API in a Server Component
```typescript
// app/posts/page.tsx
export default async function PostsPage() {
  const res = await fetch('https://jsonplaceholder.typicode.com/posts');
  const posts = await res.json();

  return (
    <div>
      <h1>Posts</h1>
      <ul>
        {posts.map((post: any) => (
          <li key={post.id}>{post.title}</li>
        ))}
      </ul>
    </div>
  );
}
```
✅ Runs only on the server, so the API key (if used) remains safe.  
✅ No extra JavaScript is sent to the client for the fetch logic.

#### Benefits:
- No client-side JavaScript needed for fetching.
- Keeps API keys and credentials private.
- Can run heavy computation without affecting client performance.

---

### Fetching Data Using Client Components

Client Components fetch data **after** the page loads in the browser.  
This is useful for **real-time updates**, **user-triggered fetches**, and **interactivity**.

#### Example: Fetching Data in a Client Component
```typescript
// app/components/RandomUser.tsx
'use client';
import { useEffect, useState } from 'react';

export default function RandomUser() {
  const [user, setUser] = useState<any>(null);

  useEffect(() => {
    fetch('https://randomuser.me/api/')
      .then((res) => res.json())
      .then((data) => setUser(data.results[0]));
  }, []);

  if (!user) return <p>Loading...</p>;

  return (
    <div>
      <h2>{user.name.first} {user.name.last}</h2>
      <img src={user.picture.medium} alt="User" />
    </div>
  );
}
```

✅ Runs in the browser after page load.  
✅ Can update UI in real-time based on user interactions.

#### When to Use Client-Side Fetching:
- For **dynamic data** that changes after initial page load.
- When data depends on **user actions** (e.g., search queries, filters).
- For **real-time data** (e.g., WebSockets, polling).

---

### Updating Data

**Server Actions:**
```typescript
'use server';
export async function updateUser(formData: FormData) {
  const name = formData.get('name') as string;
  console.log(`Updating user to ${name}`);
  return { success: true };
}
```

**API Routes:**
```typescript
export async function PUT(request: Request) {
  const { name } = await request.json();
  return NextResponse.json({ success: true, name });
}
```

## Caching and Revalidating

Next.js automatically caches data fetched in **Server Components** to improve performance.  
You can control **how long** the data is cached and when it should be revalidated.

#### 1. Default Caching Behavior
- `fetch()` in Server Components caches results by default.
- Same request URL + options → served from cache.

#### 2. Disabling Cache
If you want fresh data **on every request**, set `cache: 'no-store'`:
```typescript
export default async function Page() {
  const res = await fetch('https://api.example.com/data', { cache: 'no-store' });
  const data = await res.json();
  return <pre>{JSON.stringify(data, null, 2)}</pre>;
}
```

#### 3. Revalidating Data After a Certain Time
Use `next: { revalidate: seconds }` to re-fetch data periodically:
```typescript
export default async function Page() {
  const res = await fetch('https://api.example.com/data', {
    next: { revalidate: 60 } // revalidate every 60 seconds
  });
  const data = await res.json();
  return <pre>{JSON.stringify(data, null, 2)}</pre>;
}
```

#### 4. On-Demand Revalidation
Revalidate data manually when needed using API routes or Server Actions.

**Example: API Route to Trigger Revalidation**
```typescript
// app/api/revalidate/route.ts
import { revalidatePath } from 'next/cache';

export async function GET() {
  revalidatePath('/'); // revalidate home page
  return Response.json({ revalidated: true });
}
```

Call `/api/revalidate` whenever you need to refresh data.

## Error Handling

Next.js provides built-in mechanisms to handle errors gracefully, especially with the App Router.

### 1. Using `error.tsx` for Route-Level Errors
In the App Router, create an `error.tsx` file inside a route folder to handle errors in that specific route.

**Example:**
```
app/dashboard/error.tsx
```
```typescript
'use client';

export default function Error({ error, reset }: { error: Error; reset: () => void }) {
  return (
    <div>
      <h2>Something went wrong!</h2>
      <p>{error.message}</p>
      <button onClick={() => reset()}>Try again</button>
    </div>
  );
}
```
- `error`: The error object thrown by the route.
- `reset()`: Function to attempt recovery (re-renders the route).

### 2. Handling Errors in Server Components
Wrap code in `try/catch` to handle errors and return fallback UI.

```typescript
export default async function Page() {
  try {
    const res = await fetch('https://api.example.com/data');
    if (!res.ok) throw new Error('Failed to fetch data');
    const data = await res.json();
    return <pre>{JSON.stringify(data, null, 2)}</pre>;
  } catch (error: any) {
    return <p>Error: {error.message}</p>;
  }
}
```

### 3. Handling Errors in Client Components
Use `try/catch` in async functions and display error messages in the UI.

```typescript
'use client';
import { useState } from 'react';

export default function ClientFetcher() {
  const [error, setError] = useState<string | null>(null);
  const [data, setData] = useState<any>(null);

  async function fetchData() {
    try {
      const res = await fetch('/api/data');
      if (!res.ok) throw new Error('Request failed');
      const json = await res.json();
      setData(json);
    } catch (err: any) {
      setError(err.message);
    }
  }

  return (
    <div>
      <button onClick={fetchData}>Load Data</button>
      {error && <p style={{ color: 'red' }}>{error}</p>}
      {data && <pre>{JSON.stringify(data, null, 2)}</pre>}
    </div>
  );
}
```

### 4. Global Error Handling
For global error handling in the App Router, create a top-level `error.tsx` in the `app/` directory.

**Example:**
```
app/error.tsx
```
```typescript
'use client';
export default function GlobalError({ error, reset }: { error: Error; reset: () => void }) {
  return (
    <html>
      <body>
        <h2>Global Error!</h2>
        <p>{error.message}</p>
        <button onClick={() => reset()}>Try Again</button>
      </body>
    </html>
  );
}
```

## Image Optimization

Next.js provides the built-in `<Image>` component from `next/image` to automatically **optimize images** for better performance.

### Benefits of `next/image`:
- Automatic resizing and optimization.
- Lazy loading by default.
- Supports WebP and AVIF formats for smaller file sizes.
- Prevents layout shift by requiring `width` and `height`.

### Basic Usage
```typescript
import Image from 'next/image';

export default function HomePage() {
  return (
    <div>
      <h1>Welcome</h1>
      <Image
        src="/profile.jpg"
        alt="Profile picture"
        width={200}
        height={200}
      />
    </div>
  );
}
```

### External Images
Allow images from external domains in `next.config.js`:
```javascript
// next.config.js
module.exports = {
  images: {
    domains: ['example.com'],
  },
};
```

```typescript
<Image
  src="https://example.com/photo.jpg"
  alt="External Image"
  width={500}
  height={300}
/>
```

### Responsive Images
```typescript
<Image
  src="/banner.jpg"
  alt="Banner"
  width={1200}
  height={400}
  sizes="(max-width: 768px) 100vw, 50vw"
/>
```

### Fill Layout
For full-width images:
```typescript
<div style={{ position: 'relative', width: '100%', height: '400px' }}>
  <Image src="/cover.jpg" alt="Cover" fill style={{ objectFit: 'cover' }} />
</div>
```

### Font Optimization

Next.js provides built-in font optimization with the `next/font` module.  
It automatically **downloads, optimizes, and hosts fonts** with zero layout shift and improved performance.

#### Benefits
- No external network requests to Google Fonts (fonts are self-hosted).
- Automatic subset generation for smaller file sizes.
- Avoids layout shift caused by late-loading fonts.

#### Using Google Fonts with `next/font/google`
```typescript
// app/layout.tsx
import { Roboto } from 'next/font/google';

const roboto = Roboto({
  subsets: ['latin'],
  weight: ['400', '700'],
});

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en">
      <body className={roboto.className}>{children}</body>
    </html>
  );
}
```

#### Using Local Fonts with `next/font/local`
```typescript
// app/layout.tsx
import localFont from 'next/font/local';

const myFont = localFont({
  src: '../public/fonts/MyFont.woff2',
  weight: '400',
  style: 'normal',
});

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en">
      <body className={myFont.className}>{children}</body>
    </html>
  );
}
```

#### Applying Fonts to Specific Elements
```typescript
export default function HomePage() {
  return <h1 className={myFont.className}>Hello with custom font</h1>;
}
```


---

### Metadata and Open Graph (OG) Images

Next.js (App Router) has a built-in way to define **SEO metadata** and **Open Graph images** directly inside your page or layout components.

Configuring metadata and Open Graph metadata improves your application SEO and links preview. 

Open Graph (OG) metadata is a set of <meta> tags that describe a page so social networks (and chat apps, Slack, etc.) can generate rich link previews—title, description, image, etc. It was introduced by Facebook but is widely used.

#### 1. Setting Metadata for a Page
Add a `metadata` export to your page file:
```typescript
// app/page.tsx
export const metadata = {
  title: 'Home Page',
  description: 'Welcome to my Next.js app',
};
export default function HomePage() {
  return <h1>Home</h1>;
}
```

#### 2. Adding Open Graph Metadata
```typescript
// app/page.tsx
export const metadata = {
  title: 'Home Page',
  description: 'Welcome to my Next.js app',
  openGraph: {
    title: 'Home Page',
    description: 'Welcome to my Next.js app',
    url: 'https://example.com',
    siteName: 'My Next.js App',
    images: [
      {
        url: 'https://example.com/og-image.jpg',
        width: 1200,
        height: 630,
      },
    ],
    locale: 'en_US',
    type: 'website',
  },
};
```

#### 3. Metadata in `layout.tsx`
You can set metadata globally for all pages in a layout:
```typescript
// app/layout.tsx
export const metadata = {
  title: {
    default: 'My Next.js App',
    template: '%s | My Next.js App',
  },
  description: 'A great app built with Next.js',
};
```

#### 4. Dynamic Metadata
For dynamic pages, export a `generateMetadata` function:
```typescript
// app/products/[id]/page.tsx
export async function generateMetadata({ params }: { params: { id: string } }) {
  const product = await getProduct(params.id);
  return {
    title: product.name,
    description: product.description,
    openGraph: {
      images: [product.image],
    },
  };
}
```

### Route Handlers

In Next.js (App Router), **Route Handlers** let you create API endpoints inside the `app/api` directory.  
They are stored in a `route.ts` or `route.js` file and can handle different HTTP methods (`GET`, `POST`, `PUT`, `DELETE`, etc.).

#### 1. Basic GET Route
```typescript
// app/api/hello/route.ts
export async function GET() {
  return Response.json({ message: 'Hello from API' });
}
```
- Accessible at `/api/hello`.
- Always returns JSON unless specified otherwise.

#### 2. Handling POST Requests
```typescript
// app/api/user/route.ts
export async function POST(request: Request) {
  const body = await request.json();
  return Response.json({ success: true, data: body });
}
```
- Use `request.json()` to parse JSON payload.
- Can also use `request.formData()` for form submissions.

#### 3. Supporting Multiple Methods
```typescript
// app/api/user/route.ts
export async function GET() {
  return Response.json({ message: 'GET all users' });
}

export async function POST(request: Request) {
  const body = await request.json();
  return Response.json({ message: 'User created', data: body });
}
```

#### 4. Dynamic API Routes
```typescript
// app/api/products/[id]/route.ts
export async function GET(
  request: Request,
  { params }: { params: { id: string } }
) {
  return Response.json({ productId: params.id });
}
```
- Access dynamic segments with the `params` object.

#### 5. Returning Custom Responses
```typescript
// app/api/download/route.ts
export async function GET() {
  const file = new Blob(['Hello, world!'], { type: 'text/plain' });
  return new Response(file, {
    headers: {
      'Content-Disposition': 'attachment; filename="hello.txt"',
    },
  });
}
```

## Middleware

Middleware in Next.js allows you to run code **before** a request is completed.  
It can be used for tasks like authentication, redirects, rewrites, logging, and more.

### 1. Creating Middleware
Create a `middleware.ts` file in the project root (same level as `app/` or `pages/`).

```typescript
// middleware.ts
import { NextResponse } from 'next/server';
import type { NextRequest } from 'next/server';

export function middleware(request: NextRequest) {
  console.log('Middleware executed:', request.url);

  // Example: Redirect if user is not authenticated
  const isAuthenticated = false; // Replace with real auth check
  if (!isAuthenticated && request.nextUrl.pathname.startsWith('/dashboard')) {
    return NextResponse.redirect(new URL('/login', request.url));
  }

  return NextResponse.next();
}
```

### 2. Matching Specific Paths
You can control which paths run the middleware with the `config` export:
```typescript
export const config = {
  matcher: ['/dashboard/:path*', '/profile/:path*'],
};
```
- `/dashboard/:path*` → applies to `/dashboard` and any sub-path.

### 3. Common Use Cases
- **Authentication**: Redirect users who are not logged in.
- **Localization**: Redirect users to language-specific routes.
- **A/B Testing**: Serve different versions of a page based on conditions.
- **Logging & Analytics**: Track requests before serving a page.

### 4. Example: Adding a Header
```typescript
export function middleware(request: NextRequest) {
  const response = NextResponse.next();
  response.headers.set('X-Custom-Header', 'MyValue');
  return response;
}
```

### 5. Limitations
- Runs on the **Edge Runtime** (no Node.js APIs like `fs`).
- Must be **fast** (small bundle, minimal logic).
- Cannot directly send a full HTML response; must redirect, rewrite, or continue.

## Deploying

Next.js supports multiple deployment targets, including **Vercel** (official hosting), **Node.js servers**, **static exports**, and more.

### 1. Deploying to Vercel (Recommended)
Vercel is the easiest and most optimized platform for hosting Next.js apps.

**Steps:**
1. Push your project to GitHub, GitLab, or Bitbucket.
2. Go to [Vercel](https://vercel.com), import your repository.
3. Vercel detects Next.js automatically and configures the build.
4. Every git push triggers an automatic redeploy.

### 2. Deploying to a Custom Node.js Server
If you want to self-host:
```bash
npm run build
npm run start
```
- Ensure you have Node.js installed on the server.
- This runs the app in production mode.

### 3. Deploying as Static HTML
For static sites (no server-side rendering):
```bash
next build
next export
```
- Outputs static files to the `out/` directory.
- Can be hosted on platforms like GitHub Pages, Netlify, or any static host.

### 4. Environment Variables in Production
Set environment variables on your hosting platform:
- **Vercel**: Project Settings → Environment Variables.
- **Custom server**: Use `.env` files or server config.

## Comparison tables

# API Routes vs. Server Actions (Server Functions)

| Criteria | **API Routes** | **Server Actions** |
|---|---|---|
| Caller | External (mobile, third-party, webhooks) | Internal UI (your React components/forms) |
| Public URL | ✅ Yes | ✗ No |
| Webhooks / Cron | ✅ | ✗ |
| File uploads | ✅ Multipart/form-data | ✅ From your own forms (`FormData`); internal only |
| Streaming / file downloads | ✅ Supported | ✗ Not supported |
| CORS / custom headers / status | ✅ Full control | ✗ Not applicable |
| Boilerplate | More (HTTP parsing/response) | Less (direct function call) |
| Works without client JS | ✗ | ✅ with `<form action={...}>` |
| Data revalidation | In handler or via cache headers | `revalidatePath` / `revalidateTag` |
| Auth/session access | Via request/middleware | `cookies()` / `headers()` in action |
| Use when… | Need a URL, webhooks, external clients, streaming, Edge | Internal mutations/forms, tight UI↔data loop, minimal code |

**Rule of thumb:** Need a **URL/HTTP features** → **API Route**.  
Purely **internal UI action** with easy revalidation → **Server Action**.

### Server vs Client Fetching Summary

| Feature | Server Fetching | Client Fetching |
|---------|----------------|-----------------|
| Execution | Server only | Browser |
| Performance | Faster initial load (HTML rendered with data) | Slower initial load, data fetched after render |
| API Key Safety | Safe (never sent to client) | Risky (must avoid exposing keys) |
| Real-time updates | ❌ Needs extra setup | ✅ Easy to update with state |
| Ideal for | Static or SSR content | Interactive, real-time content |

# SSR vs. SSG vs. ISR (aka ISG)

| Concept | What it is | How to do it in Next.js | Use when | Trade-offs |
|---|---|---|---|---|
| **SSR** (Server-Side Rendering) | Render HTML **on every request** on the server | **Pages Router:** `getServerSideProps()` • **App Router:** make route **dynamic** (`export const revalidate = 0` or `export const dynamic = 'force-dynamic'`; use `fetch(..., { cache: 'no-store' })`) | Data changes on every request (per-user dashboards, frequently updated data) | Higher server cost and latency; less cacheable |
| **SSG** (Static Site Generation) | Render HTML **at build time**; served as static files | **Pages Router:** `getStaticProps()` (+ `getStaticPaths()` for dynamic) • **App Router:** default server components with **no** revalidate; use `fetch(..., { cache: 'force-cache' })` | Content rarely changes (marketing pages, docs) | Requires rebuilds to update; initial build time can grow |
| **ISR / ISG** (Incremental Static Regeneration) | **Static first**, then **auto-regenerate** in the background on a schedule | **Pages Router:** `getStaticProps()` **with** `revalidate` • **App Router:** `export const revalidate = <seconds>` or tag/path revalidation | Mostly static but needs periodic freshness (blogs, product catalogs) | Stale-while-revalidate window; cache invalidation strategy needed |

## Quick tips
- Prefer **SSG** for fastest loads when data is stable.  
- Use **ISR** to blend speed and freshness without full rebuilds.  
- Choose **SSR** when content is **personalized** or **changes per request**.

### General tips
- Use fetch API to fetch data because using it Next automatically caches the requests.
- For most static or semi-static content, use revalidate with an interval. For highly dynamic content, use no-store or WebSockets for real-time updates.
- Use `error.tsx` for localized route error handling and top-level `error.tsx` for global fallbacks. Always provide a way for users to retry operations.
- At working with images always set `alt` text for accessibility and use the smallest possible `width` and `height` for your needs.
- Store static images in the `public/` folder when possible to these images being available by default.
- Use only the font weights and subsets you need.
- Prefer local fonts for brand consistency.
- Always set `font-display` via `next/font` defaults to prevent FOUT (Flash of Unstyled Text).
- At working with media for Open Graph, use 1200x630 pixels for standard OG images, keep file size under 300 KB for faster loading, and ensure the image is publicly accessible.
- Use route handlers for **internal APIs** or server-side logic; for public APIs, consider adding authentication.
- Always run `npm run build` before deploying.
- Keep sensitive data in environment variables, not in code. Use the Vercel's dashboard to configure your environment variables.
- Use a CDN for serving static assets.