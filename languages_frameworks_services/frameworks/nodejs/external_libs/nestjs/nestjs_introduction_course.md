# NestJS Introduction Course

##  What is NestJS?
NestJS is a progressive Node.js framework for building efficient, scalable server-side applications. It uses TypeScript by default and is heavily inspired by Angular's architecture.

## Creating a new NestJS project

1. Install the nest cli running the command ```npm i -g @nestjs/cli``` and then run the command ```nest new your_project_name```to create a new nestjs project 

2. After the project is created, you can exclude eslint files, readme and test files. In the package.json, you can remove the test scripts, all tests configurations and eslint, eslint plugins and tests, and tests plugins libraries.

3. Run ```npm run start``` to check if your project can run correctly.


## Understanding the main NestJs files

### main.ts

Is the file responsible to configure the server and start the server.

### app.controller.ts

Is the file that contains a class that contains a set of application controllers. This file uses decorators like ```@Controller```, ```Get```, ```Post```, and so on.

### app.module.ts

Is the file that joins all application configurations like controllers and providers. Example:

```typescript
import { Module } from '@nestjs/common';
import { AppController } from './app.controller';
import { AppService } from './app.service';

@Module({
  //All application controllers
  controllers: [AppController],
  //All application providers that can be injected in a controller. The providers need be is under the @Injectable decorator. An useCase or anything else doesn't deal http, can be considered a provider.
  providers: [AppService],
})
export class AppModule {}

```

## Core concepts

### **Modules**
- The basic building blocks of a NestJS application.
- Encapsulate providers, controllers, and imports.
- Every NestJS app has at least one root module (`AppModule`).

```typescript
import { Module } from '@nestjs/common';
import { AppController } from './app.controller';
import { AppService } from './app.service';

@Module({
  imports: [],
  controllers: [AppController],
  providers: [AppService],
})
export class AppModule {}
```

### **Controllers**
- Handle incoming HTTP requests and return responses.
- Defined using the `@Controller()` decorator.
- Endpoints are methods decorated with route decorators like `@Get()`, `@Post()`, etc.

```typescript
import { Controller, Get } from '@nestjs/common';

@Controller('users')
export class UsersController {
  @Get()
  findAll() {
    return 'This action returns all users';
  }
}
```

### **Providers & Services**
- Services contain business logic and are injected into controllers or other services.
- Use `@Injectable()` decorator.

```typescript
import { Injectable } from '@nestjs/common';

@Injectable()
export class UsersService {
  findAll() {
    return ['User1', 'User2'];
  }
}
```

### **Dependency Injection**
- Core feature of NestJS.
- Services can be injected into controllers via the constructor.

```typescript
@Controller('users')
export class UsersController {
  constructor(private readonly usersService: UsersService) {}

  @Get()
  findAll() {
    return this.usersService.findAll();
  }
}
```

### **Decorators**
- Special functions that add metadata to classes, methods, or parameters.
- Common examples:
  - `@Controller()`
  - `@Get()`, `@Post()`
  - `@Injectable()`
  - `@Module()`


### **Middleware**
- Functions executed before request reaches a controller.
- Useful for logging, authentication, etc.

```typescript
import { Injectable, NestMiddleware } from '@nestjs/common';
import { Request, Response, NextFunction } from 'express';

@Injectable()
export class LoggerMiddleware implements NestMiddleware {
  use(req: Request, res: Response, next: NextFunction) {
    console.log(`Request...`);
    next();
  }
}
```

### **Pipes**

Pipes on NestJS  can be used to validate a received data in a request or transform this data (example: convert a string to integer). You should use pipes when:

- You want to **validate** incoming data (e.g., checking if an email is valid).
- You need to **transform** data (e.g., converting a string to a number).

```typescript
import { Controller, Get, Param, ParseIntPipe } from '@nestjs/common';

@Controller('users')
export class UsersController {
  @Get(':id')
  getUser(@Param('id', ParseIntPipe) id: number) {
    // id is guaranteed to be a number here
    return { message: `User ID is ${id}` };
  }
}
```
**Most used pipes**

- **ValidationPipe**	Validates DTOs using class-validator.
- **ParseIntPipe**	Converts strings to numbers.
- **ParseBoolPipe**	Converts strings to booleans.
- **ParseUUIDPipe**	Validates UUID format (v1, v4, etc.).
- **DefaultValuePipe**	Provides fallback value if param is missing.
- **ParseArrayPipe**	Parses and validates arrays from strings.
- **ParseEnumPipe**	Validates that a value matches an enum value.

### Guards
In NestJS, **guards** are classes that determine whether a request should be processed by the route handler.  
They are mainly used for **authorization** and **access control** but can also be used for any custom logic to allow or block a request.

You should use guards when:
- You need to **restrict access** to routes based on user roles or permissions.
- You want to check **authentication status**.
- You want to implement **custom authorization logic**.
- 
**Creating and using a simple guard. Role-Based Guard**

1. Creating the guard.

```typescript
import { Injectable, CanActivate, ExecutionContext, ForbiddenException } from '@nestjs/common';

@Injectable()
export class RolesGuard implements CanActivate {
  canActivate(context: ExecutionContext): boolean {
    const request = context.switchToHttp().getRequest();
    const user = request.user;

    if (user?.role !== 'admin') {
      throw new ForbiddenException('Only admins can access this route');
    }

    return true;
  }
}
```
2. Using the guard

```typescript
import { Controller, Get, UseGuards } from '@nestjs/common';
import { RolesGuard } from './roles.guard';

@Controller('admin')
export class AdminController {
  @Get()
  @UseGuards(RolesGuard)
  getAdminData() {
    return { message: 'Welcome Admin!' };
  }
}
```
