## STRINGS

```javascript
function countOcorrences(baseString){
	const ocorrences = (baseString.match(/React/g) || []).length
	return ocorrences 
}
```


## ARRAYS

```javascript
function orderAToZ(arr){
	return arr.sort((a, b) => {
		if(a.toLowerCase() < b.toLowerCase()) return -1
		if(a.toLowerCase() > b.toLowerCase()) return 1
		return 0
	})
}


function orderZToA(arr){
	return arr.sort((a, b) => {
		if(a.toLowerCase() < b.toLowerCase()) return 1
		if(a.toLowerCase() > b.toLowerCase()) return -1
		return 0
	})
}


function shuffleList(arr){
	return arr.sort(() => Math.random() - 0.5)
}


function filterByExactTitle(arr, term){
	return arr.filter( item => item.title.toLowerCase() === term.toLowerCase())
}


function removeDuplicated(arr){	
	const removeDuplicate = arr.filter((value, index) => arr.indexOf(value) === index)
	return removeDuplicate
}


function randomValue(arr){
	return arr[Math.floor(Math.random() * arr.length)]
}

function repeatedInArray(){
	const test = [1,2,1,2,1,1]
	let count = 0
	const filter = test.map(el => {
		if(el.map(el === el)){
			count ++
			return el
		}
	})
	return filter
}

console.log(repeatedInArray())


//Generating arrays programmatically
Array.from(Array(31), (_,index) =>index + 1)

//Generating spaced arrays programmatically
function provideYearsInterval(start, stop, step) {
  return Array.from(
    { length: (stop - start) / step + 1 },
    (_, i) => start + i * step
  );

//Check each value between two arrays if each one is greater than another

const arr1 = [1, 2, 3]
const arr2 = [2, 33, 4]

function checkEachValueIsGreaterThanAnother(arr1: number[], arr2: number[]) {
    if (arr1.length === arr2.length) {
        let i: number = 0;
        let check: boolean[] = []
        for (i; i < arr1.length; i++) {
            const isHigh = arr2[i] > arr1[i]
            check.push(isHigh)
        }
        if (check.every(el => el === true)) {
            console.log('Is all numbers of the second array greater than first array')
        } else {
            console.log('Is not all numbers of the second array greater than first array')
        }
    } else {
        console.log('Impossible to calc')
    }
}

checkEachValueIsGreaterThanAnother(arr1, arr2)
```
### REGEX
```javascript
const searchSpecificString = () => {
	const sentence = 'Better than yesterday'
	const checkSentence = /Better/g
	const result = sentence.match(checkSentence)
	result != null? console.log(result) : 
	console.log('Not found the desired string') 
}



const searchAnyString = () => {
	const sentence = 'Beetter than yesterday'
	const checkSentence = /([a-z])/gi
	const result = sentence.match(checkSentence)
	console.log(result)
}



const searchAnyDigit = () => {
	const numbers = '1,2,3,3,33,33,23'
	const checkNumbers = /(\d)/g //or /[0-9]/g 
	const result = numbers.match(checkNumbers)
	console.log(result)
}



const verifySpaces = () => {
	const sentence = 'Beetter than yesterday'
	const checkSentence = /(\s)/g
	const result= sentence.match(checkSentence)
	result !== null? console.log(result) : 
console.log('No has spaces found')
}



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



const getDifferentDigit = () => {
	const sentence = 'I borned in 1995'
	const checkSentence = /[^0-9]/g //or /(\D)/g
	const result = sentence.match(checkSentence)
	console.log(result)
}



const searchAlphaNumeric = () => {
	const sentence = 'Realize 100%'
	const checkSentence = /\w/g
	const result = sentence.match(checkSentence)
	console.log(result)
}



const searchSpecialCharacters = () => {
	const sentence = 'Realze 100%'
	const checkSentence = /\W/g
	const result = sentence.match(checkSentence)
	console.log(result)
}



const groupNumbers = () => {
	const numbers = '122212 121212 1111 11'
	const checkNumbers = /\d{4}/g
	const result = numbers.match(checkNumbers)
	console.log(result)
}



const getWordsWithInitialsLetterA = () => {
	const sentence = 'Ada an a beautiful woman'
	const checkSentence = /\b[Aa]\w+/g
	const result = sentence.match(checkSentence)
	console.log(result)
}



const checkPlateCar = () => {
	const plate = 'ABC-1234'
	const checkPlate = plate.match(/([A-Z]){3}\-\d{4}/g)
	checkPlate == null? console.log('Not found') : 
	console.log(checkPlate)
}



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
```



