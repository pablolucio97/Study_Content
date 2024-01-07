# BACK-END NOTES

## Back-end Responsibilities

- **Business Rules**: Implementing the logic of the application.
- **Database Connections**: Managing connections to the database.
- **Sending Emails**: Handling email communications.
- **External Services**: Connecting with external APIs and services.
- **User Authentication and Permissions**: Managing user access and roles.
- **Cryptography and Security**: Ensuring data security and integrity.

## Back-end Concepts

### Route
The complete URL used to access a resource.

### Resource/Feature
The part of the route that specifies the entity to be accessed, typically the string after the '/'.

### Pivot Tables
Tables that create many-to-many relationships between other tables.

### Migrations
The history of database actions, allowing synchronization of changes across different environments.

### Entities
Objects that perform actions and have database records.

### Functionality
The actions performed by entities.

### TDD - Test-Driven Development
A technique where tests are written before the actual code, focusing on the requirements before implementation.

### Unit Tests
Tests that cover isolated pieces of code.

### Integration Tests
Tests that cover the complete route and functionality of the application, including back-end structures.

### ORM - Object Relational Mapping
Tools for managing database queries using JavaScript. Examples include Sequelize, Mongoose, and TypeORM.

## Database Types

### SQL
Structured, relational databases using SQL language for queries. Examples: SQL Server, MySQL, PostgreSQL.

### NoSQL
Less structured, non-relational databases using query builder syntax. Examples: MongoDB, Cassandra.

## Controller Methods

### Show()
Used to display a specific item or a filtered set of items.

### Index()
Displays an unfiltered list of items.

### Create()
Creates a new item.

### Update()
Updates an existing item.

### Delete()
Deletes an item.

## API INTEGRATION

API stands for Application Programming Interface, a set of specifications for possible interactions between applications.

An API integration is the communication between your app and the available resources of third-party APIs. The main types of APIs include:

- Collections API
- Payment API
- API for calculating shipping and other calculations
- Authentication API
- Communication API (sending emails and SMS messages)

When creating an API, you should document the available endpoints and resources. When consuming an API, check the available endpoints and resources.

## REST APIs

REST, or Representational State Transfer, is an architectural model with 6 basic rules:

1. **Client-Server Separation**: Client and server must have different responsibilities.
2. **Statelessness**: The API needs to be stateless; the server doesn't store requests, and all information should be provided in each request.
3. **Cache Support**: The API needs to have cache support.
4. **Uniform Interface**: The interface must be uniform with resource identification (e.g., `http://myapiendpoint/my_resource`), resource representation (e.g., JSON format), self-descriptive messages, clear response messages, and the ability to return links in the JSON body.
5. **Layered System**: The API must be created in layers (e.g., load balancing layers).
6. **Code on Demand (optional)**: The response should be provided according to request demand.

## HTTP Methods

- **GET**: Retrieve data from the backend.
- **POST**: Create new data in the backend.
- **PUT**: Update one or more data items in the backend.
- **PATCH**: Update a single data item in the backend.
- **DELETE**: Remove data from the backend.

Examples:
- POST `http://localhost:3333/users` => Create a new user.
- GET `http://localhost:3333/users` => List users.
- GET `http://localhost:3333/users/7` => List the user with ID = 7.

## Request-Response Pattern

The request-response pattern involves the client making requests to the server, which then provides a response with various status codes.

### Main Response Status Codes

- **Informational responses**: (100–199)
- **Successful responses**: (200–299)
- **Redirects**: (300–399)
- **Client errors**: (400–499)
- **Server errors**: (500–599)

Examples:
- 200: Successful request.
- 201: New resource created.
- 202: Request received but not yet acted upon.
- 203: Non-authoritative information.
- 204: No content.
- 205: Reset content.
- 400: Bad request.
- 401: Unauthorized.
- 403: Forbidden.
- 404: Not found.
- 405: Method not allowed.
- 407: Proxy authentication required.
- 409: Conflict.
- 413: Payload too large.
- 414: URI too long.
- 415: Unsupported media type.
- 419: Too many requests.
- 451: Unavailable for legal reasons.
- 500: Internal server error.
- 503: Service unavailable.
- 504: Gateway timeout.
- 505: HTTP version not supported.
- 511: Network authentication required.

## Parameter Types

- **Header Parameters**: Embedded in the request header.
- **Request Parameters**: Identifies fundamental resources in the route.
- **Query Parameters**: Used for optional resources, filtering, and pagination.
- **Request Body**: Contains data for creating or updating resources.
- **Route Parameters**: Identifies unique resources.

## Middlewares

Middleware is a function that sits between the request and response in an HTTP method. It standardizes data in the header and determines if the method should continue.

### Creating a Middleware

```javascript
function verifyAccountCPFExists(req, res, next) {
    const { cpf } = req.headers;
    const customer = customers.find(customer => customer.cpf === cpf);
    if (!customer) {
        return res.status(201).json({ error: "Customer not found" });
    }
    req.customer = customer;
    return next();
}
```

### Using middlewares

```javascript
app.get('/statement', verifyAccountCPFExists, (req, res) => {
    const {customer} = req;
    return res.json(customer.statement);
});

// or

app.use(verifyAccountCPFExists);
```

## General Tips and Best practices

- Use the correct HTTP method for your request.
- Choose the most appropriate status code for your response.
- Always extract data from a response for use in your application, keeping in mind that a response comprises a header and a body, with the data typically in the body.
- Use `await trx.commit()` as the last HTTP method in the controller file to ensure transaction completion.
- Include the flag `--unhandled-rejections=strict` in your start script in `package.json` to handle uncaught exceptions in promises.
- A single route can be used with different HTTP methods for various operations.
- Avoid performing rollbacks on tables in production. Instead, create a new migration to address any issues.
