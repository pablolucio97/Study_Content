# Supertest Test Examples

## Example 1: Listing Categories

```typescript
import { Connection } from 'typeorm'
import request from 'supertest'

import { app } from '@shared/infra/http/app';
import createConnection from '@shared/infra/typeorm'

let connection : Connection

describe('list categories', () => {

    beforeAll(async () => {
        connection = await createConnection()
        await connection.runMigrations()
    })

    afterAll(async () => {
        await connection.close()
    })

    it('should be able to list all categories', async () => {
        const response = await request(app).get('/categories')
        expect(response.status).toBe(200)
    })

})
```

---

## Example 2: Creating a Category (Requires Token)

```typescript
import { hash } from 'bcryptjs';
import { Connection } from 'typeorm';
import request from 'supertest';
import { v4 as uuidv4 } from 'uuid'

import { app } from '@shared/infra/http/app';
import createConnection from '@shared/infra/typeorm'

let connection: Connection;

describe('Create Category Controller', () => {

    beforeAll(async () => {
        connection = await createConnection()
        await connection.runMigrations()

        const id = uuidv4()
        const password = await hash('admin', 8)

        await connection.query(
            `INSERT INTO USERS(id, name, email, password, "isAdmin", created_at, "driver_license")
                values('${id}', 'admin', 'admin@rentx.com', '${password}', true, 'now()', '123456')
            `
        )
    })

    afterAll(async () => {
        await connection.dropDatabase()
        await connection.close() 
    })

    it('should be able to create a new category', async () => {
        const responseToken = await request(app).post('/sessions')
        .send({
            email: 'admin@rentx.com',
            password: 'admin'
        })
        
        const { token } = responseToken.body
        
        const response = await request(app)
        .post('/categories').send({
                name: 'Categrory Supertest',
                description: 'Category Supertest'
            }).set({
                Authorization: `Bearer ${token}`
            })

        expect(response.status).toBe(201)
    })

})
```

**Notes:**
- `.set()` is used to add custom headers or properties to the request.
- Use `beforeAll` and `afterAll` to set up and clean up the database for test isolation.
