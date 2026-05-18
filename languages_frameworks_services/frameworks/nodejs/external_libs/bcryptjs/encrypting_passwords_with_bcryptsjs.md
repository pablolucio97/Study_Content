

# ENCRYPTING PASSWORD WITH BCRYPTJS

## 1. Install Bcrypt

Run the following commands to install Bcrypt and its types:

```typescript
yarn add bcryptjs
yarn add @types/bcryptjs -D

import { inject, injectable } from "tsyringe";
import { hash } from 'bcryptjs';
import { ICreateUserDto } from './../../dtos/ICreateUserDto';
import { IUsersRepository } from "../../repositories/implementations/IUserRepo";

@injectable()
class CreateUserUseCase {

    constructor(
        @inject("UsersRepository")
        private usersRepository: IUsersRepository
    ) {}

    async execute({
        name,
        password,
        email,
        driver_license
    }: ICreateUserDto): Promise<void> {

        // Hash the password with bcrypt before saving the user
        const passwordHash = await hash(password, 8);

        await this.usersRepository.create({
            name,
            password: passwordHash,
            email,
            driver_license
        });
    }
}

export { CreateUserUseCase };
```

---

#nodejs #authentication #security #tutorial

**Related:** [[data_safety]] | [[generating_and_using_jwt_tokens]] | [[verifying_authentication_with_jwt]] | [[handling_authentication_with_jwt_and_passport_using_rsa256]]
