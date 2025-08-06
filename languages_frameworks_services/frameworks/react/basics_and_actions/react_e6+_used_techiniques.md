# 📘 Most Used React ES6+ Techniques

This guide lists the most commonly used ES6+ techniques in React development that make your code cleaner and more expressive.

---

## 1. ✅ Conditional Rendering

Used to render content conditionally based on logic.

```jsx
{isLoggedIn ? <Dashboard /> : <Login />}
{items.length > 0 && <ItemList items={items} />}
```

---

## 2. ✅ Spread Operator (Objects)

Used to copy or extend object properties.

```jsx
const user = { name: "John", age: 30 };
const updatedUser = { ...user, age: 31 };
```

---

## 3. ✅ Spread Operator (Arrays)

Used to copy or merge arrays.

```jsx
const numbers = [1, 2, 3];
const moreNumbers = [...numbers, 4, 5];
```

---

## 4. ✅ Destructuring (Objects)

Extract values from objects.

```jsx
const user = { name: "Alice", age: 25 };
const { name, age } = user;
```

---

## 5. ✅ Destructuring (Arrays)

Extract values from arrays.

```jsx
const [first, second] = [10, 20, 30];
```

---

## 6. ✅ Merging Objects

Useful in reducers or when updating state.

```jsx
const state = { count: 1, loading: false };
const newState = { ...state, loading: true };
```

---

## 7. ✅ Optional Chaining

Safely access deeply nested properties.

```jsx
const name = user?.profile?.name;
```

---

## 8. ✅ Nullish Coalescing

Fallback only if null or undefined (not false or 0).

```jsx
const title = userInput ?? "Default Title";
```

---

## 9. ✅ Template Literals

Embed expressions in strings.

```jsx
const greeting = `Hello, ${name}!`;
```

---

## 10. ✅ Arrow Functions

Shorter syntax for functions, especially in props or callbacks.

```jsx
const handleClick = () => {
  console.log("Clicked!");
};
```

---

## 11. ✅ Shorthand Property Names

Use property name directly when it matches the variable.

```jsx
const name = "John";
const user = { name };
```

---

## 12. ✅ Ternary Operator

Short `if/else` expression for rendering.

```jsx
const content = isLoading ? <Spinner /> : <Content />;
```

---

## 13. ✅ Logical && Operator

Render something only when condition is true.

```jsx
{isVisible && <Modal />}
```

---

## 14. ✅ Default Parameters

Provide default values for function parameters.

```jsx
function greet(name = "Guest") {
  return `Hello, ${name}`;
}
```

---

## 15. ✅ Dynamic Object Keys

Build objects with keys defined at runtime.

```jsx
const key = "role";
const user = { [key]: "admin" };
```
