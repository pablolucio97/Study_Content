# DOMAIN DRIVEN DESIGN CONCEPTS

## Domain
The domain refers to the core concepts, rules, processes, and behaviors specific to a business or application. It's crucial for developing software that aligns with business needs.

**Example**: In an e-commerce application, the domain includes concepts like customers, orders, and products.

## Domain Experts
Individuals with deep understanding of the business for which a system is being developed.

**Example**: A receptionist at a hospital or hotel.

## Use Cases
Use cases describe the functional requirements of a system, detailing specific interactions between the user and the system.

**Example**: In an e-commerce application, examples include `createOrder` and `listUserOrders`.

## Aggregates
A collection of related objects in a software system, treated as a single unit.

**Example**: In a blogging platform, a ‘Post’ aggregate might include ‘Comments’ and ‘Tags’.

## WatchedList
A collection of data that depends on another information for correct database handling.

**Example**: Editing a post with attachments in a forum.

## Ubiquitous Language
A common language understood by both developers and domain experts to describe domain concepts and processes.

**Example**: In healthcare, terms like “Patient”, “Appointment”, and “Prescription” are used universally.

## Value Objects
Properties of an entity that contain their own business rules and are represented by separate classes.

**Example**: In a travel app, ‘Location’ defined by latitude and longitude.

## Entities
Domain objects representing crucial business concepts, crucial for modeling software to reflect business rules and behaviors.

**Example**: In a banking application, a ‘Customer’ entity with unique ID and behaviors like account management.

## Subdomains (Bounded Context)
Explicit boundaries around a set of domain models, separating specific domain models within the same system.

**Example**: In a school management system, separate ‘Grading’ and ‘Attendance’ bounded contexts.

## Domain Events
Asynchronous notifications indicating significant occurrences within the domain.

**Example**: In an online auction system, a ‘BidPlaced’ event is triggered when a bid is placed.

# GENERAL TIPS

- **Development Flow**: Start with Entity, followed by Repository, UseCase, Controller, Routes, and Server.
- **Domain Expertise**: Developers are not domain experts. Engage with real domain experts of the business.
- **Understanding Domain**: Have multiple conversations to understand the domain expert's challenges.
- **Layered Development**: Develop the system in layers where internal layers (entities and use cases) are independent of external context (controllers).
- **Documentation**: Create a `readme.md` listing all domain expert pains to identify necessary entities and use cases.
- **Entity Representation**: An entity might not always be a database table but an object to enhance code understanding.
- **Use Case Uniqueness**: Avoid using the same use case for different entities to prevent future conflicts.
- **Repository Contracts**: Core system components (entities and use cases) need repositories to connect to the external world, with contracts specifying methods for each use case.
- **Slug Usage**: Provide a slug for each entity in web applications (instead of using the entity ID).
