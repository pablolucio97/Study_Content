# Building and Consuming API with Next.js and Hosting in AWS S3 with MongoDB

1. **Create Endpoint Folder in Next.js:**
   - With a Next.js project running, create a folder with the name of your endpoint inside the `api` folder, e.g., `videos`.

2. **Setting Up MongoDB:**
   - Create and log in to your MongoDB account.
   - Create a new cluster with AWS as the cloud provider (you can have one free cluster but multiple databases in a single cluster).
   - Create a new database and collection.
   - In 'Database Access', add a new user with a username and password, allowing read and write access to any database.
   - Set `0.0.0.0/0` as the IP address to open your network address.

3. **Install MongoDB and Its Types:**
   - Install MongoDB packages and their TypeScript types.

4. **Create .env.local for Environment Variables:**
   - Add the following variables:
     ```
     MONGODB_URI=your_mongodb_uri
     MONGODB_DB=your_mongodb_database
     ```

5. **Set Up MongoDB Connection:**
   - Create a file named `mongodb.ts` in a `utils` folder.
   - Import `Db` and `MongoClient` from `mongodb`.
   - Instance an async function to connect with the MongoDB database and return it.

6. **AWS S3 Bucket Setup:**
   - Log in to AWS console, search for S3, and create a new S3 bucket.
   - Go to IAM to get your AWS keys and store them in `.env.local`. Example:
     ```
     AWS_SECRET_KEY=your_aws_secret_key
     AWS_ACCESS_KEY=your_aws_access_key
     AWS_REGION=your_aws_region
     AWS_BUCKET=your_aws_s3_bucket
     ```

7. **Install AWS SDK, Multer, and Multer-S3:**
   - Install necessary packages for file uploading.

8. **Create Upload Configuration:**
   - In the `utils` folder, create `upload.ts`.
   - Set up AWS SDK, S3 instance, and Multer configuration for file upload.

9. **Setting Up API Handler with Next.js:**
   - In your endpoint folder (e.g., `videos`), create a file (e.g., `video.ts`).
   - Import your upload, database connection, and `next-connect`.
   - Set up a handler using `next-connect` to manage the API requests.

10. **Testing API with Insomnia:**
    - Create a new environment in Insomnia with a POST method and multipart file.
    - Perform your requests.

11. **Creating a Function for Data Retrieval:**
    - In the `utils` folder, create a file (e.g., `getVideos.ts`).
    - Export an async function to retrieve data from MongoDB.

12. **Consuming Data in a Next.js Page:**
    - Import your data retrieval function in a Next.js page.
    - Use `getStaticProps` to fetch data at build time.
    - Consume the data in your component/page.
