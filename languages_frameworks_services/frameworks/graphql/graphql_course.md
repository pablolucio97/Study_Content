# GraphQL Course

## Concepts

### Schema Definition Language (SDL): 
GraphQL uses a schema to define the structure of your data. This schema is written in Schema Definition Language, which is a syntax that allows you to define types, fields, and other constructs. Understanding SDL is crucial for defining your API's capabilities.

### Types and Fields: 
At the heart of a GraphQL schema are the types and fields. Types can be objects, scalars, enums, interfaces, or unions. Each field on a GraphQL object type can have its own set of arguments and a return type. The types used by the GraphQL are analogous to the TypeScript's types.

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

## Considerations

GraphQL can be used in as server-side as client-side. GraphQL is used on the server side to create an API that defines how data can be queried and manipulated. On the client side, it's used to interact with this API, requesting and updating data as needed by the application. This dual-sided usage makes GraphQL a powerful tool for building efficient and flexible data-driven applications.

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

## Subscriptions

Subscriptions are used to push on the server and get on the client data in real time. It's analogue to doing a pooling using react-query, but in real time. Its based on pub/sub mechanism where the interested clients listen to server changes through subscriptions. Subscriptions are particularly useful in applications where data needs to be updated in real time, such as in collaborative environments, real-time monitoring systems, or live messaging applications. Example in a chat application:

```graphql
subscription {
  newMessage(channelId: "abc123") {
    id
    content
    sender {
      name
    }
    timestamp
  }
}
```

How it works:

1. Client Subscribes: The client subscribes to the newMessage event for a specific chat channel.
2. Message Sent: Another user sends a message to the channel.
3. Server Publishes: The server detects this new message, and triggers the newMessage subscription, sending the message details to all subscribed clients.
4. Client Receives: The subscribing client receives the new message in real time and can update the chat interface accordingly.

## Complete GraphQL CRUD example (need be imported on Insomnia): 

```json
{"_type":"export","__export_format":4,"__export_date":"2023-12-02T11:03:25.041Z","__export_source":"insomnia.desktop.app:v8.4.5","resources":[{"_id":"req_033c6e3d9bf04cef979629412201b995","parentId":"wrk_0e0e87ee08d04e78a4bfccfccb4bf7ed","modified":1701512896842,"created":1701511731195,"url":"https://api-sa-east-1.hygraph.com/v2/clp2mx1k60vf101uc88vu8atp/master","name":"Create lesson - ignite event platform","description":"","method":"POST","body":{"mimeType":"application/graphql","text":"{\"query\":\"mutation createLesson($title: String!, $slug: String!, $videoId: String!, $lessonType: LessonType!){\\n\\tcreateLesson(data: {title: $title, slug: $slug, videoId: $videoId, lessonType: $lessonType}){\\n\\t\\tid\\n\\t}\\n}\",\"operationName\":\"createLesson\",\"variables\":\"{\\n\\t\\\"title\\\": \\\"Learning advanced JSON\\\",\\n\\t\\\"slug\\\": \\\"learning-advanced-json\\\",\\n\\t\\\"videoId\\\": \\\"QZCw5dcu5Yg\\\",\\n\\t\\\"lessonType\\\": \\\"live\\\"\\n}\"}"},"parameters":[],"headers":[{"name":"User-Agent","value":"insomnia/8.4.5"},{"name":"Content-Type","value":"application/json"}],"authentication":{},"metaSortKey":-1701511731195,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"wrk_0e0e87ee08d04e78a4bfccfccb4bf7ed","parentId":null,"modified":1701513951122,"created":1701508660126,"name":"Ignite Event Platform - GraphQL Crud example","description":"","scope":"collection","_type":"workspace"},{"_id":"req_b7dbc7c7b9fb483ea19831c933b09030","parentId":"wrk_0e0e87ee08d04e78a4bfccfccb4bf7ed","modified":1701512826829,"created":1701511065742,"url":"https://api-sa-east-1.hygraph.com/v2/clp2mx1k60vf101uc88vu8atp/master","name":"Get lessons - ignite event platform","description":"","method":"POST","body":{"mimeType":"application/graphql","text":"{\"query\":\"query getLessons {\\n  lessons  {\\n    slug\\n    id\\n    lessonType\\n    publishedAt\\n    title\\n    description\\n    teacher {\\n      name\\n      id\\n      bio\\n    }\\n  }\\n}\\n\",\"operationName\":\"getLessons\"}"},"parameters":[],"headers":[{"name":"User-Agent","value":"insomnia/8.4.5"},{"name":"Content-Type","value":"application/json"}],"authentication":{},"metaSortKey":-1701511065742,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"req_bd95485a88214b2096ccb7c93f8e7e16","parentId":"wrk_0e0e87ee08d04e78a4bfccfccb4bf7ed","modified":1701514108490,"created":1701513996499,"url":"https://api-sa-east-1.hygraph.com/v2/clp2mx1k60vf101uc88vu8atp/master","name":"Get lesson by id - ignite event platform","description":"","method":"POST","body":{"mimeType":"application/graphql","text":"{\"query\":\"query getLessonById($id: ID!) {\\n  lessons(where: {id: $id})  {\\n    slug\\n    id\\n    lessonType\\n    publishedAt\\n    title\\n    description\\n    teacher {\\n      name\\n      id\\n      bio\\n    }\\n  }\\n}\\n\",\"operationName\":\"getLessonById\",\"variables\":\"{\\n\\t\\\"id\\\" : \\\"clp2n4ilw00970bm0644vsxp5\\\"\\n}\"}"},"parameters":[],"headers":[{"name":"User-Agent","value":"insomnia/8.4.5"},{"name":"Content-Type","value":"application/json"}],"authentication":{},"metaSortKey":-1701510265946.5,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"req_19848804e259441cb12378da98317190","parentId":"wrk_0e0e87ee08d04e78a4bfccfccb4bf7ed","modified":1701513203217,"created":1701511313475,"url":"https://api-sa-east-1.hygraph.com/v2/clp2mx1k60vf101uc88vu8atp/master","name":"Delete lesson - ignite  event platform","description":"","method":"POST","body":{"mimeType":"application/graphql","text":"{\"query\":\"mutation deleteLesson($id: ID!) {\\n\\tdeleteLesson(where: {id: $id}){\\n\\t\\ttitle\\n\\t}\\n}\\n\",\"operationName\":\"deleteLesson\",\"variables\":\"{\\n\\t\\\"id\\\": \\\"clpnwq1y318wr0bkg9wh319g9\\\"\\n}\"}"},"parameters":[],"headers":[{"name":"User-Agent","value":"insomnia/8.4.5"},{"name":"Content-Type","value":"application/json"}],"authentication":{},"metaSortKey":-1701047108928,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"req_a0b6705677ba4befa10ec770757beff6","parentId":"wrk_0e0e87ee08d04e78a4bfccfccb4bf7ed","modified":1701513764068,"created":1701513667591,"url":"https://api-sa-east-1.hygraph.com/v2/clp2mx1k60vf101uc88vu8atp/master","name":"Update lesson - ignite  event platform","description":"","method":"POST","body":{"mimeType":"application/graphql","text":"{\"query\":\"mutation deleteLesson($id: ID!, $title: String!) {\\n\\tupdateLesson(where: {id: $id}, data:{title: $title}){\\n\\t\\ttitle\\n\\t}\\n}\\n\",\"operationName\":\"deleteLesson\",\"variables\":\"{\\n\\t\\\"id\\\": \\\"clpnx39z319dt0alo6amuqs0i\\\",\\n\\t\\\"title\\\" : \\\"Learning JSON best practices\\\"\\n}\"}"},"parameters":[],"headers":[{"name":"User-Agent","value":"insomnia/8.4.5"},{"name":"Content-Type","value":"application/json"}],"authentication":{},"metaSortKey":-1700815930316.5,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"env_adea6f9220a9416aa868748e8452fefa","parentId":"wrk_0e0e87ee08d04e78a4bfccfccb4bf7ed","modified":1700492990901,"created":1698873136147,"name":"Base Environment","data":{"authToken":"{% response 'body', 'req_6049364abc954ecf91ef1df9bb8dd2a8', 'b64::JC5kYXRhLmxvZ2luVXNlci50b2tlbg==::46b', 'never', 60 %}"},"dataPropertyOrder":{"&":["authToken"]},"color":null,"isPrivate":false,"metaSortKey":1698873136147,"_type":"environment"},{"_id":"jar_8162e7fe71864a8bac72323e50e838b6","parentId":"wrk_0e0e87ee08d04e78a4bfccfccb4bf7ed","modified":1698873136147,"created":1698873136147,"name":"Default Jar","cookies":[],"_type":"cookie_jar"}]}
```