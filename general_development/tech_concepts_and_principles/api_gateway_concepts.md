# API Gateways concepts

## Definition

An API gateway is a management tool used to unify a single point of communication between different backend APIs and clients. When we adapt external services inside our backend and expose them to clients through our own routes—rather than allowing clients to call third-party services directly—we are implementing a gateway. The gateway need to have security layers because it is the entry point from external world. Its main functionalities are:
- Requests callings control (rate limiting)
- Authentication
- Logs control
- Standard metrics (used to know which status code are being more returned and so on)
- API's management (through routing)

## API Gateway flow:

<img src='https://i.ibb.co/5KFjkwT/Screenshot-2024-06-10-at-10-03-10.png'/>

## Types of API Gateways

**Enterprise Gateway**: Is a tool created by a commercial business to handle an another business's APIs lifecycle. Generally this type of solution needs external dependencies like databases, and services. 
**Microservices Gateway**: Is a tool that allows the dev team to route the API entrance traffic to the business services. Generally this type of solution does not has external dependencies and are open source. Example: Kong.


## General tips

At building an API Gateway, you must have at least two instances running your gateway, because if an instance dies, the another one is alive.
Be careful at using Enterprise Gateways because it can limit the deployment mobility and let the application stuck on the Vendor conditions (Vendor Lock-in).
Keep your API Gateway stateless to turn easy to scale and available your API Gateway. Try to not have too many instances to deal with the API Gateway
An API gateway can be used to route routes to different services. Its useful when you have a monolith and desire to migrate new routes to a different service.
