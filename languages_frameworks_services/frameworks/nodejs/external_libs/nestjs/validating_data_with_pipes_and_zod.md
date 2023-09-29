# Validating data using Pipes and Zod

## Pipes

Pipes on NestJS  can be used to validate a received data in a request or transform this data (example: convert a string to integer).

## Validating a request:

1 - Install the zod running ```npx yarn add zod``` and ```zod-validation-error``` to have a better error formatting.

2 - Inside the src folder, create a new folder named "pipes" and inside it create a general pipe to validate the received data using 

```typescript
import { PipeTransform, BadRequestException } from '@nestjs/common'
import { ZodError, ZodSchema } from 'zod'
import { fromZodError } from 'zod-validation-error'

export class ZodValidationPipe implements PipeTransform {
  constructor(private schema: ZodSchema) {}

  transform(value: unknown) {
    try {
      this.schema.parse(value)
    } catch (error) {
      if (error instanceof ZodError) {
        throw new BadRequestException({
          message: 'Validation failed',
          statusCode: 400,
          errors: fromZodError(error),
        })
      }

      throw new BadRequestException('Validation failed')
    }
    return value
  }
}
```

3 - On your controller, create your object validation schema, import the decorator UsePipes, and use the ZodValidationPipe passing the expect object schema format. Example:

```typescript
import {
  Body,
  ConflictException,
  Controller,
  HttpCode,
  Post,
  UsePipes,
} from '@nestjs/common';
import { PrismaService } from '../prisma/prisma-service';
import { hash } from 'bcryptjs';
import { z } from 'zod';
import { ZodValidationPipe } from 'src/pipes/zod-validation-pipe';

const createAccountBodySchema = z.object({
  name: z.string(),
  email: z.string().email(),
  password: z.string(),
});

type CreateAccountBodySchema = z.infer<typeof createAccountBodySchema>;


@Controller('/accounts')
export class CreateAccountController {
  constructor(private prisma: PrismaService) {}

  @Post()
  @HttpCode(201)
  @UsePipes(new ZodValidationPipe(createAccountBodySchema))
  async handle(@Body() body: CreateAccountBodySchema) {
    const { name, email, password } = createAccountBodySchema.parse(body);

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