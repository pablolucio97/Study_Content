# Handling Pub/Sub Domain Events on NodeJs applications

## Motivation

When the system has two or more different domains that need to communicate with each other at once we can use a transaction to perform the operations in the database and guarantee that all data will be recorded only if all operations run successfully, but there is code acoplament that isn't a good idea if we need to exchange some of the domains, for that we can use the Pub/Sub (publisher/subscriber) domain event. Pub/Sub domain event should be used also if two or more different use cases need to trigger the same use case.

## Concept

Pub/Sub is a technique of register an new event when a use case is called and other use case listen to the created event. Each event is an array of objects where each object has properties for the event, like name of the event, another useful payloads and a "ready" property initialized as false to indicate that event was called (but not ready yet).


## Event Flow

Bellow, as example, we'll use a flow of creating a new answer and notify the user that a new answer has been created.

### Emitter

Answer entity => createAnswerUseCase() => [{event: 'create-answer', answer: {}, topic:{}, ready: false}] => Record data on database => [{event: 'create-answer', answer: {}, topic:{}, ready: true}]

### Subscribers

ListenToAnswerEvent where ready is true => createNotificationUseCase()
