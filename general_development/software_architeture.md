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
- **Scalability** How the system will scale, if it is will scaled horizontally or vertically. Autobalance will be used? How much instances will be work?
- **Compliance** Check which governmental rules my system must obey.
- **Security** Which certificates my application must have.
- **Audit** Defines how and where each user action is be logged.
- **Marketing** Defines if the system should be trackable for auditing marketing metrics and purposes. Examples: Deep linking, Google Analytics and Google Crashlytics.
- **Accessibility** Defines which features the system must have to attend users with reduced capabilities. Examples: Audible support, on screen keyboard and so on.

## General tips
- The business team structure reflects directly on the final software architecture. Example: If a team is composed of just one back-end developer, then the front-end application will be embedded on the back-end.
- Always design your application thinking on the future. It can be done using clean architecture.
- Be careful at be attracted by new market technologies, must be a deep analysis of this technology before implement it on your software architecture.
- Always see your whole project architecture structure before implementing new features.
- A business software must have clear governance. It means, if the developer that has more contact with that software leaves the company, then that software must keep clean.
- Each application that you'll develop, keep a `docs` folder containing the main application processes and have the possible Architectural Requirements documented.