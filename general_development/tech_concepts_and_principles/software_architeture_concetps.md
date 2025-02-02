# Introduction to Software Architecture

## Types of Architectures

**Technological Architecture** Its the specialization that someone has in an specific technology being able to generate value through his knowledge.

**Software Architecture** Its an Engineer Software discipline that is directly related to software development process. This professional must transform business requirements onto architecture patterns choosing the best architecture model for each case taking development best practices.

**Solution Architecture** This architecture resides between the business and software spheres. This architecture is responsible for convert business requirements into softwares to be developed. Generally it is done through charts and flows (C4 diagram, UML, Use case diagrams and so on). The professional on this architecture must take decision about which technologies to use, and general is requested to be on business meetings.

**Corporative Architecture** Are policies and rules that impacts directly the organization. This architecture is responsible for review if a technology should be used by the company, its costs and so on.

## Software Sustainability rules
- A software majorly must follow the business evolution.
- A software must pay for itself over the time.
- A software is built to resolve a pain.

## Software Architecture columns
- **Structure**:  The software must be thought and structured to accept new features easily.
- **Componentization**: The software must be composed by components to easily identify parts of the software.
- **Relationship** The software must be able to easily relate with others systems and services.
- **Governance**: The software must has a clear set of rules and documentation for develop new features since its beginning.

## Architectural Requirements
- **Performance**: It is the performance a feature should have. Example: A request must be performed by 10s and have 15s timeout.
- **Data storage** How the data will be stored. Witch type of database must be used and why.
- **Scalability** How the system will scale, if it is will scaled horizontally (adding more instances) or vertically(upgrading instance RAM, processor, and storage). Autobalance will be used? How much instances will be work?
- **Compliance** Check which governmental rules my system must obey.
- **Security** Which security techniques the application must apply.
- **Audit** Defines how and where each user action is be logged.
- **Marketing** Defines if the system should be trackable for auditing marketing metrics and purposes. Examples: Deep linking, Google Analytics and Google Crashlytics.
- **Accessibility** Defines which features the system must have to attend users with reduced capabilities. Examples: Audible support, on screen keyboard and so on.

### Architectural Requirements - Operational characteristics (Instance characteristics)

- **Availability**: It defines how available the system should be. When the maintenance must be done.
- **Chaos recovery**: Defines how the process of solve unexpected problems must be done.
- **Data recovery**: Determines the backup process, when it must be done. Its extremely important to test a backup after generating a new one. 
- **Robustness**: Defines how robust the cloud/host where your system is host. Define plans for migrate your system if this host/cloud is offline.

### Architectural Requirements - Structural characteristics (Software characteristics)
- **Configurability**: Your software must be configurable through environment variables. It is important if a service key or some database configuration changes.
- **Extensibility**: Adding new modules, screens, components and services in your application must be easy without too much refactors.
- **Easy Installation** Your application must be easy to install/deploy. The best way to grant easy installation on back-end services, is trough containers.
- **Components reuse** Your application's components must be easy to be reused.
- **Internationalization** If your system will be distributed for multi countries, you should to apply techniques to shown text on front-end and grant your process will keep working on back-end when the country changes, example: currency.
- **Easy maintenance** Your system must be easy to maintain. Avoid coupling, and use clean patterns. As less code your system has, better.
- **Portability** Your system must be easy to exchange the database. Use clean architecture to reach it.
- **Strong support** Your system must be able to track logs easily. Use standard console logs on each request, and important actions.

### Architectural Requirements - Cross-cutting
- **Accessibility**: Your system must be accessible to persons with reduced capabilities. Use a screen reader.
- **Data storage retention**: Plan which data must persist or not and its lifetime.
- **Authentication** Defines how the authentication process must be done.
- **Authorization** Defines roles and possible access based on roles (user/admin).
- **Security** Apply security techniques to protect your application. Use captcha on authentication, use an input validation, and implement rate limiting to avoid suffer too many requests attacks.
- **Laws** Which laws your system must obey and where the data related to the user will be persisted if requested judicially.
- **Privacy** You must apply techniques to user data to not leak. If there is another developers on the project, request them to assign a privacy policy before start working on the project.
- **Usability** How your system should be used. Consider implementing responsiveness and navigation by keyboard.
- **Portability** Your system must be easy to exchange the database. Use clean architecture to reach it.


### Improving software performance

Performance is the time a software takes to complete a workload. To improve the system performance you must:

1. Reduce the response time. An acceptable response time is between 200ms and 2500ms. Checklist to reduce response time:

2. Rise the throughput, increasing the quantity of inputs you system can handle at once.
 
Checklist to improve general performance:

 - Check for external calls. Sometimes external calls can take longer than expected.
 - Take a look how the process data algorithm works.
 - Increase your instance computational power.
 - Use programming languages that allows asynchronous and not blocking communication. Request can't works serially (one by one). Example: NodeJS.
 - Check the database used and watch the SQL queries response time.
 - Always as possible store large processed data on cashing.


## Concurrence and Parallelism

Concurrence is deal with multiple tasks at once, and Parallelism is do multiple tasks at once.

Example: A webserver that is working concurrently has just 1 thread, and this thread receives 5 requests to process at once. Each request takes 10ms to respond, then the final response time is 50ms because it is processed in series. If this same webserver had 5 threads available, it would work with parallelism allocating each request in a thread where the final response time would be 10ms.


## Scalability

Is the capacity a system has to increase or decrease its throughput adding or removing more computational resources.
A system can be scaled vertically(increasing the computational instance resource) or horizontally(adding more instances, and using a load balance/reverse proxy to handle the requests).

At scaling a system horizontally you must have in mind that an instance is a disposable resource and all content that is in your instance must be available in a shared service like  Amazon S3 and shared database. Disks are used only to record data temporarily.

You system must be stateless, you should maintain a service for your application, one for assets, and another one for caching.

Scaling a system is decentralize an instance Its means exporting all its content into external services allowing that instance can be removed or duplicated where the new instances can consume the same content as the first instance.

To scale a database we can create a database for reading and another one for writing. If your database is dealing with large tables, you should use indexes to reduce the scanned table area on queries.


## Reverse Proxy 

A proxy is a request handler that redirects your request based on rules configured in the proxy. 

A reverse proxy is a server that redirect the request to the most appropriated server according to rules configured in the reverse proxy. The most used reverse proxy tool is Nginx.


## Resilience

Resilience is the ability a software has to deal with unexpected situations. Example: What would happen to the system registering flow if the CEP service is unavailable? A good software deal with these conditions and provide another options. Techniques to check and improve your system resilience:

### Health check

You can check if a system is health creating a route that bumps on database checking it responses time.

### Rate Limiting 

You can configure the rate limit by client always allowing most important client a large number of requests compared to adjacent systems. If your application supports 100 requests per second, so you could configure by example 70 requests per second for the most important client and 30 to another one.

### Circuit Breaker

You can implement Circuit Breaker on your system to automatically responds with 500 status code when its request exceeds the supported requests limits and automatically respond normally when the system recoveries.

### Service Mesh

Service Mesh is an infrastructure layer used to control all network through proxies communication between the systems. Instead of implementing each technique on the own system, using a Service Mesh you can implement Circuit Breaker, define Retry Policies, configure timeouts, Fault Injection and so on.

### Retry Policies

Are a set of rules used to minimize the number of requests to be processed at once on a system that is recovering from another requests. At defining a retry policy, is important to define rules to not allow multiple requests being processed simultaneously at once (this rule is called Jitter Exponential backoff).

At working with delivery guarantees, you can define the priority of the message based on this Ack type. Based on the type the message could be delivery fast, but without delivery guarantees or vice versa. You must choose between performance and resilience based on your system needs.


### Another concepts
- **Service Level Agreement (SLA)**: It is related with the software metrics what was dealt with the business client.
- **Service Level Objectives (SLO)**: Over the SLA, what is my software metrics. Generally exceeds what was dealt as SLA.


## Working with caching

### Type of caching

- **Static data* on Edge Computing** This type of caching provides all already processed in a server before the user bump your server. All website cache content is stored in the nearest to the user server. Generally it has a good payoff.
- **Cached Web page** Some Javascript frameworks allows building cached pages that will be server with the HTML already built. Example: NextJS.
- **Internal cached functions** Are heavy algorithms that could be embedded in a function to be executed in some spaced interval instead each request reducing also databases operations.
- **Cached objects** Is the technique of caching your entities objects to avoid it run repeated operations. It can be done using Redis or some NodeJS library to deal with caching like node-cache.
- **Local caching** The cache is available only locally. Its more faster, but can't be shared between user sessions. It means the user must repeat all same process in different machines.
- **Shared caching** The cache is available in an external server where each instance should bump on this server to get the cached. It's more slower, mas generally more recommended. In this type of caching, the database queries can be cached and shared too.

## General tips
- The business team structure reflects directly on the final software architecture. Example: If a team is composed of just one back-end developer, then the front-end application will be embedded on the back-end.
- Always design your application thinking on the future. It can be done using clean architecture.
- Be careful at be attracted by new market technologies, must be a deep analysis of this technology before implement it on your software architecture.
- Always see your whole project architecture structure before implementing new features.
- A business software must have clear governance. It means, if the developer that has more contact with that software leaves the company, then that software must keep clean.
- Each application that you'll develop, keep a `docs` folder containing the main application processes and have the possible Architectural Requirements documented.
- Always tests the done backup. Grant the backup is working for when you need it.
- To allow that your application is able to be scaled horizontally, you must implement 12 factors and it need to be stateless.
- Always prefer to scale your system instances horizontally because it allows more flexibility and grant more computational power if the system grows to much.
- To test if your application is configurable, you can run your application on production environment with stage credentials. All fixes must be done just exchanging credentials.
- Always as possible avoid operations on your database, because depending on the number of requests it can be expensive.
- Internet is not unlimited, always as possible use Edge Computing/CDN's to server static files, and allow the user bump on server nearest to him instead bump on your server directly.
- Use the `EXPLAIN` declaration on your SQL queries for watch queries performance.
- At working with a system that communicates with another system, you should think about the entire ecosystem and not overcharge the another system because if the another system is not working properly, it will affect your system. A slow system online is better than a fast system offline. An unhealthy system has chance of recovery itself if stop receiving requests.
- Using an API Gateway can help to implement Health check, Rate limiting and others features directly on the API Gateway.
- Do not try implementing rate limiting, circuit breaker, retry policies, and other features directly on the system, use a Service Mesh/API Gateway to do it.
- At working with cloud services, do not rely on a single available zone.