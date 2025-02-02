# DATA STRUCTURE

## STACKS

Stacks are like arrays, where data is stacked and unstacked through operations like push and pop. Unstacking is done in reverse order.

## CONVERTING NUMBERS TO BINARY NUMBERS

To convert decimal numbers to binary, split the number by 2 and separate the division remainder. When the number can no longer be divided by 2, collect all remainders and arrange them in reverse order to get the binary number.

Example: Converting the number 10 to binary:
10/2 = 5(0) => 5/2 = 2(1) => 2/2 = 1(0) => 1/2 = 0(1) = 1010

## QUEUES

In queues, elements are inserted at the last position, and the first element in the queue is the first to be removed.

## LISTS

Lists are sets without a predefined length.

## BINARY SEARCH

Binary search is a method that splits the search logarithmically, breaking long lists into shorter ones to find the desired value. It requires that the array is ordered.

# GENERAL TIPS

- In stacks, the last element that enters is the first to be popped, whereas in queues, the first element that enters is the first to be popped.
- Stacks and queues have a default length, whereas lists have unlimited length.
- Use binary search for looping through long arrays.