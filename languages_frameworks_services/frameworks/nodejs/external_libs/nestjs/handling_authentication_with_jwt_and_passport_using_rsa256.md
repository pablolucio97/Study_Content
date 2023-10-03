# Handling authentication with Jwt and Passport using RSA256 algorithm


## Generating the private and public keys

1 - Run the commands ```openssl genpkey -algorithm RSA -out private_key.pem  ``` and ```openssl rsa -pubout -in private_key.pem -out public_key.pem```  to generate the private and public keys that will generate in your project root folder.

2 - Now run the commands ```base64 -i private_key.pem -o private_key-base64.txt```  and ```base64 -i public_key.pem -o public_key-base64.txt``` to convert these keys into base64 encoded (legible strings).
## Generating the token

1 - Insde the "src" folder, create a new folder named "auth" and a new file named "auth.module.ts".

2 - Run ```npx yarn add @nestjs/passport @nestjs/jwt passport passport-jwt``` to install passport and jwt to deal with authentication in the application. Run ```@types/passport-jwt```to install the passport types too.

3 Add yours generated private and public keys in your environment variables that will be used for generating the token using the RSA256 algorithm (that will contain a private key used only for generate tokens, and a public key that can be read for another application if necessary to validate if a token is valid), and add the validation for these keys on your zod envSchema. Ex:

```typescript
import { z } from 'zod';

export const envSchema = z.object({
  DATABASE_URL: z.string().url(),
  JWT_PRIVATE_KEY: z.string(),
  JWT_PUBLIC_KEY: z.string(),
  PORT: z.coerce.number().optional().default(3333)
});

export type Env = z.infer<typeof envSchema>

```

4 - In the "auth.ts" file, create a new file named jwt-strategy.ts to handle the Passport to use jwt strategy. In this file we need to export an injectable class to access the PassportStrategy constructor thought the super method  passing the strategy object config, and a call a function to validate the token based on the tokenSchema. Example:

```typescript
import { Injectable } from '@nestjs/common';
import { ConfigService } from '@nestjs/config';
import { PassportStrategy } from '@nestjs/passport';
import { ExtractJwt, Strategy } from 'passport-jwt';
import { Env } from 'src/env';
import { z } from 'zod';

const tokenSchema = z.object({
  sub: z.string().uuid(),
});

export type UserPayloadSchema = z.infer<typeof tokenSchema>;

@Injectable()
export class JwtStrategy extends PassportStrategy(Strategy) {
  constructor(config: ConfigService<Env, true>) {
    const publicKey = config.get('JWT_PUBLIC_KEY', { infer: true });
    super({
      jwtFromRequest: ExtractJwt.fromAuthHeaderAsBearerToken(),
      secretOrKey: Buffer.from(publicKey, 'base64'),
      algorithms: ['RS256'],
    });
  }

  async validate(payload: UserPayloadSchema) {
    return tokenSchema.parse(payload);
  }
}
```

5 - Create and export the AuthModule class importing the Module from '@nestjs/config' to configure new module, the ConfigService from '@nestjs/config' to validate the ConfigService, the PassportModule from '@nestjs/passport' to register a new injection passing your ConfigService, and the Env from 'src/env' to server as environment typing. This authentication will use RSA256 algorithm based on private and public keys. Add the JwtStrategy as your provider too. Example:

```typescript
import { Module } from '@nestjs/common';
import { ConfigService } from '@nestjs/config';
import { JwtModule } from '@nestjs/jwt';
import { PassportModule } from '@nestjs/passport';
import { Env } from 'src/env';
import { JwtStrategy } from './jwt-strategy';

@Module({
  imports: [
    PassportModule,
    JwtModule.registerAsync({
      inject: [ConfigService],
      global: true,
      useFactory(config: ConfigService<Env, true>) {
        const privateKey = config.get('JWT_PRIVATE_KEY', { infer: true });
        const publicKey = config.get('JWT_PUBLIC_KEY', { infer: true });
        return {
          signOptions: {algorithm: 'RS256'},
          //nodejs needs to receive the keys value as base64, and not a plain string
          privateKey: Buffer.from(privateKey, 'base64'),
          publicKey: Buffer.from(publicKey, 'base64')
        };
      },
    }),
  ],
  providers: [JwtStrategy]
})
export class AuthModule {}
```
6 - Create your authentication controller file:

```typescript
import {
  Body,
  Controller,
  Post,
  UnauthorizedException,
  UsePipes,
} from '@nestjs/common';
import { JwtService } from '@nestjs/jwt';
import { compare } from 'bcryptjs';
import { ZodValidationPipe } from 'src/pipes/zod-validation-pipe';
import { PrismaService } from 'src/prisma/prisma-service';
import { z } from 'zod';

const authenticateBodySchema = z.object({
  email: z.string().email(),
  password: z.string(),
});

type AuthenticateUserBodySchema = z.infer<typeof authenticateBodySchema>;

@Controller('/sessions')
export class AuthenticateController {
  constructor(private jwt: JwtService, private prisma: PrismaService) {}
  @Post()
  @UsePipes(new ZodValidationPipe(authenticateBodySchema))
  async handle(@Body() body: AuthenticateUserBodySchema) {
    const { email, password } = body;

    const user = await this.prisma.user.findUnique({
      where: {
        email,
      },
    });

    const isPasswordValid = await compare(password, user!.password);

    if (!user || !isPasswordValid) {
      throw new UnauthorizedException('User credentials do not match');
    }

    const token = this.jwt.sign({ sub: user.id });
    return token;
  }
}
```

7 - Create a custom decorator to be used in each controller to get and type the user payload, example:

```typescript
import {ExecutionContext, createParamDecorator} from '@nestjs/common';
import { UserPayloadSchema } from './jwt-strategy';

export const CurrentUser = createParamDecorator(
    (_: never, context: ExecutionContext) => {
        const request = context.switchToHttp().getRequest();
        return request.user as UserPayloadSchema;
    }
);
```
8 - Create a route that needs to be authorized to test the authentication process. You need to import the UseGuard from "nestjs/common" nad the AuthGuard from "@nestjs/passport" using the AuthGuard inside  UseGuards decorator passing the strategy type. In the handle method you need to pass the custom crated decorator to read correctly the value of the encrypted payload. Example:

```typescript
import { Controller, Post, UseGuards } from '@nestjs/common';
import { AuthGuard } from '@nestjs/passport';

@Controller('/questions')
@UseGuards(AuthGuard('jwt'))
export class CreateQuestionController {
  constructor() {}
  @Post()
  async handle(@CurrentUser() user: UserPayloadSchema) {
    return user.sub;
  }
}
```
9 - In your app.module.ts file import and add the auth module into your imports array and AuthenticateController to your controllers.

