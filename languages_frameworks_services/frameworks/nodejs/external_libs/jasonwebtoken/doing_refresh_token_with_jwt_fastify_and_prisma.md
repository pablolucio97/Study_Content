# DOING REFRESH TOKEN WITH JWT, FASTIFY, AND PRISMAORM

It is not secure to use a token with long validity (above 20 minutes). For this reason, to avoid forcing the user to log in again to generate a new token, the system generates a new token (refresh token) when the original token has expired.

The token ensures the application's security, while the refresh token is used only to generate a new token. When authenticating, both a token and a refresh token are generated. The token is used for the user to interact with the application, and the refresh token generates a new token when the original one expires. In the refresh token route, the user must pass the generated refresh token from the first authentication to get a new token with a new refresh token, allowing the process to repeat whenever the token expires.

### 1. Install Cookie Handling Library

Run the following command to handle cookies in Fastify:

`npx yarn add @fastify/cookie`

---

### 2. Configure the JWT and Cookie in `app.ts`

On the `app.ts` file, configure the token signing and the cookie handling. Example:

`app.register(fastifyJwt, {`
`secret: env.JWT_SECRET,`
`cookie: {`
`cookieName: 'refreshToken',`
`signed: false,`
`},`
`sign: {`
`expiresIn: '10m'`
`}`
`})`

`app.register(fastifyCookie)`

---

### 3. Add Refresh Token to the Authentication Controller

The controller should set the refresh token in a cookie, but not return it in the response. Example:

`const userRegistrationSchema = zod.object({`
`email: zod.string().email(),`
`password: zod.string().min(6),`
`})`

`export async function authenticateUserController(req: FastifyRequest, rep: FastifyReply) {`
`const { email, password } = userRegistrationSchema.parse(req.body)`
`try {`
`const authenticateUserUseCase = makeAuthenticateUserUseCase()`
`const user = await authenticateUserUseCase.execute({ email, password })`

`const token = await rep.jwtSign({}, { sign: { sub: user.id } })`

`const refreshToken = await rep.jwtSign({}, { sign: { sub: user.id, expiresIn: '7d' } })`

`return rep.setCookie('refreshToken', refreshToken, {`
`path: '/',`
`secure: true,`
`sameSite: true,`
`httpOnly: true`
`}).status(200).send({ token })`

`} catch (error) {`
`if (error instanceof AppError) {`
`return rep.status(403).send({ message: error.message })`
`}`
`throw error`
`}`
`}`

---

### 4. Create a Controller for Refreshing the Token

Create a controller and a route to refresh the token based on the existing cookie. Example:

`import { AppError } from '@/errors/AppError'`
`import { FastifyReply, FastifyRequest } from 'fastify'`

`export async function RefrehsTokenController(req: FastifyRequest, rep: FastifyReply) {`
`await req.jwtVerify({ onlyCookie: true })`

`try {`
`const token = await rep.jwtSign({}, { sign: { sub: req.user.sub } })`

`const refreshToken = await rep.jwtSign({}, { sign: { sub: req.user.sub, expiresIn: '7d' } })`

`return rep.setCookie('refreshToken', refreshToken, {`
`path: '/',`
`secure: true,`
`sameSite: true,`
`httpOnly: true`
`}).status(200).send({ token })`

`} catch (error) {`
`if (error instanceof AppError) {`
`return rep.status(403).send({ message: error.message })`
`}`
`throw error`
`}`
`}`

---

### 5. Register a New Route for the `RefrehsTokenController`

Example:

**routes/system.ts**

`import { FastifyInstance } from 'fastify'`
`import { RefrehsTokenController } from '../controllers/system/refreshToken'`

`export async function systemRoutes(app: FastifyInstance) {`
`app.patch('/system/refresh-token', RefrehsTokenController)`
`}`

**app.ts**

`app.register(systemRoutes)`

---

### 6. Test the `/system/refresh-token` Endpoint

Test the `/system/refresh-token` request without a body on Insomnia.
