# Working with Dynamic Path Imports in VSCode and tsconfig

1. **Configuring tsconfig.json:**
   - Overwrite the `baseUrl` property pointing to `src`.
   - Define the `paths` property for commonly used folders to avoid complex relative paths (`../../`):
     ```json
     "baseUrl": "./src",
     "paths": {
       "@modules/*": ["modules/*"],
       "@config/*": ["config/*"],
       "@shared/*": ["shared/*"],
       "@errors/*": ["errors/*"],
     }
     ```

2. **Using Dynamic Imports:**
   - You can import files from these folders by adding `@folder_name`. For example:
     ```typescript
     import { AppError } from "@errors/AppError"
     ```
   - **Note:** If you're working with TypeORM/Docker and encounter errors, add the library `tsconfig-paths`:
     - Run `yarn add tsconfig-paths -D`.
     - Add the flag `-r tsconfig-paths/register` to your server and TypeORM scripts. Example:
       ```json
       "dev": "ts-node-dev -r tsconfig-paths/register --transpile-only --respawn src/server.ts",
       "typeorm": "ts-node-dev -r tsconfig-paths/register ./node_modules/typeorm/cli"
       ```
