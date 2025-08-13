# Zod Introduction Course (Practical Guide)

A hands-on introduction to **Zod**, a TypeScript-first schema declaration and validation library. This introduction course is designed for real-world apps (React, React Native, Node/Nest/Express) and focuses on **robust typing**, **runtime validation**, and **clear error handling**.

---

## Table of Contents

- [Zod Introduction Course (Practical Guide)](#zod-introduction-course-practical-guide)
  - [Table of Contents](#table-of-contents)
  - [What is Zod \& When it’s Useful](#what-is-zod--when-its-useful)
  - [Core Concepts](#core-concepts)
  - [Typing \& Validating Environment Variables](#typing--validating-environment-variables)
  - [Handling Input Validation (Front‑end \& Back‑end)](#handling-input-validation-frontend--backend)
    - [Front-end (React) – Form validation without extra libs](#front-end-react--form-validation-without-extra-libs)
    - [Back-end (Express) – Request body validation middleware](#back-end-express--request-body-validation-middleware)
    - [Back-end (NestJS) – Guarding controllers with Zod](#back-end-nestjs--guarding-controllers-with-zod)
  - [Handling Response Errors (Shaping \& Surfacing)](#handling-response-errors-shaping--surfacing)
    - [1) Return a consistent error shape](#1-return-a-consistent-error-shape)
    - [2) Use it in controllers/handlers](#2-use-it-in-controllershandlers)
    - [3) Client-side: show inline errors](#3-client-side-show-inline-errors)
  - [Schemas You’ll Use Daily](#schemas-youll-use-daily)
  - [Composing, Transforming \& Refining](#composing-transforming--refining)
  - [Error Messages, Error Maps \& i18n](#error-messages-error-maps--i18n)
  - [Testing Zod Schemas](#testing-zod-schemas)
  - [Performance \& Best Practices](#performance--best-practices)
  - [Cheat Sheet](#cheat-sheet)
    - [General tips](#general-tips)

---

## What is Zod & When it’s Useful

**Zod** bridges **TypeScript types** with **runtime validation**. TypeScript types disappear at runtime; Zod keeps them **alive** with schemas you can **parse** against. You’ll use Zod when you need to:

- **Trust your inputs**: Validate **HTTP requests**, **forms**, **webhooks**, **CLI args**, **environment variables**, etc.  
- **Generate types from the source of truth**: `z.infer<typeof Schema>` gives you strongly-typed DTOs without duplication.  
- **Handle failures gracefully**: Map **field-level errors** to your UI or API responses in a consistent way.  
- **Evolve contracts safely**: Share schemas across **front-end & back-end** to ensure end-to-end type safety.  
- **Coercion/Transforms**: Accept flexible inputs (e.g., stringified numbers/dates) while keeping domain types strict.

---

## Core Concepts

```ts
import { z } from "zod";

// 1) Declare schemas
const User = z.object({
  id: z.string().uuid(),
  email: z.string().email(),
  name: z.string().min(2).max(100),
  age: z.number().int().nonnegative().optional(),
  roles: z.array(z.enum(["admin", "editor", "viewer"])).default(["viewer"]),
});

// 2) Parse (throws on error)
const user = User.parse({
  id: "8e1e1f1f-1234-4c4c-b6b6-7a7a7a7a7a7a",
  email: "john@doe.com",
  name: "John Doe",
});
// user is fully typed & validated

// 3) Safe parse (doesn't throw)
const result = User.safeParse({ id: "x", email: "bad", name: "" });
if (!result.success) {
  // result.error is ZodError (great for surfacing errors)
  console.log(result.error.format());
}

// 4) Infer TypeScript types from schema
type UserDTO = z.infer<typeof User>;
```

**Tip:** Use `safeParse` for request/response boundaries so you can send structured errors back.

---

## Typing & Validating Environment Variables

Environment variables are **untyped strings** by default. Zod lets you **coerce**, **validate**, and **export typed config** safely.

```ts
// env.ts
import { z } from "zod";

// Accepts values like "true"/"false"/"1"/"0" → boolean
const BoolFromString = z
  .string()
  .transform((s) => ["true", "1", "yes", "y"].includes(s.toLowerCase()));

const EnvSchema = z.object({
  NODE_ENV: z.enum(["development", "test", "production"]).default("development"),
  PORT: z.coerce.number().int().positive().default(3000),
  DATABASE_URL: z.string().url(),
  JWT_SECRET: z.string().min(16, "JWT_SECRET must be at least 16 chars"),
  ENABLE_DEBUG: BoolFromString.default("false"),
  // Optional with default
  CDN_BASE_URL: z.string().url().optional(),
});

const _raw = {
  NODE_ENV: process.env.NODE_ENV,
  PORT: process.env.PORT,
  DATABASE_URL: process.env.DATABASE_URL,
  JWT_SECRET: process.env.JWT_SECRET,
  ENABLE_DEBUG: process.env.ENABLE_DEBUG,
  CDN_BASE_URL: process.env.CDN_BASE_URL,
};

const parsed = EnvSchema.safeParse(_raw);

if (!parsed.success) {
  console.error("[env] Invalid environment variables");
  console.error(parsed.error.format());
  process.exit(1);
}

export const env = parsed.data;
export type Env = z.infer<typeof EnvSchema>;
```

Usage:

```ts
import { env } from "./env";

app.listen(env.PORT, () => {
  if (env.ENABLE_DEBUG) console.log("Debug mode ON");
});
```

**Why this matters**: You fail **fast** with a clear error when env vars are misconfigured, and you get **typed access** throughout the app.

---

## Handling Input Validation (Front‑end & Back‑end)

### Front-end (React) – Form validation without extra libs

```tsx
// ProfileForm.tsx
import { useState } from "react";
import { z } from "zod";

const ProfileSchema = z.object({
  name: z.string().min(2, "Name is too short"),
  email: z.string().email("Invalid email"),
  birthDate: z.coerce.date().max(new Date(), "Birth date cannot be in the future"),
});

type ProfileInput = z.infer<typeof ProfileSchema>;

export default function ProfileForm() {
  const [errors, setErrors] = useState<Record<string, string[]>>({});

  async function onSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    const form = new FormData(e.currentTarget);
    const data = {
      name: String(form.get("name") || ""),
      email: String(form.get("email") || ""),
      birthDate: String(form.get("birthDate") || ""),
    };
    const result = ProfileSchema.safeParse(data);

    if (!result.success) {
      setErrors(formatZodErrors(result.error));
      return;
    }

    // Success → submit to API
    await fetch("/api/profile", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(result.data),
    });
  }

  return (
    <form onSubmit={onSubmit} className="space-y-3">
      <input name="name" placeholder="Name" />
      {errors.name && <div className="text-red-500">{errors.name.join(", ")}</div>}

      <input name="email" placeholder="Email" />
      {errors.email && <div className="text-red-500">{errors.email.join(", ")}</div>}

      <input name="birthDate" type="date" />
      {errors.birthDate && (
        <div className="text-red-500">{errors.birthDate.join(", ")}</div>
      )}

      <button type="submit">Save</button>
    </form>
  );
}

// Utility to map ZodError → { [field]: string[] }
function formatZodErrors(err: z.ZodError) {
  const fieldErrors: Record<string, string[]> = {};
  const formatted = err.format();
  for (const key of Object.keys(formatted)) {
    if (key === "_errors") continue;
    const entry: any = (formatted as any)[key];
    const messages = entry?._errors as string[] | undefined;
    if (messages?.length) fieldErrors[key] = messages;
  }
  return fieldErrors;
}
```

### Back-end (Express) – Request body validation middleware

```ts
// validate.ts
import { z } from "zod";
import { RequestHandler } from "express";

export function validateBody<T extends z.ZodTypeAny>(schema: T): RequestHandler {
  return (req, res, next) => {
    const result = schema.safeParse(req.body);
    if (!result.success) {
      return res.status(400).json({
        message: "Validation failed",
        errors: result.error.flatten(),
      });
    }
    req.body = result.data; // now typed & sanitized
    next();
  };
}

// routes.ts
import express from "express";
import { z } from "zod";
import { validateBody } from "./validate";

const router = express.Router();

const CreateUser = z.object({
  email: z.string().email(),
  password: z.string().min(8),
  name: z.string().min(2),
});

router.post("/users", validateBody(CreateUser), async (req, res) => {
  // req.body is CreateUser type
  const user = await createUser(req.body);
  res.status(201).json(user);
});

export default router;
```

### Back-end (NestJS) – Guarding controllers with Zod

Nest typically uses `class-validator`, but you can use Zod with a custom pipe:

```ts
// zod.pipe.ts
import { PipeTransform, BadRequestException, ArgumentMetadata } from "@nestjs/common";
import { z, ZodTypeAny } from "zod";

export class ZodValidationPipe implements PipeTransform {
  constructor(private schema: ZodTypeAny) {}

  transform(value: unknown, _metadata: ArgumentMetadata) {
    const result = this.schema.safeParse(value);
    if (!result.success) {
      throw new BadRequestException({
        message: "Validation failed",
        errors: result.error.flatten(),
      });
    }
    return result.data;
  }
}

// user.controller.ts
import { Body, Controller, Post, UsePipes } from "@nestjs/common";
import { z } from "zod";
import { ZodValidationPipe } from "./zod.pipe";

const CreateUser = z.object({
  email: z.string().email(),
  password: z.string().min(8),
  name: z.string().min(2),
});
type CreateUserDTO = z.infer<typeof CreateUser>;

@Controller("users")
export class UserController {
  @Post()
  @UsePipes(new ZodValidationPipe(CreateUser))
  create(@Body() dto: CreateUserDTO) {
    return { ok: true, dto };
  }
}
```

---

## Handling Response Errors (Shaping & Surfacing)

Your API should return **predictable** error shapes so clients can render them easily.

### 1) Return a consistent error shape

```ts
// error.ts
import { z } from "zod";

export type ApiError = {
  message: string;
  code: string; // e.g., "VALIDATION_ERROR", "NOT_FOUND", "CONFLICT"
  fieldErrors?: Record<string, string[]>;
};

export function fromZodError(err: z.ZodError, message = "Validation failed"): ApiError {
  const fieldErrors: Record<string, string[]> = {};
  const formatted = err.format();
  for (const key of Object.keys(formatted)) {
    if (key === "_errors") continue;
    const entry: any = (formatted as any)[key];
    const msgs = entry?._errors as string[] | undefined;
    if (msgs?.length) fieldErrors[key] = msgs;
  }
  return { message, code: "VALIDATION_ERROR", fieldErrors };
}
```

### 2) Use it in controllers/handlers

```ts
import { fromZodError } from "./error";

const CreatePost = z.object({
  title: z.string().min(3),
  content: z.string().min(10),
});

app.post("/posts", (req, res) => {
  const result = CreatePost.safeParse(req.body);
  if (!result.success) {
    return res.status(400).json(fromZodError(result.error));
  }
  // ... proceed
});
```

### 3) Client-side: show inline errors

```ts
async function createPost(input: unknown) {
  const res = await fetch("/posts", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(input),
  });

  if (!res.ok) {
    const error: {
      message: string;
      code: string;
      fieldErrors?: Record<string, string[]>;
    } = await res.json();

    if (error.code === "VALIDATION_ERROR") {
      return { ok: false, fieldErrors: error.fieldErrors };
    }
    throw new Error(error.message);
  }

  return { ok: true, data: await res.json() };
}
```

**Tip:** Use `error.flatten()` for a quick `{ formErrors, fieldErrors }` shape:  
`const { fieldErrors, formErrors } = err.flatten();`

---

## Schemas You’ll Use Daily

```ts
import { z } from "zod";

// Primitive + constraints
const Id = z.string().uuid();
const Email = z.string().email();
const Password = z.string().min(8);

// Enums
const Role = z.enum(["admin", "editor", "viewer"]);
type Role = z.infer<typeof Role>;

// Dates & Numbers with coercion
const IsoDate = z.coerce.date(); // accepts string/number → Date
const Money = z.coerce.number().finite().nonnegative(); // "12.3" → 12.3

// Objects
const Address = z.object({
  street: z.string().min(3),
  city: z.string(),
  zip: z.string().min(5),
});

// Arrays & Sets
const Tags = z.array(z.string().min(1)).max(10).default([]);
const UniqueTags = z.set(z.string()).default(new Set());

// Discriminated unions (great for polymorphic inputs)
const Payment = z.discriminatedUnion("kind", [
  z.object({ kind: z.literal("pix"), key: z.string().min(3) }),
  z.object({ kind: z.literal("card"), brand: z.string(), last4: z.string().length(4) }),
]);

// Records & Maps
const FeatureFlags = z.record(z.string(), z.boolean()).default({});
```

---

## Composing, Transforming & Refining

```ts
import { z } from "zod";

// .transform → change shape but keep validation
const Slug = z
  .string()
  .min(1)
  .transform((s) => s.trim().toLowerCase().replace(/\s+/g, "-"));

// .refine → custom predicates
const StrongPassword = z.string().refine(
  (v) => /[A-Z]/.test(v) && /[a-z]/.test(v) && /\d/.test(v),
  "Password must include upper, lower, and number"
);

// .superRefine → access ctx for multi-field logic
const PasswordPair = z
  .object({
    password: StrongPassword,
    confirmPassword: z.string(),
  })
  .superRefine(({ password, confirmPassword }, ctx) => {
    if (password !== confirmPassword) {
      ctx.addIssue({
        code: z.ZodIssueCode.custom,
        message: "Passwords do not match",
        path: ["confirmPassword"],
      });
    }
  });

// Merge & Partial
const Base = z.object({ id: z.string().uuid() });
const Profile = z.object({ name: z.string(), avatarUrl: z.string().url().optional() });
const User = Base.merge(Profile);
const UserPatch = User.partial(); // all fields optional
```

**Note:** After `.transform`, use the **resulting type** inferred by `z.infer`. Don’t manually annotate — let Zod be the source of truth.

---

## Error Messages, Error Maps & i18n

Customize messages globally:

```ts
import { z, ZodErrorMap } from "zod";

const errorMap: ZodErrorMap = (issue, ctx) => {
  switch (issue.code) {
    case z.ZodIssueCode.invalid_type:
      return { message: `Expected ${issue.expected}, received ${issue.received}` };
    default:
      return { message: ctx.defaultError };
  }
};

z.setErrorMap(errorMap);
```

Or per-schema:

```ts
const PositiveInt = z.number({ invalid_type_error: "Must be a number" })
  .int("Must be an integer")
  .positive("Must be positive");
```

**i18n**: Map `ZodError` to your translation system keys before sending to the UI.

---

## Testing Zod Schemas

```ts
// user.test.ts (vitest/jest)
import { z } from "zod";

const User = z.object({
  email: z.string().email(),
  age: z.number().int().min(18),
});

test("valid user", () => {
  const r = User.safeParse({ email: "a@b.com", age: 20 });
  expect(r.success).toBe(true);
});

test("invalid user", () => {
  const r = User.safeParse({ email: "bad", age: 15 });
  expect(r.success).toBe(false);
  if (!r.success) {
    const { fieldErrors } = r.error.flatten();
    expect(fieldErrors.email?.[0]).toMatch(/Invalid email/i);
    expect(fieldErrors.age?.[0]).toMatch(/greater than or equal to 18/i);
  }
});
```

---

## Performance & Best Practices

- **Schema at module scope**: Define schemas once; avoid redefining in hot paths.  
- **Prefer `safeParse` at boundaries** (HTTP, env, CLI). Throwing is fine internally but return structured errors externally.  
- **Use coercion intentionally**: `z.coerce.number()` for query params; avoid over-coercing sensitive fields.  
- **Keep domain types central**: Export schemas and inferred types from a single module (e.g., `schemas/`).  
- **Validate on both sides when necessary**: UI for user feedback, API for security.  
- **Version schemas**: For breaking changes, create `v2` alongside `v1` during migrations.  
- **Avoid duplicated DTOs**: Use `z.infer` everywhere instead of hand-written interfaces.

---

## Cheat Sheet

```ts
// Build
z.string().min(1); z.number().int().positive(); z.boolean();
z.enum(["a","b"]); z.literal("ok"); z.nativeEnum(MyEnum);

// Objects / Arrays
z.object({ a: z.string() }); z.array(z.number()).min(1);
z.record(z.string(), z.number()); z.set(z.string());

// Dates & Coercion
z.date(); z.coerce.date(); z.coerce.number();

// Union / Intersection
z.union([A, B]); z.intersection(A, B);
z.discriminatedUnion("kind", [A, B]);

// Effects
schema.default(value); schema.optional(); schema.nullable();
schema.refine(fn, msg); schema.superRefine((val, ctx) => {...});
schema.transform((val) => newVal);

// Parsing
schema.parse(input); // throws
schema.safeParse(input); // { success, data | error }

// Types
type T = z.infer<typeof schema>;

// Errors
err.flatten(); err.format();
```

---

### General tips

- Use **Zod as the single source of truth** for your data shapes.  
- Always **surface validation errors** in a predictable JSON shape.  
- Start small: validate **env**, **requests**, **responses** — then grow into **shared schemas** across your app(s).

