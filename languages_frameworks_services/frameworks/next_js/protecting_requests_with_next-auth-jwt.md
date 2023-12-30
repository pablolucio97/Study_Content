# PROTECTING REQUESTS WITH NEXT-AUTH-JWT

This guide details how to protect HTTP requests in a Next.js project using JWT (JSON Web Tokens) from `next-auth/jwt`.

## 1. Set Up JWT_SECRET

- Define `JWT_SECRET` in your `.env` file. This can be a generated or a fixed value.

---

## 2. Implement JWT in Controller

- Use `jwt` from `next-auth/jwt` in your HTTP methods file (controller).
- Add logic to allow requests only if a JWT token is present.
- Example:
  ```js
  import jwt from 'next-auth/jwt';
  import { NextApiRequest, NextApiResponse } from 'next';
  import nc from 'next-connect';
  import connectToDatabase from '../path/to/mongodb';

  const secret = process.env.JWT_SECRET;

  const handler = nc()
    .post(async (req: NextApiRequest, res: NextApiResponse) => {
      const { title, authorId, videoURL, authorName, authorAvatar, views } = req.body;
      const token = await jwt.getToken({ req, secret });

      if (token) {
        const { db } = await connectToDatabase();
        const collection = db.collection('videos');
        
        await collection.insertOne({
          title,
          authorAvatar,
          authorId,
          views,
          videoURL,
          authorName,
          // @ts-ignore
          thumb: req.file.location,
        });

        return res.json({ ok: true });
      }
      return res.status(401).end();
    });
