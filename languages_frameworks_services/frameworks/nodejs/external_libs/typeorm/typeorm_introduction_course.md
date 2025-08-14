
# TypeORM Introduction Course

This course covers the **most important concepts** of TypeORM, a popular ORM for Node.js and TypeScript.

---
## What is TypeORM?
TypeORM is an **Object-Relational Mapping** library that allows you to interact with databases using TypeScript/JavaScript classes instead of writing raw SQL.


## Creating a CRUD using TypeORM and Docker

This guide walks through setting up a basic CRUD with **TypeORM** and **Docker**, including migrations, entities, repositories, use cases, controllers, and routes.

---

### 1) Set up Docker

Install **Docker** and run one container for your **database** and another for your **server** (or run the server locally). Ensure the DB container is reachable from your app.

---

### 2) Initialize TypeORM Connection

Inside `src/`, create a `database/` folder and an `index.ts` that initializes TypeORM. Import it in `server.ts`.

**`database/index.ts`**
```ts
import { createConnection } from 'typeorm'

createConnection()
```

**`server.ts`**
```ts
import './database'
```

---

### 3) Create a Migration

```bash
yarn typeorm migration:create -n your_migration_name
```

---

### 4) Implement Migration Up/Down

Open the generated migration and implement `up` and `down` using `queryRunner` to create/drop tables.

```ts
import { MigrationInterface, QueryRunner, Table } from "typeorm";

export class users1660125247352 implements MigrationInterface {
  public async up(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.createTable(
      new Table({
        name: 'users',
        columns: [
          { name: "id", type: "uuid", isPrimary: true },
          { name: "name", type: "varchar" },
          { name: "username", type: "varchar", isUnique: true },
          { name: "password", type: "varchar" },
          { name: "email", type: "varchar" },
          { name: "driver_license", type: "varchar" },
          { name: "isAdmin", type: "boolean", default: false },
          { name: "created_at", type: "timestamp", default: "now()" },
        ]
      })
    )
  }

  public async down(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.dropTable('users')
  }
}
```

---

### 5) Run the Migration

```bash
yarn typeorm migration:run
```

---

### 6) Create the Entity

Create the entity in `modules/your_module/entities/your_entity.ts`. The table name should match the migration name.

```ts
import { v4 as uuidv4 } from 'uuid'
import { Column, CreateDateColumn, Entity, PrimaryColumn } from 'typeorm'

@Entity('your_migration_name')
class User {
  @PrimaryColumn()
  id: string

  @Column()
  name: string

  @Column()
  username: string

  @Column()
  password: string

  @Column()
  email: string

  @Column()
  driver_license: string

  @Column()
  isAdmin: boolean

  @CreateDateColumn()
  created_at: Date

  constructor() {
    if (!this.id) {
      this.id = uuidv4()
    }
  }
}

export { User }
```

---

### 7) Repository Interface

Create your repository interface in `modules/your_module/repositories/implementations/your_repository_interface.ts`.

```ts
import { UserProps } from './implementations/IUserProps'

interface IUsersRepository {
  create(data: UserProps): Promise<void>;
  list(): Promise<UserProps[]>;
}

export { IUsersRepository }
```

---

### 8) Repository Implementation

Create your repository in `modules/your_module/repositories/your_repository.ts`, using TypeORM’s `Repository<T>` methods.

```ts
import { Repository } from 'typeorm'
import { User } from '../entities/user'
import { IUsersRepository } from './implementations/IUserRepository'

interface UserDTOProps {
  name: string;
  email: string;
  password: string;
  username: string;
  driver_license: string;
}

class UserRepository implements IUsersRepository {
  private repository: Repository<User>

  async create({
    name,
    email,
    password,
    username,
    driver_license
  }: UserDTOProps): Promise<void> {
    const user = {
      name,
      username,
      email,
      driver_license,
      password,
    }

    await this.repository.save(user)
  }

  // Example list method
  async list(): Promise<User[]> {
    return this.repository.find()
  }
}

export { UserRepository }
```

---

### 9) Use Case

Create a use case in `modules/your_module/useCases/your_use_folder/CreateUserUseCase.ts`. It should be decorated with `@injectable()` and use DI with `tsyringe`.

```ts
import { ICreateUserDto } from './../../dtos/ICreateUserDto';
import { inject, injectable } from "tsyringe";
import { IUsersRepository } from "../../repositories/implementations/IUserRepository";

@injectable()
class CreateUserUseCase {
  constructor(
    @inject("UsersRepository")
    private usersRepository: IUsersRepository
  ) {}

  async execute({
    name,
    username,
    password,
    email,
    driver_license
  }: ICreateUserDto): Promise<void> {
    await this.usersRepository.create({
      name,
      username,
      password,
      email,
      driver_license
    })
  }
}

export { CreateUserUseCase }
```

---

### 10) Register the Repository in the Container

In `shared/container/index.ts` register your repository.

```ts
import { container } from 'tsyringe'

import { UserRepository } from '../../repositories/UserRepository'
import { IUsersRepository } from '../../repositories/implementations/IUserRepository'

container.registerSingleton<IUsersRepository>(
  'UsersRepository',
  UserRepository
)
```

---

### 11) Controller

Create a controller for the use case in `modules/your_module/useCases/your_use_folder/CreateUserController.ts`.

```ts
import { Request, Response } from 'express';
import { container } from 'tsyringe';

import { CreateUserUseCase } from './CreateUserUseCase';

class CreateUserController {
  async handle(req: Request, res: Response): Promise<Response> {
    const {
      name,
      username,
      password,
      email,
      driver_license
    } = req.body

    const createUserUseCase = container.resolve(CreateUserUseCase)

    await createUserUseCase.execute({
      name,
      username,
      password,
      email,
      driver_license
    })

    return res.status(201).send()
  }
}

export { CreateUserController }
```

---

### 12) Routes

Define routes in `routes/users.routes.ts` and export them for the index routes file.

```ts
import { Router } from 'express';
import { CreateUserController } from '../modules/users/useCases/createUser/CreateUserController';

const usersRouter = Router();
const createUserController = new CreateUserController();

usersRouter.post('/', createUserController.handle)

export { usersRouter }
```

---

### 13) Index Routes

Add your new route in your routes index file.

```ts
import { Router } from 'express'

import { usersRouter } from './users.routes'

const routes = Router()

routes.use('/users', usersRouter)

export { routes }
```

---

### 14) Server

Finally, consume routes in your `server.ts` and start the application.

```ts
import express, { json } from 'express';
import { routes } from './routes';

const app = express();

app.use(json())

app.use(routes)

app.listen('3333', () => {
  console.log('listening on 3333');
})
```

---

# Managing Relationships in TypeORM

This guide shows how to create relationship (junction) tables, wire up entities, repositories, and expose endpoints. It also covers querying relations and listing related data.

---

## 🔗 Relationship Tables (Join/Junction Tables)

A **relationship table** (junction table) acts as a bridge between two tables in many‑to‑many relations.

### 1) Create the Migration

```ts
import { MigrationInterface, QueryRunner, Table, TableForeignKey } from "typeorm";

// table to store relationships
export class CreateSpecificationsCars1661081316074 implements MigrationInterface {
  public async up(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.createTable(new Table({
      name: 'specifications_cars',
      columns: [
        { name: 'car_id', type: 'uuid' },
        { name: 'specification_id', type: 'uuid' },
        { name: 'created_at', type: 'timestamp', default: 'now()' },
      ],
    }));

    await queryRunner.createForeignKey(
      "specifications_cars",
      new TableForeignKey({
        name: 'FKSpecificationCar',
        referencedTableName: 'specifications',
        referencedColumnNames: ['id'],
        columnNames: ['specification_id'],
        onDelete: 'SET NULL',
        onUpdate: 'SET NULL',
      })
    );

    await queryRunner.createForeignKey(
      "specifications_cars",
      new TableForeignKey({
        name: 'FKCarSpecification',
        referencedTableName: 'cars',
        referencedColumnNames: ['id'],
        columnNames: ['car_id'],
        onDelete: 'SET NULL',
        onUpdate: 'SET NULL',
      })
    );
  }

  // Revert from bottom to top
  public async down(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.dropForeignKey('specifications_cars', 'FKSpecificationCar');
    await queryRunner.dropForeignKey('specifications_cars', 'FKCarSpecification');
    await queryRunner.dropTable('specifications_cars');
  }
}
```

---

### 2) Alter the Entities Being Related

```ts
import {
  Column,
  CreateDateColumn,
  Entity,
  JoinTable,
  ManyToMany,
  PrimaryColumn
} from 'typeorm';
import { v4 as uuidv4 } from 'uuid'
import { Specification } from './Specification';

@Entity('cars')
class Car {
  @PrimaryColumn()
  id: string;

  @Column()
  name: string;

  @ManyToMany(() => Specification)
  @JoinTable({
    name: 'specifications_cars',                // junction table name
    joinColumns: [{ name: 'car_id' }],          // column in junction that references this entity
    inverseJoinColumns: [{ name: 'specification_id' }] // column that references the other entity
  })
  specifications: Specification[];

  @CreateDateColumn()
  created_at: Date;

  constructor() {
    if (!this.id) this.id = uuidv4();
  }
}

export { Car }
```

> Ensure `Specification` entity exists and is registered in your data source.

---

## 📦 Repository Contracts & Implementation

### 3) Define the Interface

```ts
import { Specification } from "../infra/typeorm/entities/Specification";

interface ICreateSpecificationDTO {
  name: string;
  description: string;
}

interface ISpecificationsRepository {
  create(data: ICreateSpecificationDTO): Promise<Specification>;
  findByName(name: string): Promise<Specification | undefined>;
  findByIds(ids: string[]): Promise<Specification[]>;
}

export { ISpecificationsRepository, ICreateSpecificationDTO }
```

### 4) Implement the Repository

```ts
import { ICreateSpecificationDTO, ISpecificationsRepository } from "@modules/cars/repositories/ISpecificationsRepository";
import { getRepository, Repository } from "typeorm";
import { Specification } from "../entities/Specification";

class SpecificationRepository implements ISpecificationsRepository {
  private repository: Repository<Specification>;

  constructor() {
    this.repository = getRepository(Specification);
  }

  async create({ name, description }: ICreateSpecificationDTO): Promise<Specification> {
    const specification = this.repository.create({ name, description });
    await this.repository.save(specification);
    return specification;
  }

  async findByName(name: string): Promise<Specification | undefined> {
    const specification = await this.repository.findOne({ name });
    return specification ?? undefined;
  }

  async findByIds(ids: string[]): Promise<Specification[]> {
    const specifications = await this.repository.findByIds(ids);
    return specifications;
  }
}

export { SpecificationRepository }
```

> In TypeORM v0.3+, use `AppDataSource.getRepository(Specification)` instead of `getRepository`.

---

## 📄 Use Case, Controller, and Route

### 5) Create the Use Case & Controller
Write the use case to attach specifications to a car and wire the controller + route. (Omitted for brevity — match your app’s DI and routing patterns.)

---

## 🔎 Doing Relationships & Listing Them

### 1) Update the Entity that Exposes the Relation

```ts
import { Car } from '@modules/cars/infra/typeorm/entities/Car';
import {
  Column, CreateDateColumn, Entity, JoinColumn, ManyToOne, PrimaryColumn
} from 'typeorm';
import { v4 as uuidv4 } from 'uuid'

@Entity("rentals")
class Rental {
  @PrimaryColumn()
  id: string;

  @Column()
  car_id: string;

  @ManyToOne(() => Car)                 // many rentals for one car
  @JoinColumn({ name: 'car_id' })       // FK in this table
  car: Car;

  @Column()
  user_id: string;

  @Column()
  start_date: Date;

  @Column()
  end_date: Date;

  @Column()
  expect_return_date: Date;

  @Column()
  total: number;

  @CreateDateColumn()
  created_at: Date;

  @CreateDateColumn()
  updated_at: Date;

  constructor() {
    if (!this.id) this.id = uuidv4();
  }
}

export { Rental }
```

> Fix common typos: `car_id` (not `card_id`), and ensure `@JoinColumn` name matches your FK column.

---

### 2) Repository Method that Loads Relations

```ts
import { IRentalsRepository } from "@modules/rentals/repositories/IRentalsRepository";
import { getRepository, Repository } from "typeorm";
import { Rental } from "../entities/Rental";

class RentalsRepository implements IRentalsRepository {
  private repository: Repository<Rental>;

  constructor() {
    this.repository = getRepository(Rental);
  }

  async findByUser(user_id: string): Promise<Rental[]> {
    const rentals = await this.repository.find({
      where: { user_id },
      relations: ["car"], // relation property name defined in entity, not the FK column
    });
    return rentals;
  }
}

export { RentalsRepository }
```

> Use `relations: ["car"]` to eager-load the `car` relation. For selective fields, use QueryBuilder with `leftJoinAndSelect`.

---

### 3) Use Case

```ts
import { inject, injectable } from "tsyringe";
import { Rental } from "@modules/rentals/infra/typeorm/entities/Rental";
import { IRentalsRepository } from "@modules/rentals/repositories/IRentalsRepository";

@injectable()
class ListRentalsByUserUseCase {
  constructor(
    @inject("RentalsRepository")
    private rentalsRepository: IRentalsRepository
  ) {}

  async execute(user_id: string): Promise<Rental[]> {
    const rentalsByUser = await this.rentalsRepository.findByUser(user_id);
    return rentalsByUser;
  }
}

export { ListRentalsByUserUseCase };
```

---

### 4) Controller

```ts
import { Request, Response } from "express";
import { container } from "tsyringe";
import { ListRentalsByUserUseCase } from "./ListRentalsByUserUseCase";

class ListRentalsByUserController {
  async handle(request: Request, response: Response): Promise<Response> {
    const { id } = request.user as { id: string };

    const listRentalsByUserUseCase = container.resolve(ListRentalsByUserUseCase);
    const rentals = await listRentalsByUserUseCase.execute(id);

    return response.json(rentals);
  }
}

export { ListRentalsByUserController };
```

---

### 5) Route
Create your route that calls the controller and expose the endpoint as usual.

```ts
import { Router } from "express";
import { ListRentalsByUserController } from "@modules/rentals/useCases/listRentalsByUser/ListRentalsByUserController";

const rentalsRouter = Router();
const listByUserController = new ListRentalsByUserController();

rentalsRouter.get("/by-user", listByUserController.handle);

export { rentalsRouter };
```

## TypeORM Seed Generation Guide

This guide explains how to create seeds (pre-populated data) in a TypeORM project using a script.

---

### 1) Create the Seeds Folder and File
Inside `src/shared/infra/typeorm`, create a new folder called `seeds` and a file named `admin.ts`.

---

### 2) Write the Seed Script
Import the necessary modules and create an async function that uses `getConnection` to insert an admin user into the database.

```typescript
import { v4 as uuidv4 } from 'uuid'
import { hash } from 'bcryptjs'
import createConnection from '../index'

async function create() {
    const connection = await createConnection('localhost')

    const id = uuidv4()
    const password = await hash('admin', 8)

    await connection.query(
        `INSERT INTO USERS(id, name, email, password, "isAdmin", created_at, "driver_license")
            values('${id}', 'admin', 'admin@rentx', '${password}', true, 'now()', '123456')
        `
    )

    await connection.close()
}

create().then(() => console.log('Admin user created'))
```
**Note:** `isAdmin` and `driver_license` need double quotes.

---

### 3) Adjust `index.ts` for Connection
Inside `src/shared/infra/typeorm/index.ts`, adjust the connection to avoid Docker conflicts:

```typescript
import { Connection, createConnection, getConnectionOptions } from 'typeorm';

export default async (host = "database"): Promise<Connection> => {
    const defaultOptions = await getConnectionOptions();
  
    return createConnection(
      Object.assign(defaultOptions, {
        host,
      })
    );
};
```

**Note:** The `host` value must match your `docker-compose.yml` service name.

---

### 4) Initialize the Connection in `server.ts`
```typescript
import createConnection from '../typeorm'

createConnection()
const app = express();
```

---

### 5) Add the Script to `package.json`
```json
"scripts": {
    "seed:admin": "ts-node-dev src/shared/infra/typeorm/seeds/admin.ts"
}
```

Run the seed:
```bash
yarn seed:admin
```

---

# Altering an Existing Table Using Migrations

This guide shows how to **modify an existing table** in TypeORM using migrations (e.g., drop a column and restore it on rollback).

---

### 1) Create and Run a Migration

Create a migration named after the change you’re making and run it:

```bash
# Create
typeorm migration:create -n DeleteUsernameField

# Run
typeorm migration:run
```

In the migration file, **drop** the column in `up` and **re-add** it in `down`:

```ts
import { MigrationInterface, QueryRunner, TableColumn } from "typeorm";

export class AlterUserDeleteUsername1660216015165 implements MigrationInterface {
  public async up(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.dropColumn('users', 'username');
  }

  public async down(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.addColumn(
      'users',
      new TableColumn({
        name: 'username',
        type: 'varchar',
      })
    );
  }
}
```

> Tip: For TypeORM v0.3+, ensure your CLI is configured or use the `DataSource`-based commands.

---

### 2) Update Your Codebase

Remove or update the `username` property **everywhere it appears**:
- Entity classes (`@Column()` fields)
- DTOs/types/interfaces
- Repositories and services
- Controllers/use cases
- Validation schemas
- Tests and seed scripts

Keeping code and schema **in sync** prevents runtime errors and migration drift.

---

## General tips
- Ensure your Docker database container’s connection details (host, port, credentials) match your TypeORM config. Keep credentials in environment variables for security.
- Name **FK columns** consistently (`car_id`, `specification_id`) and match in `@JoinColumn`/`@JoinTable`.
- In repositories, specify **`relations`** to load associations; use QueryBuilder for complex selections.
- Keep migrations the **source of truth** in production (avoid `synchronize: true`).
- For TypeORM v0.3+, prefer `DataSource.getRepository()` and `FindOptions` over deprecated APIs.