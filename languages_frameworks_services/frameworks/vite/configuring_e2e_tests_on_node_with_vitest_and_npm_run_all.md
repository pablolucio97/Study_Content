
## Configuring E2E Tests on Node.js with Vitest and npm-run-all

End-to-end tests verify the full flow of your application, such as testing routes and business logic in an integrated manner. They are usually executed in CI environments (like GitHub Actions) and require an isolated test environment, typically with its own database schema.

---

### 1. Install Dependencies

```bash
npx yarn add vitest@0.33.0
npx yarn add npm-run-all
```

---

### 2. Create Environment Directory

Inside the `prisma/` folder:

```bash
mkdir prisma/vitest-environment-prisma
cd prisma/vitest-environment-prisma
npm init -y
```

Update `package.json`:

```json
{
  "name": "vitest-environment-prisma",
  "version": "1.0.0",
  "main": "prisma-test-environment.ts"
}
```

---

### 3. Configure `prisma-test-environment.ts`

```ts
import 'dotenv/config'
import { Environment } from 'vitest'
import { randomUUID } from 'node:crypto'
import { execSync } from 'node:child_process'
import { PrismaClient } from '@prisma/client'

const prisma = new PrismaClient()

function generateDatabaseUrl(schema: string) {
    if (!process.env.DATABASE_URL) {
        throw new Error('Please provide a DATABASE_URL environment variable')
    }
    const url = new URL(process.env.DATABASE_URL)
    url.searchParams.set('schema', schema)
    return url.toString()
}

export default <Environment>(<unknown>{
    name: 'prisma',
    async setup() {
        const schema = randomUUID()
        const databaseUrl = generateDatabaseUrl(schema)
        process.env.DATABASE_URL = databaseUrl
        execSync('npx yarn prisma migrate deploy')
        return {
            async teardown() {
                await prisma.$executeRawUnsafe(`DROP SCHEMA IF EXISTS "${schema}" CASCADE`)
                await prisma.$disconnect()
            },
        }
    },
})
```

---

### 4. Update `vite.config.ts`

```ts
import { defineConfig } from 'vitest/config'
import tsconfigPaths from 'vite-tsconfig-paths'

export default defineConfig({
  plugins: [tsconfigPaths()],
  test: {
    environmentMatchGlobs: [['src/http/controllers/**', 'prisma']],
    dir: 'src'
  }
})
```

---

### 5. Link Environment Package

```bash
cd prisma/vitest-environment-prisma
npm link

cd ../../your-project-root
npm link vitest-environment-prisma
```

---

### 6. Example E2E Test File

File: `src/http/controllers/tests/sample.spec.ts`

```ts
import { test } from 'vitest'

test('ok', () => {})
```

---

### 7. Configure NPM Scripts in `package.json`

```json
{
  "scripts": {
    "dev": "tsx watch src/server.ts",
    "release": "node build/server.js",
    "build": "tsup src --out-dir build",
    "test:unit": "vitest run --dir src/useCases",
    "test:create-e2e-environment": "npm link ./prisma/vitest-environment-prisma",
    "test:install-e2e-environment": "npm link vitest-environment-prisma",
    "pretest:e2e": "run-s test:create-e2e-environment test:install-e2e-environment",
    "test:e2e": "vitest run --dir src/http/controllers/tests",
    "test:coverage": "vitest run --coverage"
  }
}
```

---

### 8. Run E2E Tests

```bash
npm run test:e2e
```
