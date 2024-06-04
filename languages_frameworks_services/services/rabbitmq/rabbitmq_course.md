# RabbitMQ Course

## Introduction

- Rabbit MQ is a reliable messaging systems for microservices communication.

## Main Concepts

### Message Broker

- Acts as an intermediary in message handling.
- RabbitMQ facilitates communication between message publishers and consumers.

### Protocols

- Implements AMQP, MQTT, STOMP, and HTTP, with AMQP being the most commonly used.

## RabbitMQ Features

- In-memory message handling for speed.
- Extensibility through plugins.
- Industry standard with widespread adoption.

### Queue

- Basic structure where messages are stored and retrieved.
- FIFO (First In, First Out) system, with priority settings available.

### Queue Properties

- **Durability**: Define if a queue must persist after a broker restart.
- **Auto-delete**: Automatically deletes the queue when it has no consumers.
- **Expiry**: Defines how long a queue remains idle before it's deleted.
- **Message TTL (Time-To-Live)**: Duration a message remains in the queue before being discarded.
- **Overflow and Reject Publish**: Handles scenarios when queues reach capacity.
- **Max Length or Bytes**: Maximum of messages or bytes allowed to be received in the queue. Ex: allow that the message until 2MB size.

### Dead Letter Queues

- Used for store messages that cannot be delivered or processed within their life time.

### Lazy Queues

- Stores messages on disk to manage large volumes of messages and preserve them across broker restarts. It can happen when the exchange is receiving too many messages at once overpassing the RabbitMQ memory limit.

### Exchange

- Handles routing of messages to one or more queues based on rules.
- Types of exchanges:
  - **Direct**: Routes messages to a specific queue.
  - 
  - **Fanout**: Broadcasts messages to all bound queues. It's large used on e-commerce applications where we have a server to handle logs, another to handle orders, to handle emails, and these systems need to receive this message to call some function or request.
  - 
  - **Topic**: Routes messages based on pattern matching of routing keys declared on the message params.
  - **Headers**: Routes messages based on header attributes (less common).

### Binding

- Links queues to an exchange and defines rules for message routing.

### Routing Key

- Used by exchanges to determine which queue(s) a message should be routed to.


## Diagrams

### RabbitMQ Connection diagram:

[image]('https://i.ibb.co/tb8HQ9R/Screenshot-2024-06-04-at-08-13-28.png')

### RabbitMQ Direct Exchange message flow diagram:

[image]('https://i.ibb.co/5hP029f/Screenshot-2024-06-04-at-08-20-43.png')

### RabbitMQ Fanout Exchange message flow diagram:

[image]('https://i.ibb.co/s5NQ5W8/Screenshot-2024-06-04-at-08-23-13.png')

### RabbitMQ Topic Exchange message flow diagram:

[image]('https://i.ibb.co/5hP029f/Screenshot-2024-06-04-at-08-20-43.png')

## General Tips

- At working with TCP connections, the first one request is the most lasted because it need to pen and recognize the connection first (handshake).
- At working with RabbitMQ you'll never publish a message directly into a queue, it will pass to the exchange and then the exchange will determine the correct queue/queues to delivery the message.
- Each queue is totally independent from another one.
- Avoid changing the default queue behavior FIFO, it can be hard to deal. Let that the first message received will be the first to exit.

