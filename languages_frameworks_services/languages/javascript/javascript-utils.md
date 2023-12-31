 ALTERING OBJECTS VALUES INSIDE ARRAYS
 
 In this case an array of tasks with id, title, and isComplete props
 will be looped and the object with id that matchs with the id params 
 will be changed your prop isComplete:
  
  function handleToggleTaskCompletion(id: number) {
    const alteredTasks = tasks.map(task => task.id === id ? {
      ...task,
      isComplete: !task.isComplete
    } : task)

    setTasks(alteredTasks)
  }

  ----------------CHANGING STYLES WITH JAVASCRIPT-----------------------

examples:

example 01:
document.getElementById('dvi1').style.color = 'red'
----------------------------------------------------------------------
example 02:
document.getElementById('dvi1').style.backgroundColor = 'cyan'
----------------------------------------------------------------------
example 03:
document.getElementById('dvi1').style.width = '150px'
----------------------------------------------------------------------
example 04: 
document.getElementById('dvi1').style.transform = "skew(30deg, 30deg)";
----------------------------------------------------------------------
example 05: 
document.getElementById("GFG").style.transform = "rotateZ(90deg)";

### Comparing objects

    function compareObjs (a,b) {

        a = {
            name: 'Pablo',
            age: 26
        }

        b = {
            name: 'Pablo',
            age: 26
        }

        if(JSON.stringify(a) === JSON.stringify(b)){
            console.log('The objects are equals')
        }else{
            console.log('The objects not are equals')
        }
    }

### Generating arrays programmatically

Array.from(Array(31), (_,index) =>index + 1)

### Generating spaced arrays programmatically

function provideYearsInterval(start, stop, step) {
  return Array.from(
    { length: (stop - start) / step + 1 },
    (_, i) => start + i * step
  );
}

### Generating random numbers

function getRndInteger(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}

### Shuffle arrays

let shuffled = myArray.sort(() => Math.random() - 0.5)


### Finding min and max values from arrays

var points = [40, 100, 1, 5, 25, 10];

function myArrayMax(arr) {
  return Math.min.apply(null, arr);
}

myArrayMax(points)


### Getting the last item from array

const myArray = [1,2,4,7,8,3,2]

const lastItem = myArray.slice(-1)[0]



## Regex examples

const searchSpecificString = () => {
	const sentence = 'Better than yesterday'
	const checkSentence = /Better/g
	const result = sentence.match(checkSentence)
	result != null? console.log(result) : 
	console.log('Not found the desired string') 
}

-----------------------------------------------------------------------

const searchAnyString = () => {
	const sentence = 'Beetter than yesterday'
	const checkSentence = /([a-z])/gi
	const result = sentence.match(checkSentence)
	console.log(result)
}

-----------------------------------------------------------------------

const searchAnyDigit = () => {
	const numbers = '1,2,3,3,33,33,23'
	const checkNumbers = /(\d)/g //or /[0-9]/g 
	const result = numbers.match(checkNumbers)
	console.log(result)
}

-----------------------------------------------------------------------

const verifySpaces = () => {
	const sentence = 'Beetter than yesterday'
	const checkSentence = /(\s)/g
	const result= sentence.match(checkSentence)
	result !== null? console.log(result) : 
console.log('No has spaces found')
}

-----------------------------------------------------------------------

const checkingEmail = () => {
	//acepts only @hotmail.com and @yahoo.com format
	const email = 'camila@yahoo.com'
	const checkEmail = /@+\w+\W+\w+/g
	const result = email.match(checkEmail)
	result =='@hotmail.com' || result == 
	'@yahoo.com' ? console.log('Aproved domain') : 
	console.log('Reproved domain')
	console.log(result)
}

-----------------------------------------------------------------------

const checkCPF = () => {
	const cpf = '119.294.216-81'
	const checkCPF = /\d{3}\.\d{3}\.\d{3}\-\d{2}/g
	const cpfWithOutSpecialCharacters = /\d+/g
	const result = cpf.match(checkCPF)
	const result2 = cpf.match(cpfWithOutSpecialCharacters)
	cpf == result || cpf == result2 ? console.log('CPF Aproved') : 
	console.log('CPF Reproved')
	console.log(result2)
}

-----------------------------------------------------------------------

const getDifferentDigit = () => {
	const sentence = 'I borned in 1995'
	const checkSentence = /[^0-9]/g //or /(\D)/g
	const result = sentence.match(checkSentence)
	console.log(result)
}

-----------------------------------------------------------------------

const searchAlphaNumeric = () => {
	const sentence = 'Realize 100%'
	const checkSentence = /\w/g
	const result = sentence.match(checkSentence)
	console.log(result)
}

-----------------------------------------------------------------------

const searchSpecialCharacters = () => {
	const sentence = 'Realze 100%'
	const checkSentence = /\W/g
	const result = sentence.match(checkSentence)
	console.log(result)
}

-----------------------------------------------------------------------

const groupNumbers = () => {
	const numbers = '122212 121212 1111 11'
	const checkNumbers = /\d{4}/g
	const result = numbers.match(checkNumbers)
	console.log(result)
}

-----------------------------------------------------------------------

const getWordsWithInitialsLetterA = () => {
	const sentence = 'Ada an a beautiful woman'
	const checkSentence = /\b[Aa]\w+/g
	const result = sentence.match(checkSentence)
	console.log(result)
}

-----------------------------------------------------------------------

const checkPlateCar = () => {
	const plate = 'ABC-1234'
	const checkPlate = plate.match(/([A-Z]){3}\-\d{4}/g)
	checkPlate == null? console.log('Not found') : 
	console.log(checkPlate)
}

-----------------------------------------------------------------------

const checkStringInitialsAndEnd = () => {
	const str = 'Sou programador digital'
	const pattern1 = /^Sou ./g
	const pattern2 = /.digital$/g
	const pattern3 = /./g
	const result3 = str.match(pattern3)
	console.log(pattern1.test(str))
	console.log(pattern2.test(str))
	console.log(result3)
}


## JavaScript exercises list:

### Strings
- Count string occurrences over another string.
- Reverse a given string.
- Check if a string is a palindrome.
- Convert the first letter of each word in a string to uppercase.
- Find the longest word in a string.
- Count the number of vowels in a string.
- Replace a specific word in a string.
- Convert a string into camelCase format.
- Split a string into an array of words.
- Check if a string contains a specific substring.
- Concatenate two strings without using the `+` operator.

### Arrays
- Sort descending order the items of an array.
- Sort ascending order the items of an array.
- Calc the sum of items of an array.
- Shuffle all items from an array.
- Filter an object by its name.
- Check how many repetitions are an array of a specific value.
- Remove array's duplicated items.
- Select randomly an item from an array.
- Check if each item in two different arrays is greater the another item in the same position.
- Convert an array into an object.
- Merge two arrays without duplicates.
- Find the maximum/minimum value in a number array.
- Create an array of numbers from 1 to n.
- Group elements of an array based on a specific property or value.
- Flatten a multi-dimensional array.
- Convert all elements in an array to a specific data type (e.g., all to strings).
- Find the intersection of two arrays.
- Rotate the elements of an array (left or right).
- Find the difference between two arrays.
- Create a deep copy of a multi-dimensional array.

### Math and Numbers
- Return a random number between 0 and 100.
- Check if a number is prime.
- Calculate the factorial of a number.
- Find the greatest common divisor (GCD) of two numbers.
- Convert a decimal number to binary.
- Calculate the average of an array of numbers.
- Implement a function for linear interpolation between two points.
- Calculate compound interest.
- Find the nth Fibonacci number.
- Round a number to a specified number of decimal places.
- Generate a list of prime numbers up to n.

### Objects
- Sort descending an object's keys. 
- Transform all keys to upper case of an object.
- Transform an object into an array.
- Transform an array into an object.
- Compare if two objects are equals.
- Merge two objects into one.
- Delete a property from an object.
- Check if an object contains a specific property or value.
- Count the number of properties in an object.
- Deep clone an object.
- Map an object's properties to a different structure.
- Filter an object's properties based on a condition.
- Invert keys and values of an object.
- Implement a nested property access function (e.g., access `obj['a']['b']` using a string like `'a.b'`).
- Aggregate data from an array of objects based on a property (e.g., sum of ages).


Solutions



