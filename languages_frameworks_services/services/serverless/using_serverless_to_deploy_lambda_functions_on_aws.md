# Using Serverless framework to deploy Lambda Functions on AWS

1. Install the serverless cli globally running `npm install serverless -g`.
2. Create your project folder and starts the npm configuration running `npm init -y`.
3. Install the required dependencies: `npm install aws-sdk express serverless-http`
4. Create your serverless application running `serverless`. Provide a name and choice the `AWS / NodeJS / HTTP API` template.
5. Create a handler.js file , write and export your function that will be executed as AWS Lambda function. In this example w'll export a function that uses a GET and POST endpoints to retrieve and create an user on users table created using DynamoDB:
```javascript
import AWS from 'aws-sdk'
import express from 'express'
import serverlessHttp from 'serverless-http'

const app = express()

const USERS_TABLE = process.env.USERS_TABLE_NAME
const dynamoDbClient = new AWS.DynamoDB.DocumentClient()

app.use(express.json())

app.get("/users/:userId", async (req, res) => {
    const params = {
        TableName: USERS_TABLE,
        Key: {
            userId: req.params.userId,
        },
    };
    
    try {
        const { Item } = await dynamoDbClient.get(params).promise();
        if (Item) {
            const { userId, name, email } = Item;
            return res.json({ userId, name, email });
        } else {
            return res
            .status(404)
            .json({ error: 'Could not find user with provided "userId"' });
        }
    } catch (error) {
        console.log(error);
        return res.status(500).json({ error: "Could not retreive user" });
    }
});

app.post("/users", async (req, res) => {
    const { userId, name, email } = req.body;
    
    const params = {
        TableName: USERS_TABLE,
        Item: {
            userId,
            name,
            email,
        },
    };
    
    try {
        await dynamoDbClient.put(params).promise();
        return res.json({ userId, name, email });
    } catch (error) {
        console.log(error);
        return res.status(500).json({ error: "Could not create user" });
    }
});

app.use((req, res, next) => {
    return res.status(404).json({
        error: "Not Found",
    });
});

//proxy the received events from express and parse to serverless
export const handler = serverlessHttp(app)
``` 

6. Provide the serverless.yml file containing the AWS infrastructure instructions. Example:

```yml
org: pscode
app: serverless-api
service: serverless-api
frameworkVersion: "4"

custom:
  tableName: "users-table-${sls:stage}"

provider:
  name: aws
  runtime: nodejs20.x
  iam:
    role:
      statements:
        - Effect: Allow
          Action:
            - dynamodb:Query
            - dynamodb:Scan
            - dynamodb:GetItem
            - dynamodb:PutItem
            - dynamodb:UpdateItem
            - dynamodb:DeleteItem
          Resource:
            - Fn::GetAtt: [UsersTable, Arn]
  environment:
    USERS_TABLE_NAME: ${self:custom.tableName}

functions:
  crud-test:
    handler: handler.handler
    events:
      - httpApi: "*"

resources:
  Resources:
    UsersTable:
      Type: AWS::DynamoDB::Table
      Properties:
        AttributeDefinitions:
          - AttributeName: userId
            AttributeType: S
        KeySchema:
          - AttributeName: userId
            KeyType: HASH
        BillingMode: PAY_PER_REQUEST
        TableName: ${self:custom.tableName}
```
7. Run the command `serverless deploy` to deploy your service.
8. If the deploy is succeed, the AWS Lambda URL will be returned and it will be your base URL. You can test calls to your Lambda function testing it on your REST client. Example: `https://7b33ucizzj.execute-api.us-east-1.amazonaws.com/users/1`

## General tips
- Serverless will concatenate your service + function name to provide a name for your Lambda Function.
- Serverless creates a new function as you rename the function name under functions on your serverless.yml file.
- By default only LambdaFullAccess permission is attached to your Lambda function. You must provide DynamoDBFullAccess or related accesses you're requesting AWS for on your IAM profile/resources.
- Pay attention on your 
- Use the flag --debug to watch any possible error at trying to deploy your serverless function. It helps to identify specific errors.

## References:

[Repository example](https://github.com/pablolucio97/serverless)
[Serverless Docs](https://www.serverless.com/framework/docs/getting-started)