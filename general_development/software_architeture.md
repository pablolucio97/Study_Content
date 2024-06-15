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



### Another concepts
- **Service Level Agreement (SLA)**: It is related with the software metrics what was dealt with the business client.
- **Service Level Objectives (SLO)**: Over the SLA, what is my software metrics. Generally exceeds what was dealt as SLA.

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