/* 1. Write a JavaScript program to display the current day and time in the following format.  Go to the editor
Sample Output : Today is : Tuesday.
Current time is : 10 PM : 30 : 38 */

function showCurrentDayAndTime() {
    var daylist = ["Sunday", "Monday", "Tuesday", "Wednesday ", "Thursday", "Friday", "Saturday"];
    const startDte = new Date();
    const day = new Date().getDay()
    var hour = startDte.getHours();
    var minute = startDte.getMinutes();
    var second = startDte.getSeconds();
    console.log(daylist[day], `${hour}:${minute}:${second}`)
}

showCurrentDayAndTime()

/* Write a JavaScript program to find the area of a triangle */

function calcTriangle(a, b, c) {
    return console.log((a * b) / c)
}

calcTriangle(1, 43, 5)


/* Write a JavaScript program to rotate the string 'w3resource' in right direction by periodically removing one letter from the end of the string and attaching it to the front */


/* Write a JavaScript program to find which 1st January is being a Sunday between 2014 and 2050. */

function checkInitialDayOnYear(){
    for(let year = 2014; year <= 2050; year ++){
        const startDate = new Date(year, 0, 1)
        if(startDate.getDay() === 0){
            console.log(`1st January is being a Sunday  ${year}`)
        }
    }
}

checkInitialDayOnYear()

/* Write a JavaScript program to calculate days left until next Christmas. */

function daysLakeToNextChirstmas(){
    const startDate = new Date()
    const christmasDate = new Date(startDate.getFullYear(), 11, 25)
    var oneDay = 1000 * 60 * 60 * 24
    console.log(`Lakes ${Math.ceil((christmasDate.getTime() - startDate.getTime()) / (oneDay))} days to Christmas.`)
 }

 daysLakeToNextChirstmas()


 //Write a function to calc in wich days the date 11/05 is on sundays between 2021 and 2090

 function sundaysOn11May(){
    for(let year = 2021; year < 2090 ; year ++){
        const dates = new Date(year, 05,11)
        if(dates.getDay() === 0){
            console.log(`Is sunday on ${year}`)
        }        
    }
 }

 sundaysOn11May()


 //Write a JavaScript program to convert temperatures to and from Celsius, Fahrenheit

 function convetFahrenheihtToCelsius(n){
    const result = (n - 32) * (5/9)
    console.log(`${result} fahenreiht degrees is ${n} celsius degress.`)
 }

 convetFahrenheihtToCelsius(600)


 /* Write a JavaScript program to compute the sum of the two given integers. If the two values are same, then returns triple their sum. */


 function sumTwoNumbers(n1, n2){
     if(n1 === n2){
         return console.log((n1 + n2) * 3)
     }else{
         return console.log(n1 + n2)
     }
 }

 sumTwoNumbers(4,4)


/*  Write a JavaScript program to get the difference between a given number and 13, if the number is greater than 13 return double the absolute difference. */

function diffBy13(n1){
    if(n1 > 13){
        return console.log((n1 - 13) * 2)
    }else{
        return console.log(13 - n1)
    }
}

/* Write a JavaScript program to check two given numbers and return true if one of the number is 50 or if their sum is 50 */

function check50(n1, n2){
    if(n1 === 50 || n2 === 50 || n1 + n2 === 50){
    return console.log(true)
}else{
    return console.log(false)
}
}

check50(50,3)

/* Write a JavaScript program to create a new string adding "Py" in front of a given string. If the given string begins with "Py" then return the original string. */

function checkPy(word){
    if(word.indexOf('Py') === -1){
        console.log(`Py${word}`)
    }else{
        console.log(word)
    }
}

checkPy('apple')

/* Write a JavaScript program to create a new string from a given string with the first character of the given string added at the front and back.
 */

function newStringFromFirst(word){
    const firstLetter = word.substring(0,1)
    const newWord = firstLetter.concat(word).concat(firstLetter)
    console.log(newWord)
}

newStringFromFirst('pablo')

/* Write a JavaScript program to check whether a given positive number is a multiple of 3 or a multiple of 7 */

function chechMultiple3Or7(n){
    if(n % 3 === 0 || n % 7 === 0){
        return console.log(true)
    }else{
        return console.log(false)
    }
}

chechMultiple3Or7(11)

/* Write a JavaScript program to check whether a string starts with 'Java' and false otherwise */

function checkBeginsWithJava(word){
    if(word.substring(0,4) === 'JAVA'){
        return console.log(true)
    }else{
        return console.log(false)
    }
}

checkBeginsWithJava('JAVAscript')

/* Write a JavaScript program to find the largest of three given integers */

function returnTheLargerNumber(n1, n2, n3){
    if(n1 > n2 && n1 > n3){
        return console.log(n1)
    }else if(n2 > n1 && n2 > n3){
       return console.log(n2)
    }else{
        console.log(n3)
    }
}

returnTheLargerNumber(11,22,4)

/* Write a JavaScript program to find the larger number from the two given positive integers, the two numbers are in the range 40..60 inclusive. */

function largerBetween40And60(n1, n2){
    if(n1 > 40 && n1 < 60 && n2 > 40 && n2 < 60 ){
        if(n1 > n2){
            return console.log(n1)
        }else{
            return console.log(n2)
        }
    }else{
        return console.log('Both numbers should be between 40 and 60.')
    }
}

largerBetween40And60(43, 34)

/* Write a JavaScript program to check two given non-negative integers that whether one of the number (not both) is multiple of 7 or 11. */

function checkDivisibleBy7Or11(n){
    if(n % 7 === 0 || n % 11 === 0){
        return console.log(true)
    }else{
        console.log(false)
    }
}

checkDivisibleBy7Or11(23)


/* Write a JavaScript program to reverse a given string */

function reverseString(string){
    const reversed = string.split('').reverse().join()
    console.log(reversed)
}

reverseString('pablo')


/* Write a JavaScript program to capitalize the first letter of each word of a given string */

function capitalizeWords(sentence){
    const capitalize = sentence.split(' ')
    .map(letter => letter.substring(0,1).toUpperCase() + letter.substring(1, letter.length))
    .toString()
    console.log(capitalize)
}

capitalizeWords('test is a test')

/* Writes a Fibbonaci function */



function fibbonaci(){
    
let fib = []; // Initialize array!

fib[0] = 0;
fib[1] = 1;
for (let i = 2; i <= 10; i++) {
  // Next fibonacci number = previous + one before previous
  // Translated to JavaScript:
  fib[i] = fib[i - 2] + fib[i - 1];
  console.log(fib[i]);
}
}

fibbonaci()


const names = ['Fulan', 'Beltran', 'Ciclan']
const photos = ['nsd9f8sdfsdf.jpg', 'sdnfo8374rodf.jpg', 'shdfgo8asfdf.jpg']

const formatedNamesAndPhotos = () => names.map((name, index) => {
    return  console.log({...name, img: photos[index]}) 
})

formatedNamesAndPhotos()