# Using React Query with Next.js

## 3) Create a hook and a query function

Create a file containing **a function** to fetch and (optionally) format your data, and **a hook** that uses `useQuery`.  
The hook should receive a param named `options` typed as `UseQueryOptions` and spread it into the third parameter of `useQuery`.

```ts
import { useQuery, UseQueryOptions } from 'react-query'
import { api } from '../services/api'
import { gameTypes } from '../types/gameCardTypes'

export const getGames = async () => {
  const { data } = await api.get<gameTypes[]>('/games')
  const games = data.map(game => ({
    id: game.id,
    thumbnail: game.thumbnail,
    freetogame_profile_url: game.freetogame_profile_url,
  }))

  return games
}

export function useGamesList(options: UseQueryOptions) {
  return useQuery('games', () => getGames(), {
    ...options,
  })
}
```

---

## 4) Use your hook with SSR data (Next.js)

In your application, call the fetch function inside your SSR function and return it as a prop.  
Consume this prop in your component and call your hook passing the prop from SSR as `initialData`.

```tsx
import GameCard from '../components/GameCard'
import { GetStaticProps } from 'next'
import { getGames, useGamesList } from '../hooks/useGamesList'

export default function Games({ games }) {
  const { data, error, isLoading } = useGamesList({ initialData: games })

  if (isLoading) return <p>Loading...</p>
  if (error) return <p>Something went wrong.</p>

  return (
    <main>
      {data.map((game) => (
        <GameCard
          key={game.id}
          id={game.id}
          freetogame_profile_url={game.freetogame_profile_url}
          thumbnail={game.thumbnail}
        />
      ))}
    </main>
  )
}

export const getStaticProps: GetStaticProps = async () => {
  const games = await getGames()

  return {
    props: {
      games,
    },
  }
}
```

# Doing Data Prefetch with Next.js

## 1) Write a prefetch helper

Import the `queryClient` from `services/queryClient` and write an async function to call `prefetchQuery`, passing the **query key** and a **fetcher**:

```ts
import { queryClient } from '../services/queryClient'
import { api } from '../services/api'

export async function handlePrefetchGame(gameId: number) {
  await queryClient.prefetchQuery(['game', gameId], async () => {
    const response = await api.get(`/games/${gameId}`)
    return response.data
  })
}
```

---

## 2) Call the helper on hover

```tsx
<button onMouseEnter={() => handlePrefetchGame(game.id)}>
  See game
</button>
```
