
# TYPESCRIPT COURSE

## Concepts

- **Types**: Define the structure a variable, function, or object should follow.
- **Interface**: Similar to types, but they are extendable and meant to describe the shape of objects. Properties can’t be reassigned (readonly).
- **Generics**: Types passed as arguments to functions, classes, or interfaces to make them reusable.
- **Dynamic types**: Types assigned at runtime (JavaScript behavior).
- **Static types**: Types assigned at compile time (TypeScript behavior).
- **Type inference**: When TypeScript automatically infers the type of a variable.
- **Type assertions**: When you explicitly tell TypeScript the type of a variable.

## Main Types

### string

```ts
let phrase: string = 'I am a string';
```

### number

```ts
let x: number = 10;
```

### object

```ts
const person: {
  name: string;
  age: number;
  overname: string;
}
```

### array

```ts
let numbers: number[] = [1, 2, 3];
let words: string[] = ['word1', 'word2'];
```

### any

```ts
let a: any = 'anything';
```

### boolean

```ts
let a: boolean = true;
```

### union

```ts
function addOrConcat(a: number | string, b: number | string) {
  if (typeof a === 'number' && typeof b === 'number') return a + b;
  return `${a}${b}`;
}

addOrConcat(3, 4); // 7
addOrConcat('3', '4'); // '34'
```

### enum

```ts
enum Colors {
  Red,
  Green,
  Blue
}
```

### void

Used for functions that don’t return anything.

```ts
function logMessage(): void {
  console.log("This returns nothing.");
}
```

### tuple

```ts
const customerData: [number, string] = [1, 'Pablo'];
```

### null

Indicates an intentional absence of any value.

```ts
let value: null = null;
```

### undefined

Indicates a value not yet assigned.

```ts
let notDefined: undefined;
```

### unknown

A safer alternative to `any`. You must assert the type before use.

```ts
let x: unknown = 30;
const y = 50;
if (typeof x === 'number') console.log(x + y); // 80
```

### never

Used for functions that never return (e.g. error throwing).

```ts
function throwError(): never {
  throw new Error("Something went wrong!");
}
```

### literal

```ts
const a = 100; // a is literally 100, cannot be reassigned.
```

### alias

```ts
type Age = { age: number };
```

## Using Generics

```ts
function identity<T>(value: T): T {
  return value;
}

console.log(identity<number>(1));
console.log(identity<string>('1'));
```

## Using Tuples

```ts
const customerData: [string, number, ...string[]] = ['Pablo', 26, 'Married', 'M'];
customerData[0] = 'Camila';
customerData[1] = 25;
customerData[3] = 'F';
```

## Using Enums

```ts
enum CarLabels {
  Chevrolet = "Chevrolet",
  Toyota = "Toyota",
  Honda = "Honda"
}

function showLabel(label: CarLabels) {
  return label;
}

console.log(showLabel(CarLabels.Honda));
```

## Functions as Types

```ts
type MapString = (item: string) => string;

function mapString(initialArray: string[], callbackfn: MapString): string[] {
  return initialArray.map(callbackfn);
}

const abcMap = mapString(['a', 'b', 'c'], (item) => item.toUpperCase());
console.log(abcMap); // ['A', 'B', 'C']
```

## Creating and Using Interfaces

```ts
interface IUsers {
  name: string;
  email: string;
}

interface IMessages {
  subject: string[];
  body: string;
  attachment?: string[];
  options: {
    id: string;
    name: string;
  }[];
}

function sendMail(to: IUsers, message: IMessages) {
  console.log(`Email with subject ${message.subject.join(', ')} was sent to ${to.name}.`);
}
```

## Inheriting Interfaces

```ts
interface User {
  name: string;
  age: number;
}

interface UserWrapper {
  user: User;
}

const UserComponent: React.FC<UserWrapper> = (props) => {
  return (
    <>
      <strong>Name: {props.user.name}</strong>
      <strong>Age: {props.user.age}</strong>
    </>
  );
};
```

# Advanced TypeScript Tips

## Intersectioning Two Props

To intersect two or more props, use the `&` operator to create a new type:

```tsx
export type TextProps = {
  text: string;
};

export type TestStyleProps = {
  color?: string;
};

type IntersectionProps = TextProps & TestStyleProps;

const Text = ({ text, color }: IntersectionProps) => {
  return <h1 style={{ color }}>{text}</h1>;
};

export { Text };
```

## Creating Types for Functions

```ts
type FunctionType = {
  onDoAnyThing: (anyArg: GlobalObject) => void;
};
```

## Typing Functional Components

```tsx
type AppProps = { 
  title: string;
};

const App = ({ title }: AppProps) => <div>{title}</div>;

<App title="Hello from Typescript" />
```

## Typing HTML Elements

```tsx
import React, { SelectHTMLAttributes } from 'react';

interface SelectProps extends SelectHTMLAttributes<HTMLSelectElement> {
  label: string;
  name: string;
  options: Array<{ value: string; label: string }>;
}

const Select: React.FC<SelectProps> = ({ label, name, options, ...rest }) => (
  <div className="select-block">
    <label htmlFor={name}>{label}</label>
    <select id={name} {...rest}>
      <option value="" disabled hidden>
        Selecione uma opção
      </option>
      {options.map((option) => (
        <option key={option.value} value={option.value}>{option.label}</option>
      ))}
    </select>
  </div>
);
```

## Typing Events

```tsx
import React, { FormEvent, ChangeEvent } from 'react';

function handleSubmit(e: FormEvent) {
  e.preventDefault();
}

function handleNewMessage(e: ChangeEvent<HTMLInputElement>) {
  setMessage(e.target.value);
}
```

## Type Assertions

```ts
const body = document.querySelector('body') as HTMLBodyElement;
body.style.background = 'cyan';
```

## Pick, Omit and Partial

```ts
type TransactionProps = {
  id: number;
  title: string;
  amount: number;
  category: string;
  type: string;
  createdAt: string;
};

type TransactionInput = Pick<TransactionProps, 'title' | 'amount'>;

type TransactionOmit = Omit<TransactionProps, 'id' | 'createdAt'>;

type User = {
  name: string;
  email: string;
  created_at: string;
};

user: Model.extend<Partial<User>>({});
```

## Extending Native Props from Elements

```tsx
import { ReactElement, cloneElement } from 'react';
import Link, { LinkProps } from 'next/link';
import { useRouter } from 'next/router';

interface ActiveLinkProps extends LinkProps {
  children: ReactElement;
  route: string;
}

export default function ActiveLink({ route, children, ...rest }: ActiveLinkProps) {
  const { asPath } = useRouter();
  const currentRoute = asPath === rest.href ? route : '';
  return <Link {...rest}>{cloneElement(children, { currentRoute: route })}</Link>;
}
```

## Extending Third Libraries

```ts
import { Knex } from 'knex';

declare module 'knex/types/tables' {
  export interface Tables {
    transactions: {
      id: string;
      title: string;
      amount: number;
      created_at: string;
      session_id?: string;
    };
  }
}
```

## Optional Generic

Use Optional TypeScript Generic to allow using a property that is obligatory for the entity, but at the moment creation it can be informed or not.

```ts
type Optional<T, K extends keyof T> = Pick<T, K> & Omit<T, K>;

interface IUser {
  name: string;
  email: string;
  created_at: Date;
}

type userProps = Optional<IUser, 'created_at'>;
```

## Forcing Types

```ts
const { user_id } = <{ user_id: string }>request.headers;
// or
const { user_id } = request.headers as { user_id: string };
```

## Using Specific Literal Props

To use specific object props in interfaces you should to force the object as a const and pass the interface prop as a keyof typeof of the desired object. Ex:

```ts

const STATUS_COLOR = {
	green: "green-500",
	yellow: "yellow-500",
	red: "red-500",
} as const

interface StatusProps {
    statusColor: keyof typeof STATUS_COLOR;
}

export const Status = styled.span<StatusProps>
    &::before{
        content: '';
        width: 0.5rem;
        height: 0.5rem;
        background-color: ${(props) => 
          props.theme[STATUS_COLOR[props.statusColor]]};

    }

```

## Overwriting TypeScript Interfaces

1. Inside the src folder, create a new folder with your module name that you 
want to overwrite, example "express", and inside it a new file named  as 
index.d.ts.

2. Inside this file, declare the namespace and export the interface that you 
want to overwrite with a new prop. Example:

```ts
// src/express/index.d.ts
declare namespace Express {
  export interface Request {
    user: {
      id: string;
    };
  }
}
```

# General Tips and Best Practices

## Use Strong Typing for Functions and Objects

Always define types for functions, objects, and components. This makes the contract explicit and prevents errors.

```ts
function add(a: number, b: number): number {
  return a + b;
}
```

## When to Use `interface` vs `type`

- Use `interface` for working with external APIs and object-oriented patterns.
- Use `type` for internal component props and functional programming.

## Import Types When Used Across Files

When using a type or interface from a library or external module, explicitly import it:

```ts
import { Request, Response } from 'express';

export default {
  async index(req: Request, res: Response) {
    return res.json();
  }
}
```

## Handling Optional Interface Properties

Optional properties can be rendered conditionally:

```ts
interface User {
  name: string;
  age: number;
  email?: string;
}

<strong>Email: {user.email || 'No email provided'}</strong>
```

## Typing State with Arrays or Objects

When creating state variables for arrays or objects, type them properly:

```ts
const [users, setUsers] = useState<User[]>([]);
```

## Match Interface Fields with API Keys

Ensure that your TypeScript interfaces match exactly the structure of the API response, especially property names.

## `type` vs `interface` Design Philosophy

- `type` is more flexible and often used in functional programming.
- `interface` is ideal for class-based and OOP models.

## Combine Enums with Union Types

You can create union types using enums:

```ts
type Status = 'success' | 'error' | 'loading';
```

## Typing Async Functions

Always type async functions with `Promise`:

```ts
const firebaseSignIn = (): Promise<void> => {
  return firebase.auth().signInAnonymously();
}
```

## `target: es5` in tsconfig.json

Use `"target": "es5"` in `tsconfig.json` for maximum browser compatibility.

## Understanding Index Signatures

Index signatures allow you to type dynamic object keys:

```ts
interface StringMap {
  [key: string]: string;
}
```

## Use `extends` Only with Interfaces

```ts
interface A {
  name: string;
}

interface B extends A {
  age: number;
}
```

## Typing Components with `ElementType`

Use `ElementType` to type polymorphic components:

```ts
interface NavLinkProps {
  icon: ElementType;
}

<Icon as={icon} fontSize="20" />
```

## Typing `children` in Components

Use `ReactNode` or a specific type:

```ts
interface NavLinkProps {
  children: React.ReactNode;
}
```

## Typing Custom Hooks from Libraries

Many libraries export hook types. Use them:

```ts
import { UseFormRegister } from 'react-hook-form';
```

## Force Type with `as unknown as`

```ts
const user = newUser() as unknown as UserProps;
```

## `noImplicitAny` in tsconfig.json

Set `"noImplicitAny": false` if dealing with poorly typed libraries.

## Use `keyof typeof` to Mirror Object Keys

```ts
const STATUS_COLORS = {
  success: 'green',
  error: 'red',
} as const;

interface StatusProps {
  status: keyof typeof STATUS_COLORS;
}
```

## Derive Type from Function Return

```ts
function createProduct(product: IProduct) {
  return {
    type: 'ADD_PRODUCT',
    payload: product,
  };
}

type ProductAction = ReturnType<typeof createProduct>;
```

## Nullish Coalescing (`??`)

Use `??` to provide default values for possibly `null` or `undefined` variables:

```ts
const value = response.data ?? 'Default Value';
```

## Logical OR (`||`)

Use `||` for falsy values (e.g., empty string, 0):

```ts
const label = user.name || 'Guest';
```

## Double Negation (`!!`)

Use `!!` to convert a value to boolean:

```ts
const isValid = !!user.email;
```

## Optional Generics

Use optional generics to make specific props optional:

```ts
type Optional<T, K extends keyof T> = Omit<T, K> & Partial<Pick<T, K>>;
```

## Overwriting Native Interfaces (e.g., Express)

```ts
// src/@types/express/index.d.ts
declare namespace Express {
  export interface Request {
    user: {
      id: string;
    };
  }
}
```
