# GITHUB ACTIONS 

GitHub Actions is a framework to run custom workflows for software development, reducing CI complexity.

**Continuous Integration (CI)** is the practice of frequently checking the code repository and validating code every time it's merged or pushed. Some tasks may be executed automatically, such as tests or deployment.

Example with Gradle:

- `./gradlew lint`: checks bugs and potential improvements related to correctness, security, performance  
- `./gradlew test`: executes all unit tests in the project  
- `./gradlew assemble`: builds all archives in the project

---

## DEFINING WORKFLOWS 

Workflows are created as YAML files. You must define:

- When the code should run  
- What environment it runs in  
- What tasks (jobs) it will execute

### Step 1

Create a new folder in your project root:

`.github/workflows`

> Note: This is a special folder recognized by GitHub.

---

### Step 2

Inside this folder, create a file with `.yml` extension:  
Example:

`.github/workflows/deploy.yml`

---

### Step 2.1

Provide a name for your workflow:

`name: Android Build`

---

### Step 2.2

Define when the workflow runs:

`on: pull_request`

---

### Step 2.3

Define the jobs to be executed:

`name: Android Build`  
`on: pull_request`  
`jobs:`  
&nbsp;&nbsp;`build:`  
&nbsp;&nbsp;&nbsp;&nbsp;`runs-on: ubuntu-latest`  
&nbsp;&nbsp;&nbsp;&nbsp;`steps:`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- uses: actions/checkout@v1`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- name: Set Up JDK`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`uses: Set Up JDK`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`with:`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`java-version: 1.8`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- name: Run Tests`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`run: ./gradlew test`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- name: Build Project`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`run: ./gradlew assemble`

---

### Step 3

Commit and push your changes. GitHub Actions will trigger automatically.

Go to the **"Actions"** tab on your repository to track status.

---

## CIs EXAMPLES

### Unit Test CI

`name: Run Unit Tests`  
`on: [push]`  
`jobs:`  
&nbsp;&nbsp;`run-unit-tests:`  
&nbsp;&nbsp;&nbsp;&nbsp;`name: Run Unit Tests`  
&nbsp;&nbsp;&nbsp;&nbsp;`runs-on: ubuntu-latest`  
&nbsp;&nbsp;&nbsp;&nbsp;`steps:`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- uses: actions/checkout@v3`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- uses: actions/setup-node@v3`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`with:`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`node-version: 18`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`cache: 'yarn'`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- run: yarn`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- run: yarn test:unit`

---

### End-to-End Test CI

`name: Run E2E Tests`  
`on: [pull_request]`  
`jobs:`  
&nbsp;&nbsp;`run-e2e-tests:`  
&nbsp;&nbsp;&nbsp;&nbsp;`name: Run E2E Tests`  
&nbsp;&nbsp;&nbsp;&nbsp;`runs-on: ubuntu-latest`  
&nbsp;&nbsp;&nbsp;&nbsp;`services:`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`postgres:`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`image: bitnami/postgresql`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`ports:`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- 5432:5432`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`env:`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`POSTGRESQL_USERNAME: docker`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`POSTGRESQL_PASSWORD: docker`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`POSTGRESQL_DATABASE: ignite-gym-db`  
&nbsp;&nbsp;&nbsp;&nbsp;`steps:`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- uses: actions/checkout@v3`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- uses: actions/setup-node@v3`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`with:`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`node-version: 18`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`cache: 'yarn'`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- run: yarn`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`- run: yarn test:e2e`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`env:`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`JWT_SECRET: testing`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`DATABASE_URL: "postgresql://docker:docker@localhost:5432/ignite-gym-db?schema=public"`

---

##  GENERAL TIPS 

- Every workflow must contain at least one job. 
- You can use **GitHub-hosted** or **self-hosted** runners  
- If you're using `yarn`, all CI commands should use `yarn`. If using `npm`, use `npm` consistently.