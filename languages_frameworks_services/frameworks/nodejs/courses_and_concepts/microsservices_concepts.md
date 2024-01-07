# MICROSERVICES CONCEPTS

Microservices architecture involves splitting a system into various independent services (in contrast to monolithic architectures). This architecture typically includes an API Gateway to manage access to these microservices, where access to a specific service or database (monolithic) is determined based on the port linked to that monolithic. Each function of the system is handled by a separate microservice.

## Advantages of Microservices

- **High Scalability**: Easier to scale individual components as needed.
- **Technology Diversity**: Allows the use of different technologies for each service.
- **Ease of Maintenance**: Simplifies updates and maintenance due to the modular nature.
- **Reusable Code**: Promotes code reuse across different parts of the application.
- **Autonomy and Agility**: Each service can be developed and deployed independently.

Microservices architecture is particularly beneficial for growing businesses that understand the full scope of their organizational resources.

## Monolithic Architecture

In a monolithic architecture, all functionalities of the system are concentrated within a single application.

- **Small Applications**: Tend to be monolithic to avoid unnecessary complexity.
- **Large Applications**: Often use microservices to distribute responsibilities, reducing the risk of system failures and simplifying maintenance.

## Scalability in Microservices

If a particular microservice (monolithic) experiences increased demand, resources can be specifically allocated to that service to handle the load.

## Technology in Microservices

Different programming languages and technologies can be used to build individual microservices, which can communicate with each other to form a cohesive system.
