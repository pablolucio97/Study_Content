# Handling Websockets with NestJS and React

1. Run `npm i @nestjs/websockets @nestjs/platform-socket.io` to install `@nestjs/websockets ` and `@nestjs/platform-socket.io` libraries to handle websockets.
2. Run the command `nest generate gateway yourfile`. Nest will generate a file that should look like this:

```typescript
import { SubscribeMessage, WebSocketGateway } from "@nestjs/websockets";

@WebSocketGateway({
  cors: {
    origin: "*",
  },
})
export class RoutesDriverGateway {
  @SubscribeMessage("message")
  handleMessage(client: any, payload: any): string {
    client.broadcast.emit("message", payload);
    console.log(payload);
    return "Hello world!";
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

4. Call your websocket request on Postman calling the endpoint `ws://localhost:your-port`. Be sure calling the same port as exposed by your application and be sure using the `Socket.IO` request type instead `WebSocket`.

5. On your client-application install the library socket.io-client running `npm install socket.io-client`.
6. Consume the socket in your application calling `socket.send` passing the channel and your message. Example:

```typescript

import {io} from 'socket.io-client'

const socket = io('http://localhost:3000', {
    autoConnect: false
})

import { useMap } from "@/hooks/useMap";
import { socket } from "@/utils/socket-io";
import { useEffect, useRef } from "react";

export function MapDriver() {
  useEffect(() => {
    if (socket.disconnected) {
      socket.connect();
    } else {
      socket.offAny();
    }
    socket.connect();
    socket.on("message", (val) => {
      console.log(val);
    });
  }, []);

  const dispatchEvent = () => {
    socket.send("message", "message sent");
  };

  return (
   <div>
    <Button title='Send message' onClick={dispatchEvent}>
   </div>

  );
}

```

The first call for using websockets is done automatically by the websocket's gateway using HTTP protocol with a GET method including header with the value "Upgrade: websocket".
