# Programming Concepts with Simple TypeScript Examples

This guide reviews the main concepts that appeared in the assessment using simple TypeScript examples.

---

## 1. Singly Linked List

A singly linked list is formed by nodes. Each node stores:

- A value
- A reference to the next node

```ts
class ListNode<T> {
  value: T;
  next: ListNode<T> | null = null;

  constructor(value: T) {
    this.value = value;
  }
}

const first = new ListNode("A");
const second = new ListNode("B");
const third = new ListNode("C");

first.next = second;
second.next = third;

console.log(first.value); // A
console.log(first.next?.value); // B
```

The structure is:

```text
A -> B -> C -> null
```

### Main complexities

| Operation | Complexity |
|---|---:|
| Insert at the beginning | O(1) |
| Remove from the beginning | O(1) |
| Search for an element | O(n) |
| Access element by index | O(n) |

Linked lists do not move all elements when adding a new node.

---

## 2. Removing a Node from a Linked List

To remove a node, the previous node must point to the node after the removed one.

Before:

```text
A -> B -> C -> D -> E
```

Removing `D`:

```text
C.next = D.next
```

After:

```text
A -> B -> C -> E
```

TypeScript example:

```ts
function removeAfter<T>(previous: ListNode<T>): void {
  if (previous.next === null) {
    return;
  }

  previous.next = previous.next.next;
}

const a = new ListNode("A");
const b = new ListNode("B");
const c = new ListNode("C");
const d = new ListNode("D");

a.next = b;
b.next = c;
c.next = d;

// Removes D because C is the previous node.
removeAfter(c);

console.log(c.next); // null
```

The important idea is that deleting a node normally requires access to the previous node.

---

## 3. Doubly Linked List

A doubly linked list stores references in both directions.

```ts
class DoublyListNode<T> {
  value: T;
  previous: DoublyListNode<T> | null = null;
  next: DoublyListNode<T> | null = null;

  constructor(value: T) {
    this.value = value;
  }
}
```

Example:

```ts
const nodeA = new DoublyListNode("A");
const nodeB = new DoublyListNode("B");

nodeA.next = nodeB;
nodeB.previous = nodeA;

console.log(nodeA.previous); // null
console.log(nodeB.previous?.value); // A
```

The first node normally has:

```ts
first.previous === null
```

The last node normally has:

```ts
last.next === null
```

---

## 4. Queue

A queue follows the FIFO rule:

> First In, First Out

The first element added is the first one removed.

```text
enqueue -> A, B, C -> dequeue
```

Simple TypeScript implementation:

```ts
class Queue<T> {
  private items: T[] = [];

  enqueue(item: T): void {
    this.items.push(item);
  }

  dequeue(): T | undefined {
    return this.items.shift();
  }

  peek(): T | undefined {
    return this.items[0];
  }

  isEmpty(): boolean {
    return this.items.length === 0;
  }
}

const queue = new Queue<string>();

queue.enqueue("A");
queue.enqueue("B");
queue.enqueue("C");

console.log(queue.dequeue()); // A
console.log(queue.dequeue()); // B
```

### Important note

Using `Array.shift()` is easy to understand, but in JavaScript it can be O(n), because remaining elements may be reindexed.

A queue implemented with a linked list can perform both insertion and removal in O(1).

---

## 5. Queue with a Linked List

```ts
class LinkedQueue<T> {
  private head: ListNode<T> | null = null;
  private tail: ListNode<T> | null = null;

  enqueue(value: T): void {
    const newNode = new ListNode(value);

    if (this.tail === null) {
      this.head = newNode;
      this.tail = newNode;
      return;
    }

    this.tail.next = newNode;
    this.tail = newNode;
  }

  dequeue(): T | undefined {
    if (this.head === null) {
      return undefined;
    }

    const value = this.head.value;
    this.head = this.head.next;

    if (this.head === null) {
      this.tail = null;
    }

    return value;
  }
}
```

Complexities:

| Operation | Complexity |
|---|---:|
| Enqueue | O(1) |
| Dequeue | O(1) |

No element shifting is required.

---

## 6. Hash Table and Map

A hash table stores values using keys.

In TypeScript and JavaScript, `Map` is a practical built-in structure for this purpose.

```ts
const usersById = new Map<number, string>();

usersById.set(1, "Ana");
usersById.set(2, "Carlos");

console.log(usersById.get(1)); // Ana
console.log(usersById.has(2)); // true

usersById.delete(2);
```

Average complexities:

| Operation | Average complexity |
|---|---:|
| Insert | O(1) |
| Search | O(1) |
| Delete | O(1) |

---

## 7. Hash Collisions

A collision happens when different keys produce the same internal position.

Simplified example:

```ts
function simpleHash(value: string): number {
  return value.length % 5;
}

console.log(simpleHash("cat")); // 3
console.log(simpleHash("dog")); // 3
```

Both strings produce the same index.

A real hash table handles collisions using strategies such as:

- Chaining
- Open addressing

Collisions do not automatically cause:

- Stack overflow
- Out-of-memory errors
- Segmentation faults

However, too many collisions reduce performance.

---

## 8. Using a Hash Table for Fast Lookup

Suppose we want to store antonym pairs:

```ts
const antonyms = new Map<string, string>();

antonyms.set("hot", "cold");
antonyms.set("fast", "slow");
antonyms.set("light", "dark");

console.log(antonyms.get("hot")); // cold
```

This is usually faster than searching every item in an array or linked list.

Array search:

```ts
const pairs: Array<[string, string]> = [
  ["hot", "cold"],
  ["fast", "slow"],
  ["light", "dark"],
];

const result = pairs.find(([word]) => word === "hot");

console.log(result?.[1]); // cold
```

The array search may require O(n).

The map lookup is O(1) on average.

---

## 9. Binary Search Tree

A Binary Search Tree follows this rule:

```text
Left values < Node value < Right values
```

Node definition:

```ts
class TreeNode {
  value: number;
  left: TreeNode | null = null;
  right: TreeNode | null = null;

  constructor(value: number) {
    this.value = value;
  }
}
```

Insertion:

```ts
function insert(root: TreeNode | null, value: number): TreeNode {
  if (root === null) {
    return new TreeNode(value);
  }

  if (value < root.value) {
    root.left = insert(root.left, value);
  } else {
    root.right = insert(root.right, value);
  }

  return root;
}

let root: TreeNode | null = null;

root = insert(root, 10);
root = insert(root, 5);
root = insert(root, 15);
```

Search:

```ts
function contains(root: TreeNode | null, value: number): boolean {
  if (root === null) {
    return false;
  }

  if (root.value === value) {
    return true;
  }

  if (value < root.value) {
    return contains(root.left, value);
  }

  return contains(root.right, value);
}

console.log(contains(root, 15)); // true
```

Complexities:

| Case | Search complexity |
|---|---:|
| Balanced tree | O(log n) |
| Completely unbalanced tree | O(n) |

---

## 10. Heap and Max Heap

A max heap keeps the largest value at the root.

Example:

```text
       90
      /  \
    57    25
```

Every parent is greater than or equal to its children.

A heap is usually stored in an array.

```ts
const maxHeap = [90, 57, 25, 13, 11, 9, 17];
```

For a node at index `i`:

```ts
const leftChildIndex = 2 * i + 1;
const rightChildIndex = 2 * i + 2;
const parentIndex = Math.floor((i - 1) / 2);
```

Example:

```ts
const heap = [90, 57, 25, 13, 11];

const rootValue = heap[0];
const leftChild = heap[1];
const rightChild = heap[2];

console.log(rootValue); // 90
console.log(leftChild); // 57
console.log(rightChild); // 25
```

---

## 11. HeapSort

HeapSort works in two main phases:

1. Build a max heap
2. Repeatedly move the largest element to the end

Simplified implementation:

```ts
function heapify(array: number[], size: number, rootIndex: number): void {
  let largest = rootIndex;
  const left = 2 * rootIndex + 1;
  const right = 2 * rootIndex + 2;

  if (left < size && array[left] > array[largest]) {
    largest = left;
  }

  if (right < size && array[right] > array[largest]) {
    largest = right;
  }

  if (largest !== rootIndex) {
    [array[rootIndex], array[largest]] = [
      array[largest],
      array[rootIndex],
    ];

    heapify(array, size, largest);
  }
}

function heapSort(array: number[]): number[] {
  const result = [...array];

  for (let i = Math.floor(result.length / 2) - 1; i >= 0; i--) {
    heapify(result, result.length, i);
  }

  for (let end = result.length - 1; end > 0; end--) {
    [result[0], result[end]] = [result[end], result[0]];
    heapify(result, end, 0);
  }

  return result;
}

console.log(heapSort([11, 2, 9, 13, 57, 25, 17, 1, 90, 3]));
```

Complexity:

```text
O(n log n)
```

---

## 12. Graphs

A graph contains:

- Vertices, also called nodes
- Edges, which connect vertices

Adjacency list example:

```ts
const graph = new Map<number, number[]>([
  [1, [2, 3]],
  [2, [1, 4, 5]],
  [3, [1, 6, 7]],
  [4, [2, 8]],
  [5, [2, 8]],
  [6, [3, 8]],
  [7, [3, 8]],
  [8, [4, 5, 6, 7]],
]);
```

---

## 13. Breadth-First Search

Breadth-First Search, or BFS, visits the graph level by level.

It uses a queue.

```ts
function bfs(
  graph: Map<number, number[]>,
  start: number,
): number[] {
  const visited = new Set<number>();
  const queue: number[] = [start];
  const order: number[] = [];

  visited.add(start);

  while (queue.length > 0) {
    const current = queue.shift();

    if (current === undefined) {
      break;
    }

    order.push(current);

    for (const neighbor of graph.get(current) ?? []) {
      if (!visited.has(neighbor)) {
        visited.add(neighbor);
        queue.push(neighbor);
      }
    }
  }

  return order;
}

console.log(bfs(graph, 6));
```

The exact order can depend on the order in which neighbors are stored.

Complexity:

```text
O(V + E)
```

Where:

- `V` is the number of vertices
- `E` is the number of edges

---

## 14. Depth-First Search

Depth-First Search, or DFS, follows one branch deeply before returning.

It uses recursion or a stack.

```ts
function dfs(
  graph: Map<number, number[]>,
  current: number,
  visited = new Set<number>(),
  order: number[] = [],
): number[] {
  visited.add(current);
  order.push(current);

  for (const neighbor of graph.get(current) ?? []) {
    if (!visited.has(neighbor)) {
      dfs(graph, neighbor, visited, order);
    }
  }

  return order;
}

console.log(dfs(graph, 6));
```

Complexity:

```text
O(V + E)
```

Remember:

- BFS uses a queue
- DFS uses a stack or recursion

---

## 15. Insertion Sort

Insertion Sort maintains a sorted section on the left.

Example:

```text
[17, 9, 2, 5]

[9, 17, 2, 5]
[2, 9, 17, 5]
[2, 5, 9, 17]
```

TypeScript implementation:

```ts
function insertionSort(values: number[]): number[] {
  const result = [...values];

  for (let i = 1; i < result.length; i++) {
    const current = result[i];
    let position = i - 1;

    while (position >= 0 && result[position] > current) {
      result[position + 1] = result[position];
      position--;
    }

    result[position + 1] = current;
  }

  return result;
}

console.log(insertionSort([17, 9, 2, 5, 6, 11]));
// [2, 5, 6, 9, 11, 17]
```

Complexity:

| Case | Complexity |
|---|---:|
| Best case | O(n) |
| Average case | O(n²) |
| Worst case | O(n²) |

It is useful for:

- Small arrays
- Almost sorted arrays
- Learning sorting fundamentals

---

## 16. Recursion

A recursive function calls itself.

Factorial example:

```ts
function factorial(value: number): number {
  if (value <= 1) {
    return 1;
  }

  return value * factorial(value - 1);
}

console.log(factorial(5)); // 120
```

Execution:

```text
factorial(5)
5 * factorial(4)
5 * 4 * factorial(3)
5 * 4 * 3 * factorial(2)
5 * 4 * 3 * 2 * factorial(1)
```

Time complexity:

```text
O(n)
```

Space complexity:

```text
O(n)
```

The space is O(n) because each call remains in the call stack until the recursion returns.

---

## 17. Iterative Factorial

An iterative version uses constant additional space.

```ts
function factorialIterative(value: number): number {
  let result = 1;

  for (let current = 2; current <= value; current++) {
    result *= current;
  }

  return result;
}
```

Complexities:

| Measurement | Complexity |
|---|---:|
| Time | O(n) |
| Additional space | O(1) |

This demonstrates the difference between time complexity and space complexity.

---

## 18. Big-O Complexity

Big-O describes how resource use grows as input size increases.

### O(1): Constant time

```ts
function getFirst<T>(items: T[]): T | undefined {
  return items[0];
}
```

The operation does not depend on the array size.

### O(n): Linear time

```ts
function containsValue(items: number[], target: number): boolean {
  for (const item of items) {
    if (item === target) {
      return true;
    }
  }

  return false;
}
```

The function may inspect every element.

### O(log n): Logarithmic time

Binary search repeatedly divides the search space in half.

```ts
function binarySearch(
  sortedValues: number[],
  target: number,
): number {
  let left = 0;
  let right = sortedValues.length - 1;

  while (left <= right) {
    const middle = Math.floor((left + right) / 2);
    const value = sortedValues[middle];

    if (value === target) {
      return middle;
    }

    if (value < target) {
      left = middle + 1;
    } else {
      right = middle - 1;
    }
  }

  return -1;
}

console.log(binarySearch([2, 5, 9, 11, 17], 11)); // 3
```

### O(n²): Quadratic time

```ts
function printAllPairs(items: number[]): void {
  for (const first of items) {
    for (const second of items) {
      console.log(first, second);
    }
  }
}
```

Two nested loops often indicate O(n²).

### O(n log n)

Efficient comparison-based sorting algorithms often have this complexity.

Examples:

- HeapSort
- Merge Sort
- QuickSort on average

---

## 19. Complexity Summary

| Structure or algorithm | Typical complexity |
|---|---:|
| Array access by index | O(1) |
| Linked list access by index | O(n) |
| Linked list insertion at head | O(1) |
| Queue enqueue with linked list | O(1) |
| Queue dequeue with linked list | O(1) |
| Hash table lookup, average | O(1) |
| Balanced BST lookup | O(log n) |
| BFS | O(V + E) |
| DFS | O(V + E) |
| HeapSort | O(n log n) |
| Insertion Sort, average | O(n²) |
| Recursive factorial time | O(n) |
| Recursive factorial space | O(n) |

---

## 20. SQL Subqueries

A subquery is a query inside another query.

Example:

```sql
SELECT first_name, last_name, salary
FROM employees
WHERE salary > (
  SELECT salary
  FROM employees
  WHERE title = 'HSK'
);
```

Logical execution:

1. Execute the inner query
2. Obtain the salary of the employee with title `HSK`
3. Use the result in the outer query
4. Return employees with a larger salary

The inner query must run first because the outer query depends on its result.

Conceptually:

```ts
const referenceSalary = findSalaryByTitle("HSK");

const employees = findEmployeesWithSalaryAbove(referenceSalary);
```

---

## 21. Main Concepts to Memorize

```text
Queue = FIFO
Stack = LIFO
BFS = Queue
DFS = Stack or Recursion
Hash table lookup = O(1) on average
Balanced BST search = O(log n)
Linked list search = O(n)
Max heap root = largest value
HeapSort = O(n log n)
Insertion Sort = O(n²) on average
Recursive factorial space = O(n)
SQL subquery = inner query before outer query
```

---

## 22. Quick Comparison

| Concept | Main idea |
|---|---|
| Array | Fast access by index |
| Linked List | Fast insertion when node position is known |
| Queue | First item added is the first removed |
| Stack | Last item added is the first removed |
| Hash Table | Fast lookup by key |
| BST | Ordered tree for searching |
| Heap | Quickly accesses minimum or maximum |
| BFS | Explores level by level |
| DFS | Explores one branch deeply |
| Insertion Sort | Inserts each item into a sorted section |
| Recursion | Function calls itself |
| Subquery | SQL query nested inside another query |
