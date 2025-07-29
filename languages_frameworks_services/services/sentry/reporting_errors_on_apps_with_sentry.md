# Reporting Production Errors with Sentry on Node Apps

Sentry is a powerful tool for monitoring and debugging production errors in real time. Here's how to set it up in your Node.js application.

---

## Step 1: Create a Project in Sentry

- Log in to [sentry.io](https://sentry.io)
- Navigate to the dashboard and click **"Create Project"**
- Choose your project type (e.g., Node.js)
- Select **"Alert me on every issue"**, mark all alert options, and provide a project name

---

## Step 2: Install Sentry Dependencies

Run the following command to add Sentry and tracing support:

`yarn add @sentry/node @sentry/tracing`

---

## Step 3: Configure Sentry in Your Application

Import and configure Sentry in your `app.ts` or main server file:

`import "reflect-metadata"`  
`import 'dotenv/config'`  
`import express, { json, NextFunction } from 'express'`  
`import * as Sentry from "@sentry/node"`  
`import * as Tracing from "@sentry/tracing"`  
`import 'express-async-errors'`  
`import swagger from 'swagger-ui-express'`  
`import { routes } from './routes'`  
`import rateLimiter from '@shared/infra/http/middlewares/rateLimiter'`  
`import cors from 'cors'`  
`import swaggerJSON from '../../../swagger.json'`  
`import createConnection from '../typeorm'`  
`import '@shared/container'`  
`import { AppError } from "@shared/errors/AppError"`  
`import upload from "@config/upload"`

`createConnection()`  
`const app = express()`  
`app.use(rateLimiter)`

`Sentry.init({`  
&nbsp;&nbsp;`dsn: process.env.SENTRY_DNS,`  
&nbsp;&nbsp;`integrations: [`  
&nbsp;&nbsp;&nbsp;&nbsp;`new Sentry.Integrations.Http({ tracing: true }),`  
&nbsp;&nbsp;&nbsp;&nbsp;`new Tracing.Integrations.Express({ app }),`  
&nbsp;&nbsp;`],`  
&nbsp;&nbsp;`tracesSampleRate: 1.0,`  
`})`

`app.use(Sentry.Handlers.requestHandler())`  
`app.use(Sentry.Handlers.tracingHandler())`  
`app.use(json())`  
`app.use('/api-docs', swagger.serve, swagger.setup(swaggerJSON))`  
`app.use('/avatar', express.static(\`\${upload.tmpFolder}/avatar\`))`  
`app.use(cors())`  
`app.use(routes)`  
`app.use(Sentry.Handlers.errorHandler())`

`app.use((err: Error, req: express.Request, res: express.Response, next: NextFunction) => {`  
&nbsp;&nbsp;`if (err instanceof AppError) {`  
&nbsp;&nbsp;&nbsp;&nbsp;`return res.status(err.statusCode).json({ message: err.message })`  
&nbsp;&nbsp;`}`  
&nbsp;&nbsp;`return res.status(500).json({ status: 500, message: \`Internal server error: \${err.message}\` })`  
`})`

`export { app }`

> ⚠️ Use the `dsn` inside `Sentry.init` as an environment variable.

---

## Step 4: Monitor Errors

Once everything is configured, all production errors should automatically appear on your Sentry dashboard.