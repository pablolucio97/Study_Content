# GraphQL Course

## Concepts

### Schema Definition Language (SDL): 
GraphQL uses a schema to define the structure of your data. This schema is written in Schema Definition Language, which is a syntax that allows you to define types, fields, and other constructs. Understanding SDL is crucial for defining your API's capabilities.

### Types and Fields: 
At the heart of a GraphQL schema are the types and fields. Types can be objects, scalars, enums, interfaces, or unions. Each field on a GraphQL object type can have its own set of arguments and a return type.

### Queries and Mutations:

- Queries: These are used to fetch data in GraphQL. They are analogous to GET requests in REST.
- Mutations: These are used to modify data (create, update, delete). They are similar to POST, PUT, DELETE in REST.

### Resolvers: 
Resolvers are functions that handle the fetching or computing of data for a field in your schema. Each field on each type is backed by a resolver that knows how to fetch or compute the value for that field.

Example of resolvers on Queries:

```typescript
const resolvers = {
    Query: {
        // Resolver for fetching all posts
        posts: async () => {
            // Logic to fetch all posts from the database
            return await database.getAllPosts();
        },

        // Resolver for fetching a single post by ID
        post: async (_, args) => {
            // Logic to fetch a specific post using the provided ID
            return await database.getPostById(args.id);
        }
    },

    // ... (other resolvers)
};
```

Example of resolvers on Mutations:

```typescript
const resolvers = {
    // ... (other resolvers)

    Mutation: {
        // Resolver for adding a new post
        addPost: async (_, args) => {
            // Logic to add a new post to the database
            const newPost = {
                id: generateNewId(), // A function to generate a unique ID
                title: args.title,
                content: args.content
            };

            await database.addPost(newPost);
            return newPost;
        }
    }
};
```

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

### Performing queries with variables

To perform queries with variables you need to:

1 - Create a interface for your query response.

2 - Write your query receiving the variable as param (generally the variable is used to perform filters).

3 - Pass the expected param to the query through the variables object as param of the useQuery hooke. 

In this example, we are retrieving for a video that matches to the slug received via query params:

```typescript
import { gql, useQuery } from '@apollo/client'
import '@vime/core/themes/default.css'
import { DefaultUi, Player, Youtube } from '@vime/react'
import {
    CaretRight,
    DiscordLogo,
    FileArrowDown,
    Lightning
} from 'phosphor-react'

interface VideoProps {
    lessonSlug: string
}

interface GetLessonBySlugResponse {
    lesson: {
        title: string;
        videoId: string;
        description: string;
        teacher: {
            bio: string;
            avatarURL: string;
            name: string;
        }
    }
}

export function Video(props: VideoProps) {


    const GET_LESSON_BY_SLUG_QUERY = gql`
    query GetLessonBySlug($slug: String){
        lesson(where: {slug: $slug}){
            title
            videoId
            description
            teacher{
                bio
                avatarURL
                name
            }
        }
    }
    `

    const { data } = useQuery<GetLessonBySlugResponse>(GET_LESSON_BY_SLUG_QUERY, {
        variables:{
            slug: props.lessonSlug
        }
    })

    if (!data) {
        return (
            <div className='flex-1'>
                <p>Carregando...</p>
            </div>
        )
    }

    return (
        <div className='flex-1'>
            <div className="bg-black flex justify-center">
                <div className="h-full w-full max-w-[1100px] max-h-[60vh] aspect-video">
                    <Player>
                        <Youtube
                            videoId={data.lesson.videoId}
                        />
                        <DefaultUi />
                    </Player>
                </div>
            </div>

            <div className="p-8 max-w-[1100px] mx-auto">
                <div className="flex items-start gap-16">
                    <div className="flex-1">
                        <h1 className="text-2xl- font-bold">
                            {data.lesson.title}
                        </h1>
                        <p className="mt-4 text-gray-200 leading-relaxed">
                            {data.lesson.description}
                        </p>
                        <div className="flex items-center gap-4 mt-6">
                            <img
                                src={data.lesson.teacher.avatarURL}
                                alt="ignite-lab"
                                className='rounded-full border-blue-500 h-16 w-16 mb-4'
                            />
                        </div>
                        <div className="leading-relaxed">
                            <strong className="font-bold text">{data.lesson.teacher.name}a</strong>
                            <span className="text-gray-200 text-sm block">{data.lesson.teacher.bio}</span>
                        </div>
                    </div>
                    <div className="flex flex-col gap-4">
                        <a href="#" className="p-4 text-sm bg-green-500 flex items-center border font-bold uppercase justify-center gap-2 hover:bg-green-700">
                            <DiscordLogo
                                size={24}
                            />
                            Comunidade do Discord
                        </a>
                        <a href="#" className="p-4 text-sm bg-none border-blue-500 border flex items-center font-bold uppercase justify-center  gap-2">
                            <Lightning
                                size={24}
                            />
                            Acesse o desafio
                        </a>
                    </div>
                </div>
                <div className="gap-8 mt-12 mb-8 grid grid-cols-2">
                    <a href="#" className='bg-gray-600 rounded overflow-hidden flex items-stretch gap-6 hover:bg-gray-500'>
                        <div className="bg-green-700 p-6 h-full flex items-center">
                            <FileArrowDown size={40} />
                        </div>
                        <div className="py-6 leading-relaxed">
                            <strong className='text-2-xl'>
                                Material complementar
                                <p className='text-sm text-gray-300'>
                                    Acesse o material complementar da aula
                                </p>
                            </strong>
                        </div>
                        <div className='h-full p-6 flex items-center'>
                            <CaretRight size={24} />
                        </div>
                    </a>
                </div>
            </div>
        </div>
    )
}
```