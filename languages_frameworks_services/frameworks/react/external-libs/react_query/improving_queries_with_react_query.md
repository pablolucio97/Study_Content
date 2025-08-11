# Using React Query

React Query is a useful tool for data fetching that returns more resources to allow better control of your application and uses a cache to avoid unnecessary queries.

---

## 1) Installation

Run:

```bash
yarn add react-query
```

---

## 2) Creating the Query Client

In the `services` folder, create a file named **queryClient.ts** exporting an instance of `QueryClient`:

```ts
import { QueryClient } from "react-query";

export const queryClient = new QueryClient();
```

---

## 3) Adding QueryClientProvider to Your App

Inside your `app.tsx` file, wrap your application with `QueryClientProvider` and `ReactQueryDevtools`:

```tsx
import { AppProps } from 'next/app'
import { QueryClientProvider } from 'react-query'
import { queryClient } from '../../services/queryClient'
import { ReactQueryDevtools } from 'react-query/devtools'

function MyApp({ Component, pageProps }: AppProps) {
    return (
      <QueryClientProvider client={queryClient}>
        <Component {...pageProps} />
        <ReactQueryDevtools/>
      </QueryClientProvider>
    )
}

export default MyApp
```

---

## 4) Using useQuery

Example:

```tsx
import { useQuery } from 'react-query'

export default function UserList() {
    const { data, isLoading, error } = useQuery('users', async () => {
        const response = await fetch('http://localhost:3000/api/users')
        const data = await response.json()

        return data.users.map(user => ({
            id: user.id,
            name: user.name,
            email: user.email,
            createdAt: new Date(user.createdAt).toLocaleDateString('pt-BR', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            })
        }))
    }, {
        staleTime: 5000
    })

    if (isLoading) return <div>Loading...</div>
    if (error) return <div>Failed to load users</div>

    return (
        <table>
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Data de cadastro</th>
                </tr>
            </thead>
            <tbody>
                {data?.map(user => (
                    <tr key={user.id}>
                        <td>{user.name}</td>
                        <td>{user.createdAt}</td>
                    </tr>
                ))}
            </tbody>
        </table>
    )
}
```

---

# Doing Infinite Queries

Example API:  
`https://randomuser.me/api/?page=1&results=10`

## 1) Fetch Function

```ts
const fetchUsers = async ({ pageParam = 1 }) => {
    const res = await fetch(`https://randomuser.me/api/?page=${pageParam}&results=10`);
    return res.json();
} 
```

> The API must have pagination. You can check it if the API returns an array of objects or pagination metadata.

## 2) Using useInfiniteQuery

```ts
import { useInfiniteQuery } from "react-query"

const {
    data,
    isLoading,
    isError,
    error,
    fetchNextPage,
    isFetchingNextPage,
    isFetching
} = useInfiniteQuery("users", fetchUsers, {
    getNextPageParam: (currentPage) => currentPage.info.page + 1
});
```

## 3) Rendering

```tsx
import { useInfiniteQuery } from "react-query";

const fetchUsers = async ({ pageParam = 1 }) => {
    const res = await fetch(`https://randomuser.me/api/?page=${pageParam}&results=10`);
    return res.json();
}

export default function InfinityQuery() {
    const {
        data,
        isLoading,
        isError,
        error,
        fetchNextPage,
        isFetchingNextPage,
        isFetching
    } = useInfiniteQuery("users", fetchUsers, {
        getNextPageParam: (currentPage) => currentPage.info.page + 1
    });

    if (isLoading) return <h2>Loading...</h2>
    if (isError) return <h2>{(error as Error).message}</h2>

    return (
        <>
            <h2>Infinite Scroll View</h2>
            <div>
                {data?.pages.map(page =>
                    page.results.map((user: any) => (
                        <p key={user.email}>{user.email}</p>
                    ))
                )}
            </div>
            <button onClick={() => fetchNextPage()}>Load More</button>
            {isFetching && !isFetchingNextPage && 'Fetching...'}
        </>
    );
}
```

---

## General Tips

- Prefetch only data from your own application. Avoid prefetching from third-party APIs.
- Control your query stale time and some more options using the options from the useQuery hook.
