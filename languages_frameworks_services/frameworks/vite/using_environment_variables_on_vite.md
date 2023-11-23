# Using Environment Variables on Vite

1 - Create a .env.local file in your root folder containing the variables. Example:

```
VITE_API_ACCESS_TOKEN="your_env"
VITE_API_BASE_URL="https://api-sa-east-1.hygraph.com/v2/clp2mx1k60vf101uc88vu8atp/master"
```

2 - Import the environment variable through import.meta.env.VITE_YOUR_ENV_VARIABLE. Example:

```typescript
import { ApolloClient, InMemoryCache } from "@apollo/client";

export const client = new ApolloClient({
  uri: import.meta.env.VITE_API_BASE_URL,
  headers: {
    Authorization: `Bearer ${import.meta.env.VITE_API_ACCESS_TOKEN}`,
  },
  cache: new InMemoryCache(),
});

```


3 - Add the .env.local file to .gitignore file.

4 - Restart the project.