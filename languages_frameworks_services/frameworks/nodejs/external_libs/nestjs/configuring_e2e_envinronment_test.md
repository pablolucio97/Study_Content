# Configuring Vitest E2E tests environment 

1 - Run ```npx yarn @swc/core @vitest/coverage-v8 unplugin-swc vitest vite-tsconfig-paths dotenv``` to install swc (a more faster typescript compilation lib), vitest and its plugins.

2 - Create a file named vitest.config.ts and another named vitest.config.e2e.ts in your project root folder with the configurations:

vitest.config.ts:

```typescript
import swc from 'unplugin-swc';
import { defineConfig } from 'vitest/config';
import tsConfigPaths from 'vite-tsconfig-paths';

export default defineConfig({
  test: {
    globals: true,
    root: './',
  },
  plugins: [
    tsConfigPaths(),
    swc.vite({
      module: { type: 'es6' },
    }),
  ],
});
```
vitest.config.e2e.ts:

```typescript
import swc from 'unplugin-swc';
import { defineConfig } from 'vitest/config';
import tsConfigPaths from 'vite-tsconfig-paths';

export default defineConfig({
  test: {
    include: ['**/*.e2e-spec.ts'],
    globals: true,
    root: './',
    setupFiles: ['./test/setup-e2e.ts']
  },
  plugins: [
    tsConfigPaths(),
    swc.vite({
      module: { type: 'es6' },
    }),
  ],
});
```

3 - In your root folder, create a folder named test, and inside it create a file named setup-e2e.ts containing the configuration for creating a new database with new url every time your test is ran and delete the database after the test has been ran. Example:

```typescript
import 'dotenv/config'

import { PrismaClient } from '@prisma/client'
import { randomUUID } from 'node:crypto'
import { execSync } from 'node:child_process'

const prisma = new PrismaClient()

function generateUniqueDatabaseURL(schemaId: string) {
  if (!process.env.DATABASE_URL) {
    throw new Error('Please provider a DATABASE_URL environment variable')
  }

  const url = new URL(process.env.DATABASE_URL)

  url.searchParams.set('schema', schemaId)

  return url.toString()
}

const schemaId = randomUUID()

beforeAll(async () => {
  const databaseURL = generateUniqueDatabaseURL(schemaId)

  process.env.DATABASE_URL = databaseURL

  execSync('npx yarn prisma migrate deploy')
})

afterAll(async () => {
  await prisma.$executeRawUnsafe(`DROP SCHEMA IF EXISTS "${schemaId}" CASCADE`)
  await prisma.$disconnect()
})
```

4 - Add the scripts to the package.json file:

```
"test": "vitest run",
"test:watch": "vitest",
"test:cov": "vitest run --coverage",
"test:debug": "vitest --inspect-brk --inspect --logHeapUsage --threads=false",
"test:e2e": "vitest run --config ./vitest.config.e2e.ts"
```

5 - Add the vitest type as a global types in your tsconfig file, and update the target version based on your node version consulting https://github.com/microsoft/TypeScript/wiki/Node-Target-Mapping as reference:

```
"target": "es2022",
"types": [
    "vitest/globals"
]
```

5 - Create a file always named as your-test.e2e-spec.ts for testing the environment configuration: Example:

```
test('1 plus 1', () => {
  expect(1 + 1).toBe(2)
})
```