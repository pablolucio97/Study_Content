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


## Using Domains Events

1 - Create a entity.ts file exporting a generic Entity class that must be extended to server as base for the system class entities. Example:

```
export abstract class Entity<Props>{
    private _id: string;
    protected: props: Props;

    get id(){
        return this._id;
    }

    protected: constructor (props: Props, id: string) {
        this.props = props;
        this.id = id;
    }

    public equals(entity: Entity<any>) {
    if (entity === this) {
      return true
    }

    if (entity.id === this._id) {
      return true
    }

    return false
  }
}
```

2 - Create a file named as "aggregate-root.ts" to be extended to be used for the aggregate classes of your application. Example:

```
import { DomainEvents } from '@/core/events/domain-events'
import { DomainEvent } from '../events/domain-event'
import { Entity } from './entity'

export abstract class AggregateRoot<Props> extends Entity<Props> {}
export abstract class AggregateRoot<Props> extends Entity<Props> {
  private _domainEvents: DomainEvent[] = []

  get domainEvents(): DomainEvent[] {
    return this._domainEvents
  }

  protected addDomainEvent(domainEvent: DomainEvent): void {
    this._domainEvents.push(domainEvent)
    DomainEvents.markAggregateForDispatch(this)
  }

  public clearEvents() {
    this._domainEvents = []
  }
}
```

3 - Create a folder named as "events" and inside it a file named as "domain-events.ts" exporting a class that contains two methods, handlersMap (an object that represents the subscribers, listening always a single event at once to trigger an event) and markedAggregates (responsible for store agregates that have pendent events). Example:

```
import { AggregateRoot } from '../entities/aggregate-root'
import { UniqueEntityID } from '../entities/unique-entity-id'
import { DomainEvent } from './domain-event'

type DomainEventCallback = (event: any) => void

export class DomainEvents {
  private static handlersMap: Record<string, DomainEventCallback[]> = {}
  private static markedAggregates: AggregateRoot<any>[] = []

  //stores the event to be fired
  public static markAggregateForDispatch(aggregate: AggregateRoot<any>) {
    const aggregateFound = !!this.findMarkedAggregateByID(aggregate.id)

    if (!aggregateFound) {
      this.markedAggregates.push(aggregate)
    }
  }

  //trigger all events for each domain event linked to the aggregate
  private static dispatchAggregateEvents(aggregate: AggregateRoot<any>) {
    aggregate.domainEvents.forEach((event: DomainEvent) => this.dispatch(event))
  }

  private static removeAggregateFromMarkedDispatchList(
    aggregate: AggregateRoot<any>,
  ) {
    const index = this.markedAggregates.findIndex((a) => a.equals(aggregate))

    this.markedAggregates.splice(index, 1)
  }

  private static findMarkedAggregateByID(
    id: UniqueEntityID,
  ): AggregateRoot<any> | undefined {
    return this.markedAggregates.find((aggregate) => aggregate.id.equals(id))
  }

  public static dispatchEventsForAggregate(id: UniqueEntityID) {
    const aggregate = this.findMarkedAggregateByID(id)

    if (aggregate) {
      this.dispatchAggregateEvents(aggregate)
      aggregate.clearEvents()
      this.removeAggregateFromMarkedDispatchList(aggregate)
    }
  }

  public static register(
    callback: DomainEventCallback,
    eventClassName: string,
  ) {
    const wasEventRegisteredBefore = eventClassName in this.handlersMap

    if (!wasEventRegisteredBefore) {
      this.handlersMap[eventClassName] = []
    }

    this.handlersMap[eventClassName].push(callback)
  }

  public static clearHandlers() {
    this.handlersMap = {}
  }

  public static clearMarkedAggregates() {
    this.markedAggregates = []
  }

  private static dispatch(event: DomainEvent) {
    const eventClassName: string = event.constructor.name

    const isEventRegistered = eventClassName in this.handlersMap

    if (isEventRegistered) {
      const handlers = this.handlersMap[eventClassName]

      for (const handler of handlers) {
        handler(event)
      }
    }
  }
}
```


4 - In the same folder create another file named as "domain-event-interface.ts" exporting an interface for domain events:

```
export interface DomainEvent {
  ocurredAt: Date
  getAggregateId(): string
}
```

5 - And another file named as "event-handler-interface.ts" exporting an interface for the event handler. Example:

```
export interface EventHandler {
  setupSubscriptions(): void
}
```


