# WORKING WITH REFRESH TOKEN WITH JWT AND TYPEORM

It is not secure to use a token with long validity (above 20 minutes). For this reason, to avoid forcing the user to log in again to generate a new token, the system generates a new token (refresh token) when the original token has expired.

The token ensures the application's security, while the refresh token is only used to generate a new token. When authenticating, both a token and a refresh token are generated. The token is used for the user to interact with the application, and the refresh token generates a new token when the original one expires. In the refresh token route, the user must pass the generated refresh token from the first authentication to get a new token with a new refresh token, allowing the process to repeat whenever the token expires.

### 1. Create a Migration to Store the Refresh Token Related to Users

Create the migration and run it. Example:

`import { MigrationInterface, QueryRunner, Table } from "typeorm";`

`export class CreateUserRefreshTokens1661598597205 implements MigrationInterface {`

`public async up(queryRunner: QueryRunner): Promise<void> {`
`await queryRunner.createTable(new Table({`
`name: "users_token",`
`columns: [`
`{ name: "id", type: "uuid", isPrimary: true },`
`{ name: "refresh_token", type: "varchar" },`
`{ name: "user_id", type: "uuid" },`
`{ name: "expires_date", type: "timestamp" },`
`{ name: "created_at", type: "timestamp", default: "now()" }`
`],`
`foreignKeys: [`
`{ name: "FKUserToken", referencedTableName: "users", referencedColumnNames: ["id"], columnNames: ["user_id"], onUpdate: "CASCADE", onDelete: "CASCADE" }`
`]`
`}))`
`}`

`public async down(queryRunner: QueryRunner): Promise<void> {`
`await queryRunner.dropTable('users_token')`
`}`
`}`

---

### 2. Create the User Tokens Entity

Example:

`import { Column, Entity, PrimaryColumn, CreateDateColumn, JoinColumn, ManyToOne } from "typeorm";`

`import { User } from "./user";`

`import { v4 as uuidv4 } from 'uuid'`

`@Entity("users_token")`
`class UserTokens {`

`@PrimaryColumn()`
`id: string;`

`@Column()`
`refresh_token: string;`

`@Column()`
`user_id: string;`

`@CreateDateColumn()`
`expires_date: Date;`

`@CreateDateColumn()`
`created_at: Date;`

`@ManyToOne(() => User)`
`@JoinColumn({ name: "user_id" })`
`user: User`

`constructor() {`
`if (!this.id) {`
`this.id = uuidv4();`
`}`
`}`
`}`

`export { UserTokens }`

---

### 3. Create the DTO for User Tokens

Example:

`interface ICreateUserTokenDTO {`
`user_id: string;`
`expires_date: Date;`
`refresh_token: string;`
`}`

`export { ICreateUserTokenDTO };`

---

### 4. Create the User Tokens Repository Interface

Example:

`import { ICreateUserTokenDto } from '../dtos/ICreateUserTokenDto'`
`import { UserTokens } from "../infra/typeorm/entities/UserTokens";`

`interface IUsersTokensRepository {`
`create({ expires_date, refresh_token, user_id }: ICreateUserTokenDto): Promise<UserTokens>;`
`}`

`export { IUsersTokensRepository }`

---

### 5. Create Auth Configuration

Inside `src/config`, create a new `auth.ts` file exporting an object with your auth options. Example:

`export default {`
`secret_token: process.env.SECRET_AUTH_TOKEN,`
`expiration_time_token: "15m",`
`secret_refresh_token: process.env.SECRET_AUTH_REFRESH_TOKEN,`
`expiration_time_refresh_token: "30d",`
`expiration_time_refresh_token_days: 30,`
`}`

---

### 6. Implement the User Tokens Repository

Example:

`import { ICreateUserTokenDto } from "@modules/accounts/dtos/ICreateUserTokenDto";`
`import { IUsersTokensRepository } from "@modules/accounts/repositories/IUserRepositoryTokens";`
`import { getRepository, Repository } from "typeorm";`
`import { UserTokens } from "../entities/UserTokens";`

`class UsersTokenRepository implements IUsersTokensRepository {`

`private repository: Repository<UserTokens>;`

`constructor() {`
`this.repository = getRepository(UserTokens);`
`}`

`async create({ expires_date, refresh_token, user_id }: ICreateUserTokenDto): Promise<UserTokens> {`
`const userToken = await this.repository.create({ user_id, expires_date, refresh_token });`
`await this.repository.save(userToken);`
`return userToken;`
`}`
`}`

`export { UsersTokenRepository }`

---

### 7. Add the Repository to the Container

Using `tsyringe`, add the repository to the container. Example:

`import { container } from 'tsyringe';`
`import '@shared/container/providers';`
`import { UsersRepository } from '@modules/accounts/infra/typeorm/repositories/UserRepository';`
`import { IUsersTokensRepository } from '@modules/accounts/repositories/IUserRepositoryTokens';`
`import { UsersTokenRepository } from '@modules/accounts/infra/typeorm/repositories/UsersTokensReposiroty';`

`container.registerSingleton<IUsersRepository>('UsersRepository', UsersRepository);`

`container.registerSingleton<IUsersTokensRepository>('UsersTokensRepository', UsersTokenRepository);`

---

### 8. Modify `AuthenticateUserUseCase`

Inject the repositories and handle the refresh token relationship. Example:

`import auth from "@config/auth";`
`import { IUsersRepository } from "@modules/accounts/repositories/IUserRepository";`
`import { IUsersTokensRepository } from "@modules/accounts/repositories/IUserRepositoryTokens";`
`import { IDateProvider } from "@shared/container/providers/DateProvider/IDateProvider";`
`import { AppError } from "@shared/errors/AppError";`
`import { compare } from 'bcryptjs';`
`import { sign } from 'jsonwebtoken';`
`import { inject, injectable } from "tsyringe";`

`interface IRequest {`
`email: string;`
`password: string;`
`}`

`interface IResponse {`
`user: { name: string; email: string; };`
`token: string;`
`refresh_token: string;`
`}`

`@injectable()`
`class AuthenticateUserUseCase {`

`constructor(`
`@inject('UsersRepository') private usersRepository: IUsersRepository,`
`@inject('UsersTokensRepository') private usersTokensRepository: IUsersTokensRepository,`
`@inject('DayjsDateProvider') private DateProvider: IDateProvider`
`) {}`

`async execute({ email, password }: IRequest): Promise<IResponse> {`
`const user = await this.usersRepository.findByEmail(email);`
`const passwordMatch = await compare(password, user.password);`

`if (!passwordMatch) {`
`throw new AppError('Email or password incorrect');`
`}`

`if (!user) {`
`throw new AppError('User does not exists');`
`}`

`const { secret_token, expiration_time_refresh_token, expiration_time_token, secret_refresh_token, expiration_time_refresh_token_days } = auth;`

`const token = sign({}, secret_token, { subject: user.id, expiresIn: expiration_time_token });`

`const refresh_token = sign({}, secret_refresh_token, { subject: user.id, expiresIn: expiration_time_refresh_token });`

`const refresh_token_expires_date = this.DateProvider.addDays(expiration_time_refresh_token_days);`

`await this.usersTokensRepository.create({ user_id: user.id, refresh_token: secret_refresh_token, expires_date: refresh_token_expires_date });`

`const tokenReturn: IResponse = { token, user: { name: user.name, email: user.email }, refresh_token };`

`return tokenReturn;`
`}`
`}`

`export { AuthenticateUserUseCase };`

---

### 9. Create the Refresh Token Use Case

Example:

`import { inject, injectable } from "tsyringe";`
`import { verify, sign } from "jsonwebtoken";`
`import auth from "@config/auth";`
`import { AppError } from "@shared/errors/AppError";`
`import { IDateProvider } from "@shared/container/providers/DateProvider/IDateProvider";`
`import { IUsersTokensRepository } from "@modules/accounts/repositories/IUserRepositoryTokens";`

`interface IPayload { sub: string; email: string; }`

`interface ITokenResponse { token: string; refresh_token: string; }`

`@injectable()`
`class RefreshTokenUseCase {`

`constructor( @inject("UsersTokensRepository") private usersTokensRepository: IUsersTokensRepository, @inject("DateProvider") private dateProvider: IDateProvider ) {}`

`async execute(token: string): Promise<ITokenResponse> {`
`const { email, sub } = verify(token, auth.secret_refresh_token) as IPayload;`
`const user_id = sub;`

`const userToken = await this.usersTokensRepository.findByUserIdAndRefreshToken(user_id, token);`
`if (!userToken) { throw new AppError("Refresh Token does not exist!"); }`

`await this.usersTokensRepository.deleteById(userToken.id);`

`const refresh_token = sign({ email }, auth.secret_refresh_token, { subject: sub, expiresIn: auth.expires_in_refresh_token });`
`const expires_date = this.dateProvider.addDays(auth.expires_refresh_token_days);`

`await this.usersTokensRepository.create({ expires_date, refresh_token, user_id });`

`const newToken = sign({}, auth.secret_token, { subject: user_id, expiresIn: auth.expires_in_token });`

`return { refresh_token, token: newToken };`
`}`
`}`

`export { RefreshTokenUseCase };`

---

### 10. Create the Refresh Token Controller

Example:

`import { Request, Response } from 'express';`
`import { container } from 'tsyringe';`
`import { RefreshTokenUseCase } from './RefreshTokenUseCase';`

`class RefreshTokenController {`
`async handle(req: Request, res: Response): Promise<Response> {`
`const { token } = req.body.token || req.headers['x-access-token'] || req.query.token;`
`const refreshTokenUseCase = await container.resolve(RefreshTokenUseCase);`
`const refreshToken = await refreshTokenUseCase.execute(token);`
`return res.json(refreshToken);`
`}`
`}`

`export { RefreshTokenController };`

---

### 11. Modify the `ensureAuthenticated` Middleware

Ensure the middleware expects the refresh token and not the old token. Example:

`import auth from '@config/auth';`
`import { UsersTokenRepository } from '@modules/accounts/infra/typeorm/repositories/UsersTokensReposiroty';`
`import { AppError } from '@shared/errors/AppError';`
`import { NextFunction, Request, Response } from 'express';`
`import { verify } from 'jsonwebtoken';`

`interface IPayload { sub: string }`

`export async function ensureAuthenticated(req: Request, res: Response, next: NextFunction) {`
`const authHeader = req.headers.authorization;`
`const usersTokensRepository = new UsersTokenRepository();`

`if (!authHeader) { throw new AppError('Missing token', 401); }`

`const [, token] = authHeader.split(' ');`

`try {`
`const { sub: user_id } = verify(token, auth.secret_refresh_token) as IPayload;`
`const user = await usersTokensRepository.findByUserIdAndRefreshToken(user_id, token);`
`if (!user) { throw new AppError('User does not exist', 401); }`

`req.user = { id: user_id };`
`next();`

`} catch (error) {`
`throw new AppError('Invalid token', 401);`
`}`
`}`

---

### 12. Create the Route and Use the Controller

Example:

`import { Router } from 'express';`
`import { AuthenticateUserController } from '../../../../modules/accounts/useCases/authenticateUser/AuthenticateUserController';`

`const authenticateRoutes = Router();`
`const authenticateUserController = new AuthenticateUserController();`

`authenticateRoutes.post('/sessions', authenticateUserController.handle);`

`export { authenticateRoutes };`
