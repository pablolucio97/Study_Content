# SOFTWARE ENGINEERING COURSE

Software Engineering is the field that studies software development, its lifecycle, concepts, and techniques.

## CONCEPTS

### COT Systems
Generic systems created for sale and adapted to client needs.

### CR (Change Request)
Where the client requests changes in the project. CRs need to be appraised before implementation.

### BaseLine
Stable lines that are reliable for implementation in the software.

### Codeline
Represents the version of each item in the software.

### Checkout
When a developer copies the reliable code of the project to work on it. Concurrent checkouts require merging.

### Checking
When the developer delivers a new reliable version to the system of change management after working on it.

### Version
The current version of the software development. Changes should be documented with Version, Changer, Date, Author, and Reason for changes.

### Release
The current version of the software released to the client.

### Software Design
Responsible for code-level design, determining the scope and objectives of each class and function.

### Fast Methods
Flexible methods focused more on development than documentation, born out of the software crisis. Examples include XP, SCRUM, TDD (Test-Driven Development). Principles include client relationships, incremental delivery, focus on people over process, and simplicity.

### SCRUM
Composed of various sprints (cycles) to evaluate, select, review, and develop the project.

### Functional Requirements
Functions that the system will execute, e.g., login, calculate purchase amount, send an email.

### Non-Functional Requirements
How the functions will be executed, including the technologies used, system performance, and task execution time.

#### Main Observations on Writing Requirements
- All requirements should be implementable.
- Different requirements shouldn't diverge.
- Requirements should be realistic and testable.

### Legacy System
A system that no longer receives maintenance.

## PROCESS TO DEVELOP SOFTWARES

### Particular Softwares
1. Meet the client and conduct a technical interview to gather requirements.
2. Define functional and non-functional requirements.
3. Draw the Class Diagram and Use Case Diagram.
4. Design the software on Figma.
5. Code the software with reuse in mind.
6. Test each requirement.
7. Deploy the software according to the client's agreement.

### Public Softwares
Similar to the process for particular softwares, with the addition of documenting the project on GitHub.

### SOFTWARE LIFE CYCLE
#### Elicitation
Meet with the client with specific questions to understand their needs. Observe manual processes that can be automated. Consult different stakeholders.

## MODELS OF SOFTWARE PROCESS

### CASCADE
A sequential process where one task finishes and another starts automatically.

### INCREMENTAL
Builds the core of the software first, then incrementally adds and validates new features.

### ORIENTED TO REUSE
Focuses on reusing components of previously developed software. Requires careful testing to ensure it meets client requirements.

#### General Steps
Follow these steps regardless of the chosen model: Specification > Development > Validation > Evolution.

## MAIN TOOLS OF SOFTWARE ENGINEERING
- Entity Relationship Diagram
- Data Flow Diagram
- Use Case Diagram**
- Use Case Specification
- Class Diagram**
- Sequence Diagram
- Activities Diagram**

**The Class Diagram is particularly useful for defining the system structure.

## MAIN ARCHITECTURAL MODELS/DESIGN PATTERNS

### Layered Pattern
Structured in stacked layers where lower layers serve the upper ones.

### Client-Server Pattern
Involves a server and a client where the client requests data, and the server responds.

### MVC Pattern (Model View Controller)
Back-end controlled by the Model, browser rendering information (View), and HTML/JavaScript acting as the Controller.

### Serverless Architecture
Relies on third-party services for backend management, including Back as a Service and Functions as a Service.

### Event-Oriented Architecture
Based on producers and consumers of events, with modules called upon as needed.

### Microservices Architecture
Consists of small, independent microservices, each solving a problem and connecting through a defined API.

### ERP System Architecture
Database > Business Rules > Process > Buy - Supply Chain - Logistic - CRM

## SOFTWARE TESTING

### Validation
Ensures the developed software is what the client wanted.

### Verification
Checks if the software functionalities meet the requirements.

#### Stages of Tests
- Development tests: Conducted during development.
- Release tests: Performed before client delivery.
- User tests: Monitoring user interaction.

#### Types of Tests
- Manual: Used during development for short functionalities.
- Automated: Programmed tests for specific value correspondence.
- Unit tests: Focused on individual components or isolated parts.
- Integration tests: Conducted on a set of components.
- System tests: Testing the system as a whole.

#### Testing Techniques
- Black Box Testing: Testing requirements without code verification.
- White Box Testing: Testing code without validating requirements.
- TDD (Test-Driven Development): Testing before implementing functionality.

## SOFTWARE REUSE

### Advantages
Faster development, reduced workload, and standard conformity.

### Penalty
Lack of source code and support.

#### Techniques for Software Reuse
- Maintain core code in a generic project and show clients mandatory, alternative, and optional functionalities.
- Inherit existing components from generic software.

#### Rules for Providing Components
- Standardize components with a good interface and usage documentation.
- Ensure components are independent and compatible with others.

#### Rules for Consuming Components
- Define system requirements before using third-party components.
- Identify usable components before designing architecture. Modify components as needed.

## GENERAL TIPS
- Requirement changes are inevitable in large projects.
- Combine various development methods in a single project.
- Manage software changes through a Software Changes Manager.
- Test each new version before proceeding with further development.
- Aim for the maximum number of failures with the minimum number of tests.
