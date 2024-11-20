# SOLID Concepts

## The SOLID is five concepts written by Robert Martin that are used to make your code more readable and organized. The SOLID principles should be used when your application tends to grow.

- **S (SRP) Single Responsibility Principle**: Each class, module, or function should have only one reason to change. This ensures that a component has a single responsibility, making it easier to understand, test, and maintain.

- **O (OCP) Open Closed Principle**: Software entities (classes, modules, functions) should be open for extension but closed for modification. This means you should be able to add new functionality without altering existing code, ensuring stability and reducing the risk of introducing bugs.

- **L (LSP) Liskov Substitution Principle**: Subtypes must be substitutable for their base types without altering the correctness of the application. In practical terms, subclasses should respect the behavior and expectations of their parent classes, ensuring consistency and predictability in the application.

- **I (ISP) Interface Segregation Principle**: Interfaces should be small and specific, tailored to the exact needs of the implementing classes. This avoids forcing classes to implement unnecessary methods, resulting in cleaner and more focused designs.

- **D (DIP) Dependency Inversion Principle**: High-level modules should not depend on low-level modules; both should depend on abstractions. Abstractions should not depend on details; instead, details should depend on abstractions. This ensures flexibility and makes the system easier to modify or extend.


---

# Applying SOLID Principles in Node.js Projects

To apply SOLID in Node.js, separate responsibilities using folders like `useCases` for business logic, `repositories` for data handling, and `controllers` for request management. Use interfaces to ensure flexibility and consistency across modules, allowing for easier database or service replacements. Focus on clean, modular code that follows single responsibility, extensibility, and dependency inversion principles.


Applying SOLID in our application means segregating our code to adapt easily to future changes. Our routes should only call the method of the controller responsible for handling the request and not handle business rules directly.

To apply some SOLID concepts in Node.js projects, we use a folder named `useCases` containing all methods that will run in our application. Each method has:
- `caseUse.ts` (responsible for business rules)
- `caseUseController.ts` (responsible for handling requests)
- `index.ts` (imports `caseUse` and `caseUseController`, uses `caseUseController` with `caseUse` as a parameter, and exports `caseUseController` to be used in routes)

---

# Classes Definitions and Usage Following SOLID Principles

### Entities/Models
Represents the data in your application. Example:
`import { v4 as uuidV4 } from 'uuid'`
`class Category {`
`    id?: string`
`    name: string`
`    description: string`
`    created_at: Date`
`    constructor() {`
`        if (!this.id) {`
`            this.id = uuidV4()`
`        }`
`    }`
`}`
`export { Category }`

---

### Repositories
Handles data from entities in a pure way (create, list, update, delete). Example:
`import { Category } from "../../models/Category"`
`import { ICategoriesRepository, ICreateCategoryDTO } from "../ICategoriesRepository"`
`class CategoriesRepository implements ICategoriesRepository {`
`    private categories: Category[]`
`    private static INSTANCE: CategoriesRepository`
`    public constructor() {`
`        this.categories = []`
`    }`
`    public static getInstance(): CategoriesRepository {`
`        if (!CategoriesRepository.INSTANCE) {`
`            CategoriesRepository.INSTANCE = new CategoriesRepository()`
`        }`
`        return CategoriesRepository.INSTANCE`
`    }`
`    create({ name, description }: ICreateCategoryDTO): void {`
`        const category = new Category()`
`        Object.assign(category, {`
`            name,`
`            description,`
`            created_at: new Date()`
`        })`
`        this.categories.push(category)`
`    }`
`    list(): Category[] {`
`        return this.categories`
`    }`
`    findByName(name: string): Category {`
`        const category = this.categories.find(category => category.name === name)`
`        return category`
`    }`
`}`
`export { CategoriesRepository }`

---

### Services/useCases
Responsible for accessing repositories to execute business rules. Example:
`import { ICategoriesRepository } from "../../repositories/ICategoriesRepository"`
`interface RequestDataProps {`
`    name: string`
`    description: string`
`}`
`class CreateCategoryUseCase {`
`    constructor(private categoriesRepository: ICategoriesRepository) {}`
`    execute({ name, description }: RequestDataProps): void {`
`        const categoryAlreadyExists = this.categoriesRepository.findByName(name)`
`        if (categoryAlreadyExists) {`
`            throw new Error('Category already exists.')`
`        }`
`        this.categoriesRepository.create({ name, description })`
`    }`
`}`
`export { CreateCategoryUseCase }`

---

### Controllers
Handles requests, sends data to useCases, and returns responses. Example:
`import { Request, Response } from "express"`
`import { CreateCategoryUseCase } from "./CreateCategoryUseCase"`
`class CreateCategoryController {`
`    constructor(private createCategoryUseCase: CreateCategoryUseCase) {}`
`    handle(req: Request, res: Response) {`
`        const { name, description } = req.body`
`        this.createCategoryUseCase.execute({ name, description })`
`        return res.status(201).send()`
`    }`
`}`
`export { CreateCategoryController }`

