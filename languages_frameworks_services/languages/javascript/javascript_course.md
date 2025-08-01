
# JAVASCRIPT COURSE

## INSTRUCTIONS AND DECLARATIONS

- **var**: Declares a variable.
- **let**: Declares a variable that can be used only in the local scope.
- **const**: Declares an immutable constant.
- **function**: Declares a function.
- **return**: Specifies the return value of a function.
- **async function**: Declares an asynchronous function.
- **class**: Declares a class.
- **for**: Creates a loop that runs an index and returns an action based on this index.
- **for if**: Iterates through the key and value of the array.
- **for of**: Iterates through the array elements without an index.
- **while**: Runs a loop of execution while the condition is true.
- **do while**: Runs a loop of execution until the condition becomes false.
- **if else**: Executes an instruction if the condition is true and another otherwise.
- **throw**: Creates a new constraint (error).
- **switch**: Executes different instructions according to a specific value.
- **break**: Finishes the current loop or switch and moves to the next case.
- **continue**: Skips the current loop and continues to the next iteration.
- **try catch**: Tries to execute a code block and catches an error otherwise.
- **import**: Imports a function, class, object, or others already exported.
- **export**: Prepares a function, class, object, or others to be imported.

## CONCEPTS

### Call Stack
The call stack determines how and when the JavaScript engine stacks, executes, and removes functions. It starts and ends empty. Functions are executed from top to bottom and are removed from the stack after execution.

### Closure
Closures are functions inside other functions that can access variables of their parent function.

```javascript
function storeMessage () {
   var msg = 'Hello World'
   function displayMessage(){
     return console.log(msg)
   }
}
```

#### Wrong use of a closure:
```javascript
for(var i = 0; i < elements.length; i++){
  elements[i].onclick = function(){
    alert('This is the element' + i)
  }
}
// Always returns the value of elements.length
```

#### Correct use of a closure:
```javascript
for(var i = 0; i < elements.length; i++){
  (function(i){
    elements[i].onclick = function(){
      alert('This is the element' + i)
    } 
  })(i)
}
// Returns each iteration of i allowing the function access to i.
```
---

## `this` Keyword

The `this` keyword is the value of a function that relies on the context where it's called.  
In the web, `this` points to the `window` object by default and to the own object or function when bound to it.

```js
() => console.log(this === window) // true
```

---

### `this` with Common Functions

```js
const body = document.getElementsByTagName('body')[0]

function function1() {
  body.onclick = function() {
    console.log(this === window) // false
  }
}

function function2() {
  body.onclick = function() {
    console.log(this === body) // true
  }
}
```

---

### `this` with Arrow Functions

```js
const body = document.getElementsByTagName('body')[0]

() => body.onclick = () => console.log(this === window) // true
() => body.onclick = () => console.log(this === body) // false
```

---

### `this` in Objects

```js
const player = {
  name: 'Paul',
  sayName() {
    console.log(this.name)
  }
}

player.sayName() // 'Paul'
```

> ❗ The `this` never varies when used in arrow functions.  
> ⚠️ In strict mode, the global `this` is not recognized inside functions. (`'use strict'` is enabled by default)

---

## `bind()`

The `bind` method binds a function to the value of another object.  
Useful to force `this` to refer to an instanced object instead of the window.

```js
const person = {
  salutation: 'Good morning',
  talks() {
    console.log(this.salutation)
  }
}

const talksOfPerson = person.talks.bind(person)
talksOfPerson() // 'Good morning'
```

---

## `apply()` vs `call()`

- `apply()` receives an array of arguments.  
- `call()` receives arguments separately.

```js
const player = {
  name: 'Sonic',
  speed: 90,
  agility: 50,
  showAttributes: function() {
    console.log(`${this.name} has ${this.speed} speed and ${this.agility} agility.`)
  }
}

const changeAttributes = function(speed, agility) {
  this.speed += speed;
  this.agility += agility;
  this.showAttributes();
}

changeAttributes.apply(player, [95, 55])
// OR
// changeAttributes.call(player, 95, 55)
```
---

## Currying

Calling functions inside functions to reduce code repetition:

```js
const calcPrice = (price) => (discount) => price - price * (discount / 100)

console.log(`Your discount: R$ ${calcPrice(100)(5)}`) // 95
```

---

## Hoisting

Hoisting is the process of moving variable declarations to the top of the scope.  
Only happens with `var`. Avoid hoisting issues using `const` or `let`.

---

## Prototype

In JavaScript, object and function inheritance is done through prototypes.  
The prototype is the parent class from which new instances inherit.  
**Prototype Chain** is the path used to resolve attributes and methods.

---

## High Order Functions

High order functions are functions that receive another function as a parameter and return a function.  
Examples: `filter`, `reduce`, `map`, etc.

```js
const higherOrder = whoStrikesBack => whoStrikesBack()
```

---

## First Order Functions

First order functions do not call other functions.

```js
const firstOrder = () => console.log('First order strikes back!')
```

---

## Pure Functions

Pure functions do not affect the global scope, and their result depends only on the provided arguments.

```js
function sum(a, b) {
  return a + b
}

product.map(p => console.log(p))
```

---

## Unary, Binary, and Ternary Functions

These are named based on the number of arguments they accept.

```js
const unaryFunction = message => console.log(message)
const binaryFunction = (color, message) => console.log(color, message)
const ternaryFunction = (size, color, message) => console.log(size, color, message)
```

---

## Duck Typing

Duck typing occurs when different objects share the same method.

```js
['abc', ['a', 'b']].forEach(el => console.log(el.indexOf('a')))
```

Here we use:
- `String.prototype.indexOf`
- `Array.prototype.indexOf`

---

## Recursive Functions

Recursive functions are functions that call themselves.

```js
function calcFatorial(n) {
  return (n !== 1) ? n * calcFatorial(n - 1) : 1;
}
```

---

# Data Types

```js
var length = 16;                               // Number
var lastName = "Johnson";                      // String
var x = { firstName: "John", lastName: "Doe" }; // Object
var cars = ["Saab", "Volvo", "BMW"];           // Array
```

---

## The `typeof` Operator

```js
typeof "John"                  // "string"
typeof 314                     // "number"
typeof 3.14                    // "number"
typeof (3 + 4)                 // "number"
typeof true                    // "boolean"
typeof false                   // "boolean"
var car;                       // "undefined"
var car = "";                  // "string"
typeof [1,2,3,4]               // "object"
typeof {name:'John', age:34}   // "object"
typeof new Date()              // "object"
typeof function () {}          // "function"
typeof myCar                   // "undefined"
typeof null                    // "object"
```

---

## The `constructor` Property

```js
"John".constructor                  // function String()
(3.14).constructor                  // function Number()
false.constructor                   // function Boolean()
[1,2,3,4].constructor               // function Array()
{name:'John', age:34}.constructor  // function Object()
new Date().constructor              // function Date()
function () {}.constructor          // function Function()
```
## PROTOTYPES

### Adding a new method named `myReduce` to prototype chain, example:

```javascript
Array.prototype.myReduce = function(callback){
    let acc = this[0]
    for(let i = 1; i < this.length; i++){
        acc = callback(acc, this[i], this)
    }
    return acc
}
```

### Using the new method:

```javascript
const sum = (total, value) => total + value
const nums = [1, 4, 6, 8]
console.log(nums.myReduce(sum))
```

---

## DOING COMMENTARIES

### SINGLE COMMENTARY

```javascript
// Change heading:
```

### MULTILINE COMMENTARY

```javascript
/*
The code below will change
the heading with id = "myH"
and the paragraph with id = "myP"
in my web page:
*/
```

---

## DECLARING VARIABLES

In JavaScript, a variable can be an array, a text, a number, an object, or a HTML element.

Variables declared inside a function are **local scope**.  
Variables declared outside a function are **global variables**.

---

### Using `var`

Using `var` you can get the variables from other scopes. A variable inside `if` or `while` can be accessed.

```javascript
var x = 10;
// Here x is 10
{  
  var x = 2;
  // Here x is 2
}

document.getElementById("demo").innerHTML = x;
// Output: 2
```

---

### Using `let`

Using `let` you can't get the variable outside the block scope like `if` or `while`.

```javascript
var x = 10;
// Here x is 10
{  
  let x = 2;
  // Here x is 2
}
// Here x is 10
document.getElementById("demo").innerHTML = x;
// Output: 10
```

---

### Using `const`

`const` are variables that **can't be changed**.

```javascript
const PI = 3.141592653589793;
PI = 3.14;      // This will give an error
PI = PI + 10;   // This will also give an error
```

---

### Other Examples

```javascript
var a = 5;
var people = "Pablo";
var cars = ["Saab", "Volvo", "BMW"];
var person = "John Doe", carName = "Volvo", price = 200;
var text = "<p>";
```

## OPERATORS

### ASSIGNMENT

| Operator | Example   | Meaning            |
|----------|-----------|--------------------|
| =        | x = y     | x = y              |
| +=       | x += y    | x = x + y          |
| -=       | x -= y    | x = x - y          |
| *=       | x *= y    | x = x * y          |
| /=       | x /= y    | x = x / y          |
| %=       | x %= y    | x = x % y          |
| **=      | x **= y   | x = x ** y         |

---

### ARITHMETICS

- `+` Addition  
- `-` Subtraction  
- `*` Multiplication  
- `**` Exponentiation (ES2016)  
- `/` Division  
- `%` Modulus (Division Remainder)  
- `++` Increment  
- `--` Decrement  

---

### COMPARISON

- `==` equal to  
- `===` equal value and equal type  
- `!=` not equal  
- `!==` not equal value or not equal type  
- `>` greater than  
- `<` less than  
- `>=` greater than or equal to  
- `<=` less than or equal to  
- `?` ternary operator  

---

### LOGICAL

- `&&` logical and  
- `||` logical or  
- `!` logical not  

## LOGICAL SENTENCES

- `&&`: If a condition is true, do this.  
- `??`: If a value is null or undefined, replace it with a fallback value   
- `||`: If a value is other kind of falsy (empty string, 0, or empty object), replace it with a fallback value   

## CREATING FUNCTIONS

```js
function myFunction() {
  alert("Hello World!");
}
```

## WORKING WITH OBJECTS

### DECLARING THE OBJECT

```js
var person = {firstName:"John", lastName:"Doe", age:50, eyeColor:"blue"};
```

---

### ACCESSING PROPERTIES OF THE OBJECT

```js
objectName.propertyName
objectName["propertyName"]

person.lastName;  // Output: "Doe"
```

---

### USING FUNCTIONS IN OBJECTS

```js
var person = {
  firstName: "John",
  lastName : "Doe",
  id       : 5566,
  fullName : function() {
    return this.firstName + " " + this.lastName;
  }
};
```

## FUNCTIONS

### PASSING A FUNCTION INSIDE AN OBJECT

```
const function3 = function(n){
    return console.log(n * 2)
}

const myObj = {}
myObj.runFunc = function3(3)
myObj.runFunc
```

### PASSING A FUNCTION AS PARAM FOR ANOTHER FUNCTION

```
function run(fun){
    return fun(1,2)
}

run(function(a,b){console.log(a + b)})
```

### RETURNING ANOTHER FUNCTION INSIDE A FUNCTION

```
function sum1(a,b){
    return function sum2(c){
        return setTimeout (() => {
            console.log(a + b + c)
        }, 1000)
    }
}

sum1(1,2)(3)
```

### CALLBACK FUNCTIONS

Callback functions are functions that run for each event that occurs. Examples include `forEach`, `filter`, `map`, etc.

#### Without callback:

```
const labels = ['BMW', 'GM', 'FORD']

const withOutCallback = function (i, label){
    for(let i in labels){
        console.log(`${i}. ${label}`)
    }
}
```

#### With callback:

```
const withCallback = labels.forEach((label, i) => 
    console.log(`${i}. ${label}`))
```

### AUTOINVOKE FUNCTIONS

An Immediately Invoked Function Expression (IIFE) is a function that runs immediately after it is defined.

```
(function autoRun(){
    console.log('Auto run works here.')
}())
```

### CONSTRUCTOR FUNCTIONS

Constructor functions in JavaScript are like classes in other languages.

```
function Car(maxVelocity = 200, delta = 5) {
    let currentVelocity = 0

    this.acelerate = function () {
        if (currentVelocity + delta <= maxVelocity) {
            currentVelocity += delta
        } else {
            currentVelocity = maxVelocity
        }
    }
    
    this.getCurrentVelocity = function () {
        return currentVelocity
    }
}

const celta = new Car
celta.acelerate()
console.log(celta.getCurrentVelocity()) //5

const ferrari = new Car(350, 20)
ferrari.acelerate()
console.log(ferrari.getCurrentVelocity()) //20
```

### RETURNING DATA FROM FUNCTIONS

You can return data from functions and access it:

```
function returnData() {
    const data = {
        name: 'Pablo',
        age: 25
    }
    return {
        data: {
            name: data.name
        }
    }
}

console.log(returnData().data.name)
```


## PROMISES EXAMPLES

### Using Single Promise
```javascript
const myPromise = new Promise ((resolve, reject) => {
    setTimeout(() => {
        resolve('The promise has resolved')
    }, 2000)
})

myPromise.then(result => 
    console.log(result)
)
```

---

### Async/Await
```javascript
const myPromise2 = async () => {
    try {
        const content = await setTimeout(() =>  {
            console.log('It is my content')
        }, 1000)
        return content
    } catch(error) {
        console.log('Error: ' + error)
    }
}

myPromise2()
```

---

### Fetch Example
```javascript
fetch('https://viacep.com.br/01001000/json/')
    .then(function (data) {
        return data.json()
    })
    .then(function(address){
        console.log(address)
    })
```

---

### Returning Data from Async Functions
```javascript
const delay = (amount = 1000) => new Promise(resolve => setTimeout(resolve, amount))

async function responseWithDelay() {
    await delay()

    const data = {
        name: 'Pablo',
        age: 25
    }
    return data
}

responseWithDelay().then(response => console.log(response.name))
```

## TYPE COMPARISON

### Strict Equality (===)
Compares both value and type.
```javascript
5 === 5      // true  
5 === '5'    // false
```

---

### Loose Equality (==)
Compares values only and allows type coercion.
```javascript
5 == 5      // true  
5 == '5'    // true
```

> `5 === '5'` => second element can be converted to number, but strict equality prevents it.

---

### Falsy Values
The following are falsy in JavaScript:
- `0`
- `false`
- `undefined`
- `null`
- `""` (empty string)
- `NaN` (Not a Number)

> Only `NaN` does not pass type coercion for equality comparison.

## EXPRESSION VS STATEMENT

### Expression
A snippet that returns a single value.
Example:
```javascript
a + b * 6
```

### Statement
Code declaration like:
- `if/else`
- `for`
- `while`
- `function` definitions

> A function is a statement, but the body can contain expressions.


## CLASSES

### Creating and using class and your methods in JavaScript:

#### Initializing the class
```ts
class Person {}
```

---

#### Defining the class properties:
All class properties should be typed before the constructor and must be used inside the constructor through the `this` keyword. Example:

```ts
class Person {
  name: string;
  age: number;
  constructor() {
    this.name = 'Pablo';
    this.age = 27;
  }
}
```

---

#### Instancing the class and defining a method `talk`:
```ts
class Person {
  name: string;
  age: number;
  constructor() {
    this.name = 'Pablo';
    this.age = 27;
  }
  talk() {
    return console.log('OK!, I HAVE TALKED');
  }
}
```

---

#### Using the class:
```ts
console.log(new Person().talk());
// 'OK!, I HAVE TALKED' 
```

---

#### Defining getters:
Getter is a class modifier that can access the class properties and run a method. It should be accessed as a class property. Example:

```ts
class Person {
  name: string;
  age: number;
  constructor() {
    this.name = 'Pablo';
    this.age = 27;
  }
  talk() {
    return console.log('OK!, I HAVE TALKED');
  }
  get show() {
    return console.log(this.name, this.age);
  }
}

const usePerson = new Person();
console.log(usePerson.show);
// 'Pablo', 27
```

---

#### Defining and using setters:
Setter is a class modifier that is used to alter some class property. It must receive exactly one parameter. Example:

```ts
class Person {
  name: string;
  age: number;
  constructor() {
    this.name = 'Pablo';
    this.age = 27;
  }
  talk() {
    return console.log('OK!, I HAVE TALKED');
  }
  get show() {
    return console.log(this.name, this.age);
  }
  set personName(personName: string) {
    this.name = personName;
  }
}

const usePerson = new Person();
usePerson.personName = 'Pablo2';
```

## Controlling Strings

### Length
```js
const txt = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
console.log(txt.length); // 26
```

### indexOf & lastIndexOf
```js
const str = "Please locate where 'locate' occurs!";
console.log(str.indexOf("locate"));     // 7
console.log(str.lastIndexOf("locate")); // 21
```

### search
```js
console.log(str.search("locate")); // 7
```

### slice vs substring
```js
const fruits = "Apple, Banana, Kiwi";
console.log(fruits.slice(7, 13));     // Banana
console.log(fruits.slice(7));         // Banana, Kiwi
console.log(fruits.substring(7, 13)); // Banana
```

### replace (basic and with regex)
```js
const str1 = "Please visit Microsoft!";
console.log(str1.replace("Microsoft", "W3Schools")); // Please visit W3Schools!

const str2 = "Please visit Microsoft and Microsoft!";
console.log(str2.replace(/Microsoft/g, "W3Schools")); // Please visit W3Schools and W3Schools!
```

### toLowerCase & toUpperCase
```js
const text = "W3Schools";
console.log(text.toLowerCase()); // w3schools
console.log(text.toUpperCase()); // W3SCHOOLS
```

### concat & + operator
```js
const hello = "Hello";
const world = "World";
console.log(hello.concat(" ", world)); // Hello World
console.log(hello + " " + world + "!"); // Hello World!
```

### trim
```js
const padded = "   Hello World!   ";
console.log(padded.trim()); // "Hello World!"
```

### split
```js
const sentence = "Hello World is commonly used";
console.log(sentence.split(" ")); // ["Hello", "World", "is", "commonly", "used"]
```

### `includes()`
Checks if a string contains a specified value. Returns `true` or `false`.

```js
const text = "Hello world";
console.log(text.includes("world")); // true
```

---

### `startsWith()`
Checks if a string starts with a specified value.

```js
const text = "Hello world";
console.log(text.startsWith("Hello")); // true
```

---

### `endsWith()`
Checks if a string ends with a specified value.

```js
const text = "Hello world";
console.log(text.endsWith("world")); // true
```

---

### `repeat()`
Returns a new string with a specified number of copies of an existing string.

```js
const text = "Ha! ";
console.log(text.repeat(3)); // "Ha! Ha! Ha! "
```

---

### `padStart()`
Pads a string with another string at the start, until it reaches a given length.

```js
const str = "5";
console.log(str.padStart(3, "0")); // "005"
```

---

### `padEnd()`
Pads a string with another string at the end.

```js
const str = "5";
console.log(str.padEnd(3, "0")); // "500"
```

---

### `match()`
Returns an array of matches or `null` using RegExp.

```js
const text = "The rain in SPAIN stays mainly in the plain";
console.log(text.match(/ain/g)); // [ 'ain', 'ain', 'ain' ]
```

---

### `matchAll()`
Returns an iterator of all results matching a string against a RegExp.

```js
const regex = /t(e)(st(\d?))/g;
const str = 'test1test2';
const matches = [...str.matchAll(regex)];
console.log(matches);
/* 
[
  ["test1", "e", "st1", "1"],
  ["test2", "e", "st2", "2"]
]
*/
```

---

### `normalize()`
Returns the Unicode Normalization Form of a string.

```js
const str = '\u0041\u006d\u00e9\u006c\u0069\u0065'; // Amélie
console.log(str.normalize("NFC"));
```

---

### `codePointAt()`
Returns the Unicode code point at the given position.

```js
const emoji = '💩';
console.log(emoji.codePointAt(0)); // 128169
```

---

### `charAt()`
Returns the character at a specified index.

```js
const str = "Hello";
console.log(str.charAt(1)); // "e"
```

---

### `charCodeAt()`
Returns the UTF-16 code of a character.

```js
const str = "Hello";
console.log(str.charCodeAt(1)); // 101
```

---

### `at()` (ES2022)
Gets the character at a specific index. Supports negative indices.

```js
const str = "Hello";
console.log(str.at(-1)); // "o"

```
## Controlling Numbers

### Exceptions

- `NaN`: Means "Not a Number". It occurs when you perform arithmetic operations involving non-numeric values.
- `Infinity`: Returned when a number exceeds the limits of mathematics, e.g., `2 / 0` results in `Infinity`.

---

### `toString()`

Returns a number as a string.

```js
var x = 123;
x.toString(); // Output: "123"
```

---

### `toLocaleString()`

Returns a number formatted according to the current locale.

```js
var x = 123;
x.toLocaleString('pt-BR'); // Output: "123,00"
```

---

### `toFixed()`

Returns a string, with the number written with a specified number of decimals.

```js
var x = 9.656;
x.toFixed(0); // Output: "10"
x.toFixed(2); // Output: "9.66"
```

---

### `toPrecision()`

Returns a string, with a number written with a specified length.

```js
var x = 9.656;
x.toPrecision();   // Output: "9.656"
x.toPrecision(2);  // Output: "9.7"
x.toPrecision(4);  // Output: "9.656"
```

## Converting Variables to Numbers

### `Number()`
This method is used to convert variables to numbers:

**Example 1:**
```javascript
Number("10");          // returns 10
Number("10.33");       // returns 10.33
Number("10,33");       // returns NaN
```

**Example 2:**
```javascript
Number(new Date("2017-09-30"));    // returns 1506729600000
```

---

### `parseInt()`
Parses a string and returns a whole number. Spaces are allowed. Only the first number is returned:

```javascript
parseInt("10");         // returns 10
parseInt("10.33");      // returns 10
parseInt("10 20 30");   // returns 10
parseInt("10 years");   // returns 10
parseInt("years 10");   // returns NaN
```

---

### `parseFloat()`
Parses a string and returns a number. Spaces are allowed. Only the first number is returned:

```javascript
parseFloat("10");        // returns 10
parseFloat("10.33");     // returns 10.33
parseFloat("10 20 30");  // returns 10
parseFloat("10 years");  // returns 10
parseFloat("years 10");  // returns NaN
```

---

## Number Properties

### `MAX_VALUE`
Returns the largest possible number in JavaScript.

```javascript
var x = Number.MAX_VALUE;
```

---

### `MIN_VALUE`
Returns the lowest possible number in JavaScript.

```javascript
var x = Number.MIN_VALUE;
```


## Controlling Arrays

Arrays are a special type of objects. The `typeof` operator in JavaScript returns `"object"` for arrays. Arrays use numbers to access their "elements".

### Declaring an Array

```js
// Example 01:
var cars = ["Saab", "Volvo", "BMW"];
// or
var cars = new Array("Saab", "Volvo", "BMW");

// Example 02:
var person = ["John", "Doe", 46];
// or
var person = new Array("John", "Doe", 46);
```

---

### Accessing an Array

```js
var cars = ["Saab", "Volvo", "BMW"];
document.getElementById("demo").innerHTML = cars[1];
// Output: "Volvo"

document.getElementById("demo").innerHTML = cars;
// Output: "Saab,Volvo,BMW"
```

---

### Arrays Elements Can Be Objects

```js
myArray[0] = Date.now;    // element 0 is the current timestamp
myArray[1] = myFunction;  // element 1 is a function
myArray[2] = myCars;      // element 2 is another array
```

---

### Array Property

```js
var fruits = ["Banana", "Orange", "Apple", "Mango"];
fruits.length; // Output: 4
```
## Array Methods in JavaScript

### push()
Adds a new element at the end of the array.
```js
const fruits = ["Banana", "Orange", "Apple"];
fruits.push("Lemon"); 
// ["Banana", "Orange", "Apple", "Lemon"]
```

### join()
Joins all array elements into a string.
```js
const fruits = ["Banana", "Orange"];
const result = fruits.join(" * "); 
// "Banana * Orange"
```

### pop()
Removes the last element.
```js
const fruits = ["Banana", "Orange", "Apple"];
fruits.pop(); 
// ["Banana", "Orange"]
```

### shift()
Removes the first element and shifts the rest.
```js
const fruits = ["Banana", "Orange"];
fruits.shift(); 
// ["Orange"]
```

### unshift()
Adds a new element to the beginning.
```js
const fruits = ["Orange", "Apple"];
fruits.unshift("Lemon"); 
// ["Lemon", "Orange", "Apple"]
```

### Change an element
```js
const fruits = ["Banana", "Orange"];
fruits[0] = "Kiwi"; 
// ["Kiwi", "Orange"]
```

### splice()
Add/remove elements at any position.
```js
const fruits = ["Banana", "Orange"];
fruits.splice(1, 0, "Lemon"); 
// ["Banana", "Lemon", "Orange"]
```

### concat()
Merges arrays into a new one.
```js
const girls = ["Cecilie"];
const boys = ["Emil"];
const children = girls.concat(boys); 
// ["Cecilie", "Emil"]
```

### slice()
Returns a slice of the array.
```js
const fruits = ["Banana", "Orange", "Lemon"];
const result = fruits.slice(1, 3); 
// ["Orange", "Lemon"]
```

### toString()
Converts an array to string.
```js
const fruits = ["Banana", "Orange"];
fruits.toString(); 
// "Banana,Orange"
```

### sort()
Sorts elements alphabetically.
```js
const fruits = ["Banana", "Apple"];
fruits.sort(); 
// ["Apple", "Banana"]
```

### reverse()
Reverses the array.
```js
const fruits = ["Banana", "Apple"];
fruits.reverse(); 
// ["Apple", "Banana"]
```

### indexOf()
Returns the first index of the element.
```js
const fruits = ["Apple", "Orange", "Apple"];
fruits.indexOf("Apple"); 
// 0
```

### lastIndexOf()
Returns the last index of the element.
```js
const fruits = ["Apple", "Orange", "Apple"];
fruits.lastIndexOf("Apple"); 
// 2
```

### map()
Returns a new array with function applied.
```js
const numbers = [1, 2, 3];
const doubled = numbers.map(x => x * 2); 
// [2, 4, 6]
```

### forEach()
Executes a function for each item.
```js
const numbers = [1, 2];
numbers.forEach(x => console.log(x)); 
// logs 1 then 2
```

### reduce()
Reduces to a single value.
```js
const numbers = [1, 2, 3];
const sum = numbers.reduce((total, num) => total + num); 
// 6
```

### every()
Checks if all items pass the test.
```js
const numbers = [22, 33];
numbers.every(n => n > 18); 
// true
```

### some()
Checks if at least one item passes.
```js
const numbers = [22, 8];
numbers.some(n => n > 18); 
// true
```

### filter()
Returns a new filtered array.
```js
const numbers = [5, 20, 25];
const result = numbers.filter(n => n > 18); 
// [20, 25]
```

### find()
Finds the first value that passes.
```js
const numbers = [5, 20, 25];
numbers.find(n => n > 18); 
// 20
```

### findIndex()
Finds index of first item that passes.
```js
const numbers = [5, 20, 25];
numbers.findIndex(n => n > 18); 
// 1
```


## Controlling Dates in JavaScript

### Creating a New Date
```javascript
var d = new Date();
```

---

### Using a Passed Date
```javascript
var d1 = new Date(2018, 11, 24, 10, 33, 30, 0);
var d2 = new Date(2018, 11, 24);
var d3 = new Date(2018);
```

---

### `Date.parse()`
Returns the number of milliseconds between the date and January 1, 1970:
```javascript
var msec = Date.parse("March 21, 2012");
```

---

### `getTime()`
Returns the number of milliseconds since January 1, 1970:
```javascript
var d = new Date();
d.getTime();
```

---

### `getFullYear()`
Returns the year of a date with four digits:
```javascript
var d = new Date();
d.getFullYear();
```

---

### `getMonth()`
Returns the month of a date as a number (0-11):
```javascript
var d = new Date();
d.getMonth();
```

---

### `getDate()`
Returns the day of a date as a number (1-31):
```javascript
var d = new Date();
d.getDate();
```

---

### `getHours()`
Returns the hours of a date as a number (0-23):
```javascript
var d = new Date();
d.getHours();
```

---

### `getMinutes()`
Returns the minutes of a date as a number (0-59):
```javascript
var d = new Date();
d.getMinutes();
```

---

### `getSeconds()`
Returns the seconds of a date as a number (0-59):
```javascript
var d = new Date();
d.getSeconds();
```

---

### `getMilliseconds()`
Returns the milliseconds of a date as a number (0-999):
```javascript
var d = new Date();
d.getMilliseconds();
```

---

### `getDay()`
Returns the weekday of a date as a number (0-6):
```javascript
var d = new Date();
d.getDay();
```

---

### Converting Date to String
```javascript
new Date().toString(); // "Thu Jul 17 2014 15:38:19 GMT+0200 (W. Europe Daylight Time)"
```

---

### Setting a Date and Hour

#### Setting a Date
```javascript
var d = new Date();
d.setMonth(11);
d.setDate(11);
d.setFullYear(2022);
// Output: Sun Dec 11 2022
```

#### Setting Date with `setFullYear`
```javascript
var d = new Date();
d.setFullYear(2020, 5, 3);
// Output: Wed Jun 03 2020
```

## Native Object Methods

### Object.freeze()
This method is used to prevent modifications to an object. Once an object is frozen, you cannot add, remove, or change its properties.

---

### Object.entries()
Returns an array of a given object's own enumerable string-keyed property [key, value] pairs.

```
const obj = { a: 1, b: 2 };
Object.entries(obj); // [["a", 1], ["b", 2]]
```

---

### Object.values()
Returns an array of a given object's own enumerable property values.

```
const obj = { a: 1, b: 2 };
Object.values(obj); // [1, 2]
```

---

### Object.keys()
Returns an array of a given object's own enumerable property names.

```
const obj = { a: 1, b: 2 };
Object.keys(obj); // ["a", "b"]
```

---

### Object.is()
Compares two values to determine if they are the same value.

```
const obj1 = { a: 1, b: 2 };
const obj2 = { b: 1, f: 2 };
const obj3 = { a: 1, b: 2 };

Object.is(obj1, obj2); // false
Object.is(obj1, obj3); // false
const obj4 = obj1;
Object.is(obj1, obj4); // true
```

> Note: `Object.is()` compares references for objects, not their content.

---

### Object.seal()
Prevents new properties from being added to an object and marks all existing properties as non-configurable.

```
const obj = { a: 1, b: "apple" };
Object.seal(obj);
obj.a = "orange";
console.log(obj); // { a: "orange", b: "apple" }
delete obj.b; // won't work
obj.c = "new"; // won't work
```

## Math Methods

### `Math.PI`
Returns the value of PI.
```js
Math.PI; // 3.141592653589793
```

---

### `Math.round()`
Rounds a number to the nearest integer.
```js
Math.round(4.7); // 5
Math.round(4.4); // 4
```

---

### `Math.pow()`
Returns the value of x to the power of y.
```js
Math.pow(8, 2); // 64
```

---

### `Math.sqrt()`
Returns the square root of a number.
```js
Math.sqrt(64); // 8
```

---

### `Math.abs()`
Returns the absolute (positive) value of a number.
```js
Math.abs(-4.7); // 4.7
```

---

### `Math.ceil()`
Returns the value of a number rounded up to the nearest integer.
```js
Math.ceil(4.4); // 5
```

---

### `Math.floor()`
Returns the value of a number rounded down to the nearest integer.
```js
Math.floor(4.7); // 4
```

---

### `Math.sin()`
Returns the sine of a number in radians.
```js
Math.sin(90 * Math.PI / 180); // 1
```

---

### `Math.cos()`
Returns the cosine of a number in radians.
```js
Math.cos(0 * Math.PI / 180); // 1
```

---

### `Math.min()`
Returns the number with the lowest value.
```js
Math.min(0, 150, 30, 20, -8, -200); // -200
```

---

### `Math.max()`
Returns the number with the highest value.
```js
Math.max(0, 150, 30, 20, -8, -200); // 150
```


## Conditional Statements

Use `if` to specify a block of code to be executed, if a specified condition is true.  
Use `else` to specify a block of code to be executed, if the same condition is false.  
Use `else if` to specify a new condition to test, if the first condition is false.  
Use `switch` to specify many alternative blocks of code to be executed.

---

### IF

```
if (condition) {
  // block of code to be executed if the condition is true
}
```

---

### ELSE

```
if (condition) {
  // block of code to be executed if the condition is true
} else {
  // block of code to be executed if the condition is false
}
```

---

### ELSE IF

```
if (condition1) {
  // block of code to be executed if condition1 is true
} else if (condition2) {
  // code executed if condition1 is false and condition2 is true
} else {
  // code executed if both conditions are false
}
```

---

### SWITCH

Switch is a useful statement to select one of many code blocks to be executed.

```
switch(expression) {
  case x:
    // code block
    break;
  case y:
    // code block
    break;
  default:
    // code block
}
```

---

## Loops

Types of loops:

- `for` - loops through a block of code a number of times  
- `while` - loops through a block of code while a specified condition is true  
- `do/while` - also loops through a block of code while a specified condition is true

---

### FOR LOOP

```
for (statement 1; statement 2; statement 3) {
  // code block to be executed
}
```

Example:

```
const myArray = ['item1', 'item2', 'item3', 'item4', 'item5'];

for (let i = 0; i < myArray.length; i++) {
  console.log(`${i}. ${myArray[i]}`);
}
```

Output:

```
0. item1
1. item2
2. item3
3. item4
4. item5
```

---

### WHILE LOOP

Use `while` when you do not know the iterable object length.

```
while (condition) {
  // code block to be executed
}
```

Example:

```
let response;
do {
  response = await fetchNextPage();
} while (response.hasMore);
```


## Regular Expressions

### Flags

#### `i` - Case-insensitive search
```javascript
var str = "Visit W3Schools";
var patt1 = /w3schools/i;
var result = str.match(patt1);
// Output: W3Schools
```

#### `g` - Global search
```javascript
var str = "Is this all there is?";
var patt1 = /is/g;
var result = str.match(patt1);
// Output: is,is
```

### Character Sets

#### `[abc]` - Find any of the characters
```javascript
var str = "Is this all there is?";
var patt1 = /[h]/g;
var result = str.match(patt1);
// Output: h,h
```

#### `[0-9]` - Find any of the digits
```javascript
var str = "123456789";
var patt1 = /[1-4]/g;
var result = str.match(patt1);
// Output: 1,2,3,4
```

### Alternation

#### `(x|y)` - Find any of the alternatives
```javascript
var str = "re, green, red, green, gren, gr, blue, yellow";
var patt1 = /(red|green)/g;
var result = str.match(patt1);
// Output: green,red,green
```

### Metacharacters

#### `\d` - Find a digit
```javascript
var str = "Give 100%!";
var patt1 = /\d/g;
var result = str.match(patt1);
// Output: 1,0,0
```

#### `\s` - Find a whitespace character
```javascript
var str = "Is this all there is?";
var patt1 = /\s/g;
var result = str.match(patt1);
// Output: , , ,
```

#### `\b` - Word boundary

- Beginning of word:
```javascript
var str = "HELLO, LOOK AT YOU!";
var patt1 = /\bLO/;
var result = str.search(patt1);
// Output: 7
```

- End of word:
```javascript
var str = "HELLO, LOOK AT YOU!";
var patt1 = /LO\b/;
var result = str.search(patt1);
// Output: 3
```

### Quantifiers

#### `n+` - One or more occurrences
```javascript
var str = "Hellooo World! Hello W3Schools!";
var patt1 = /o+/g;
var result = str.match(patt1);
// Output: ooo,o,o,oo
```

#### `n*` - Zero or more occurrences
```javascript
var str = "Hellooo World! Hello W3Schools!";
var patt1 = /lo*/g;
var result = str.match(patt1);
// Output: l,looo,l,l,lo,l
```

#### `n?` - Zero or one occurrence
```javascript
var str = "1, 100 or 1000?";
var patt1 = /10?/g;
var result = str.match(patt1);
// Output: 1,10,10
```
## JSON OBJECT

All data received on the web comes in string format. When storing or reading data using localStorage or working with databases, this data should be represented in JSON format.

**JSON format example:**
```json
{ "name": "John", "age": 31, "city": "New York" }
```

### Methods

- `parse()` - Converts a string into a JSON object.
- `stringify()` - Converts a JSON object into a string.


## TREATING ERRORS

### TRY, CATCH AND THROW

```javascript
try {
  // Block of code to try
}
catch(err) {
  // Block of code to handle errors
}
```

**Example:**
```html
<p>Please input a number between 5 and 10:</p>
<input id="demo" type="text">
<button type="button" onclick="myFunction()">Test Input</button>
<p id="p01"></p>

<script>
function myFunction() {
  var message, x;
  message = document.getElementById("p01");
  message.innerHTML = "";
  x = document.getElementById("demo").value;
  try { 
    if(x == "")  throw "empty";
    if(isNaN(x)) throw "not a number";
    x = Number(x);
    if(x < 5)  throw "too low";
    if(x > 10) throw "too high";
  }
  catch(err) {
    message.innerHTML = "Input is " + err;
  }
}
</script>
```

---

### TRY, CATCH, THROW AND FINALLY

```javascript
try {
  // Block of code to try
}
catch(err) {
  // Block of code to handle errors
}
finally {
  // Block of code to be executed regardless of the try/catch result
}
```

**Example:**
```html
<p>Please input a number between 5 and 10:</p>
<input id="demo" type="text">
<button type="button" onclick="myFunction()">Test Input</button>
<p id="p01"></p>

<script>
function myFunction() {
  var message, x;
  message = document.getElementById("p01");
  message.innerHTML = "";
  x = document.getElementById("demo").value;
  try { 
    if(x == "")  throw "is empty";
    if(isNaN(x)) throw "is not a number";
    x = Number(x);
    if(x > 10) throw "is too high";
    if(x < 5)  throw "is too low";
  }
  catch(err) {
    message.innerHTML = "Input " + err;
  }
  finally {
    document.getElementById("demo").value = "";
  }
}
</script>
```

---

### TYPE OF ERRORS

- `EvalError` – An error has occurred in the `eval()` function.
- `RangeError` – A number "out of range" has been used.
- `ReferenceError` – You tried to use an undeclared variable.
- `SyntaxError` – A syntax error has occurred.
- `TypeError` – You used a value that is outside the expected types.
- `URIError` – You used illegal characters in a URI function.

## Reserved keywords

JavaScript has a list of reserved keywords that should not be used as identifiers (e.g., variable names, function names) because they are part of the language syntax or may be used in future versions.

### List of Reserved Words and Their Explanations

- `abstract`: Reserved for future use in JavaScript classes.
- `arguments`: Refers to the arguments passed to a function.
- `await`: Pauses execution of an async function until a Promise is settled.
- `boolean`: Represents a logical entity and can have two values: `true` and `false`.
- `break`: Terminates the current loop, switch, or label statement.
- `byte`: Reserved for future use.
- `case`: Defines a case in a switch statement.
- `catch`: Defines a block of code to handle errors in a try...catch structure.
- `char`: Reserved for future use.
- `class`: Declares a class (template for creating objects).
- `const`: Declares a constant (block-scoped variable).
- `continue`: Skips the rest of the loop iteration and continues with the next.
- `debugger`: Invokes any available debugging functionality.
- `default`: Specifies the default block in a switch statement.
- `delete`: Deletes an object property or array element.
- `do`: Executes a block of code once, then repeats while a condition is true.
- `double`: Reserved for future use.
- `else`: Specifies a block of code if the condition in `if` is false.
- `enum`: Reserved for future use (used in TypeScript).
- `eval`: Executes a string of JavaScript code.
- `export`: Exports functions, objects, or values from a module.
- `extends`: Used in class declarations/inheritance.
- `false`: Boolean value indicating false.
- `final`: Reserved for future use.
- `finally`: Executes code after try and catch blocks, regardless of the result.
- `float`: Reserved for future use.
- `for`: Creates a loop that consists of three optional expressions.
- `function`: Declares a function.
- `goto`: Reserved for future use.
- `if`: Executes a block of code if a condition is true.
- `implements`: Reserved for future use (used in TypeScript/Java).
- `import`: Imports functions, objects, or values from a module.
- `in`: Checks if a property exists in an object.
- `instanceof`: Tests whether an object is an instance of a constructor.
- `int`: Reserved for future use.
- `interface`: Reserved for future use (used in TypeScript).
- `let`: Declares a block-scoped variable.
- `long`: Reserved for future use.
- `native`: Reserved for future use.
- `new`: Creates an instance of an object.
- `null`: Denotes a null or empty value.
- `package`: Reserved for future use.
- `private`: Reserved for future use (used in classes/TypeScript).
- `protected`: Reserved for future use (used in classes/TypeScript).
- `public`: Reserved for future use (used in classes/TypeScript).
- `return`: Specifies the value to be returned by a function.
- `short`: Reserved for future use.
- `static`: Defines a static method or property for a class.
- `super`: Refers to the parent class in class inheritance.
- `switch`: Selects one of many code blocks to be executed.
- `synchronized`: Reserved for future use.
- `this`: Refers to the current object.
- `throw`: Throws a user-defined exception.
- `throws`: Reserved for future use.
- `transient`: Reserved for future use.
- `true`: Boolean value indicating true.
- `try`: Defines a block of code to test for errors.
- `typeof`: Returns the type of a variable or expression.
- `var`: Declares a variable (function-scoped).
- `void`: Discards a return value.
- `volatile`: Reserved for future use.
- `while`: Creates a loop that executes while a specified condition is true.
- `with`: Extends the scope chain for a statement (deprecated).
- `yield`: Pauses and resumes a generator function.

## Best Practices and Tips

### ✅ General Guidelines

- **Always declare variables with `const` or `let`**, never `var`.
- **Use `const`** by default. Only use `let` if the variable needs to be reassigned.
- **Avoid polluting the global scope**. Encapsulate code inside functions or modules.
- **Prefer ES6+ syntax**, like arrow functions, destructuring, template literals, etc.
- **Use strict equality (`===`)** instead of loose equality (`==`) for type safety.
- **Always handle errors** using `try/catch`, especially with `async/await`.

---

### 🧱 Variable Declarations

- Group related declarations together and initialize them when declared:
```js
const firstName = "", lastName = "", price = 0, discount = 0;
```

- Use literal syntax:
  - `[]` instead of `new Array()`
  - `{}` instead of `new Object()`
  - `""` instead of `new String()`

---

### 🧠 Functions

- Use **arrow functions** for simple callbacks or function expressions.
```js
const double = x => x * 2;
```

- Avoid using `function` keyword unless creating methods or for better context (`this` binding).
- Don’t use `eval()` — it's slow and a security risk.

---

### 🔁 Loops & Iteration

- Prefer `for...of` for arrays and `for...in` for objects.
- Use `Array.prototype.map`, `filter`, and `reduce` over traditional `for` loops for functional style.

---

### 🧪 Comparisons

- Reference types (`{}`, `[]`, functions) are compared by reference, not value.
```js
{} === {} // false
```

- Convert to strings or use deep comparison libraries (e.g., Lodash `_.isEqual`) for value equality.

---

### 📦 Objects & Arrays

- Clone arrays/objects with spread syntax:
```js
const clone = { ...original };
const newArr = [...arr];
```

- Destructure objects and arrays to access values clearly:
```js
const { name, age } = person;
```

---

### 💥 Defensive Programming

- Use optional chaining (`?.`) and nullish coalescing (`??`) for safe property access.
```js
const name = user?.profile?.name ?? "Guest";
```

- Always check for `undefined` before accessing properties.

---

### 🧰 Tooling

- Use **linters** like ESLint with Prettier for consistent code style.
- Adopt a **formatter** like Prettier for auto-formatting code.
- Use **TypeScript** where possible for type safety.

---

### 📚 Comments & Documentation

- Write meaningful comments for non-obvious logic.
- Use JSDoc for documenting functions and types if not using TypeScript.

---

### ⚠️ Common Mistakes to Avoid

- Not handling promise rejections (`.catch()` or `try/catch`).
- Forgetting to `return` in a function block.
- Using `==` instead of `===`.
- Modifying objects/arrays directly — prefer immutability.
- Ignoring performance implications of frequent re-renders in the UI.

---

### 🧼 Clean Code Habits

- Keep functions small and focused on one responsibility.
- Use meaningful, descriptive variable names.
- Avoid deep nesting — use guard clauses.
- Break large files into smaller modules.

---

### 🔐 Security Tips

- Escape user input to prevent XSS attacks.
- Never store sensitive data (tokens, passwords) in localStorage.
- Sanitize data sent to and from APIs.
