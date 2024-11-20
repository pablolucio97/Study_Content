# NodeJS introduction course, main concepts

# Table of Contents

- [NodeJS introduction course, main concepts](#nodejs-introduction-course-main-concepts)
- [Table of Contents](#table-of-contents)
- [Asynchronous Programming](#asynchronous-programming)
  - [Asynchronous Programming in Node.js](#asynchronous-programming-in-nodejs)
  - [What is Asynchronous Programming?](#what-is-asynchronous-programming)
  - [Why is Asynchronous Programming Important in Node.js?](#why-is-asynchronous-programming-important-in-nodejs)
  - [Core Asynchronous Patterns in Node.js](#core-asynchronous-patterns-in-nodejs)
    - [Callbacks](#callbacks)
- [Events Loops](#events-loops)
- [The Event Loop in Node.js](#the-event-loop-in-nodejs)
  - [How the Event Loop Works](#how-the-event-loop-works)
    - [1. **Timers Phase**](#1-timers-phase)
    - [2. **I/O Callbacks Phase**](#2-io-callbacks-phase)
    - [3. **Idle, Prepare Phase**](#3-idle-prepare-phase)
    - [4. **Poll Phase**](#4-poll-phase)
    - [5. **Check Phase**](#5-check-phase)
    - [6. **Close Callbacks Phase**](#6-close-callbacks-phase)
    - [7. **`process.nextTick()`**](#7-processnexttick)
  - [Best Practices for Using the Event Loop](#best-practices-for-using-the-event-loop)
- [Error Handling in Node.js](#error-handling-in-nodejs)
  - [Synchronous Error Handling](#synchronous-error-handling)
    - [Example:](#example)
  - [Asynchronous Error Handling](#asynchronous-error-handling)
    - [Callbacks:](#callbacks-1)
    - [Promises:](#promises)
    - [Async/Await:](#asyncawait)
  - [Uncaught Exceptions](#uncaught-exceptions)
  - [Promise Rejections](#promise-rejections)
  - [Best Practices for Error Handling](#best-practices-for-error-handling)
- [Streams in Node.js](#streams-in-nodejs)
  - [Types of Streams](#types-of-streams)
  - [Using Readable Streams](#using-readable-streams)
    - [Example:](#example-1)
  - [Using Writable Streams](#using-writable-streams)
    - [Example:](#example-2)
  - [Piping Streams](#piping-streams)
    - [Example:](#example-3)
  - [Handling Stream Errors](#handling-stream-errors)
    - [Example:](#example-4)
  - [Best Practices for Using Streams](#best-practices-for-using-streams)
- [Buffers in Node.js](#buffers-in-nodejs)
  - [Understanding Buffers](#understanding-buffers)
  - [Creating Buffers](#creating-buffers)
    - [Allocating a Buffer](#allocating-a-buffer)
    - [From Strings](#from-strings)
    - [From Arrays](#from-arrays)
  - [Working with Buffers](#working-with-buffers)
    - [Writing to a Buffer](#writing-to-a-buffer)
    - [Reading from a Buffer](#reading-from-a-buffer)
    - [Accessing Buffer Data](#accessing-buffer-data)
  - [Why Use Buffers?](#why-use-buffers)
  - [Buffer and Streams](#buffer-and-streams)
    - [Example with Streams](#example-with-streams)
  - [Buffer Limitations](#buffer-limitations)
  - [Conclusion](#conclusion)
- [Path Module in Node.js](#path-module-in-nodejs)
  - [Key Functions of the Path Module](#key-functions-of-the-path-module)
    - [Normalize Paths](#normalize-paths)
    - [Join Paths](#join-paths)
    - [Resolve Paths](#resolve-paths)
    - [Directory Name](#directory-name)
    - [Base Name](#base-name)
    - [Extension Name](#extension-name)
    - [Parse Paths](#parse-paths)
  - [Example: Parsing a Path](#example-parsing-a-path)
  - [Cross-Platform Compatibility](#cross-platform-compatibility)
    - [Using `path.win32` and `path.posix`](#using-pathwin32-and-pathposix)
  - [Conclusion](#conclusion-1)
- [File System Module in Node.js](#file-system-module-in-nodejs)
  - [Core Functions of the fs Module](#core-functions-of-the-fs-module)
    - [Reading Files](#reading-files)
    - [Writing Files](#writing-files)
    - [Appending to Files](#appending-to-files)
    - [Checking File Existence](#checking-file-existence)
    - [Deleting Files](#deleting-files)
    - [Watching Files](#watching-files)
  - [Best Practices for Using the fs Module](#best-practices-for-using-the-fs-module)
- [Child Process Module in Node.js](#child-process-module-in-nodejs)
  - [Overview](#overview)
  - [Key Functions of the Child Process Module](#key-functions-of-the-child-process-module)
    - [Exec](#exec)
    - [Spawn](#spawn)
    - [Fork](#fork)
  - [Error Handling](#error-handling)
  - [Use Cases](#use-cases)
  - [Conclusion](#conclusion-2)


# Asynchronous Programming

## Asynchronous Programming in Node.js

Asynchronous programming is a foundational concept in Node.js, enabling the runtime to perform non-blocking operations. This guide will delve into the key aspects of asynchronous programming in Node.js, including its importance, methods, and best practices.

## What is Asynchronous Programming?

Asynchronous programming allows a program to initiate a potentially time-consuming task and then move on to other tasks before the first one finishes. This is especially useful in web servers where operations like reading files, querying a database, or making an API call can be performed without blocking the server from handling other requests.

## Why is Asynchronous Programming Important in Node.js?

Node.js is designed with a non-blocking event-driven architecture, primarily for I/O-heavy operations. Using asynchronous programming:

- **Improves Scalability**: Handle multiple connections concurrently without waiting for tasks to complete.
- **Enhances Performance**: Reduces idle time by doing other operations while waiting for I/O tasks to complete.
- **Non-blocking Behavior**: Ensures that CPU-intensive operations don't block the main thread, preventing slowdowns.

## Core Asynchronous Patterns in Node.js

Node.js offers several patterns for managing asynchronous operations:

### Callbacks

The simplest form of asynchronous programming, where functions take an extra argument – a callback function that gets called when the operation completes.

```javascript
const fs = require('fs');

fs.readFile('/path/to/file', (err, data) => {
  if (err) throw err;
  console.log(data);
});
```
---

# Events Loops

# The Event Loop in Node.js

The event loop is a pivotal component of Node.js that allows it to perform non-blocking I/O operations. It enables Node.js to handle many operations asynchronously, which is essential for maintaining high performance in network applications and servers.

## How the Event Loop Works

Node.js uses a single-threaded model, but it can handle multiple I/O operations by leveraging the event loop. Here are the key phases of the event loop:

### 1. **Timers Phase**

This phase executes callbacks scheduled by `setTimeout()` and `setInterval()`.

`setTimeout(() => { console.log('Timer expired'); }, 1000);`

### 2. **I/O Callbacks Phase**

This phase is used for handling I/O-related callbacks, excluding close events, timers, and `setImmediate()` callbacks.

`fs.readFile('/path/to/file', (err, data) => { if (err) throw err; console.log(data); });`

### 3. **Idle, Prepare Phase**

An internal phase that the Node.js system uses to prepare for upcoming operations.

### 4. **Poll Phase**

The poll phase retrieves new I/O events and executes their associated callbacks.

### 5. **Check Phase**

`setImmediate()` callbacks are executed in this phase.

`setImmediate(() => { console.log('Immediate callback executed'); });`

### 6. **Close Callbacks Phase**

Handles callbacks for closing requests, such as socket shutdowns or closed connections.

### 7. **`process.nextTick()`**

While not a phase of the event loop, `process.nextTick()` allows developers to schedule callbacks to be invoked after the current operation completes, but before the event loop continues.

`process.nextTick(() => { console.log('Next tick callback'); });`

## Best Practices for Using the Event Loop

- **Avoid CPU-intensive tasks**: Since Node.js is single-threaded, CPU-bound tasks can block the event loop. Offload these tasks if possible.
- **Utilize asynchronous APIs**: Maximize the use of Node.js's non-blocking APIs to keep your application responsive.
- **Monitor event loop health**: Tools can help monitor the event loop latency and throughput, providing insights for optimization.

Understanding the event loop's operation is crucial for developing efficient Node.js applications. Proper usage ensures that applications remain responsive and performant under load.

---

# Error Handling in Node.js

Effective error handling is crucial in Node.js to ensure that your application is reliable, robust, and able to recover from unexpected situations. Here's how to handle errors in various scenarios in Node.js.

## Synchronous Error Handling

For synchronous code, you can use the traditional `try/catch` blocks to handle errors.

### Example:

`try {`
`  const result = someSynchronousOperation();`
`  console.log('Result:', result);`
`} catch (error) {`
`  console.error('Error caught:', error);`
`}`

## Asynchronous Error Handling

Asynchronous error handling can be performed using callbacks, promises, and async/await.

### Callbacks:

When using callbacks, errors are typically handled in the first argument, often referred to as the "error-first callback" pattern.

`fs.readFile('/path/to/file', (error, data) => {`
`  if (error) {`
`    console.error('Error reading file:', error);`
`    return;`
`  }`
`  console.log('File data:', data);`
`});`

### Promises:

With promises, you can handle errors using the `.catch()` method.

`doSomethingAsync()`
`.then(result => {`
`  console.log('Success:', result);`
`})`
`.catch(error => {`
`  console.error('Error:', error);`
`});`

### Async/Await:

Async/await allows you to handle errors using `try/catch` blocks around asynchronous operations.

`async function fetchData() {`
`  try {`
`    const data = await fetchDataAsync();`
`    console.log('Data:', data);`
`  } catch (error) {`
`    console.error('Failed to fetch data:', error);`
`  }`
`}`

## Uncaught Exceptions

Node.js has a mechanism to catch uncaught exceptions which, if not handled, will crash your application.

`process.on('uncaughtException', (error) => {`
`  console.error('Uncaught exception:', error);`
`});`

## Promise Rejections

Handling unhandled promise rejections is similar to uncaught exceptions, but for promises.

`process.on('unhandledRejection', (reason, promise) => {`
`  console.error('Unhandled rejection at:', promise, 'reason:', reason);`
`});`

## Best Practices for Error Handling

- **Do not ignore errors**: Always handle errors appropriately. Ignoring errors can lead to unpredictable application behavior.
- **Use error logging**: Implement logging mechanisms to record errors and monitor them effectively.
- **Graceful shutdown**: In case of critical errors, ensure your application shuts down gracefully, releasing all resources properly.

By understanding and implementing effective error handling in Node.js, you can build more stable and resilient applications.

---

# Streams in Node.js

Streams are one of the fundamental concepts in Node.js, enabling handling of reading and writing data in a continuous flow. They are especially useful for processing large amounts of data efficiently without keeping it all in memory.

## Types of Streams

Node.js provides several types of streams, each designed for different purposes:

- **Readable Streams**: Allow reading data from a source in chunks.
- **Writable Streams**: Allow writing data to a destination in chunks.
- **Duplex Streams**: Both readable and writable, such as TCP sockets.
- **Transform Streams**: A type of duplex stream where the output is computed from the input.

## Using Readable Streams

You use readable streams to read large data sources like files or network requests piece by piece.

### Example:

`const fs = require('fs');`
`const readableStream = fs.createReadStream('file.txt');`
`readableStream.on('data', (chunk) => {`
`  console.log('Received data chunk:', chunk);`
`});`
`readableStream.on('end', () => {`
`  console.log('No more data to read.');`
`});`

## Using Writable Streams

Writable streams are used to write data incrementally.

### Example:

`const fs = require('fs');`
`const writableStream = fs.createWriteStream('file.txt');`
`writableStream.write('Hello, ');`
`writableStream.write('World!');`
`writableStream.end('Ending the write process.');`
`writableStream.on('finish', () => {`
`  console.log('Finished writing.');`
`});`

## Piping Streams

Piping is a mechanism to connect the output of one stream to the input of another, making it easy to manage data flows.

### Example:

`const fs = require('fs');`
`const readStream = fs.createReadStream('input.txt');`
`const writeStream = fs.createWriteStream('output.txt');`
`readStream.pipe(writeStream);`
`writeStream.on('finish', () => {`
`  console.log('Piping complete.');`
`});`

## Handling Stream Errors

It’s important to handle errors in stream operations to prevent crashes and data corruption.

### Example:

`readStream.on('error', (error) => {`
`  console.error('Error in read stream:', error);`
`});`
`writeStream.on('error', (error) => {`
`  console.error('Error in write stream:', error);`
`});`

## Best Practices for Using Streams

- **Backpressure**: Handle backpressure by pausing the read stream if the write stream is too slow to handle the incoming data.
- **Error Handling**: Always attach error handlers to avoid crashing your application.
- **Memory Management**: Use streams to process large data sets efficiently.

Streams are a powerful part of Node.js that allow you to handle large data efficiently and elegantly. Understanding how to use them properly can greatly enhance the performance of your applications.

---

# Buffers in Node.js

Buffers are a type of data structure in Node.js used to handle binary data. They allow you to work with raw binary data in an efficient and straightforward way. This guide will explain what Buffers are, how they are used, and why they are necessary.

## Understanding Buffers

In Node.js, Buffers are used to deal with binary data directly. This can include reading files, interacting with streams, or handling network communications, where data isn't encoded in a readable format.

## Creating Buffers

Node.js provides several methods to create buffers. Here are a few common methods:

### Allocating a Buffer

`const buf = Buffer.alloc(10);`  
This method creates a buffer of 10 bytes with each byte initialized to zero.

### From Strings

`const buf = Buffer.from('Hello World', 'utf8');`  
This creates a buffer containing the UTF-8 encoded string "Hello World".

### From Arrays

`const buf = Buffer.from([0x48, 0x65, 0x6c, 0x6c, 0x6f]);`  
This creates a buffer with the ASCII values for "Hello".

## Working with Buffers

Once you have a buffer, you can manipulate data within it. Here are some operations:

### Writing to a Buffer

`buf.write('Hello', 0, 'utf8');`  
This writes the string "Hello" to the buffer at offset 0 using UTF-8 encoding.

### Reading from a Buffer

`console.log(buf.toString('utf8'));`  
Converts the buffer's content to a string using UTF-8 encoding.

### Accessing Buffer Data

`console.log(buf[0]);`  
This will display the first byte of the buffer.

## Why Use Buffers?

Buffers are essential for performance in applications that process large amounts of binary data, like images or video streams. They provide a way to manage this data without unnecessary overhead.

## Buffer and Streams

Buffers are often used with streams in Node.js. Data streamed from files or over the network can be handled as buffers to improve performance.

### Example with Streams

`const fs = require('fs');`  
`const readStream = fs.createReadStream('./example.txt');`  
`readStream.on('data', (chunk) => {`  
`  console.log('New chunk:', chunk);`  
`});`

## Buffer Limitations

It's important to note that Buffers are of a fixed size. The data written to a buffer can't exceed its capacity without causing overflow.

## Conclusion

Buffers play a crucial role in handling binary data efficiently in Node.js applications. Understanding how to use Buffers effectively can greatly enhance the performance of your applications, especially in I/O-bound or network applications.

---

# Path Module in Node.js

The `path` module in Node.js provides utilities for working with file and directory paths. It helps in making file system operations reliable and consistent across different operating systems.

## Key Functions of the Path Module

### Normalize Paths

Normalizing a path means converting it to a standard format by resolving '..' and '.' segments, and fixing any irregular slashes.

`const normalizedPath = path.normalize('/users/node/../nodejs/path/./');`  
This normalizes the path to '/users/nodejs/path/'.

### Join Paths

This method joins all given path segments together, normalizing the resulting path.

`const joinedPath = path.join('/first/', 'second', 'third/');`  
This results in '/first/second/third/'.

### Resolve Paths

This method resolves a sequence of paths into an absolute path.

`const resolvedPath = path.resolve('first', '/second', 'third');`  
This might result in '/second/third' based on the current working directory.

### Directory Name

Retrieves the directory name of a path.

`const dirName = path.dirname('/user/dir/file.txt');`  
This returns '/user/dir'.

### Base Name

Retrieves the last portion of a path.

`const baseName = path.basename('/user/dir/file.txt');`  
This returns 'file.txt'.

### Extension Name

Retrieves the extension of the path.

`const extName = path.extname('file.txt');`  
This returns '.txt'.

### Parse Paths

This function returns an object from a path string - the opposite of `path.format()`.

`const parsedPath = path.parse('/user/dir/file.txt');`  
This will return an object with properties like root, dir, base, ext, and name.

## Example: Parsing a Path

Using `path.parse()`, you can extract specific components of a path.

`const pathObj = path.parse('/home/user/dir/file.txt');`  
`console.log('Directory:', pathObj.dir);`  
`console.log('Base:', pathObj.base);`  
`console.log('Extension:', pathObj.ext);`  
`console.log('Filename:', pathObj.name);`  

## Cross-Platform Compatibility

One of the key advantages of using the `path` module is its ability to handle differences in Windows and POSIX paths.

### Using `path.win32` and `path.posix`

For cross-platform applications, you can use these properties to handle paths in a platform-specific manner.

`const windowsPath = path.win32.basename('C:\\path\\dir\\file.txt');`  
`const posixPath = path.posix.basename('/path/dir/file.txt');`  

## Conclusion

The `path` module is a powerful utility for managing and manipulating filesystem paths. It provides methods that make it easy to perform operations like joining paths or extracting parts of a path reliably, no matter the operating system.

---

# File System Module in Node.js

The `fs` module in Node.js provides an extensive set of APIs to interact with the file system in a manner closely modeled around standard POSIX functions. It allows you to work with the file system on your local computer.

## Core Functions of the fs Module

### Reading Files

Use `fs.readFile` to asynchronously read the contents of a file.

`const fs = require('fs');`  
`fs.readFile('/path/to/file', 'utf8', (err, data) => {`  
`  if (err) {`  
`    console.error('Error reading file:', err);`  
`    return;`  
`  }`  
`  console.log('File data:', data);`  
`});`

### Writing Files

Use `fs.writeFile` to asynchronously write data to a file, replacing the file if it already exists.

`fs.writeFile('/path/to/file', 'Hello, world!', (err) => {`  
`  if (err) {`  
`    console.error('Error writing file:', err);`  
`    return;`  
`  }`  
`  console.log('File written successfully');`  
`});`

### Appending to Files

Use `fs.appendFile` to append data to a file, creating the file if it does not yet exist.

`fs.appendFile('/path/to/file', 'Data to append', (err) => {`  
`  if (err) {`  
`    console.error('Error appending file:', err);`  
`    return;`  
`  }`  
`  console.log('Data appended successfully');`  
`});`

### Checking File Existence

Use `fs.exists` to check if a file exists.

`fs.exists('/path/to/file', (exists) => {`  
`  console.log('File exists:', exists);`  
`});`

### Deleting Files

Use `fs.unlink` to delete a file.

`fs.unlink('/path/to/file', (err) => {`  
`  if (err) {`  
`    console.error('Error deleting file:', err);`  
`    return;`  
`  }`  
`  console.log('File deleted successfully');`  
`});`

### Watching Files

Use `fs.watch` to watch for changes in a file or directory.

`const watcher = fs.watch('/path/to/file', (eventType, filename) => {`  
`  if (filename) {`  
`    console.log('File changed:', filename);`  
`  }`  
`});`  
`watcher.on('error', (err) => {`  
`  console.error('Failed to watch file:', err);`  
`});`

## Best Practices for Using the fs Module

- **Non-blocking Operations**: Prefer asynchronous non-blocking methods over their synchronous counterparts to avoid blocking the main thread.
- **Error Handling**: Always handle errors in callbacks to avoid crashing your Node.js application.
- **Resource Management**: Ensure to close any open file descriptors to avoid memory leaks.

The `fs` module is critical for performing file operations in any Node.js application, allowing you to interact with the file system efficiently and effectively.

---

# Child Process Module in Node.js

The `child_process` module in Node.js is used to create and manage child processes. This module is essential for performing operations that require executing other applications or scripts from a Node.js application.

## Overview

The `child_process` module allows Node.js to execute other processes on the system where it is running. This capability is useful for utilizing system-level scripts, complex operations outside of Node.js, or running processes in parallel.

## Key Functions of the Child Process Module

### Exec

Executes a shell command and buffers the output. It is best used for commands that produce limited output.

`const { exec } = require('child_process');`  
`exec('ls -l', (error, stdout, stderr) => {`  
`  if (error) {`  
`    console.error('Error:', error);`  
`    return;`  
`  }`  
`  console.log('Output:', stdout);`  
`});`

### Spawn

Launches a new process with a given command. It is best used for long-running processes since it streams the data continuously.

`const { spawn } = require('child_process');`  
`const child = spawn('ls', ['-l']);`  
`child.stdout.on('data', (data) => {`  
`  console.log('Output:', data.toString());`  
`});`  
`child.stderr.on('data', (data) => {`  
`  console.error('Error:', data.toString());`  
`});`  
`child.on('close', (code) => {`  
`  console.log('Process exited with code:', code);`  
`});`

### Fork

Creates a new instance of the V8 engine running a different Node.js script. It is used for running separate Node.js processes that can communicate with each other via IPC.

`const { fork } = require('child_process');`  
`const child = fork('script.js');`  
`child.on('message', (message) => {`  
`  console.log('Message from child:', message);`  
`});`  
`child.send({ hello: 'world' });`

## Error Handling

Handling errors in child processes is crucial to maintain the stability of your application.

`child.on('error', (err) => {`  
`  console.error('Failed to start process:', err);`  
`});`

## Use Cases

- **Automation**: Automating scripts and tasks that need to be executed periodically or based on specific triggers.
- **Heavy Computation**: Offloading heavy computational tasks to child processes to prevent blocking the Node.js event loop.
- **Microservices**: Managing multiple microservices hosted locally during development.

## Conclusion

The `child_process` module is a powerful tool for expanding the capabilities of Node.js applications, allowing them to interact with the underlying system and execute other processes as needed. Proper management of child processes can greatly enhance the performance and functionality of your application.

