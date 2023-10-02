# Handling authentication with Jwt and Passport using RSA256 algorithm


## Generating the private and public keys

1 - Run the commands ```openssl genpkey -algorithm RSA -out private_key.pem  ``` and ```openssl rsa -pubout -in private_key.pem -out public_key.pem```  to generate the private and public keys that will generate in your project root folder.

2 - Now run the commands ```base64 -i private_key.pem -o private_key-base64.txt```  and ```base64 -i public_key.pem -o public_key-base64.txt``` to convert these keys into base64 encoded (legible strings).
## Generating the token

1 - Insde the "src" folder, create a new folder named "auth" and a new file named "auth.ts".

2 - Run ```npx yarn add @nestjs/passport @nestjs/jwt passport``` to install passport and jwt to deal with authentication in the application.

3 - In the "auth.ts" file, create a new module for authentication exporting a class 

4 Add yours generated private and public keys in your environment variables that will be used for generating the token using the RSA256 algorithm (that will contain a private key used only for generate tokens, and a public key that can be read for another application if necessary to validate if a token is valid), and add the validation for these keys on your zod envSchema. Ex:

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

5 - Create and export the AuthModule class importing the Module from '@nestjs/config' to configure new module, the ConfigService from '@nestjs/config' to validate the ConfigService, the PassportModule from '@nestjs/passport' to register a new injection passing your ConfigService, and the Env from 'src/env' to server as environment typing. This authentication will use RSA256 algorithm based on private and public keys.

```typescript
import { Module } from '@nestjs/common';
import { ConfigService } from '@nestjs/config';
import { JwtModule } from '@nestjs/jwt';
import { PassportModule } from '@nestjs/passport';
import { Env } from 'src/env';

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

    const token = this.jwt.sign({ sub: 'user-id' });
    return token;
  }
}
```

7 - In your app.module.ts file import and add the auth module into your imports array and AuthenticateController to your controllers.

