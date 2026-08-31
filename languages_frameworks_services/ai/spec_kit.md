# Spec Kit

Spec Kit is a toolkit for **Spec-Driven Development (SDD)**. Instead of asking an AI agent to start coding immediately, you first describe the project's rules, the feature requirements, the technical approach, and the work breakdown. The agent then implements code based on those documents.

## Workflow Order

| Order | Command | Main File or Output | Purpose |
| --- | --- | --- | --- |
| 1 | `/speckit.constitution` | `.specify/memory/constitution.md` | Define rules that guide every feature and implementation decision. |
| 2 | `/speckit.specify` | `specs/001-todo-list/spec.md` | Define **what** the feature must do and **why** it is needed. |
| 3 | `/speckit.plan` | `specs/001-todo-list/plan.md` | Define **how** the feature will be built technically. |
| 4 | `/speckit.tasks` | `specs/001-todo-list/tasks.md` | Turn the plan into ordered, actionable work items. |
| 5 | `/speckit.implement` | Application source code and tests | Execute the tasks and build the working feature. |

`001-todo-list` is an example feature directory name. The implementation step does not normally create an `implement.md` file; it reads the previous artifacts and edits the real project files.

## Example: Todo-List App

Imagine that we want to create a small application where a user can add, complete, and delete tasks.

### 1. Constitution: Project Rules

The constitution contains permanent principles that the whole project should respect.

**File:** `.specify/memory/constitution.md`

```md
# Todo List Constitution

- Keep the interface simple and accessible.
- Store user tasks locally; no account is required.
- Add tests for task creation, completion, and deletion.
- Do not introduce a dependency unless it clearly simplifies the app.
```

The constitution is not the description of one feature. It is the project's set of rules, so future features must also follow it.

### 2. Specify: Feature Requirements

The specification describes the desired behavior without deciding technical details too early.

**File:** `specs/001-todo-list/spec.md`

```md
# Todo List Feature

## User Stories
- As a user, I can add a task so that I remember what I need to do.
- As a user, I can mark a task as completed.
- As a user, I can delete a task I no longer need.

## Acceptance Criteria
- A task cannot be empty.
- Completed tasks remain visible with a completed appearance.
- Deleted tasks no longer appear in the list.
```

At this stage, the focus is on **what the user needs**, not on React components, databases, or APIs.

### 3. Plan: Technical Decisions

The plan transforms the requirements into an architecture and implementation approach.

**File:** `specs/001-todo-list/plan.md`

````md
# Implementation Plan

- Use React with TypeScript and Vite.
- Store tasks in browser localStorage.
- Represent each task as: id, title, completed.
- Build TodoForm, TodoList, and TodoItem components.
- Use Vitest and Testing Library for automated tests.

## Expected Project Architecture

```text
src/
  App.tsx
  components/
    TodoForm.tsx
    TodoItem.tsx
    TodoList.tsx
  services/
    taskStorage.ts
  types/
    task.ts
tests/
  todo-list.test.tsx
```
````

This file answers **how the app will work technically** and what project structure is expected, while checking that the decisions follow the constitution.

### 4. Tasks: Ordered Work

The tasks file converts the plan into steps that can be executed and checked.

**File:** `specs/001-todo-list/tasks.md`

```md
# Tasks

- [ ] T001 Set up the React and TypeScript application.
- [ ] T002 Create the Task type in src/types/task.ts.
- [ ] T003 Create localStorage helpers in src/services/taskStorage.ts.
- [ ] T004 Write tests for adding, completing, and deleting tasks.
- [ ] T005 Implement TodoForm, TodoList, and TodoItem components.
- [ ] T006 Connect persistence and user interactions in src/App.tsx.
- [ ] T007 Run tests and verify the acceptance criteria.
```

Tasks are ordered so foundational work is completed before code that depends on it.

### 5. Implement: Working Code

Run `/speckit-implement`. The implementation command reads the constitution, specification, plan, and tasks, then creates or modifies the actual application files.

**Example output files:**

```text
src/
  App.tsx
  components/TodoForm.tsx
  components/TodoItem.tsx
  components/TodoList.tsx
  services/taskStorage.ts
  types/task.ts
tests/
  todo-list.test.tsx
```

At the end of this stage, the app should satisfy the acceptance criteria from `spec.md` and follow the rules from `constitution.md`.

## Example: Back-End User CRUD API

Imagine that we want to build a back-end API where clients can create, read, update, and delete users.

### 1. Constitution: API Rules

The constitution defines rules that every back-end feature should respect.

**File:** `.specify/memory/constitution.md`

```md
# Back-End API Constitution

- Validate all request data before storing it.
- Never expose user passwords or internal security fields in responses.
- Return consistent HTTP status codes and JSON error formats.
- Add automated tests for endpoints and authorization rules.
```

### 2. Specify: CRUD Requirements

The specification defines the user CRUD behavior from a client's point of view.

**File:** `specs/002-user-crud-api/spec.md`

```md
# User CRUD API

## User Stories
- As a client, I can create a user with a name and unique email.
- As a client, I can retrieve one user or a list of users.
- As a client, I can update a user's name or email.
- As an administrator, I can delete a user.

## Acceptance Criteria
- Creating a user with an invalid or duplicate email fails.
- Retrieving a missing user returns a not-found response.
- Updating a user validates the new values.
- Deleting a user removes it from later retrieval results.
- Responses never include a password hash.
```

### 3. Plan: Technical Decisions

The plan decides the API routes, persistence, validation, and test approach.

**File:** `specs/002-user-crud-api/plan.md`

````md
# Implementation Plan

- Use Node.js, TypeScript, Express, and PostgreSQL.
- Use Prisma to model and access the User table.
- Expose POST, GET, PATCH, and DELETE routes under /users.
- Validate request bodies with Zod.
- Protect DELETE /users/:id with administrator authorization middleware.
- Test the service and HTTP endpoints with Vitest and Supertest.

## Expected Project Architecture

```text
prisma/
  schema.prisma
  migrations/
src/
  controllers/
    userController.ts
  middleware/
    requireAdmin.ts
  repositories/
    userRepository.ts
  routes/
    userRoutes.ts
  schemas/
    userSchema.ts
  services/
    userService.ts
tests/
  userRoutes.test.ts
  userService.test.ts
```
````

### 4. Tasks: Ordered Work

The tasks file identifies the implementation sequence for the API.

**File:** `specs/002-user-crud-api/tasks.md`

```md
# Tasks

- [ ] T001 Define the User database model and migration.
- [ ] T002 Create request and response validation schemas.
- [ ] T003 Write repository and service tests for user CRUD behavior.
- [ ] T004 Implement the user repository and service layer.
- [ ] T005 Write endpoint tests for status codes and response data.
- [ ] T006 Implement the /users routes and controller.
- [ ] T007 Add authorization middleware to user deletion.
- [ ] T008 Run migrations, automated tests, and API acceptance checks.
```

### 5. Implement: Back-End Files

Run `/speckit-implement` to implement all steps builds the API and tests by following the preceding artifacts.

**Example output files:**

```text
prisma/
  schema.prisma
  migrations/
src/
  controllers/userController.ts
  middleware/requireAdmin.ts
  repositories/userRepository.ts
  routes/userRoutes.ts
  schemas/userSchema.ts
  services/userService.ts
tests/
  userRoutes.test.ts
  userService.test.ts
```

At the end of this stage, API clients should be able to execute the four CRUD operations while validation, safe responses, and authorization follow the project's constitution.

## Summary

1. **Constitution** defines the project's rules.
2. **Specify** defines the user's required behavior.
3. **Plan** defines the technical solution.
4. **Tasks** defines the ordered implementation checklist.
5. **Implement** produces and tests the working application code.

---

#ai #spec-driven-development #concepts

**Reference:** [GitHub Spec Kit](https://github.com/github/spec-kit)

**Related:** [[prompt_engineering]] | [[chatbots]]
