# JWT (JSON Web Token)

JWT is an encoded token used to grant authorization for the client to access specific routes or perform actions within your application. Each JWT token is unique and can only be altered by the entity that created it. Any modification to the data changes the JWT token string.

A JWT token consists of three parts, separated by dots (`.`): 

- **Header**: Contains the algorithm used to generate the token and the token type (JWT).
- **Payload**: Contains the data you want to transmit, organized into properties (claims).
- **Verify Signature**: This is the signature of your token. It contains a secret key that only your application should know. The signature combines all token information with the secret key.

---

## Generating JWT Tokens

You can generate your token using `JWT.sign()`, which accepts four parameters:
1. The data you want to encode (payload).
2. Your private key to protect the token.
3. Options (security algorithm, issuer, expiration time, etc.).
4. A callback function to resolve your promise (useful when inside an async function).

### Steps:

1. Install `jsonwebtoken` and its types by running:
   `npm i jsonwebtoken` and `npm i @types/jsonwebtoken`

2. Import JWT:
   
   `import JWT from "jsonwebtoken";`

3. Embed your `JWT.sign()` method inside a promise to call it asynchronously. In this example, a JWT token is generated on a POST request:

```typescript
export default {
  async showToken(req: Request, res: Response) {
    const ALGORITHM = "HS256";

    const generateToken = (payload) =>
      new Promise((resolve) => {
        JWT.sign(
          { payload },
          process.env.MYKEY,
          { algorithm: ALGORITHM },
          (err, token) => {
            if (err) {
              throw new Error('An error has occurred.');
            }
            resolve(token);
          }
        );
      });

    const JWTDATA = {
      iss: 'my-api',
      sub: 'user.id',
      exp: Math.floor(Date.now() / 1000) + 3600 // Expires in 1 hour
    };

    const token = await generateToken(JWTDATA);
    return res.json({ "Token": token });
  }
};
```