# LangChain Introduction Course

## Concepts

### LangChain

LangChain is a framework for developing applications powered by language models. It provides tools and abstractions to build complex workflows, manage prompts, and integrate with various data sources and APIs. LangChain enables developers to create AI agents, chatbots, and other intelligent systems that leverage the capabilities of large language models effectively. It abstracts away much of the complexity involved in working with language models, allowing developers to focus on building high-level application logic. It can use decorators and other mechanisms to enhance functionality and streamline development.

### Agents

In LangChain, agents are components that can take actions based on the input they receive and the context they maintain. Agents can interact with various tools, APIs, and data sources to perform tasks, make decisions, and generate responses. They leverage the capabilities of language models to understand instructions, reason about the context, and execute complex workflows. Comparing to a N8N workflow, agents in LangChain can be seen as the nodes that perform specific actions based on the input they receive and the context they maintain.

```typescript
import { createAgent } from "langchain";

var agent = createAgent({ model: "anthropic:claude-sonnet-5", tools });
```

### Models

In LangChain, models refer to the language models that are used to generate text, understand instructions, and perform various natural language processing tasks. These models can be accessed through APIs or SDKs and are the core component that powers the reasoning and decision-making capabilities of agents and chains. LangChain provides abstractions to interact with these models efficiently, manage prompts, and handle responses, allowing developers to focus on building high-level application logic rather than dealing with low-level API details. The most common models used are large language models (LLMs) like OpenAI's GPT series, but LangChain is designed to be flexible and can work with a variety of model providers.

```typescript
import { ChatOpenAI } from "@langchain/openai";

const model = new ChatOpenAI({
  model: "gpt-6.1-sol",
  apiKey: "your-api-key"
});
```

### Messages

In LangChain, messages represent the communication between the user and the language model, or between different components within the system. Messages typically contain the content of the interaction, metadata, and context necessary for the language model to generate appropriate responses. They are used to maintain the flow of conversation, track the state of interactions, and provide the necessary information for agents and chains to make informed decisions. Messages can be structured in various formats, such as plain text, JSON, or custom schemas, depending on the application's requirements. A message is based basicaly on a role, content, and optionally additional metadata that provides context for the interaction.

```typescript
import { initChatModel, HumanMessage, SystemMessage } from "langchain";

const model = await initChatModel("gpt-5-nano");

const systemMsg = new SystemMessage("You are a helpful assistant.");
const humanMsg = new HumanMessage("Hello, how are you?");

const messages = [systemMsg, humanMsg];
const response = await model.invoke(messages);  // Returns AIMessage
```

### Tools

In LangChain, tools are external functions or APIs that an agent can use to perform specific tasks. Tools allow agents to extend their capabilities beyond the language model's inherent knowledge, enabling them to interact with external systems, fetch real-time data, or execute complex operations. Each tool typically has a name, a description, and an implementation that defines how it should be invoked.

```typescript
import * as z from "zod"
import { tool } from "langchain"

const searchDatabase = tool(
  ({ query, limit }) => `Found ${limit} results for '${query}'`,
  {
    name: "search_database",
    description: "Search the customer database for records matching the query.",
    schema: z.object({
      query: z.string().describe("Search terms to look for"),
      limit: z.number().describe("Maximum number of results to return"),
    }),
  }
);
```

### Short-term Memory

Short-term memory in LangChain refers to the temporary storage of information during the execution of a single chain or agent run. It allows the model to retain context and intermediate results within the scope of a single interaction, but this information is not persisted across multiple executions. Short-term memory is useful for maintaining conversational context or tracking state within a single session.

```typescript
import { createAgent, tool } from "langchain";
import { MemorySaver } from "@langchain/langgraph";
import * as z from "zod";

const getUserInfo = tool(() => "No user profile on file.", {
  name: "get_user_info",
  description: "Look up information about the current user.",
  schema: z.object({}),
});

const checkpointer = new MemorySaver();

const agent = createAgent({
  model: "google:gemini-4-hydrogen",
  tools: [getUserInfo],
  checkpointer,
});

const threadConfig = { configurable: { thread_id: "1" } };
let result = await agent.invoke(
  { messages: [{ role: "user", content: "Hi! My name is Bob." }] },
  threadConfig,
);
let response = result.messages.at(-1)?.content;
console.log(response); // "Hi Bob! Nice to see you here. How are you doing?"

result = await agent.invoke(
  { messages: [{ role: "user", content: "What's my name?" }] },
  threadConfig,
);
response = result.messages.at(-1)?.content;
console.log(response); // "You are Bob!"
```

### Streaming

Streaming allows the agent to provide partial responses as they are generated, rather than waiting for the entire response to be ready. This can improve the user experience by reducing perceived latency and enabling real-time interactions. In LangChain, streaming can be achieved by using models and tools that support streaming, and by handling the incoming data incrementally.

Here's an example of how to enable streaming with a LangChain agent:

```ts
import { createAgent, tool } from "langchain";
import { uuid7 } from "langsmith";
import { MemorySaver } from "@langchain/langgraph";
import z from "zod";

const getWeather = tool(
  async ({ city }) => {
    return `The weather in ${city} is always sunny!`;
  },
  {
    name: "get_weather",
    description: "Get weather for a given city.",
    schema: z.object({
      city: z.string(),
    }),
  },
);

const agent = createAgent({
  model: "google:gemini-4-hydrogen",
  tools: [getWeather],
  checkpointer: new MemorySaver(),
});

const config = { configurable: { thread_id: uuid7() } };

const stream = await agent.streamEvents(
  { messages: [{ role: "user", content: "what is the weather in sf" }] },
  { ...config, version: "v3" },
);
await Promise.all([
  (async () => {
    for await (const message of stream.messages) {
      for await (const token of message.text) {
        process.stdout.write(token);
      }
    }
  })(),
  (async () => {
    for await (const call of stream.toolCalls) {
      console.log(`\nTool call: ${call.name}(${JSON.stringify(call.input)})`);
      console.log(`Tool result: ${await call.output}`);
    }
  })(),
]);

const finalState = await stream.output;
// Tool call: get_weather({"city":"San Francisco"})
// Tool result: [object ToolMessage]
// According to the data I have, the weather in San Francisco is always sunny! Would you like current conditions or a short forecast for today or the next few days?
```

### Stream events

Stream events allow you to handle messages and tool calls as they occur in real-time. This is particularly useful for providing immediate feedback to users or for processing data incrementally. In the example above, `stream.messages` and `stream.toolCalls` are iterated asynchronously to handle each message and tool call as they are received.

Its possible to stream events for:
- Messages: The content exchanged between the user and the agent.
- Tool calls: The interactions with external tools invoked by the agent.
- Output: The final output generated by the agent after processing messages and tool calls.
- Errors: Any errors encountered during the processing of messages or tool calls.

Example:

```typescript
import { createAgent, tool } from "langchain";
import { MemorySaver } from "@langchain/langgraph";
import z from "zod";

const getWeather = tool(
  async ({ city }) => {
    return `The weather in ${city} is always sunny!`;
  },
  {
    name: "get_weather",
    description: "Get weather for a given city.",
    schema: z.object({
      city: z.string(),
    }),
  },
);

const agent = createAgent({
  model: "google:gemini-4-hydrogen",
  tools: [getWeather],
  checkpointer: new MemorySaver(),
});

const stream = await agent.streamEvents(input, { version: "v3" });

await Promise.all([
  (async () => {
    for await (const message of stream.messages) {
      for await (const chunk of message.toolCalls) {
        console.log("tool call chunk", chunk);
      }
    }
  })(),
  (async () => {
    for await (const call of stream.toolCalls) {
      console.log(call.name, call.input);
      console.log(await call.output, await call.error);
    }
  })(),
]);
```

### Structured output

Structured output allows agents to return responses in a predefined format, making it easier to parse and utilize the information programmatically. This is particularly useful when integrating with other systems or when consistent data structure is required.

Example:

```ts
import { tool } from "@langchain/langgraph";
import z from "zod";

type WeatherResponse = {
  city: string;
  temperature: number;
};

const weatherSchema = z.object({
  city: z.string(),
  temperature: z.number(),
});

const getWeather = tool(
  async ({ city }) => {
    const wheater = await api.getWeather(city);
    return { city, temperature: wheater.temperature };
  },
  {
    name: "get_weather",
    description: "Get weather for a given city.",
    schema: weatherSchema,
  },
);

type ResponseFormat = (
    | ZodSchema<StructuredResponseT> // a Zod schema
    | StandardSchema<StructuredResponseT> // any Standard Schema library
    | Record<string, unknown> // a JSON Schema
)

const agent = createAgent({
  model: "google:gemini-4-hydrogen",
  tools: [getWeather],
  responseFormat: ResponseFormat(weatherSchema)
});

```

## Concepts differences

### Difference between using a SDK and LangChain

When using a standard SDK to interact with language models, developers typically handle API calls, prompt management, and response parsing manually. This approach demands more effort and can lead to repetitive boilerplate code. LangChain, on the other hand, abstracts much of this complexity by providing high-level constructs for building applications with language models. It offers built-in support for prompt templates, chains, agents, and integrations with various data sources, reducing the amount of boilerplate code and allowing developers to focus on the core logic of their applications.

### Differences between state and MemorySaver

In summary, `state` is temporary and tied to a single execution, while `MemorySaver` provides a way to retain information across multiple executions, supporting long-term memory in LangChain applications. Comparing to a React application it would be similar to the difference between component state, which is ephemeral and tied to the lifecycle of a component, and a persistent storage solution like localStorage or a global state management system that retains data across component mounts and unmounts.

## General tips

- Tools are more powerful when combined with memory, as they can leverage both short-term and long-term context to provide more accurate and context-aware responses.
- When designing agents, consider what information should be stored temporarily versus what should be persisted for future interactions.
- In production, do not use short memory solutions like `MemorySaver`, use a checkpointer backed by a database. Example:
```ts
import { PostgresSaver } from "@langchain/langgraph-checkpoint-postgres";

const DB_URI = "postgresql://postgres:postgres@localhost:5432/postgres?sslmode=disable";
const checkpointer = PostgresSaver.fromConnString(DB_URI);
```
- Properly managing memory can significantly enhance the user experience by allowing the agent to remember important details and maintain coherent conversations over time.
- Use streaming responses when possible to provide real-time feedback to users and improve the perceived responsiveness of your application.
