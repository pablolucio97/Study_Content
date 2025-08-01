
# Writing Unity Tests on NodeJS Applications with Vitest

## 1. Install Vitest and vite-tsconfig-paths
```bash
npx yarn add vitest vite-tsconfig-paths -D
```

## 2. Configure vite.config.ts
Create this file at the root of your project:

```ts
import { defineConfig } from 'vitest/config'
import tsconfigpaths from 'vite-tsconfig-paths'

export default defineConfig({
    plugins: [tsconfigpaths()]
})
```

## 3. Add test script in package.json
```json
"scripts": {
  "test": "vitest"
}
```

## 4. Create In-Memory Repository
Create a file like `in-memory-users-repository.ts`:

```ts
import { Prisma, User } from "@prisma/client"
import { UsersRepository } from "../interfaces/prisma-users-repository"

export class InMemoryUsersRepository implements UsersRepository {
    public items: User[] = []

    async create(data: Prisma.UserCreateInput) {
        const user = {
            id: 'user-1',
            name: data.name,
            email: data.email,
            password_hash: data.password_hash,
            created_at: new Date(),
            checkin_id: '',
            checkins: []
        }

        this.items.push(user)
        return user
    }

    async findByEmail(email: string) {
        const user = this.items.find((item) => item.email === email)
        return user || null
    }
}
```

## 5. Create Unit Test File
Example: `registerUser.spec.ts`

```ts
import { describe, it, expect } from 'vitest'
import { RegisterUseCase } from './registerUser'
import { compare } from 'bcryptjs'
import { InMemoryUsersRepository } from '@/repositories/in-memory/in-memory-users-repository'

describe('Register Use Case', () => {
    it('should hash user password correctly on registration', async () => {
        const usersRepository = new InMemoryUsersRepository()
        const registerUseCase = new RegisterUseCase(usersRepository)

        const { newUser } = await registerUseCase.execute({
            email: 'johndoe2@gmail.com',
            name: 'johndoe',
            password: 'abc123'
        })

        const isPassCorrectlyHashed = await compare(
            'abc123',
            newUser.password_hash
        )
        expect(isPassCorrectlyHashed).toBe(true)
    })
})
```

---

## General Tips

- Each route has a business rule; your tests should validate those rules.
- Unit tests **do not connect** to a real database.
- Mock the database with in-memory repositories implementing the same interfaces.