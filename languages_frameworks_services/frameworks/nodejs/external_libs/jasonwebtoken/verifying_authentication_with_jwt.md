# Verifying Authentication with JWT

To verify authentication in an application using JWT, you need to create a middleware that checks if the token exists, validates it, and retrieves the user based on the token's payload.

### Steps:

1. Inside the `src` directory, create a new folder named `middlewares`. Inside it, create a new file named `ensureAuthenticate.ts`. This file will export an asynchronous function that serves as the authentication middleware. The function must find the user by ID, check if the token exists in the request header, and validate the token using the `verify()` method from the `jsonwebtoken` library.

### Example:

```typescript
import { Request, Response, NextFunction } from 'express';
import { verify } from 'jsonwebtoken';
import { UserRepository } from '../modules/accounts/repositories/UserRepository';

interface IPayload {
    sub: string;
}

export async function ensureAuthenticated(
    req: Request,
    res: Response,
    next: NextFunction
) {
    const authHeader = req.headers.authorization;

    if (!authHeader) {
        throw new Error('Token missing');
    }

    const [, token] = authHeader.split(' ');

    try {
        // Validate the token and extract the user_id (sub)
        const { sub: user_id } = verify(token, 'your_md5_code') as IPayload;

        // Retrieve the user from the repository
        const usersRepository = new UserRepository();
        const user = await usersRepository.findById(user_id);

        if (!user) {
            throw new Error('User does not exist');
        }

        next(); // Proceed to the next middleware or route handler

    } catch (error) {
        throw new Error('Invalid token');
    }
}
```
