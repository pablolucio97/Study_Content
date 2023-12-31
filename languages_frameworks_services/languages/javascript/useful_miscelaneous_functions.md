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




