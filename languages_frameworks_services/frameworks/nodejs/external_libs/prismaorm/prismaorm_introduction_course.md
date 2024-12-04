# PRISMA ORM COURSE

## Introduction

Prisma is an ORM that translates our objects into data inside the databases. It includes several products:

- **Prisma Client**: Provides a model (acts like our table) and allows us to run all kinds of queries to interact with our data.
- **Prisma Studio**: An IDE that allows viewing our databases.
- **Prisma Migrate**: Converts our Model to a SQL table with all conventions informed, such as PrimaryKey and isUnique.
- **Prisma Data Platform**: A platform that allows using Prisma in the web browser, providing a boilerplate and easy configuration.

---

## PrismaORM capabilities

Prisma offers a comprehensive set of features that cater to various needs for database management in modern applications. Below are some of the main functionalities along with short examples using TypeScript.

## 1. Raw SQL Queries
Execute raw SQL queries directly through Prisma for complex queries that aren't directly supported by Prisma's query builder.

`const result = await prisma.$queryRaw\`SELECT * FROM users WHERE id = ${userId}\`;`

## 2. Pagination
Implement pagination to manage large datasets effectively by fetching data in segments.

`const users = await prisma.user.findMany({ skip: 10, take: 5 });`

## 3. CRUD Operations
Perform Create, Read, Update, and Delete operations using straightforward methods.

- **Create**
  `const newUser = await prisma.user.create({ data: { name: 'Alice', email: 'alice@example.com' } });`

- **Read**
  `const user = await prisma.user.findUnique({ where: { id: 1 } });`

- **Update**
  `const updateUser = await prisma.user.update({ where: { id: 1 }, data: { email: 'newalice@example.com' } });`

- **Delete**
  `const deleteUser = await prisma.user.delete({ where: { id: 1 } });`

## 4. Filtering, Sorting, and Selecting
Apply filters, sort results, and select specific fields from your data.

`const youngUsers = await prisma.user.findMany({ where: { age: { lt: 30 } }, orderBy: { age: 'asc' }, select: { name: true, age: true } });`

## 5. Relations
Manage relational data such as fetching related records or updating relational data.

`const userWithPosts = await prisma.user.findUnique({ where: { id: 1 }, include: { posts: true } });`

## 6. Transactions
Group multiple writes into a single transaction to ensure atomic operations.

`const [user, post] = await prisma.$transaction([ prisma.user.create({ data: { name: 'Bob', email: 'bob@example.com' } }), prisma.post.create({ data: { title: 'Hello World', content: 'This is a new post', authorId: 1 } }) ]);`

## 7. Aggregations
Perform aggregation operations like count, sum, avg, min, and max.

`const totalUsers = await prisma.user.count();`  
`const avgAge = await prisma.user.aggregate({ _avg: { age: true } });`

## 8. Middleware
Use middleware to execute custom logic before or after a query operation.

`prisma.$use(async (params, next) => { const before = Date.now(); const result = await next(params); const after = Date.now(); console.log(\`Query ${params.model}.${params.action} took ${after - before}ms\`); return result; });`

This guide provides a detailed look at how to utilize Prisma's capabilities to enhance your database management tasks.

---

## Using Prisma ORM on a New Project

### Step 1: Initialize the Project

`yarn init -y`  
`yarn add prisma ts-node-dev typescript @prisma/client`

### Step 2: Initialize TypeScript

`tsx --init`

Add the following configurations to `tsconfig.json`:

`{`  
`"compilerOptions": {`  
`"sourceMap": true,`  
`"outDir": "dist",`  
`"strict": true,`  
`"lib": ["es6", "dom"],`  
`"esModuleInterop": true`  
`}`  
`}`

### Step 3: Initialize Prisma

`yarn prisma init`

This creates a `Prisma` folder with `schema.prisma` and a `.env` file containing your Prisma database URL.

### Step 4: Configure the Database URL

Update the `DATABASE_URL` in the `.env` file:

`DATABASE_URL="postgresql://admin:admin@localhost:5432/igniteprisma-psd?schema=public"`

### Step 5: Run a PostgreSQL Docker Container

`docker run --name prisma_course_db -e POSTGRES_USER=admin -e POSTGRES_PASSWORD=admin -e POSTGRES_DB=prisma -p 5432:5432 -d postgres`

### Step 6: Define the Schema Model

Update `schema.prisma`:

`generator client {`  
`provider = "prisma-client-js"`  
`}`

`datasource db {`  
`provider = "postgresql",`  
`url      = env("DATABASE_URL")`  
`}`

`model Courses{`  
`id            String      @id @default(uuid()),`  
`name          String      @unique,`  
`description   String      @unique,`  
`duration      Int,`  
`created_at    DateTime    @default(now()),`  
`@@map("courses")`  
`}`

### Step 7: Generate and Migrate

`yarn prisma generate`  
`yarn prisma migrate dev`  

### Step 8: Start Prisma Studio

`yarn prisma studio`

### Step 9: Add More Tables

To add more tables, update `schema.prisma`:

`model Modules {`  
`id          String @id @default(uuid()),`  
`name        String @unique,`  
`description String @unique,`  
`created_at DateTime @default(now()),`  
`@@map("modules")`  
`}`

---

## Performing Transactions

Transactions are useful to ensure that two or more database operations are either executed successfully or rolled back together. A Prisma transaction can be **sequential** (locks the database while the operations within the transaction are running) or **interactive** (does not lock the database).

### Example: Interactive Transaction

In the example below, an interactive transaction performs user and post insertion into the database. If something goes wrong (e.g., trying to create a new post with a `user.id` that doesn't exist), the transaction will perform a rollback.

```typescript
import { prisma } from '../../../../database/prisma'  
import { CreateUserDTO, CreatePostDTO } from '../../../../dtos/userDto'  
import { AppError } from '../../../../errors/AppError'

export class CreatePostWithUserUseCase {  
async execute(userData: CreateUserDTO, postData: CreatePostDTO) {  

const { name, email } = userData  
const { title, content } = postData  
let createdUser;  
let createdPost;

await prisma.$transaction(async (tx) => {  
createdUser = await tx.users.create({  
data:{  
name,  
email  
}  
})

createdPost = await tx.posts.create({  
data:{  
title,  
content,  
id_user: createdUser.id  
}  
})  
})

return createdPost  

}  
}
```

### Query Example with Transaction

The following query returns all posts that match the provided filter along with a count of all posts:

```typescript
const [posts, totalPosts] = await prisma.$transaction([  
prisma.post.findMany({ where: { title: { contains: 'prisma' } } }),  
prisma.post.count(),  
])
```

---

## IMPORTING AN ALREADY EXISTENT DATABASE


### Step 1: Update the Database URL

In your `prisma.schema` file, modify the `DATABASE_URL` variable by passing the name of the existing database along with the correct connection credentials.

### Step 2: Synchronize with the Existing Database

Run the following command to let Prisma synchronize with the existing database and automatically create the models along with their correct relationships (if any) in the `prisma.schemas` file:

`yarn prisma db pull`

---

## General Tips

- Avoid using 'admin' as username or password for deployment.
- Do not use Prisma Studio before the database is created.
- After any modification on a model, run `yarn prisma generate` and `yarn prisma migrate dev`.
- If your new table does not appear in the Prisma Client, reload your IDE or run `yarn prisma generate`.
- Use transactions to ensure that operations are either fully completed or undone.
- Be quick when using interactive transactions to avoid long open transactions.
- Prisma does not create relationship columns in its database tables; these columns appear in a different color in the `Prisma.schema` file when using the Prisma extension on VSCode.
