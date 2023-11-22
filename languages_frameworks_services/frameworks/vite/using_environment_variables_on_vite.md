# Using Environment Variables on Vite

1 - Create a .env.local file in your root folder containing the variables. Example:

```
VITE_API_ACCESS_TOKEN="eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6ImdjbXMtbWFpbi1wcm9kdWN0aW9uIn0.eyJ2ZXJzaW9uIjozLCJpYXQiOjE3MDAyMjY0NDMsImF1ZCI6WyJodHRwczovL2FwaS1zYS1lYXN0LTEuaHlncmFwaC5jb20vdjIvY2xwMm14MWs2MHZmMTAxdWM4OHZ1OGF0cC9tYXN0ZXIiLCJtYW5hZ2VtZW50LW5leHQuZ3JhcGhjbXMuY29tIl0sImlzcyI6Imh0dHBzOi8vbWFuYWdlbWVudC5ncmFwaGNtcy5jb20vIiwic3ViIjoiODU2ZGQ1NWUtYzRhYS00ZjUxLWE4MjktYTA2Y2VhMGU1YWU0IiwianRpIjoiY2w0ZWN3bDZ4MGd4dDAxd2I5bjllOTVvdCJ9.sYBd38YxG7xwXey1yth3aFYoGGzw4ofBFw6QYhiQ6OLlv3kf1Z2grj78kfmrMwuXfj8WNnzsii6GXs8iIbE3MIy4baguwOP_bEnWycx-m26b6F2Dy57u2UR0bNJ2nbHV_hf5l5sKBDADCNxRIXqwaxrgbQpUGzu9EqOnENjLC-YPnBZclDhiQboqwvbKREx8CWtrvNzM80jN16QUijVPK67hbDEaTD14a_lTGVVkb8LF8b8PxKjTiLSFJkJvD_ac6jYyRZEEEBlAGCx3LFP0WYMPiqBJaAsi9JG92goU5FtEVtPUUHfSGUSjN5U3oZ4JUjCN3q9PZimV1QXtgHchcMcp-J5WUR8vMlJIPSEeaqL7awefbX1iApqTK-UR_JG8xKYAqW6ODEhKk_5Bfrgs9fl0NxZFq9o7l98oveuTJZwXdZ17JO1PkOsBe5RmMmZJy-vp1wU5FOzh1UwRYoGmdz3yph5D3991JIqBxXyyj7FAsW5aUfHhsSm60RhY32L_lHa3iwsWTayCsPKDpqFfryXYsFGfhlIFrKBaX8mBnAtTKWLC0e299VTSjkNbjvLvNdeez6eUmiujaFd2WInD-Qrq_fNTVqwikribcFEseTghGPv56UH1KSONV2v9rFh25odCCdm2tkc8G_IZHq0E4kDSmBY1XypaO6ARTAauY_k"
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