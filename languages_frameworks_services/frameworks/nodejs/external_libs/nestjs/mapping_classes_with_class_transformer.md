
# 🧭 Doing Class Mapper (DTO Mapping) in a Node.js + TypeScript Backend

A **mapper** converts domain entities into **DTOs (Data Transfer Objects)**, so your API returns only what clients should see — with consistent shapes and names.

---

## ✅ When to Use a Mapper
- Hide internal fields (password hashes, tokens, internal flags).
- Rename/reshape fields (e.g., `driver_license` → `driverLicense`).
- Flatten nested relations (e.g., embed small parts of related entities).
- Version responses with minimal impact on business logic.

---

## 📁 Suggested Folder Structure
```
src/
  modules/
    accounts/
      dtos/
        IUserResponseDTO.ts
      mapper/
        UserMap.ts
      infra/
        typeorm/
          entities/
            User.ts
      useCases/
        profileUser/
          ProfileUserUseCase.ts
```

---

## 1) Create the Response DTO
`modules/accounts/dtos/IUserResponseDTO.ts`
```ts
export interface IUserResponseDTO {
  id: string;
  name: string;
  email: string;
  avatar?: string | null;
  driver_license?: string | null;
}
```

> Keep DTOs **flat** and tailored to client needs. Prefer optional fields (`?`) when the data might be absent.

---

## 2) Create the Mapper Class
`modules/accounts/mapper/UserMap.ts`
```ts
import { IUserResponseDTO } from "../dtos/IUserResponseDTO";
import { User } from "../infra/typeorm/entities/User";

export class UserMap {
  // static: use without instantiation
  static toDTO(user: User): IUserResponseDTO {
    if (!user) throw new Error("UserMap.toDTO received undefined user");

    const {
      id,
      name,
      email,
      avatar = null,
      driver_license = null,
    } = user;

    return {
      id,
      name,
      email,
      avatar,
      driver_license,
    };
  }

  // Bonus: list mapping for arrays
  static listToDTO(users: User[]): IUserResponseDTO[] {
    return users.map(UserMap.toDTO);
  }
}
```

> Tip: Guard against `undefined` to fail fast in dev and catch repository issues early.

---

## 3) Use the Mapper in Your Use Case
`modules/accounts/useCases/profileUser/ProfileUserUseCase.ts`
```ts
import { inject, injectable } from "tsyringe";
import { IUsersRepository } from "@modules/accounts/repositories/IUsersRepository";
import { IUserResponseDTO } from "@modules/accounts/dtos/IUserResponseDTO";
import { UserMap } from "@modules/accounts/mapper/UserMap";

@injectable()
export class ProfileUserUseCase {
  constructor(
    @inject("UsersRepository")
    private readonly usersRepository: IUsersRepository
  ) {}

  async execute(id: string): Promise<IUserResponseDTO> {
    const user = await this.usersRepository.findById(id);
    if (!user) throw new Error("User not found");
    return UserMap.toDTO(user);
  }
}
```

---

## 4) Wire It Up in the Controller/Route
Example with Express:
```ts
import { Request, Response } from "express";
import { container } from "tsyringe";
import { ProfileUserUseCase } from "./ProfileUserUseCase";

export class ProfileUserController {
  async handle(req: Request, res: Response) {
    const { id } = req.params;

    const useCase = container.resolve(ProfileUserUseCase);
    const dto = await useCase.execute(id);

    // Always send DTOs, never raw entities
    return res.status(200).json(dto);
  }
}
```

---

## 5) Advanced Mapping Patterns

### 5.1 Rename Fields / Change Shape
```ts
static toDTO(user: User): IUserResponseDTO {
  return {
    id: user.id,
    name: user.fullName ?? user.name, // fallback
    email: user.email.toLowerCase(),
    avatar: user.avatarUrl,
    driver_license: user.driverLicenseNumber
  };
}
```

### 5.2 Include Small Relation Snapshots
```ts
export interface IUserResponseDTO {
  id: string;
  name: string;
  email: string;
  avatar?: string | null;
  company?: { id: string; name: string } | null;
}

static toDTO(user: User): IUserResponseDTO {
  return {
    id: user.id,
    name: user.name,
    email: user.email,
    avatar: user.avatar,
    company: user.company
      ? { id: user.company.id, name: user.company.name }
      : null
  };
}
```

### 5.3 Transform Types (Dates, Money)
```ts
static toDTO(user: User): IUserResponseDTO & { createdAt: string } {
  return {
    id: user.id,
    name: user.name,
    email: user.email,
    avatar: user.avatar,
    driver_license: user.driver_license,
    createdAt: user.created_at.toISOString()
  };
}
```

---

## 6) Testing the Mapper
```ts
import { UserMap } from "../mapper/UserMap";

test("UserMap.toDTO maps fields safely", () => {
  const entity: any = {
    id: "uuid",
    name: "Pablo",
    email: "pablo@example.com",
    avatar: null,
    driver_license: undefined,
    password_hash: "secret", // should NOT leak
  };

  const dto = UserMap.toDTO(entity);
  expect(dto).toEqual({
    id: "uuid",
    name: "Pablo",
    email: "pablo@example.com",
    avatar: null,
    driver_license: null,
  });
  // @ts-expect-error - password must not exist in DTO
  expect(dto.password_hash).toBeUndefined();
});
```

---

## 7) Alternatives / Complements

### 7.1 class-transformer (NestJS-friendly)
```ts
import { Exclude, Expose, Transform } from "class-transformer";

export class UserViewModel {
  @Expose() id!: string;
  @Expose() name!: string;
  @Expose() email!: string;

  @Expose()
  @Transform(({ value }) => value ?? null)
  avatar!: string | null;

  @Exclude() password_hash!: string;
}
```
> Use `plainToInstance(UserViewModel, entity, { excludeExtraneousValues: true })` to emit **only** exposed fields.

### 7.2 Prisma Selects (Reduce Data at Source)
```ts
const user = await prisma.user.findUnique({
  where: { id },
  select: { id: true, name: true, email: true, avatar: true, driver_license: true }
});
// Still run through a mapper to keep a single response policy.
```

---

## 8) Common Pitfalls & How to Avoid Them
- **Leaking sensitive fields**: Always centralize mapping; never return ORM entities directly.
- **DTO drift**: Add a small unit test for each mapper to lock wire format.
- **Over-fetching relations**: Map **snapshots** of relations, or fetch with `select`/`relations` tuned to your DTO.
- **Breaking clients**: Consider versioned DTOs when making breaking changes (e.g., `UserV2Map` + route versioning).

---

## 9) Bonus: Generic Helper (Optional)
```ts
type Mapper<E, D> = (entity: E) => D;
export const mapList = <E, D>(items: E[], mapper: Mapper<E, D>): D[] =>
  items.map(mapper);

// Usage: mapList(users, UserMap.toDTO)
```

---

## 🔚 Summary
- **DTOs** keep your API responses clean, safe, and stable.
- **Mappers** isolate representation logic from business logic.
- Test your mappers and treat them as part of your contract with clients.
