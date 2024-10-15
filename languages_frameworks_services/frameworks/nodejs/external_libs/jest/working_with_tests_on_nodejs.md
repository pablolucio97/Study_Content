# Working with Tests on Node.js

## Types of Tests and Concepts

- **Unit Tests**: Tests that check a single function, class, or component in isolation. If the function or component is integrated or depends on features of the application, it involves Mocks.
  
- **Integration Tests**: These tests focus on backend flow:
  `routes => controllers => useCases => repository`
  `repository => useCases => controllers => routes`

- **Test Driven Development (TDD)**: A methodology where tests are written before creating the application.

---

## Testing on Node.js with Jest and TypeORM

1. Run `yarn add jest@26.6.3 ts-jest@26.5.4 @types/jest@26.0.21 @types/mocha -D`.

2. Run `yarn jest --init` and answer the questions. Jest will create a `jest.config.ts` file in your application root. Edit the file as follows:

`export default { bail: true, clearMocks: true, coverageProvider: "v8", preset: 'ts-jest', testEnvironment: "node", testMatch: ["**/*.spec.ts"], };`

3. In `modules/useCases/yourUseCaseFolder`, create a file named `YourUseCase.spec.ts` (e.g., `CreateUserUseCase.spec.ts`) and write your test.

4. Run `yarn test` to execute your test.

---

## Testing Repository Classes with TypeORM and Jest

1. Create a class repository for working with data in memory inside `modules/repositories`. This class should handle entity data and contain all the methods to test. Example:


```typescript
import { Category } from "../../entities/Category"; 
import { ICategoriesRepository, ICreateCategoryDTO } from "../ICategoriesRepository"; 
class CategoriesRepositoryInMemory implements ICategoriesRepository { categories: Category[] =
 [] async create({ name, description }: ICreateCategoryDTO):Promise<void> { const category = 
 new Category() Object.assign(category, { name, description }) 
 this.categories.push(category) } async list(): Promise<Category[]> { return this.categories } 
 async findByName(name: string): Promise<Category> 
 { const category = this.categories.find(c => 
 c.name === name); return category } } 
 export { CategoriesRepositoryInMemory }
```


2. In your use case test file, instantiate the method and repository base types and place them inside a `beforeEach` function, returning a new instance of these classes. Then write your test. Example:


```typescript
import { CategoriesRepositoryInMemory } from "../../repositories/in-memory-tests/CategoriesRepositoryInMemory" 
import { CreateCategoryUseCase } from "./CreateCategoryUseCase" 
let createCategoryUseCase: CreateCategoryUseCase 
let categoriesRepositoryInMemory: CategoriesRepositoryInMemory describe('CreateCategory', () => { beforeEach(() => { 
  categoriesRepositoryInMemory = new CategoriesRepositoryInMemory() 
  createCategoryUseCase = new CreateCategoryUseCase(categoriesRepositoryInMemory) }) 
  it('should be able to create a new category', 
  async () => { const category = 
  { name: 'Pablo', description: 'Some person' } 
  await createCategoryUseCase.execute(category) 
  const createdCategory = await categoriesRepositoryInMemory.findByName(category.name) 
  expect(createdCategory).toHaveProperty('id') })
  })
```


---

## Test Jest Examples

1. Creating a token:

```typescript
it('should be able to create a token', async () => { 
const fakeUser = 
{ name: 'Jhon', username: 'jhon', email: 'jhon@gmail.com', password: '12345', driver_license: '12345' } 
await createUserUseCase.execute(fakeUser)
 const result = await authenticateUserUseCase.execute(
  { email: fakeUser.email, password: fakeUser.password }) 
  expect(result).toHaveProperty('token') 
})
 ```


2. Authenticating non-existent user:


```typescript
it('should not be able to authenticate a none existent user ', 
async () => { 
  await expect( authenticateUserUseCase.execute(
    { email: 'some@gmail.com', password: '123', }),
     ).rejects.toEqual(new AppError('User does not exists')); 
  });
```


3. Authenticating with wrong password:


```typescript
it('should not be able to authenticate with wrong password', 
async () => { const fakeUser = 
{ name: 'Jhon', username: 'jhon', email: 'jhon@gmail.com', password: '12345', driver_license: '12345' }
 await createUserUseCase.execute(fakeUser)
  await expect(authenticateUserUseCase .execute(
    { email: fakeUser.email, password: 'incorrect' }))
    .rejects.toEqual(new AppError('Wrong password')); 
  })
```


---

## Testing Email Sending


```typescript
import { UsersRepositoryInMemory } from "@modules/accounts/repositories/in-memory-tests/UsersRepositoryInMemory"
 import { DateProvider } from "@shared/container/providers/DateProvider/implementations/DayJSDateProvider"
 import { AppError } from "@shared/errors/AppError"
 import { SendForgottenPasswordMailUseCase } from "./SendForgottenPasswordMailUseCase"
 let sendForgotPasswordMailUseCase: SendForgottenPasswordMailUseCase
 let usersRepositoryInMemory: UsersRepositoryInMemory
 let dateProvider: DateProvider
 let usersTokensRepositoryInMemory: UsersTokensRepositoryInMemory
 let mailProvider: MailProviderInMemory
 describe("Send Forgot Mail", () => { beforeEach(() => { usersRepositoryInMemory = new UsersRepositoryInMemory()
 dateProvider = new DateProvider()
 usersTokensRepositoryInMemory = new UsersTokensRepositoryInMemory()
 mailProvider = new MailProviderInMemory()
 sendForgotPasswordMailUseCase = new SendForgottenPasswordMailUseCase( usersRepositoryInMemory, usersTokensRepositoryInMemory, dateProvider, mailProvider )
 })
 it("should be able to send a forgot password mail to user", async () => { const sendMail = spyOn(mailProvider, "sendMail")
 await usersRepositoryInMemory.create({ driver_license: "664168", email: "avzonbop@ospo.pr", name: "Blanche Curry", password: "1234", })
 await sendForgotPasswordMailUseCase.execute("avzonbop@ospo.pr")
 expect(sendMail).toHaveBeenCalled()
 })
 it("should not be able to send an email if user does not exists", async () => { await expect( sendForgotPasswordMailUseCase.execute("ka@uj.gr") ).rejects.toEqual(new AppError("User does not exists!"))
 })
 it("should be able to create an users token", async () => { const generateTokenMail = spyOn(usersTokensRepositoryInMemory, "create")
 usersRepositoryInMemory.create({ driver_license: "787330", email: "abome@regrog.ee", name: "Leon Perkins", password: "1234", })
 await sendForgotPasswordMailUseCase.execute("abome@regrog.ee")
 expect(generateTokenMail).toBeCalled(); }); });
```


---

## General Tips

- Use `spyOn` from Jest to check if a method of a class has been called. It is useful for interacting with third-party libraries like email services.
  
- Add the flags `--runInBand --detectOpenHandles` to test scripts to run them sequentially and avoid breaking due to previous test results.
  
- Do not work with databases in unit tests. Create a new repository with an empty array to simulate tests.
