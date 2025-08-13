
# 📜 Documenting APIs with Swagger in Node.js + TypeScript

## 1️⃣ Install Dependencies
Install **swagger-ui-express** and its TypeScript types:
```bash
yarn add swagger-ui-express
yarn add -D @types/swagger-ui-express
```

---

## 2️⃣ Enable JSON Import in TypeScript
In your `tsconfig.json`, enable:
```json
"resolveJsonModule": true
```
This allows importing `.json` files directly in TypeScript.

---

## 3️⃣ Create the `swagger.json` File
Inside your `src` folder, create a `swagger.json` with basic API information:
```json
{
  "openapi": "3.0.0",
  "info": {
    "title": "My Project API",
    "description": "API Documentation for My Project",
    "version": "1.0.0",
    "contact": {
      "email": "support@myproject.com"
    }
  }
}
```

---

## 4️⃣ Mount Swagger in Your Server
In your `server.ts` or `app.ts`:
```ts
import express from 'express';
import swaggerUi from 'swagger-ui-express';
import swaggerDocument from './swagger.json';

import { routes } from './routes';

const app = express();
app.use(express.json());

app.use('/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerDocument));

app.use(routes);

app.listen(3333, () => {
  console.log('Server running on port 3333');
});
```

---

## 5️⃣ Add Example Endpoints to `swagger.json`
Here’s an example of a **GET** and **POST** endpoint:
```json
{
  "paths": {
    "/users": {
      "post": {
        "tags": ["Users"],
        "summary": "Create a user",
        "description": "Creates a new user",
        "requestBody": {
          "required": true,
          "content": {
            "application/json": {
              "schema": {
                "type": "object",
                "properties": {
                  "name": { "type": "string" },
                  "email": { "type": "string" }
                },
                "required": ["name", "email"]
              },
              "example": {
                "name": "Pablo",
                "email": "pablo@example.com"
              }
            }
          }
        },
        "responses": {
          "201": { "description": "Created" },
          "400": { "description": "User already exists" }
        }
      },
      "get": {
        "tags": ["Users"],
        "summary": "List users",
        "description": "Retrieves all registered users",
        "responses": {
          "200": { "description": "OK" },
          "400": { "description": "Bad request" }
        }
      }
    }
  }
}
```

---

## 6️⃣ Add Components for Reuse
Avoid repetition by defining schemas in `components`:
```json
"components": {
  "schemas": {
    "User": {
      "type": "object",
      "properties": {
        "id": { "type": "string", "format": "uuid" },
        "name": { "type": "string" },
        "email": { "type": "string" }
      }
    }
  }
}
```
Then, reuse it with:
```json
"$ref": "#/components/schemas/User"
```

---

## 7️⃣ Run and Access Documentation
Start your server:
```bash
yarn dev
```
Then open in your browser:
```
http://localhost:3333/api-docs
```

---

## ✅ Best Practices
- Keep `swagger.json` updated with **every new endpoint**.
- Use `tags` to group endpoints logically.
- Always provide **examples** for request and response bodies.
- Use `$ref` to avoid repeating schema definitions.
- Add `securitySchemes` to document authentication.

---

## 🔗 Useful References
- [Swagger OpenAPI 3.0 Specification](https://swagger.io/specification/)
- [swagger-ui-express GitHub](https://github.com/scottie1984/swagger-ui-express)
