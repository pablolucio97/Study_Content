# MAIN BUILT IN OBJECTS METHODS LIST

## STRING

- `length()` - Calc the length of a string
- `indexOf()` - Returns the position of the first occurrence of a specified text in a string
- `lastIndexOf()` - Returns the position of the last occurrence of a specified text in a string
- `search()` - Search a string and returns the match correspondence
- `slice()` - Get a part of the string and return it
- `substring()` - Like slices, but doesn't accepts negative values
- `replace()` - Replace a string by other
- `toLowerCase()` - Transform a string to lower case
- `toUpperCase()` - Transform a string to upper case
- `concat()` - Joins two or more strings
- `trim()` - Remove blank between strings
- `split()` - Transform a string in an array
- `charAt()` - Returns the character at a specified index.
- `charCodeAt()` - Returns the Unicode of the character at a specified index.
- `endsWith()` - Checks whether a string ends with specified characters.
- `includes()` - Checks whether a string contains a specified string/characters.
- `localeCompare()` - Compares two strings in the current locale.
- `match()` - Searches a string for a match against a regular expression, and returns the matches.
- `normalize()` - Returns the Unicode Normalization Form of a string.
- `repeat()` - Returns a new string with a specified number of copies of an existing string.
- `startsWith()` - Checks whether a string begins with specified characters.
- `substr()` - Extracts parts of a string, beginning at the character at the specified position, and returns the specified number of characters.
- `toLocaleLowerCase()` - Converts a string to lowercase letters, according to the host's locale.
- `toLocaleUpperCase()` - Converts a string to uppercase letters, according to the host's locale.
- `valueOf()` - Returns the primitive value of a string object.
- `padStart(targetLength [, padString])` - Pads the current string from the start with another string until the specified length is reached.
- `padEnd(targetLength [, padString])` - Pads the current string from the end with another string until the specified length is reached.

## NUMBER

- `toString()` - Show a number in string format
- `toFixed()` - Fixes the decimal digits
- `toPrecision()` - Fixes the quantity of digits
- `isFinite()` - Checks whether a value is a finite number.
- `isInteger()` - Checks whether a value is an integer.
- `isNaN()` - Checks whether a value is NaN (Not-a-Number).
- `isSafeInteger()` - Checks whether a value is a safe integer.
- `toExponential()` - Converts a number into an exponential notation.
- `toLocaleString()` - Converts a number into a string, using a local language format.
- `valueOf()` - Returns the primitive value of a number.

## MATH

- `Pi()` - Returns 3.14159265
- `round()` - Round the number to above or below by according the floating value.
- `ceil()` - Round the number to above.
- `floor()` - Round the number to below.
- `pow()` - Return the power square of a number.
- `sqrt()` - Return the square root of a number.
- `abs()` - Return the absolute value of a number.
- `sin()` - Return the sin of a degree.
- `cos()` - Return the cos of a degree.
- `random()` - Return a random number, is used with Math.floor
- `acos()` - Returns the arccosine of a number.
- `asin()` - Returns the arcsine of a number.
- `atan()` - Returns the arctangent of a number.
- `atan2()` - Returns the arctangent of the quotient of its arguments.
- `exp()` - Returns E^x, where x is the argument, and E is Euler's number.
- `log()` - Returns the natural logarithm (log e) of a number.
- `log10()` - Returns the base 10 logarithm of a number.
- `max()` - Returns the number with the highest value.
- `min()` - Returns the number with the lowest value.
- `random()` - Returns a random number between 0 (inclusive) and 1 (exclusive).
- `tan()` - Returns the tangent of a number.

## DATE

- `parse()` - Return the number of milliseconds between the date and January 1, 1970.
- `getTime()` - Return the number of milliseconds since January 1, 1970.
- `getFullYear()` - Return the year of the current year in four digits format.
- `getMonth()` - Return the month of the current date in two digits format (0-11).
- `getDate()` - Returns the day of a date as a number (1-31)
- `getHours()` - Return the hours of a date as a number (0-23)
- `getMinutes()` - Return the minutes of a date as minutes (00-59)
- `getSeconds` - Returns the seconds of a date as a number (00-59).
- `getDay()` - Return the weekday as a number (0-6)
- `toString()` - Convert a date in string format.
- `setHours()` - Set the hours of a date as a number (0-23)
- `setMinutes()` - Set the minutes of a date as minutes (00-59)
- `setSeconds` - Set the seconds of a date as a number (00-59).
- `setDate()` - Set the day of a date as a number (1-31)
- `setMonth()` - Set the month of
- `toDateString()` - Converts the date portion of a Date object into a readable string.
- `toISOString()` - Returns the ISO format string of a date.
- `toJSON()` - Returns the date as a string, formatted as a JSON date.
- `toLocaleDateString()` - Returns the date portion of a Date object as a string, using locale conventions.
- `toLocaleTimeString()` - Returns the time portion of a Date object as a string, using locale conventions.
- `toTimeString()` - Converts the time portion of a Date object to a string.
- `toUTCString()` - Converts a Date object to a string, according to universal time.
- `getMilliseconds()` - Returns the milliseconds of a date as a number (0-999).
- `getUTCDate()` - Returns the day of the month, according to universal time (1-31).
- `getUTCDay()` - Returns the day of the week, according to universal time (0-6).
- `getUTCFullYear()` - Returns the year of a Date object, according to universal time.
- `getUTCHours()` - Returns the hours of a Date object, according to universal time (0-23).
- `getUTCMinutes()` - Returns the minutes of a Date object, according to universal time (0-59).
- `getUTCMonth()` - Returns the month of a Date object, according to universal time (0-11).
- `getUTCSeconds()` - Returns the seconds of a Date object, according to universal time (0-59).
- `setMilliseconds()` - Sets the milliseconds of a Date object.
- `setUTCDate()` - Sets the day of the month of a Date object, according to universal time.
- `setUTCFullYear()` - Sets the year of a Date object, according to universal time.
- `setUTCHours()` - Sets the hours of a Date object, according to universal time.
- `setUTCMinutes()` - Sets the minutes of a Date object, according to universal time.
- `setUTCMonth()` - Sets the month of a Date object, according to universal time.
- `setUTCSeconds()` - Sets the seconds of a Date object, according to universal time.

## OBJECT

- `Object.assign(target, ...sources)` - Copies the values of all enumerable own properties from one or more source objects to a target object.
- `Object.create(proto[, propertiesObject])` - Creates a new object, using an existing object as the prototype of the newly created object.
- `Object.defineProperty(obj, prop, descriptor)` - Defines a new property directly on an object, or modifies an existing property on an object, and returns the object.
- `Object.defineProperties(obj, props)` - Defines new or modifies existing properties directly on an object, returning the object.
- `Object.entries(obj)` - Returns an array of a given object's own enumerable string-keyed property [key, value] pairs.
- `Object.freeze(obj)` - Freezes an object. A frozen object can no longer be changed.
- `Object.getOwnPropertyDescriptor(obj, prop)` - Returns a property descriptor for a named property on an object.
- `Object.getOwnPropertyDescriptors(obj)` - Returns an object containing all own property descriptors of an object.
- `Object.getOwnPropertyNames(obj)` - Returns an array of all properties (including non-enumerable properties except for those which use Symbol) found directly upon a given object.
- `Object.getOwnPropertySymbols(obj)` - Returns an array of all symbol properties found directly upon a given object.
- `Object.getPrototypeOf(obj)` - Returns the prototype (i.e., the value of the internal [[Prototype]] property) of the specified object.
- `Object.is(value1, value2)` - Compares if two values are the same value. Equivalent to using JavaScript’s strict equality (===).
- `Object.isExtensible(obj)` - Determines if extending of an object is allowed.
- `Object.isFrozen(obj)` - Determines if an object was frozen.
- `Object.isSealed(obj)` - Determines if an object is sealed.
- `Object.keys(obj)` - Returns an array of a given object's own enumerable property names, iterated in the same order that a normal loop would.
- `Object.preventExtensions(obj)` - Prevents new properties from ever being added to an object (i.e., prevents future extensions to the object).
- `Object.seal(obj)` - Prevents other code from deleting properties of an object.
- `Object.setPrototypeOf(obj, prototype)` - Sets the prototype (i.e., the internal [[Prototype]] property) of a specified object to another object or null.
- `Object.values(obj)` - Returns an array of a given object's own enumerable property values, in the same order as that provided by a `for...in` loop (the difference being that a `for-in` loop enumerates properties in the prototype chain as well).

## ARRAYS

- `push()` - Adds a new item in the end of the array
- `join()` - Concats each element of the array with a string
- `pop()` - Removes the last element from the array
- `shift()` - Removes the first element and replaces down the all another elements
- `unshift()` - Adds a new first element and replaces up the all another elements.
- `splice()` - Changes a piece of an array, adding, changing or removing elements in a position.
- `concat()` - Creates a new array merging two arrays.
- `slice()` - Slices out the elements receiving the positions in a new array.
- `toString()` - Convert an array in a string.
- `sort()` - Sorts alphabetically an array
- `reverse()` - Reverse the order of the array
- `forEach()` - Calls a function once to each array element.
- `map()` - Creates a new array by according the result of a function of each array element.
- `filter()` - Creates a new filtered array by according the true value of a logical test.
- `every()` - Do a function if all array elements has true value for a logical test.
- `some()` - Check if some array values are by according a logical test.
- `indexOf()` - Search the first position of an array element.
- `lastIndexOf()` - Search the last position of an array element.
- `find()` - Return the value of the first array element that attend a constraint test function.
- `findIndex()` - Return the index of the first array element that attend a constraint test function.

## Set

- `add(value)` - Adds a new element with the specified value to the Set.
- `clear()` - Removes all elements from the Set.
- `delete(value)` - Removes the specified element from the Set.
- `has(value)` - Returns `true` if an element with the specified value exists in the Set; otherwise, `false`.
- `forEach(callbackFn[, thisArg])` - Executes the provided callback function once for each value in the Set, in insertion order.
- `values()` - Returns a new Iterator object that contains the values for each element in the Set in insertion order.
- `keys()` - Same as `values()`, returns a new Iterator object that contains the values for each element in the Set.
- `entries()` - Returns a new Iterator object that contains an array of [value, value] for each element in the Set, reflecting the fact that each key is identical to its value in a Set.
- `size` - Returns the number of values in the Set.

## Map

- `set(key, value)` - Sets the value for a key in the Map.
- `get(key)` - Returns the value associated to the key, or undefined if there is none.
- `has(key)` - Returns a boolean asserting whether a value has been associated to the key in the Map or not.
- `delete(key)` - Deletes a Map element specified by the key.
- `clear()` - Removes all elements from the Map.
- `size` - Returns the number of key/value pairs in the Map.
- `keys()` - Returns a new Iterator object that contains the keys for each element in the Map in insertion order.
- `values()` - Returns a new Iterator object that contains the values for each element in the Map in insertion order.
- `entries()` - Returns a new Iterator object that contains an array of [key, value] for each element in the Map in insertion order.
- `forEach(callbackFn[, thisArg])` - Calls `callbackFn` once for each key-value pair present in the Map object, in insertion order.

## JSON

- `JSON.parse(text[, reviver])` - Parses a JSON string, constructing the JavaScript value or object described by the string. An optional `reviver` function can be provided to perform a transformation on the resulting object before it is returned.
- `JSON.stringify(value[, replacer[, space]])` - Converts a JavaScript value to a JSON string. The `replacer` is an optional parameter that can be a function or an array to specify which properties of the object should be included in the resulting JSON string. The `space` argument is used to insert white space into the output JSON string for readability purposes.


## DATA TYPE TRANSFORMATION

- `Number()` - Converts a string or a date to number
- `parseInt()` - Converts a string to integer number
- `parseFloat()` - Converts a string to float number
