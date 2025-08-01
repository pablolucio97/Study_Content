## CONFIGURING TESTS COVERAGE

Coverage is useful to show you all your tests coverage info.

### 1. Install the coverage plugin

Run the following command to install the required plugin:

```bash
yarn add @vitest/coverage-v8
```

### 2. Create the script for generating coverage

Add the following to your `package.json` scripts section:

```json
"test:coverage": "vitest run --coverage"
```

### 3. Ignore the coverage folder in your `.gitignore`

Make sure to add this line to your `.gitignore`:

```
coverage/
```
