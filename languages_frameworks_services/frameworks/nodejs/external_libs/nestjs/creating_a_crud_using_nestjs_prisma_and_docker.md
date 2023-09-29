# Creating a CRUD using NestJS, Prisma, and Docker

## Initializing the project using NestJS 

1 -Run the command ```npm i -g  @nestjs/cli``` to install the NestJS cli and then run the command ```nest new your_project_name``` to initialize the project using NestJS. NestJS cli will guide you in the new project creation process.

2 - After the project is created, you can exclude eslint files, readme and test files. In the package.json, you can remove the test scripts, all tests configurations and eslint, eslint plugins and tests, and tests plugins libraries.

3 - Run ```npm run start``` to check if your project can run correctly.


## Configuring docker

1 - Start the docker software in your machine.

2 - Create a folder name data in your application root to allow to store and restore your application data if your  Docker container lost data for any reason. Put this data folder in your .gitignore file.

3 - Create a file named as docker-compose.yml configuring your docker file. In this file, declare your data folder to allow store and restore your application data too. Example:

```
version: '3.8'

services:
  postgres:
    container_name: nest-clean-pg
    image: postgres
    ports:
      - 5432:5432
    environment:
      POSTGRES_USER: postgres
      POSTGRES_PASSWORD: docker
      POSTGRES_DB: nest-clean
      PGDATA: /data/postgres
    volumes:
      - ./data/pg:/data/postgres
```

## Configuring Prisma

1 - Run npx ```npx yarn add prisma -D``` to have access to the prisma and its cli, and run ```npx yarn add @prisma/client``` to install the Prisma client in the application.

2 - Run the command ```npx yarn prisma init``` to initialize the Prisma in your project creating the Prisma folder and its .env file.

3 - Configure the application url inside your .env file based on your docker-compose-yml database connection settings.

4 - Configure your application models in your schema.prisma file, at finishing it, run ```npx yarn prisma migrate dev``` and give a name to your migration that will be generated.

5 - Create inside the src folder, a folder named "prisma" and inside it a file named prisma.service.ts 
exporting an injectable class extending PrismaClient. All methods inside this class will be available for your application controllers if this service is declared as a provider inside your providers array. Also include the  onModuleDestroy() and onModuleInit() decorators opening and closing the connection with Prisma. Example:

```typescript
import { Injectable, OnModuleDestroy, OnModuleInit } from '@nestjs/common';
import { PrismaClient } from '@prisma/client';

@Injectable()
export class PrismaService
  extends PrismaClient
  implements OnModuleInit, OnModuleDestroy
{
  constructor() {
    super({
      //generate query log when has an error or a warn
      log: ['error', 'warn'],
    });
  }
  //disconnect prisma client if some error occurs on the application
  onModuleDestroy() {
    return this.$disconnect();
  }
  //create the prisma connection every time application starts
  onModuleInit() {
    return this.$connect();
  }

  getUsers() {
    return;
  }
}

```

6 - Inside src folder, create a folder named "controllers" and create your controller. You controller file must declare the Controller, Body, HttpCode, the error (ConflictException in this case), and the method (Post in this case). Example:

```typescript
import {
  Body,
  ConflictException,
  Controller,
  HttpCode,
  Post,
} from '@nestjs/common';
import { PrismaService } from '../prisma/prisma-service';
import { hash } from 'bcryptjs';

@Controller('/accounts')
export class CreateAccountController {
  constructor(private prisma: PrismaService) {}

  @Post()
  @HttpCode(201)
  async handle(@Body() body: any) {
    const { name, email, password } = body;

    const userWithEmailAlreadyExists = await this.prisma.user.findUnique({
      where: {
        email,
      },
    });

    if (userWithEmailAlreadyExists) {
      throw new ConflictException('User already exists.');
    }

    const hashedPassword = await hash(password, 8);

    await this.prisma.user.create({
      data: {
        name,
        email,
        password: hashedPassword,
      },
    });
  }
}

```

7 - In your app.module.ts file, add the created PrismaService into your Nest Providers array to your provider/service be available to your entire application through controllers. Also add the controller created to turn it available for your application. Example:

```typescript
import { Module } from '@nestjs/common';
import { PrismaService } from './prisma/prisma-service';
import { CreateAccountController } from './controllers/create-account-controller';

@Module({
  controllers: [CreateAccountController],
  providers: [PrismaService],
})
export class AppModule {}


```
