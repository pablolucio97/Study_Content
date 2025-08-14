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

### Interceptors
Interceptors are classes that **intercept** incoming requests and outgoing responses, allowing you to:
- **Transform** the result returned by a route handler.
- **Bind extra logic** before/after method execution.
- **Log requests and responses**.
- **Handle response mapping** (e.g., wrapping data in a common structure).
- **Cache responses**.

They are similar to middleware but operate **closer to the route handler** and have access to both the request and the response.

**Example: Response Formatting Interceptor**

This interceptor wraps every response into a **default format** with the following structure:

```json
{****
  "RES": "<original data>",
  "STATUS": "<HTTP status code>",
  "SUCCESS": true // or false
}
```

1. Creating the interceptor
```typescript
import {
  Injectable,
  NestInterceptor,
  ExecutionContext,
  CallHandler,
} from '@nestjs/common';
import { Observable } from 'rxjs';
import { map, catchError } from 'rxjs/operators';

@Injectable()
export class ResponseFormatInterceptor implements NestInterceptor {
  intercept(context: ExecutionContext, next: CallHandler): Observable<any> {
    const ctx = context.switchToHttp();
    const response = ctx.getResponse();

    return next.handle().pipe(
      map((data) => ({
        RES: data,
        STATUS: response.statusCode,
        SUCCESS: true,
      })),
      catchError((err) => {
        throw {
          RES: err.response || err.message,
          STATUS: err.status || 500,
          SUCCESS: false,
        };
      }),
    );
  }
}
```

2. Applying the Interceptor Globally
```typescript
import { NestFactory } from '@nestjs/core';
import { AppModule } from './app.module';
import { ResponseFormatInterceptor } from './interceptors/response-format.interceptor';

async function bootstrap() {
  const app = await NestFactory.create(AppModule);
  app.useGlobalInterceptors(new ResponseFormatInterceptor());
  await app.listen(3000);
}
bootstrap();
```


## Most Used NestJS CLI Commands

NestJS provides a powerful CLI tool to **generate**, **run**, and **manage** your applications.  
Below are the most common commands you will use in day-to-day development.

---

### 1. `nest new <project-name>`
**Purpose:** Creates a new NestJS project with the default folder structure.

**Example:**
```bash
nest new my-app
```
- Prompts you to choose a package manager (`npm` or `yarn`).

---

### 2. `nest generate <schematic>` (alias: `nest g`)
**Purpose:** Generates files like modules, controllers, services, etc.

**Common usages:**
```bash
nest g module users          # Generates a new module
nest g controller users      # Generates a controller
nest g service users         # Generates a service
nest g class my-class        # Generates a plain class
```
- Schematics include: `module`, `controller`, `service`, `class`, `interface`, `enum`, `filter`, `pipe`, `guard`, `interceptor`.

---

### 3. `nest build`
**Purpose:** Compiles the TypeScript project into JavaScript inside the `dist` folder.

**Example:**
```bash
nest build
```

---

### 4. `nest start`
**Purpose:** Starts the NestJS application.

**Example:**
```bash
nest start           # Normal start
nest start --watch   # Watch mode (reload on changes)
nest start --debug   # Debug mode
```

---

### 5. `nest info`
**Purpose:** Displays information about the current environment and dependencies.

**Example:**
```bash
nest info
```

---

### 6. `nest add <library>`
**Purpose:** Installs and configures a NestJS-compatible library.

**Example:**
```bash
nest add @nestjs/swagger
```

---

### 7. `nest update`
**Purpose:** Updates NestJS dependencies to the latest versions.

**Example:**
```bash
nest update
```

## Best Practices and General Tips at working with NestJS projects

- Avoid circular dependencies. It is: avoid the A class depends on B and B class depend on A, to do that breaking logic into smaller, reusable modules.
- Keep modules small and focused. Each module should have a single responsibility.
- Group controllers, services, and related entities within the same module.
- Always use DTOs for every request payload and service expected data.
- Use the NestJS's cli commands to create your controllers, modules, and services files.
- Handle errors professionally on each controller using builtin `HttpException` according to the case.
- Use NestJS’s `Logger` service for structured logging.
- Log key events, warnings, and errors for easier debugging.
- Apply **Guards** for route protection.
- Use environment variables for sensitive data (e.g., database credentials, API keys).
- Use Interceptors for Cross-Cutting Concerns. Response formatting, logging execution time, and caching should be done in **Interceptors**, not in controllers.
- Keep Configurations Centralized. Store configuration values in a dedicated **ConfigModule** using `@nestjs/config`. Avoid hardcoding values.


