# Spec Driven Development (SDD) and Spec Kit

## Concepts

### Spec Driven Development (SDD)

Spec Driven Development (SDD) is a software development approach where the specification, not the code, is the source of truth. The spec states **what** the software must do and **why**, in terms of user-visible behavior and acceptance criteria. It deliberately leaves out **how** the software is built: no stack, no framework, no architecture, no file layout.

The "how" is decided later, in a separate planning step, and it is treated as a replaceable implementation of a stable intent. Code is the derived artifact: when the intent changes, the spec changes first and the implementation is regenerated or adjusted to match it, instead of the spec being rewritten afterwards to document whatever the code ended up doing.

This separation is the whole point. If technical decisions leak into the spec, the intent and one possible solution become entangled, and there is no longer a stable answer to "what should this do?" when the stack changes.

SDD is worth the overhead on features that are complex or ambiguous, where stakeholders, developers, and testers need a single shared definition of done, and (with AI agents) it avoids burning tokens on an agent that starts coding before the goal is agreed.

### Spec Kit

Spec Kit is a toolkit for **Spec-Driven Development (SDD)**. Instead of asking an AI agent to start coding immediately, you make the intent explicit first and only then the solution: the project's rules (constitution), the feature's required behavior (specify), the technical approach (plan), and the work breakdown (tasks). The agent then implements code based on those documents.

The command order encodes the what-before-how rule: the `spec.md` template is written to keep implementation details out and to flag anything ambiguous instead of guessing it, and `/speckit.plan` is where the technical decisions belong.

### Executable Spec

An executable spec is **not** a spec that runs in a test runner. It means the spec is precise, unambiguous, and complete enough that an implementation can be generated directly from it: an agent reads the spec and produces working code, so the document "executes" by becoming software instead of sitting next to it as documentation.

The practical test is whether a reader (human or agent) could build the feature from the spec alone and arrive at something that satisfies every acceptance criterion, without asking what was meant. Vague requirements ("the list should be fast", "handle errors gracefully") are the failure mode, because they force the implementer to invent the requirement.

This is different from the BDD sense of "executable specification" (Gherkin scenarios wired to step definitions and run as tests), even though both push toward testable, behavior-level statements.

## Anatomy of a Good Spec

A spec that an agent can implement has five parts:

| Part | Answers | Example |
| --- | --- | --- |
| **Goal (what and why)** | Which real problem does this solve, and for whom? | "Let the user see how much they spent this month, so they can decide whether they can afford a large purchase." |
| **Scope and out of scope** | Which boundaries must the work not cross? | In: monthly total. Out: budgets, categories, export. |
| **Functional requirements** | What does the system *do*? | "The user can record a transaction with date, description, amount, and type." |
| **Non-functional requirements** | *How* must the system behave while doing it? | "The listing responds in under 300 ms with 10,000 records." |
| **Acceptance criteria** | How do we know it is done? | "`POST /transactions` with amount `0` returns `422`." |

Functional requirements are capabilities; non-functional requirements are constraints on performance, security, persistence, usability, and similar qualities. Both belong in the spec, because both are demanded by the problem rather than chosen by the implementer.

### Acceptance Criteria Are Not a "How" Leak

Acceptance criteria may name an endpoint, a status code, or a persisted outcome without breaking the what-before-how rule, because those are the system's observable contract, not its internal design. "Returns `422` for a zero amount" is verifiable behavior; "validates with a `TransactionValidator` class" is a design decision that belongs to the implementer.

## Common Pitfalls When Writing a Spec

### 1. The Spec Is Implementation in Disguise

The most common beginner mistake. When the spec decides the *how*, it takes from the agent exactly the work the agent is good at.

- ❌ `Create a GET /summary endpoint that reads a MonthSummary DTO from the TransactionRepository.`
- ✅ `The user can see how much they spent in the current month.`

**Antidote — the "why this way?" test:** if the answer is *"because the business requires it"*, it is spec. If the answer is *"because I like it this way"*, it is code, and the decision belongs to the implementer. Class names, function and variable names, folder structure, algorithm choice, and data-structure choice all fail this test.

### 2. Adjectives Instead of Numbers

An adjective sounds like a requirement but cannot be verified. Nobody can fail a build for not being "fast".

- ❌ `The listing must be fast.`
- ✅ `The listing responds in under 300 ms with 10,000 records.`

**Antidote:** every quality adjective becomes a number or gets deleted. If no number can be defended, the requirement was not real.

### 3. Only the Happy Path

The spec describes what happens when everything works, and leaves the agent to invent the rest, which it will.

**Antidote:** for each behavior, state what happens on invalid input, on a resource that does not exist, and when an external service is down. Error behavior is behavior, so it is specified, not discovered.

### 4. The Spec Is Too Big

A spec that covers the whole product cannot be verified, delivered, or rejected as a unit.

**Antidote:** one spec per increment, not per product. If the acceptance criteria cannot all be checked at the end of one cycle, split the spec.

### 5. No "Out of Scope" Section

This is not a formality. Without it, the increment grows on its own: the agent (or the team) sees an adjacent gap, assumes it belongs to the work, and mixes in effort that was never part of this cycle.

**Antidote:** name the adjacent features explicitly and mark them as out. The nearer a feature is to the current work, the more it needs to be listed.

### 6. Silent Ambiguity

Pronouns and relative terms read fine to the author, who already knows the answer, and read as a coin flip to everyone else: *it*, *the same*, *appropriate*, *as needed*, *similar to the previous one*.

**Antidote:** reread the spec hunting specifically for pronouns and relative terms, and replace each one with the explicit noun or value.

### 7. Glued Requirements

Two requirements on one line cannot be accepted or rejected separately, so a half-correct implementation has no clear verdict.

- ❌ `The user can register and edit transactions, and the system validates the amount.`
- ✅ One line per requirement: register, edit, validate.

**Antidote:** one requirement per line.

## The Golden Rule

**If a new person on the team can implement the feature by reading only the spec, without asking anyone anything, then the agent can too.**

Treat the agent as a competent developer who just joined and has no context beyond the document. Every question they would have to ask is a gap in the spec. A spec that passes this test is also genuinely useful for onboarding real people.

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

The specification describes the desired behavior. Technical details are not merely postponed here, they are out of scope for this document.

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
2. **Specify** defines **what** the feature must do and **why**, with no technical decisions.
3. **Plan** defines **how** that behavior will be built.
4. **Tasks** defines the ordered implementation checklist.
5. **Implement** produces and tests the working application code.

---

#ai #spec-driven-development #concepts

**Reference:** [GitHub Spec Kit](https://github.com/github/spec-kit)

**Related:** [[prompt_engineering]] | [[chatbots]]
