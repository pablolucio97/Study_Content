# Generating not trusted HTTPS certificates for tests on development 
1. Check if you have openssl installed on your machine running `openssl -v`, if not, install it using home brew.
2.  Run the command `openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout mykey.key -out mycert.crt -subj "/C=US/ST=YourState/L=YourCity/O=YourOrganization/CN=your_ip"
`
3. On your server, refactor your application to read the certificate key and certificate files path to be used as options for https. NestJS Example:

```typescript
import { ConfigService } from "@nestjs/config";
import { NestFactory } from "@nestjs/core";
import * as fs from "fs";
import * as path from "path";
import { AppModule } from "./app.module";
import { TEnvSchema } from "./env";
import { ResponseErrorInterceptor } from "./infra/interceptors/responseError.interceptor";
import { ResponseSuccessInterceptor } from "./infra/interceptors/responseSuccess.interceptor";

async function bootstrap() {
  const configService = new ConfigService<TEnvSchema, true>();

  const certificateKeyPath = configService.get("CERTIFICATE_KEY_PATH");
  const certificatePath = configService.get("CERTIFICATE_PATH");

  const httpsOptions = {
    key: fs.readFileSync(path.resolve(certificateKeyPath)),
    cert: fs.readFileSync(path.resolve(certificatePath)),
  };
  const app = await NestFactory.create(AppModule, {
    httpsOptions,
  });
  const port = configService.get("PORT", { infer: true });
  app.useGlobalInterceptors(new ResponseSuccessInterceptor());
  app.useGlobalFilters(new ResponseErrorInterceptor());
  app.enableCors({
    origin: "*",
    methods: "*",
  });
  await app.listen(port);
}
bootstrap();
```

Observations:

- The SSL certificate not be trust for the most browsers and it will stop you performing requests. Not trusted HTTPS certificates can be used only for testing.
- Use certbot to generate trusted certificates based on your domain.
