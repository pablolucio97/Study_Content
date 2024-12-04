# Creating a CRUD with NestJS, GraphQL, Docker Compose and PrismaORM

1. Install the dependencies running ` npm i @nestjs/graphql @nestjs/apollo @apollo/server graphql`
2. Install the PrismaORM and genera the Prisma Client, running `npm install prisma @prisma/client` and `npx prisma init` to initialize Prisma schema and.
3. Define your first model on schema.prisma file, after that run  `npx prisma migrate dev --name init` to create the initial migration and make the database usable.
4. Setup the Prisma database, e.g: `DATABASE_URL="postgresql://<username>:<password>@localhost:5432/<database_name>?schema=public"
`
5. Create and configures your docker-compose.yml file in your application root directory. Have a container for the database, and another one for the application. Use health check for the application service starts only when the database service is ready to accept connections. E.g:
```yml
version: '3.8'

services:
  postgres:
    container_name: graphql-crud-db
    image: postgres
    ports:
      - 5432:5432
    environment:
      POSTGRES_USER: admin
      POSTGRES_PASSWORD: admin
      POSTGRES_DB: graphql-crud-db
      PGDATA: /data/postgres
    volumes:
      - ./data/pg:/data/postgres
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U admin -d graphql-crud-db"]
      interval: 10s
      timeout: 5s
      retries: 5

  graphql-crud-app:
    container_name: graphql-crud-app
    image: node:20-alpine
    working_dir: /usr/src/app
    volumes:
      - /Users/pablosilva/Desktop/coding/studies/graphql-prisma-nest-crud:/usr/src/app
    ports:
      - 3333:3333
    command: /bin/sh -c "npx prisma generate && npm run start:dev"
    depends_on:
      postgres:
        condition: service_healthy
    environment:
      DATABASE_URL: postgresql://admin:admin@graphql-crud-db:5432/graphql-crud-db?schema=public
```
6. Configures the GraphQL module. Eg:
```typescript
import { ApolloDriver, ApolloDriverConfig } from '@nestjs/apollo';
import { Module } from '@nestjs/common';
import { GraphQLModule } from '@nestjs/graphql';

@Module({
  imports: [
    GraphQLModule.forRoot<ApolloDriverConfig>({
      driver: ApolloDriver,
      autoSchemaFile: 'schema.gql',
      sortSchema: true,
    }),
  ],
})
export class AppModule {}
```
7. Run the commands `nest generate module users`, `nest generate resolver users`, `nest generate service users` to nest generates the files for starting creating a module, a resolver, and a service.
8. Configures your model, example:
```typescript
import { ObjectType, Field, ID } from '@nestjs/graphql';

@ObjectType()
export class User {
  @Field(() => ID)
  id: string;

  @Field()
  name: string;

  @Field()
  email: string;
}
```
9. Create a folder named graphql-inputs, and inside it create a typing for your queries and mutations. Example:
```typescript
import { Field, InputType } from '@nestjs/graphql';
/**
 * InputType representing the data required to create a new User.
 */
@InputType()
export class CreateUserInput {
  @Field(() => String)
  name: string;

  @Field(() => String)
  email: string;
}
```
9. Implement the entity's resolver queries and mutations operations for your user model. Example:
```typescript
import { Args, Mutation, Query, Resolver } from '@nestjs/graphql';
import { CreateUserInput } from '../GraphqQLInputs/userInput';
import { User, User as UserModel } from '../models/user.model';
import { UsersService } from '../services/user.service';

@Resolver((of: unknown) => UserModel)
export class UserResolver {
  constructor(private usersService: UsersService) {}

  @Query((returns) => [UserModel], { name: 'getUsers' })
  async listUsers(): Promise<User[]> {
    const users = await this.usersService.listUsers();
    return users;
  }

  @Mutation((returns) => UserModel)
  async createUser(@Args('data') data: CreateUserInput): Promise<User> {
    const user = await this.usersService.create(data);
    return user;
  }
}
```
11. Configure the Prisma Service. Example:
```typescript
import { Injectable, OnModuleInit, OnModuleDestroy } from '@nestjs/common';
import { PrismaClient } from '@prisma/client';

@Injectable()
export class PrismaService
  extends PrismaClient
  implements OnModuleInit, OnModuleDestroy
{
  async onModuleInit() {
    await this.$connect();
  }

  async onModuleDestroy() {
    await this.$disconnect();
  }
}
```
12.  Implement your entity's service injecting the Prisma Service dependency. E.g:
```typescript
import { Injectable } from '@nestjs/common';
import { PrismaService } from '../../../services/prisma';
import { CreateUserInput } from '../GraphqQLInputs/userInput';
import { User } from '../models/user.model';

@Injectable()
export class UsersService {
  constructor(private PrismaService: PrismaService) {}
  async create(data: CreateUserInput): Promise<User> {
    const newUser = await this.PrismaService.user.create({ data });
    return newUser;
  }

  async listUsers(): Promise<User[]> {
    const users = await this.PrismaService.user.findMany();
    return users;
  }
}
```
13. Creates your entity's module file injecting the PrismaService and your entity service dependencies. Example:
```typescript
import { Module } from '@nestjs/common';
import { PrismaService } from 'src/services/prisma';
import { UsersService } from './user/services/user.service';
import { UserResolver } from './user/resolvers/user.resolver';

@Module({
  providers: [PrismaService, UsersService, UserResolver],
})
export class UsersModule {}
```
14. Include the entity module into your app.module.file's imports. Example:
```typescript
import { ApolloDriver, ApolloDriverConfig } from '@nestjs/apollo';
import { Module } from '@nestjs/common';
import { GraphQLModule } from '@nestjs/graphql';
import { UsersModule } from './modules/user.module';

@Module({
  imports: [
    UsersModule,
    GraphQLModule.forRoot<ApolloDriverConfig>({
      driver: ApolloDriver,
      autoSchemaFile: 'schema.gql',
      sortSchema: true,
    }),
  ],
})
export class AppModule {}

``` 

15. Run `docker-compose up` to up the database and application.
    
16. Perform queries and mutations operations on a REST client or at Apollo Server web application, both available at http://localhost:your-port/graphql.

## General tips

- GraphQL needs at least a resolver correctly configured before to generate the schema.gql file to allow interacting with graphql on clients and Apollo Server.
- Generate a initial migration to turn your database usable.
  
- NestJS GraphQl integration has two kind of methodologies to code, use "**Code First**" 
 approach using decorators and TypeScript classes to generate the corresponding GraphQL schema.

- GraphQL uses its own typing system for typing queries and mutations, do not use plain TypeScript interfaces.
  
- The own model file works as it typings, no TypeScript interface is required.
  
- At working with GraphQL and Prisma, you need to declare manually at least one model and  generate a migrate for it. Repeat the process for new model.
  
-  If you're using NestJS/Graphql First Code Approach, you need to handle Prisma Schema manually and it will be reflected on GraphQL schema after the respective module resolver file changes. 

- Always pass a name for queries and mutations on each resolver to help to identify your queries and mutations. 



References:

- [NestJS GraphQL docs](https://docs.nestjs.com/graphql/quick-start)
- [Pablo Lucio's repository reference](https://github.com/pablolucio97/nestjs-graphql-prisma-crud)
