# Doing Uploads to AWS S3 Bucket

## 1. Accessing AWS S3
After logging into the AWS console and with an IAM user already created, search for **S3** and click on **bucket**.

---

## 2. Creating a Bucket
Click on **Create bucket**, provide a bucket name, select a region, uncheck **Block all public access**, and check **I acknowledge...** if your application will be public. Then click **Create bucket**.

---

## 3. Installing Dependencies
Run the following in your project:

```
yarn add aws-sdk
yarn add mime @types/mime@2.0.3
yarn add dotenv
```

Also install multer if you haven't.

---

## 4. Creating Environment Variables
Set the following in your `.env` file:

```
AWS_ACCESS_KEY_ID=your_aws_access_key
AWS_SECRET_ACCESS_KEY=your_aws_access_secret
AWS_BUCKET=your_aws_s3_bucket_name
```

---

## 5. Creating the IStorageProvider Interface
```ts
export interface IStorageProvider {
  save(file: string): Promise<string>;
  delete(file: string): Promise<string>;
}
```

---

## 6. Multer Configuration (`@config/upload.ts`)
```ts
import multer from 'multer';
import { resolve } from 'path';
import { randomBytes } from 'crypto';

const tmpFolder = resolve(__dirname, '..', '..', 'tmp');

export default {
  tmpFolder,
  storage: multer.diskStorage({
    destination: tmpFolder,
    filename: (req, file, cb) => {
      const fileHash = randomBytes(16).toString('hex');
      const fileName = `${fileHash}-${file.originalname}`;
      return cb(null, fileName);
    },
  }),
};
```

---

## 7. LocalStorageProvider
```ts
import { IStorageProvider } from "../IStorageProvider";
import fs from 'fs';
import { resolve } from 'path';
import upload from '@config/upload';

class LocalStorageProvider implements IStorageProvider {
  async save(file: string, folder: string): Promise<string> {
    await fs.promises.rename(resolve(upload.tmpFolder, file), resolve(`${upload.tmpFolder}/${folder}`, file));
    return file;
  }

  async delete(file: string, folder: string): Promise<string> {
    const fileName = resolve(`${upload.tmpFolder}/${folder}`, file);
    try {
      await fs.promises.stat(fileName);
    } catch (error) {
      return;
    }
    await fs.promises.unlink(fileName);
  }
}

export { LocalStorageProvider };
```

---

## 8. Registering the Provider
```ts
import { container } from 'tsyringe';
import { LocalStorageProvider } from './StorageProvider/implementations/LocalStorageProvider';
import { IStorageProvider } from './StorageProvider/IStorageProvider';

container.registerInstance<IStorageProvider>("StorageProvider", new LocalStorageProvider());
```

---

## 9. Using the Provider
```ts
import { IUsersRepository } from "@modules/accounts/repositories/IUserRepository";
import { IStorageProvider } from "@shared/container/providers/StorageProvider/IStorageProvider";
import { inject } from "tsyringe";

interface IRequest {
  user_id: string;
  avatar_file: string;
}

class UpdateUserAvatarUseCase {
  constructor(
    @inject('UsersRepository') private usersRepository: IUsersRepository,
    @inject('StorageProvider') private storageProvider: IStorageProvider
  ) {}

  async execute({ user_id, avatar_file }: IRequest): Promise<void> {
    const user = await this.usersRepository.findById(user_id);
    await this.storageProvider.save(avatar_file, 'avatar');
    if (user.avatar) {
      await this.storageProvider.delete(user.avatar, 'avatar');
    }
    user.avatar = avatar_file;
    await this.usersRepository.create(user);
  }
}

export { UpdateUserAvatarUseCase };
```

---

## 10. S3StorageProvider Implementation
```ts
import { IStorageProvider } from "../IStorageProvider";
import { S3 } from 'aws-sdk';
import { resolve } from 'path';
import fs from 'fs';
import upload from "@config/upload";
import mime from 'mime';

class S3StorageProvider implements IStorageProvider {
  private client: S3;

  constructor() {
    this.client = new S3({ region: process.env.AWS_BUCKET_REGION });
  }

  async save(file: string, folder: string): Promise<string> {
    const originalName = resolve(upload.tmpFolder, file);
    const fileContent = await fs.promises.readFile(originalName);
    const ContentType = mime.getType(originalName);

    await this.client.putObject({
      Bucket: `${process.env.AWS_BUCKET}/${folder}`,
      Key: file,
      ACL: 'public-read',
      Body: fileContent,
      ContentType,
    }).promise();

    await fs.promises.unlink(originalName);
    return file;
  }

  async delete(file: string, folder: string): Promise<void> {
    await this.client.deleteObject({
      Bucket: `${process.env.AWS_BUCKET}/${folder}`,
      Key: file,
    }).promise();
  }
}

export { S3StorageProvider };
```

---

## 11. Importing dotenv
```ts
import "reflect-metadata";
import 'dotenv/config';
import express, { json, NextFunction } from 'express';
import 'express-async-errors';
```

---

## 12. Sending Request via Insomnia
Perform a POST request to your configured upload endpoint with multipart form-data and test the file upload.
