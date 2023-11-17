# GraphQL Course

## Performing queries on React applications

1 - Install the Apollo client to handle the queries running the command `npm i @apollo/client graphql`

2 - Create a folder named services, and inside it a new file named as `apolloClient.ts` exporting the Apollo Client instance and using the class InMemoryCache to handle cache. Example:

``` typescript
import { ApolloClient, InMemoryCache } from "@apollo/client";

export const client = new ApolloClient({
    uri: 'https://api-sa-east-1.hygraph.com/v2/clp2mx1k60vf101uc88vu8atp/master',
    cache: new InMemoryCache()
})
```

3 - In your application base file (main.tsx or App.tsx, based on the framework you're using), import the ApolloProvider to wrapper your application with the ApolloProvider passing your client. Example:


``` typescript
import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App.tsx'
import './styles/global.css'
import { ApolloProvider } from '@apollo/client'
import { client } from './services/apollo.ts'

ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>
    <ApolloProvider client={client}>
      <App />
    </ApolloProvider>
  </React.StrictMode>,
)
```

4 - In your application import the `gql`, and the `useQuery` hook from `@apollo/client`, create your query using the gql, create a type for your resources used in the query, call the query through the useQuery hook typing it with the interface you created, and consume the data returned by useQuery in your application. Example:


``` typescript
import { gql, useQuery } from '@apollo/client'

interface ILesson {
  id: string;
  title: string;
}

function App() {

  const GET_LESSONS_QUERY = gql`
    query{
      lessons{
        id
        title
      },
      teachers{
        id
        name
      }
    }
  `
  const { data } = useQuery<{lessons: ILesson[]}>(GET_LESSONS_QUERY)

  return (
    <>
      <ul>
        {data?.lessons.map(item => (
          <li key={item.id}i>{item.title}</li>
        ))}
      </ul>
    </>
  )
}

export default App

```