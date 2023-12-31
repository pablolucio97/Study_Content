# ECMAScript most used features

## Arrow Functions

Arrow functions allow the use of `this` from the outside scope within class properties.

- **Syntax**: The curly braces denote the body of the function, while parentheses are used for returning multiple lines and objects.
- **Single Parameter**: Parentheses, return statement, and braces are optional for single parameters.

**Example**:
```javascript
const myArray = [1, 2, 3, 4, 5, 6];
arrayResult = myArray.map(item => item * 2)
                     .filter(item => item < 5);
console.log(arrayResult);
```

## Destructor
Destructuring is a convenient way to extract data from objects and arrays.

```javascript
const myAdress = {
    street: 'Street One',
    number: 57,
    uf_city: {
        uf: 'Texas',
        city: 'Cansas'
    }
};

const {street, number} = myAdress;
```

## Rest operator

The rest operator (...) captures the remaining elements in an array.

```javascript
const myArray = [1, 2, 3, 4, 5, 6];
[a, b, ...c] = myArray;   
```

## Object shorthand syntax

 If an object's property name matches its value, use the shorthand syntax. Example: 
```javascript 
const propName = 'name';
const person = { name: 'Alice', age: 30 };
// Accessing property using a variable
const value = person[propName]; // Returns 'Alice'
```

## General Tips
- The keyword `this` refers to the current scope.
- Spread operators are used after = and rest operators before. 
- If an object's property name matches its value, use the shorthand syntax.
- For arrow functions, use () to return HTML content and {} for JavaScript code.
- Use && for mandatory actions if the first condition is true (ternary shortcut).
- Use {} for object destructuring and [] for array and string destructuring.
- Return statements are needed inside {} in arrow functions.
- Use ?? (Nullish coalescing operator) to return the right-hand operand when the left is null or undefined.
- Use !! operator to convert a value in boolean. By default in Javascript the values  `0`, `ull`, `undefined`, `NaN`, and `""` are all falsy, everything is different from these, are truthy. Examples:

```javascript
const value = "Hello World!";
const isTruthy = !!value; // true
``````
