# USING JWT WITH FASTIFY

### 1. Install the JWT Library

Install the `@fastify/jwt` library to configure Fastify to use JWT:

`yarn add @fastify/jwt`

---

### 2. Add JWT_SECRET Environment Variable

Add a `JWT_SECRET` variable to your `.env` file for secure token handling:

`JWT_SECRET=your_jwt_secret`

---

### 3. Validate Environment Variables

In your environment variables validation file, add `JWT_SECRET` to the Zod schema for verification. Example:

```typescript
const envSchema = z.object({ NODE_ENV: z.enum(['dev', 'test', 'production']).default('dev'), JWT_SECRET: z.string(), PORT: z.coerce.number().default(3333) })
```

---

### 4. Register JWT in Fastify

In your `app.ts` file, import `fastifyJWT` and register it, passing your `JWT_SECRET` as the secret. Example:

```typescript
import fastifyJwt from '@fastify/jwt'
import fastify from 'fastify'
import { appRoutes } from '@/http/routes'
import { ZodError } from 'zod'
import { env } from '@/env'

export const app = fastify()

app.register(fastifyJwt, { secret: env.JWT_SECRET })
```
---

### 5. Create JWT Token in Authentication Controller

In your authentication controller file, get the token from the reply and return it as a response. Example:

```typescript
import { AppError } from '@/errors/AppError'
import { makeAuthenticateUserUseCase } from '@/factories/makeAuthenticateUserUseCase'
import { FastifyReply, FastifyRequest } from 'fastify'
import { z as zod } from 'zod'

const userRegistrationSchema = zod.object({ email: zod.string().email(), password: zod.string().min(6) })

export async function authenticateUserController(req: FastifyRequest, rep: FastifyReply) {
const { email, password } = userRegistrationSchema.parse(req.body)

try {
const authenticateUserUseCase = makeAuthenticateUserUseCase()
const user = await authenticateUserUseCase.execute({ email, password })

// CREATE JWT TOKEN BASED ON user.id
const token = await rep.jwtSign({}, { sign: { sub: user.id } })

// RETURN ENCODED TOKEN
return rep.status(200).send({ token })

} catch (error) {
if (error instanceof AppError) {
return rep.status(403).send({ message: error.message })
}
throw error
}
}
```

---

### 6. Extend the FastifyJWT Interface

Create a type declaration file to extend the `@fastify/jwt` interface to include the user information. Example:

```typescript
import '@fastify/jwt'

declare module '@fastify/jwt' {
export interface FastifyJWT {
user: {
sub: string
}
}
}
```

---

### 7. Recover JWT Token in Controller Routes

In each controller file where needed, recover the JWT token to access the user data. Example:

```typescript
import { FastifyRequest, FastifyReply } from 'fastify'

export async function profile(req: FastifyRequest, rep: FastifyReply) {
// RECOVER DATA PASSED TO JWT TOKEN
const user = await req.jwtVerify()

// RETURN DECODED TOKEN CONTAINING user.id
return rep.status(200).send({ userId: user.sub })
}
```
