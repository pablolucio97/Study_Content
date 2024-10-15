# CREATING ROLE VERIFICATION MIDDLEWARE USING FASTIFY AND PRISMA

### 1. Alter or Add Role Property in Prisma Schema

In your Prisma schema file, add or modify the `role` property to define user roles such as `ADMIN` or `MEMBER`. Example:

```
enum Role { ADMIN MEMBER }

model User {
id            String   @id @default(uuid())
name          String
email         String   @unique
password_hash String
role          Role @default(MEMBER)
created_at    DateTime @default(now())
checkins      Checkin[]
checkin_id    String?
@@map("users")
}

```

---

### 2. Apply Prisma Migration

Run the following command to apply your schema changes:

`npx prisma migrate dev`

---

### 3. Add Role to JWT Payload

In your `fastify-jwt.d.ts` file, extend the `FastifyJWT` interface to include the `role` property:

```typescript
import '@fastify/jwt'

declare module '@fastify/jwt' {
export interface FastifyJWT {
user: {
sub: string,
role: 'ADMIN' | 'MEMBER'
}
}
}
```

---

### 4. Add Role in JWT Token and Refresh Token

In the authentication controller, add the `role` property to the JWT and refresh token payloads. Example:


```typescript
import { AppError } from '@/errors/AppError'

import { makeAuthenticateUserUseCase } from '@/factories/makeAuthenticateUserUseCase'

import { FastifyReply, FastifyRequest } from 'fastify'

import { z as zod } from 'zod'

const userRegistrationSchema = zod.object({

email: zod.string().email(),

password: zod.string().min(6),

})

export async function authenticateUserController(req: FastifyRequest, rep: FastifyReply) {

const { email, password } = userRegistrationSchema.parse(req.body)

try {

const authenticateUserUseCase = makeAuthenticateUserUseCase()

const user = await authenticateUserUseCase.execute({ email, password })

const token = await rep.jwtSign({ role: user.role }, { sign: { sub: user.id } })

const refreshToken = await rep.jwtSign({ role: user.role }, { sign: { sub: user.id, expiresIn: '7d' } })

return rep.setCookie('refreshToken', refreshToken, { path: '/', secure: true, sameSite: true, httpOnly: true })

.status(200).send({ token })

} catch (error) {

if (error instanceof AppError) {

return rep.status(403).send({ message: error.message })

}

throw error

}

}

```
---

### 5. Authenticate and Verify JWT

Authenticate with both `MEMBER` and `ADMIN` users, and compare the payload using [JWT.io](https://jwt.io).

---

### 6. Create `verifyUserRole` Middleware

Create middleware to check the user's role and allow access only for `ADMIN` users. Example:

```typescript
import { FastifyRequest, FastifyReply } from 'fastify'

export function verifyUserRole(roleToVerify: 'ADMIN' | 'USER') {

return async (req: FastifyRequest, rep: FastifyReply) => {

const { role } = req.user

if (role !== roleToVerify) {

return rep.status(401).send({ message: 'You have no permission to access this resource.' })

}

}

}

```

---

### 7. Add Middleware to Routes

Add the `verifyUserRole` middleware to routes where you want to restrict access to `ADMIN` users. Example:

```typescript
import { FastifyInstance } from 'fastify'

import { createGymController } from '../controllers/gyms/createGym'

import { verifyJwt } from '@/http/middlewares/verify-jwt'

import { verifyUserRole } from '@/http/middlewares/verify-user-role'

export async function gymsRoutes(app: FastifyInstance) {

app.addHook('onRequest', verifyJwt)

app.post('/gyms/create', { onRequest: [verifyUserRole('ADMIN')] }, createGymController)

}

```
