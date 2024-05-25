# Uploading files to Azure Blob Storage and NestJS

1. Register at Azure if you didn't it already.

2. Create a new Azure Storage service click on "Storage Accounts".

3. Create a new Storage Container clicking on "Blob service"/"Containers". Pay attention to allow it be completely accessible for anonymous users.
   
4. Take note your connection string and your container name. Both will be used for connect to your Azure Blob Storage container.
   
5. Install the Azure Blob Storage in your application running the command `npx yarn add @azure/storage-blob`.
   
6. Add the Azure credentials to the environment variables and its schema, example:
```typescript
import { z } from "zod";
export const envSchema = z.object({
    DATABASE_URL: z.string().url(),
    JWT_PRIVATE_KEY: z.string(),
    JWT_PUBLIC_KEY: z.string(),
    PORT: z.coerce.number().optional().default(3333),
    AZURE_BLOB_STORAGE_CONNECTION_STRING: z.string(),
    AZURE_BLOB_STORAGE_CONTAINER_NAME: z.string(),
});
export type TEnv = z.infer<typeof envSchema>; 8.
```


7. Create the Azure Blob Storage provider. Example:

```typescript
import { BlobServiceClient } from "@azure/storage-blob";
import { Injectable } from "@nestjs/common";
import { ConfigService } from "@nestjs/config";
import { TEnv } from "../env";

@Injectable()
export class AzureBlobStorageProvider {
  private blobServiceClient: BlobServiceClient;
  constructor(private config: ConfigService<TEnv, true>) {
    const connectionString = this.config.get(
      "AZURE_BLOB_STORAGE_CONNECTION_STRING",
      { infer: true }
    );
    if (!connectionString) {
      throw new Error(
        "Azure Blob Storage connection string is not configured."
      );
    }
    this.blobServiceClient =
      BlobServiceClient.fromConnectionString(connectionString);
  }

  getBlobServiceClient(): BlobServiceClient {
    return this.blobServiceClient;
  }
}
```

8. Install the Multer and its types running `npx yarn add multer` and `npx yarn add @types/multer -D`.

9. Create a new folder named `config` and file named `multerConfig.ts`exporting the multer configuration and the temporary files uploaded folder. Example:

```typescript
import multer from "multer";
import path from "path";
import { uuid as uuidV4 } from "uuidv4";

const tempFolder = path.resolve(__dirname, "..", "temp_uploads");

const multerConfig = multer.diskStorage({
//this folder will not exist because on the upload service it will be stored in memory through Buffer
  destination: tempFolder,
  filename: (_, file, callback) => {
    const fileName = `${uuidV4()}-${file.originalname}`;
    return callback(null, fileName);
  },
});

export { multerConfig, tempFolder };
```
10. Crate a service for uploading files. Example:
```typescript
import { Injectable } from "@nestjs/common";
import { ConfigService } from "@nestjs/config";
import { TEnv } from "../env";
import { AzureBlobStorageProvider } from "../providers/AzureBloStorageProvider";

@Injectable()
export class UploadFileService {
  constructor(
    private azureBlobStorageProvider: AzureBlobStorageProvider,
    private config: ConfigService<TEnv, true>
  ) {}

  async uploadFile(fileBuffer: Buffer, fileName: string) {
    const blobStorageContainerName = this.config.get(
      "AZURE_BLOB_STORAGE_CONTAINER_NAME",
      { infer: true }
    );
    const blobClient = this.azureBlobStorageProvider
      .getBlobServiceClient()
      .getContainerClient(blobStorageContainerName)
      .getBlockBlobClient(fileName);
    await blobClient.uploadData(fileBuffer);
    return blobClient.url;
  }
}
```
11. Import and use the file uploading service in your controller. You need to initialize the uploadService in your constructor, to use the FileInterceptor inside the UseInterceptors decorator, to import and pass the UploadedFile and the Req from  "@nestjs/common" in your controller and then call the  uploadFileService.uploadFile()  passing the file buffer and original name that comes from the  UploadedFile decorator typed as Express.Multer.File. Example:
```typescript
import {
  ConflictException,
  Controller,
  HttpCode,
  Post,
  Req,
  UploadedFile,
  UseGuards,
  UseInterceptors,
} from "@nestjs/common";
import { AuthGuard } from "@nestjs/passport";
import { FileInterceptor } from "@nestjs/platform-express";
import { Request } from "express";
import { ClassesRepository } from "src/infra/repositories/implementations/classesRepository";
import { UploadFileService } from "src/infra/services/fileUploadService";
import { CreateClassUseCase } from "src/infra/useCases/classes/createClassUseCase";

@Controller("/classes")
@UseGuards(AuthGuard("jwt"))
export class CreateClassController {
  constructor(
    private createClassUseCase: CreateClassUseCase,
    private classesRepository: ClassesRepository,
    private uploadFileService: UploadFileService
  ) {}
  @Post()
  @HttpCode(201)
  @UseInterceptors(FileInterceptor("file"))
  async handle(@UploadedFile() file: Express.Multer.File, @Req() req: Request) {
    const { name, description, duration, moduleId, tutorId, courseId } =
      req.body;

    const parsedDuration = parseInt(duration);

    const fileUrl = await this.uploadFileService.uploadFile(
      file.buffer,
      file.originalname
    );

    const createdClass = await this.createClassUseCase.execute({
      name,
      description,
      url: fileUrl,
      duration: parsedDuration,
      moduleId,
      tutorId,
      courseId,
    });

    return createdClass;
  }
}
```

12. Call your request expecting for a multipart upload. The file must uploaded in a field named as `file`.
