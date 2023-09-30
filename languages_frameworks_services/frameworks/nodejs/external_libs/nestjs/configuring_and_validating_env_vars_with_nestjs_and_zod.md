# Configuring and validating environment variables with NestJS and Zod

Validating environment is useful to not allow you project run without environment variables configuring correctly according your environment typing schema.

### Configuring the environment validation

1 - Run ```npx yarn add @nest/config``` to install the nest environment config package. Install zod too if you haven't already did it.

2 - Inside the "src" folder, create a file env.ts exporting the envSchema and its type. Example:

```typescript
import { z } from 'zod';

export const envSchema = z.object({
  DATABASE_URL: z.string().url(),
  PORT: z.coerce.number().optional().default(3333),
});

export type Env = z.infer<typeof envSchema>

```
3 - On your app.module.ts file, import the ConfigModule from '@nestjs/config' and add this global module to your imports array to be used in the root configuration validating the schema. Example:

```typescript
import { Module } from '@nestjs/common';
import { ConfigModule } from '@nestjs/config';
import { CreateAccountController } from './controllers/create-account-controller';
import { envSchema } from './env';
import { PrismaService } from './prisma/prisma-service';

@Module({
  imports: [ConfigModule.forRoot({
    validate: env => envSchema.parse(env),
    isGlobal: true
  })],
  controllers: [CreateAccountController],
  providers: [PrismaService],
})
export class AppModule {}
```

### Using the environment variables

Import the ConfigService from @nestjs/config, create a configService variable calling app.get passing the ConfigService and your Env as typing, use the variables you want from configService.get. Example:

```typescript
import { NestFactory } from '@nestjs/core';
import { AppModule } from './app.module';
import { Env } from './env';
import { ConfigService } from '@nestjs/config';

async function bootstrap() {
  const app = await NestFactory.create(AppModule);

  const configService = app.get<ConfigService<Env, true>>(ConfigService);
  const port = configService.get('PORT', { infer: true });

  await app.listen(port);
}
bootstrap();
```