//STRINGS

function countOcorrences(baseString){
	const ocorrences = (baseString.match(/React/g) || []).length
	return ocorrences 
}


//ARRAYS

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
			return el
		}
	})
	return filter
}

console.log(repeatedInArray())


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

//MATHS AND MONEY

function maxValue(arr){
	return Math.max.apply(null, arr)
}


function minValue(arr){
	return Math.min.apply(null, arr)
}


function formatBRL(n){
	const formated = new Intl.NumberFormat('pt-BR',{
		style: 'currency',
		currency: 'BRL'
	}).format(n)
}


function formatUSD(n){
	const formated = new Intl.NumberFormat('en-US',{
		style: 'currency',
		currency: 'USD'
	}).format(n)
}


function calcDiscount(value, discountPercentage){
	return Number((value * discountPercentage) / 100)
}


function calcProportion(n1, proportion, n2){
	return Number((n2 * proportion) / n1)
}


function calcPercentage(n1, n2){
	return Number((n1 / n2) * 100)
}


//DATE AND TIME

function showCurrentTime(){
	let hours = new Date().getHours()
	let minutes = new Date().getMinutes()

	if(hours < 10){
		hours = `0${hours}`
	}

	if(minutes < 10){
		minutes = `0${minutes}`
	}

	return`${hours}:${minutes}`
}


function renderClock(){
	setInterval(() => {
	let hours = new Date().getHours()
	let minutes = new Date().getMinutes()
	let seconds = new Date().getSeconds()

	if(hours < 10){
		hours = `0${hours}`
	}

	if(minutes < 10){
		minutes = `0${minutes}`
	}

	if(seconds < 10){
	seconds = `0${seconds}`
	}

	return`${hours}:${minutes}:${seconds}`
}, 1000)
}
	

function showCurrentDate(){
	return new Intl.DateTimeFormat('pt-BR',{
		month: 'numeric',
		day:'numeric',
		year: 'numeric'
	}).format(new Date())
}

function showLiteralCurrentDate(){
	return new Intl.DateTimeFormat('pt-BR', {
		month: 'long',
		day: 'numeric',
		year: 'numeric'
	}).format(new Date())
}


function greetUser(user){
	const hours = new Date().getHours()
	const minutes = new Date().getMinutes()

	if(hours < 13){
		return `Good morning, ${user}!`
	}

	if(hours > 12 && hours < 18){
		return `Good afternoon ${user}!`
	}

	if(hours > 17){
		return `Good night ${user}!`
	}
}

function daysLakesTo(event){
	const ONE_DAY = 3600 * 1000 * 24
	event = new Date(2021, 11, 25)
	return Number(Math.floor((event.getTime() - new Date().getTime()) /ONE_DAY )).toFixed(0)
}

function datesDifference(finalDate, initialDate){
	const ONE_DAY  = 3600 * 1000 * 24
	return Number((finalDate - initialDate) / ONE_DAY)
}


//COLORS

function generateHEXRandomColor(){

	const hexValues = ['A', 'B', 'C', 'D', 'E', 'F']
	const numbersValues = [1,2,3,4,5,6,7,8,9,0]
	const randomHex1 = hexValues[Math.floor(Math.random() * hexValues.length)]
	const randomNumber1 = String(numbersValues[Math.floor(Math.random() * numbersValues.length)])
	const randomHex2 = hexValues[Math.floor(Math.random() * hexValues.length)]
	const randomNumber2 = String(numbersValues[Math.floor(Math.random() * numbersValues.length)])
	const randomHex3 = hexValues[Math.floor(Math.random() * hexValues.length)]
	const randomNumber3 = String(numbersValues[Math.floor(Math.random() * numbersValues.length)])

	 const hexColor = 
		randomHex1 + randomNumber1 + 
		randomHex2 + randomNumber2 + 
		randomHex3 + randomNumber3 
	return	hexColor

}

function generateRGBRandomColor(){
	const r = String((Math.random() * 255).toFixed(0))
	const g = String((Math.random() * 255).toFixed(0))
	const b = String((Math.random() * 255).toFixed(0))
	return `(${r},${g},${b})`
}

function generateRGBARandomColor(){
	const r = String((Math.random() * 255).toFixed(0))
	const g = String((Math.random() * 255).toFixed(0))
	const b = String((Math.random() * 255).toFixed(0))
	const a = String((Math.random() * 1).toFixed(1))
	return `(${r},${g},${b},${a})`
}


//WEB

function saveToLocalStorage(key, value){
	return localStorage.setItem(key, JSON.stringify(value))
}

function readFromLocalStorage(key){
	return JSON.parse(localStorage.getItem(key))
}

function removeLocalStorage(key){
	return sessionStorage.removeItem(key)
}

function saveToSessionStorage(key, value){
	return sessionStorage.setItem(key, JSON.stringify(value))
}

function readFromSessionStorage(key){
	return JSON.parse(sessionStorage.getItem(key))
}

function removeSessionStorage(key){
	return sessionStorage.removeItem(key)
}


function pagination (arr, startPage, endPage, itemsPerPage){
	const returnedArr = arr.slice(0, itemsPerPage)
	const buttons = 1
}