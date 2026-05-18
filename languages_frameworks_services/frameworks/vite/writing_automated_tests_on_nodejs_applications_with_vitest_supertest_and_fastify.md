

# Writing Automated Tests on NodeJS with Vitest, Fastify and Supertest

## 1. Installing Dependencies

```bash
npx yarn add vitest supertest @types/supertest -D
```

## 2. Separate `server.ts` and `app.ts`

Keep `app.ts` for application logic and use `server.ts` to listen to the app.

## 3. Example of a Test with Supertest

```ts
import { test, expect, beforeAll, afterAll, describe } from 'vitest'
import supertest from 'supertest'
import { app } from '../app'

beforeAll(async () => {
  await app.ready()
})

afterAll(async () => {
  await app.close()
})

describe('Transactions', () => {
  test('Allow user to create a new transaction', async () => {
    const response = await supertest(app.server)
      .post('/transactions')
      .send({
        title: "Freela",
        amount: 5000,
        type: "credit"
      })
    expect(response.statusCode).toBe(201)
  })
})
```

## Configuring Test Environment

### 1. `.env.test` file

```env
DATABASE_URL="./db/app.db"
NODE_ENV="test"
```

### 2. Load env file dynamically

```ts
import { config } from 'dotenv'

if (process.env.NODE_ENV === 'test') {
  config({ path: '.env.test', override: true })
} else {
  config()
}
```

### 3. Reset DB before each test

```ts
import { execSync } from 'node:child_process'

beforeEach(async () => {
  execSync('npm run knex migrate:rollback --all')
  execSync('npm run knex migrate:latest')
})
```

## General Tips

- Tests must not depend on each other.
- If a test depends on another, merge them into a single test.
- Adapt your test to your code, not the reverse.
- Maintain separate environments for development and testing.
- Clean and reset your test DB before each test.

---

#testing #nodejs #vite #backend #tutorial

**Related:** [[configuring_e2e_tests_on_node_with_vitest_and_npm_run_all]] | [[writing_e2e_tests_with_supertest]] | [[writing_unity_tests_on_nodejs_applications_with_vitest]]
