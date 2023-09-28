Nestjs should be used when you need produtivity and you have not a system with a specific strucuture defined


1 - Install the nest cli running the command ```npm i -g @nestjs/cli``` and then run the command ```nest new your_project_name```to create a new nestjs project 

2 - After the project is created, you can exclude eslint files, readme and test files. In the package.json, you can remove the test scripts, all tests configurations and eslint, eslint plugins and tests, and tests plugins libraries.

3 - Run ```npm run start``` to check if your project can run correctly.


## Understanding the main NestJs files

### main.ts

Is the file responsible to configure the server and start the server.

### app.controller.ts

Is the file that contains a class that contains a set of application controllers. This file uses decorators like ```@Controller```, ```Get```, ```Post```, and so on.

### app.module.ts

Is the file that joins all application configurations like controllers and providers. Example:

```
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

