# Handling Websockets with NestJS and React

1. Run `npm i @nestjs/websockets @nestjs/platform-socket.io` to install `@nestjs/websockets ` and `@nestjs/platform-socket.io` libraries to handle websockets.
2. Run the command `nest generate gateway your file`. Your gateway must contain a method to emit the messages, the message must contain a param for the event, and another for the message content. The message should be emitted from Socket's server instance if you are emitting the events from some route. Example:

```typescript
import {
  MessageBody,
  WebSocketGateway,
  WebSocketServer,
} from "@nestjs/websockets";

import { Server } from "socket.io";

type TWebSocketEvent = {
  event: string;
  message: string;
};

@WebSocketGateway({
  cors: {
    origin: "*",
  },
})
export class AuthControlGateway {
  @WebSocketServer()
  server: Server;
  handleEvent(
    eventName: string,
    @MessageBody() message: string
  ): TWebSocketEvent {
    this.server.emit(eventName, message);
    return {
      event: eventName,
      message,
    };
  }
}
```

3. Adds your gateway class to your module. Example:

```typescript
import { Module } from "@nestjs/common";
import { RoutesDriverService } from "prisma/routes/routes-driver/routes-driver.service";
import { MapsModule } from "src/maps/maps.module";
import { RoutesDriverGateway } from "./routes-driver/routes-driver.gateway";
import { RoutesController } from "./routes.controller";
import { RoutesService } from "./routes.service";

@Module({
  imports: [MapsModule],
  controllers: [RoutesController],
  providers: [RoutesService, RoutesDriverService, RoutesDriverGateway],
})
export class RoutesModule {}
```

4. Call the handleEvent gateway's method on your route. Example:

```typescript
import { IUnAuthenticateUserDTO } from "@/infra/dtos/UserDTO";
import { AuthControlGateway } from "@/infra/gateways/authcontrol.gateway";
import { UnAuthenticateUserUseCase } from "@/infra/useCases/users/unAuthenticateUserUseCase";
import {
  BadRequestException,
  Body,
  ConflictException,
  Controller,
  HttpCode,
  NotFoundException,
  Post,
} from "@nestjs/common";
import { z } from "zod";

const authenticateUserBodySchema = z.object({
  email: z.string().email(),
});

@Controller("/users/logout")
export class UnAuthenticateUserController {
  constructor(
    private unAuthenticateUserUseCase: UnAuthenticateUserUseCase,
    private authControlGateway: AuthControlGateway
  ) {}
  @Post()
  @HttpCode(200)
  async handle(@Body() body: IUnAuthenticateUserDTO) {
    const isBodyValidated = authenticateUserBodySchema.safeParse(body);

    if (!isBodyValidated.success) {
      throw new BadRequestException({
        message: "The body format is invalid. Check the fields below:",
        error: isBodyValidated.error.issues,
      });
    }

    try {
      const message = await this.unAuthenticateUserUseCase.execute(body);

      const { email } = body;

      this.authControlGateway.handleEvent(
        "user-disconnected",
        `email:${email}`
      );
      return message;
    } catch (error) {
      console.log("[INTERNAL ERROR]", error.message);

      if (error.status === 404) {
        throw new NotFoundException({
          message: "User not found",
          error: error.message,
        });
      }

      throw new ConflictException({
        message:
          "An error occurred. Check all request body fields for possible mismatching.",
        error: error.message,
      });
    }
  }
}
```

5. To test the socket, you can call your websocket request on Postman calling the endpoint `ws://localhost:your-port`. Be sure calling the same port as exposed by your application and be sure using the `Socket.IO` request type instead `WebSocket`.

6. On your client-application install the library socket.io-client running `npm install socket.io-client`.
7. Create a service to configure the socket connection. Example: `services/socket.ts`:

```typescript
import { io } from "socket.io-client";

const baseUrl = import.meta.env.VITE_API_BASEURL;

export const socket = io(baseUrl, {
  autoConnect: false,
});
```

8. Consume the socket in your application calling `socket.send` passing the channel and your message. Example:

```typescript
import { socket } from "@/services/socket";
import { useEffect } from "react";

useEffect(() => {
  if (socket.disconnected) {
    socket.connect();
  } else {
    socket.offAny();
  }
  //same event name triggered on back-end
  socket.on("user-disconnected", (val) => {
    if (val) {
      const userEmail = val.split(":")[1];
      if (userEmail === user.email) {
        showDisconnectedAlert();
      };
    }
  });
}, [showDisconnectedAlert, signOut, unAuthenicateUser, user.email]);
```

The first call for using websockets is done automatically by the websocket's gateway using HTTP protocol with a GET method including header with the value "Upgrade: websocket".
