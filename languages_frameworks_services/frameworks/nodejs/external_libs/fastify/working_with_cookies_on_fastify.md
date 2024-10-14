# WORKING WITH COOKIES ON FASTIFY

Cookies are pieces of information that can be read in the response of a request. They are useful for identifying who is sending a request, even if the user is not authenticated, and for sharing context between applications using the user’s browser or client.

### 1. Install Fastify Cookie Plugin

Run the following command to install the Fastify cookie plugin:

`yarn add @fastify/cookie`

---

### 2. Import and Use Cookie in `server.ts`

Import and use the cookie plugin from `@fastify/cookie` in your `server.ts` file. Ensure this is done before your routes are registered.
```typescript
import cookie from '@fastify/cookie'

import fastify from 'fastify'

const app = fastify()

app.register(cookie)

app.register(transactionsRoutes, { prefix: 'transactions' })
```
---

### 3. Check and Create Cookies in Routes

In your route, check if the cookie exists. If not, create it using `rep.cookie`, passing a name, the value, and a configuration object (including `path` and `maxAge`).
```typescript
export async function transactionsRoutes(app: FastifyInstance) {

app.post('/', async (req, rep) => {

const createTransactionBodySchema = Zod.object({

title: Zod.string(),

amount: Zod.number(),

type: Zod.enum(['credit', 'debit'])

})

const { title, amount, type } = createTransactionBodySchema.parse(req.body)

let sessionId = req.cookies.sessionId

if (!sessionId) {

sessionId = randomUUID()

rep.cookie('sessionId', sessionId, { path: '/', maxAge: 1000 * 60 * 60 * 24 * 7 // 7 DAYS })

}

await knex('transactions').insert({ id: randomUUID(), title, amount: type === 'credit' ? amount : amount * -1, session_id: sessionId })

return rep.status(201).send()

})

}
```
---

### 4. Create Middleware to Check `sessionId`

Create a middleware to check if the `sessionId` exists in `req.cookies`. If it does not exist, return an error. Otherwise, the application flow continues.
```typescript
import { FastifyRequest, FastifyReply } from 'fastify'

export async function checkSessionIdExists(req: FastifyRequest, rep: FastifyReply) {

const sessionId = req.cookies.sessionId

if (!sessionId) {

return rep.status(401).send({ error: 'Unauthorized' })

}

}
```
---

### 5. Use Middleware in Routes with `preHandler`

In your route, pass an object as the second parameter and include a `preHandler` property. This will ensure the middleware runs before the route handler. Use this to filter operations by `sessionId`.
```typescript
import { checkSessionIdExists } from "middlewares/checkSessionIdExists"

app.get('/total', { preHandler: [checkSessionIdExists] }, async (req) => {

const { sessionId } = req.cookies

const totalTransactions = await knex('transactions').where('session_id', sessionId).sum('amount', { as: 'amount' }).first()

return { totalTransactions }

})```
