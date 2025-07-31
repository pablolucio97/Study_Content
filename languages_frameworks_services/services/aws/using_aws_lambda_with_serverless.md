# SERVERLESS

## Concept
Serverless is an architecture oriented to events where the developer can stay focused only on the code development without worrying about infrastructure and server management. The serverless architecture includes a server responsible for running functions, auto-scaling, and more. It also allows cost reduction because you only pay when the server is called.

The use of serverless is recommended for actions that are not frequently used.

## Type of Serverless
- **BaaS**: Backend as a Service where functionalities for authentication, tables CRUD, and more are provided. Example: Firebase.
- **FaaS**: Function as a Service. These are cloud providers that supply functions to run in the cloud. Example: AWS Lambda, Google Cloud Functions.

# CREATING A SERVERLESS PROJECT WITH SERVERLESS FRAMEWORK, AWS DYNAMODB, AND LAMBDA

## 1. Install Serverless Framework
```bash
npm install -g serverless
```

## 2. Create a Serverless Project
```bash
serverless create --template aws-nodejs-typescript --path your_project_name
cd your_project_name
yarn install
```

## 3. Clean Up the Project
- Remove the `lib` folder.
- Empty the `functions` folder.
- Delete `tsconfigpaths` file.
- Remove `extends` and `ts-node` from `tsconfig.json`.

## 4. Create Your Lambda Function
Example function file inside `functions/`:

```typescript
import { APIGatewayProxyHandler } from "aws-lambda"
import { document } from '../utils/dynamodbClient'

interface ICreatedCertificate {
    id: string
    name: string
    grade: string
}

export const handler: APIGatewayProxyHandler = async (event) => {
    const { id, name, grade } = JSON.parse(event.body) as ICreatedCertificate

    await document.putItem({
        TableName: 'users_certificates',
        Item: {
            "id": {"S": id},
            "name": {"S": name},
            "grade": {"S": grade},
            "created_at": {"S": new Date().toTimeString()}
        }
    }).promise()

    const response = await document.query({
        TableName: 'users_certificates',
        KeyConditionExpression: "id = :id",
        ExpressionAttributeValues: {
            "id": {"S": id}
        }
    }).promise()

    return {
        statusCode: 201,
        body: JSON.stringify(response.Items[0])
    }
}
```

## 5. Add Function to `serverless.ts`
```ts
functions: {
  generateCertificate: {
    handler: 'src/functions/generateCertificate.handler',
    events: [
      {
        http: {
          path: 'generateCertificate',
          method: 'post',
          cors: true,
        }
      }
    ]
  }
},
```

## 6. Test Locally
```bash
yarn add serverless-offline esbuild -D
```
Add `serverless-offline` to `plugins` in `serverless.ts`, then:
```bash
serverless offline
```

## 7. Configure DynamoDB Table
Inside `serverless.ts`:
```ts
resources: {
  Resources: {
    dbCertificatesUsers: {
      Type: "AWS::DynamoDB::Table",
      Properties: {
        TableName: "users_certificates",
        ProvisionedThroughput: {
          ReadCapacityUnits: 5,
          WriteCapacityUnits: 5
        },
        AttributeDefinitions: [
          { AttributeName: "id", AttributeType: "S" }
        ],
        KeySchema: [
          { AttributeName: "id", KeyType: "HASH" }
        ]
      }
    }
  }
}
```

## 8. Setup Local DynamoDB
```bash
yarn add serverless-dynamodb-local -D
```

Create `src/utils/dynamoDbClient.ts`:
```ts
import { DynamoDB } from 'aws-sdk';

const options = {
    region: 'localhost',
    endpoint: 'http://localhost:8000',
}

const isOffline = () => process.env.IS_OFFLINE;

export const document = isOffline ? new DynamoDB(options) : new DynamoDB();
```

## 9. Add DynamoDB Plugin
```ts
plugins: ['serverless-dynamodb-local'],
```
Then run:
```bash
serverless plugin install -n serverless-dynamodb-local
```

## 10. Custom DynamoDB Configuration
```ts
custom: {
  dynamodb: {
    stages: ['dev', 'local'],
    start: {
      port: 8000,
      inMemory: true,
      migrate: true
    }
  }
}
```

## 11. Start Local DynamoDB
```bash
serverless dynamodb start
```

## 12. Grant IAM Permissions
- Go to AWS console > IAM.
- Attach `Administrator Access` to your user.

## 13. Configure AWS Credentials
```bash
serverless config credentials --provider aws --key=your_key --secret=your_secret -o
```

## 14. IAM Roles for Lambda
```ts
provider: {
  lambdaHashingVersion: '20201221',
  iamRoleStatements: [
    {
      Effect: "Allow",
      Action: ["dynamodb:*"],
      Resource: ["*"]
    }
  ]
}
```

## 15. Deploy Command
In `package.json`:
```json
"scripts": {
  "deploy": "serverless deploy --verbose"
}
```

## 16–24. Continue in next file due to size...
