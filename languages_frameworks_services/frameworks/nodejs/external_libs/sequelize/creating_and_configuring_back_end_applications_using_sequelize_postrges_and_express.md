# Creating and configuring applications using SequelizeORM, Postgres e Express

1. Run the command npm init -y to start your NodeJS project.
2. Install ts-node-dev and running `npm i ts-node-dev @types/node @types/express -D`
3. Run the command `npm i sequelize pg pg-hstore express` and `npm i @types/pg @types/sequelize @types/express` to install the necessary dependencies for Sequelize, Postgres, and Express.
4. Run the command `npx tsc --init` to initialize your tsconfig.json file. It must look like:
```json
   {
  "compilerOptions": {
    "target": "es2020",
    "module": "commonjs",
    "moduleResolution": "node",
    "outDir": "./dist",
    "rootDir": "./src",
    "strict": true,
    "esModuleInterop": true,
    "forceConsistentCasingInFileNames": true,
    "skipLibCheck": true
  }
}
```
5. Add the script to start your application. Example:
```json
  "scripts": {
    "dev": "ts-node-dev --ignore-watch node_modules src/server.ts"
  },
```
6. Define your envinronment varaibles in a .env file.
7. Create a folder named src and a server.ts file inside it. This file must import dotenv/config to be able to read environment variables,  initialize express and sync Sequelize database based on models you have. Example: 
```typescript
import "dotenv/config";
import express from "express";
import { sequelizeDb } from "./config/database";
import "./infra/models";

const app = express();
const PORT = process.env.PORT;

app.use(express.json());

sequelizeDb
  .sync()
  .then(() => {
    console.log("📦 Database synced");
    app.listen(PORT, () => {
      console.log(`🚀 Server running at http://localhost:${PORT}`);
    });
  })
  .catch((error) => {
    console.log(
      "Unable to connect to the database, server was not started: ",
      error
    );
  });

```
8. Create a folder named config and file named database.ts for configuring your database connection. Example:
```typescript
import { Sequelize } from "sequelize";

export const sequelizeDb = new Sequelize(
  process.env.DB_NAME!,
  process.env.DB_USER!,
  process.env.DB_PASSWORD!,
  {
    host: "localhost",
    port: 5432,
    dialect: "postgres",
    logging: false,
  }
);
```
9. Create a folder named models and create your models inside it. Have a index file exporting your all modules. Example:
```typescript
import { DataTypes, Sequelize } from "sequelize";

const sequelize = new Sequelize("follow-cep-db", "postgres", "admin", {
  host: "localhost",
  dialect: "postgres",
  port: 5432,
});

export const User = sequelize.define("user", {
  id: {
    type: DataTypes.UUID,
    primaryKey: true,
  },
  name: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  email: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  password: {
    type: DataTypes.STRING,
    allowNull: false,
  },
});

(async () => {
  await sequelize.sync({ force: true });
})();

//index.ts:
import { User } from "./User";

export const models = {
  User,
};

```
10. Create a docker-compose.yml file containing your Postgres image configured to your database using the same credentials used to configure Sequelize. Example
```yml
version: '3.8'

services:
  postgres:
    container_name: follow-cep-db
    image: postgres
    ports:
      - 5432:5432
    environment:
       POSTGRES_USER: postgres
       POSTGRES_PASSWORD: admin
       POSTGRES_DB: follow-cep-db
       PGDATA: /data/postgres
    volumes:
    - ./data/pg:/data/postgres
```
11. Start your Docker application on your machine, the container running `docker-compose up` and `npm run dev` (according the script you defined at package.json) to start your application.
12. Your application will be started successfully after the sequelize have been synced your database.