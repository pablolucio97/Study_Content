
# Clean Code Principles

## 1) Use Meaningful Names

### Variables:
```javascript
let camelCase = '';
```

### Constants:
```javascript
const DAYS_IN_A_YEAR = 365;
```

### Functions:
```javascript
const getUserBankData = () => {
    // do something
}
```

### Classes:
```javascript
class Car {
    // ...
}
```

## 2) Avoid Large Functions

Functions should be short and perform a single action.

### Bad Practice:
```javascript
const addSub = (a, b) => {
    // add
    const addition = a + b;
    // sub
    const sub = a - b;
    // returning as a string
    return \`${addition}${sub}\`;
}
```

### Good Practice:
```javascript
// add
const add = (a, b) => {
    return a + b;
}
// sub
const sub = (a, b) => {
    return a - b;
}
```

## 3) Avoid Comments

Use comments only when extremely necessary. Code should be readable and self-explanatory.

## 4) Avoid Deep Nesting

### Bad Practice:
```javascript
const array = [ [ ['Shoaib Mehedi'] ] ];
array.forEach((firstArr) => {
    firstArr.forEach((secondArr) => {
        secondArr.forEach((element) => {
            console.log(element);
        });
    });
});
```

### Good Practice:
```javascript
const array = [ [ ['Shoaib Mehedi'] ] ];
const getValuesOfNestedArray = (element) => {
    if (Array.isArray(element)) {
        return getValuesOfNestedArray(element[0]);
    }
    return element;
}
getValuesOfNestedArray(array);
```

## 5) Don't Repeat Yourself (DRY)

Functions should not be repetitive.

### Bad Practice:
```javascript
// Same as the bad practice in section 4
```

### Good Practice:
```javascript
// Same as the good practice in section 4
```

## 6) Don't Use Magic Numbers

### Bad Practice:
```javascript
for (let i = 0; i < 50; i++) {
    // do something
}
```

### Good Practice:
```javascript
let NUMBER_OF_STUDENTS = 50;
for (let i = 0; i < NUMBER_OF_STUDENTS; i++) {
    // do something
}
```

# General Tips

- Use descriptive names for variables and functions.
- Use nouns in PascalCase when declaring classes.
- Use snake and uppercase when declaring constants.
- Use verbs in camelCase when declaring functions.
