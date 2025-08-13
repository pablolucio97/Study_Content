# 🚦 Writing E2E Tests with Supertest

End-to-end (E2E) tests validate your **controllers** and HTTP behavior by spinning up your app and making real HTTP requests.  
**Supertest** provides a lightweight HTTP server/client to test your routes without starting a real network server.

---

## 1) Install Dependencies

```bash
yarn add supertest
yarn add -D @types/supertest
# or with npm
# npm i supertest
# npm i -D @types/supertest
```

---

## 2) Basic E2E Test Example

This example uses **Vitest** and a Fastify/Express-style `app` that exposes an `.server` and `.ready()` API.

```ts
import request from 'supertest'
import { app } from '@/app'
import { afterAll, beforeAll, describe, expect, it } from 'vitest'

describe('Register e2e', () => {
  beforeAll(async () => {
    await app.ready()
  })

  afterAll(async () => {
    await app.close()
  })

  it('should be able to register a new user', async () => {
    const response = await request(app.server)
      .post('/users')
      .send({
        name: 'John Doe',
        email: 'johndoe@outlook.com',
        password: '1234567',
      })

    expect(response.statusCode).toEqual(201)
  })
})
```

> ℹ️ For **Express**, you can often pass the `app` directly to `request(app)` instead of `app.server`.

---

## Tips
- Seed/clean the **test database** between runs to keep tests deterministic.
- Use **environment variables** (e.g., `NODE_ENV=test`) to load a test config.
- Assert response **status** and **body** (`expect(response.body).toMatchObject({...})`).

