
1 - Create the JwtAdminStrategy class extending the PassportStrategy configuring the authentication options in constructor instanced by the super class method, and validating if the received payload from request has a a bearer token in the header and this token has the property isAdmin encrypted.

- Obs: pay attention on passing the strategy name as second argument to PassportStrategy function to Jwt can distinguish between user and admin tokens.
  
 Example:

```typescript
import { Injectable, UnauthorizedException } from "@nestjs/common";
import { ConfigService } from "@nestjs/config";
import { PassportStrategy } from "@nestjs/passport";
import { ExtractJwt, Strategy } from "passport-jwt";
import { TEnv } from "src/infra/env";
import { z } from "zod";

const UserAdminPayloadSchema = z.object({
  sub: z.string().uuid(),
  isAdmin: z.boolean(),
});

export type UserAdminPayloadSchema = z.infer<typeof UserAdminPayloadSchema>;

@Injectable()
export class JwtAdminStrategy extends PassportStrategy(Strategy, 'jwt-admin') {
  constructor(config: ConfigService<TEnv, true>) {
    const publicKey = config.get("JWT_PUBLIC_KEY", { infer: true });
    super({
      jwtFromRequest: ExtractJwt.fromAuthHeaderAsBearerToken(),
      secretOrKey: Buffer.from(publicKey, "base64"),
      algorithms: ["RS256"],
    });
  }

  async validate(payload: UserAdminPayloadSchema) {
    if (!payload.isAdmin) {
      throw new UnauthorizedException(
        "Only admin have access to this resource"
      );
    }
    return UserAdminPayloadSchema.parse(payload);
  }
}
```

2 - Include the JwtAdminStrategy into your auth.module. Example:

```typescript
import { Module } from "@nestjs/common";
import { ConfigService } from "@nestjs/config";
import { JwtModule } from "@nestjs/jwt";
import { PassportModule } from "@nestjs/passport";
import { TEnv } from "../infra/env";
import { JwtStrategy } from "./jw_strategy";
import { JwtAdminStrategy } from "./jwt_admin_strategy";

@Module({
  imports: [
    PassportModule,
    JwtModule.registerAsync({
      inject: [ConfigService],
      global: true,
      useFactory(config: ConfigService<TEnv, true>) {
        const privateKey = config.get("JWT_PRIVATE_KEY", { infer: true });
        const publicKey = config.get("JWT_PUBLIC_KEY", { infer: true });
        return {
          signOptions: { algorithm: "RS256" },
          privateKey: Buffer.from(privateKey, "base64"),
          publicKey: Buffer.from(publicKey, "base64"),
        };
      },
    }),
  ],
  providers: [JwtStrategy, JwtAdminStrategy],
})
export class AuthModule {}
```

3 - Use the AuthGuard passing the name of your admin jwt strategy in the protected admin routes. Example:

```typescript
import { Controller, Get, HttpCode, UseGuards } from "@nestjs/common";
import { AuthGuard } from "@nestjs/passport";
import { ListAppVersionsUseCase } from "../../useCases/appVersions/listAppVersionsUseCase";

@Controller("/appVersion/list")
@UseGuards(AuthGuard("jwt-admin"))
export class ListAppVersionsController {
  constructor(private listAppVersionsUseCase: ListAppVersionsUseCase) {}
  @Get()
  @HttpCode(200)
  async handle() {
    const appVersions = await this.listAppVersionsUseCase.execute();
    return appVersions;
  }
}

```