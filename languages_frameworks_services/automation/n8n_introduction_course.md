# N8N Introduction Course

## General Concepts

**N8N**: n8n is a digital automation platform that allows you to build, test and deploy AI agents with minimal or not coding.

**AI Agents**: AI agents are autonomous programs that can make decisions, perform tasks, and interact with third apps based on received instructions.

**Automation**: Automation is a set o predictable set of predetermined actions that transfers data from one point to another.

## Architecture of an automation project

![alt text](imgs/image-1.png)

**Front-end:** Whatsapp, web application, forms and so on.
**Back-end:** Supabase, Qdrant ( a vectorial database used to save data as text), and so on.
**Third technologies:** Third APIs, RabbitMQ, Webhooks, Stripe, AI agents like Open IA, DeepSeek and so on.
**Hosting** Docker, third hosting services like Railway, Hostgator, Digital Ocean and so on.

## N8N concepts
**Trigger** It's an event. It's used to call next block/actions. It will initiate or launch your workflow.
**Nodes** Nodes are building blocks that contains your instructions.
**Workflow** It's a set of connected nodes that defines your automation logic.
**Filtering** It's a filter that allows a block proceed or not to the next workflow point.
**Actions** Tasks you want to perform with a piece of data, such as Get, Send, Update, or Delete.
**Apps** It can be any official associated app to n8n. Examples: Notion, Slack, and so on.
**Functions Apps** It can be any function available in an official third app connected to n8n. Examples: A Google Sheet function to delete a row.

## Types of triggers
- **Manual**: It's fired manually to test or execute workflows on demand.
- **Scheduled**: It's fired by a schedule on specific day and date. Ex: Every Friday, every 1 hour, every Monday 5PM.
- **Instant**: It's instantly fired based on some event. Ex: On form submission, on Google Sheet property updated.

## Types of nodes
- **Entry point**: It's the first node of your workflow, the trigger node.
- **Function**: It's a node that executes an actions app function.
- **Exit point**: It's the last node of your workflow. It should be executed to tell your workflow was executed successfully.

## Trigger Nodes
- **Webhook Trigger**: Starts a workflow when it receives an incoming HTTP request (great for integrating external apps).  
- **Cron Trigger**: Executes workflows on a defined schedule (e.g., every hour, daily, weekly).  
- **Interval Trigger**: Runs workflows repeatedly at a set interval (seconds, minutes, hours).  
- **Google Sheets Trigger**: Activates when a row is created/updated in a Google Sheet.  
- **IMAP Email Trigger**: Triggers when a new email arrives in the configured inbox.  

## Data Transformation Nodes
- **Set**: Creates or updates fields in items with fixed values, variables, or expressions.  
- **Function**: Run custom JavaScript across all items in a single function block.  
- **Function Item**: Apply JavaScript logic individually on each item.  
- **Merge**: Combine two input streams (append, merge by key, wait for both).  
- **SplitInBatches**: Breaks a data set into smaller chunks to process sequentially.  
- **IF**: Conditional branching, sending items down true/false paths based on logic.  
- **Switch**: Routes data into multiple outputs depending on matching case values.  
- **Limit**: Restrict the number of items passed forward (useful for testing).  
- **Rename Keys**: Changes property names of fields in data items.  

## API & HTTP Nodes
- **HTTP Request**: Send HTTP/HTTPS requests to external APIs (supports auth, headers, body).  
- **GraphQL**: Perform GraphQL queries or mutations against compatible APIs.  
- **Webhook**: Expose endpoints to receive or return data to external services.  

## Database Nodes
- **MySQL**: Run SQL queries, insert, update, or delete rows in a MySQL DB.  
- **Postgres**: Execute SQL operations in a PostgreSQL database.  
- **SQLite**: Query or update SQLite databases.  
- **MongoDB**: Insert, update, query, or delete documents in MongoDB collections.  

## File Nodes
- **Read Binary File**: Load a file from disk into the workflow as binary data.  
- **Write Binary File**: Save binary workflow data to a local file.  
- **Move Binary Data**: Convert fields from JSON into binary data or vice versa.  

## Messaging & Communication Nodes
- **Email Send**: Sends email via SMTP or third-party email providers.  
- **Slack**: Post messages, read channel data, or manage users in Slack.  
- **Telegram**: Send or receive messages with Telegram bots.  
- **Discord**: Interact with Discord servers (send messages, manage roles/channels).  

## Cloud & Storage Nodes
- **Google Drive**: Upload, download, or search files in Google Drive.  
- **Dropbox**: Manage and move files/folders in Dropbox.  
- **AWS S3**: Upload, download, list, or delete objects from S3 buckets.  

## Utility Nodes
- **Wait**: Pause execution until a specific time or condition is reached.  
- **NoOp**: Does nothing, passes input as output (useful for testing/debugging).  
- **Error Trigger**: Starts when another workflow fails (error handling).  
- **Execute Workflow**: Call another workflow from within the current workflow.  
- **Execute Command**: Runs shell/system commands on the host machine.  


## Useful Nodes
- **HTTP Request**: Send or receive data via APIs.
- **Set**: Define or update data within the workflow.
- **IF**: Add conditional logic to control the flow.
- **Webhook**: Receive real-time data from external sources.
- **Merge**: Combine data from multiple branches.
- **Code**: Add custom JavaScript for advanced logic.
- **Wait**: Pause workflow execution for a defined duration.

## Running N8N locally with Ngrok

1. Download the n8n official image running the command `docker pull n8nio/n8n`
2. Wait for the download, and after it, click on "Run" for run the image.
3. Configure your Ngrok credentials and run the command `ngrok http 5678` to create a Ngrok tunnel for 5678 port.
4. Provide your optional setting informing your container name, port (5678), volume path mirroring and environment variables for your image (if you are using webhook urls, add this environment variable too). Example:
![alt text](imgs/image.png)
1. Click on "Run" to start the image and wait for the container starts.
2. The n8n application will be available at your generated Ngrok URL.
3. Register and authenticate on the application.

## Running N8N locally with Ngrok and definitive domain

This tutorial is useful for keep using the same Ngrok domain instead needing configuring it again every time the container restarts or the temporary domain expires.

1. Clone this [repository](https://github.com/Joffcom/n8n-ngrok).
2. Edit .env file to use your Ngrok domain and your Ngrok Auth token.
3. Edit the ngrok.yml file passing your Ngrok's domain.
4. Run docker-compose up to start the container.
5. Use the application normally.

## Listening to webhooks using Tally forms
1. Check if the container image was created supplying a environment variable for WEBHOOK_URL.
2. Create a new Webhook node (not Respond to Webhook node), select the method POST because we are listening a form submission that is performed using POST method, and copy the Test URL.
3. Register and authenticate on [Tally](https://tally.so/dashboard). At dashboard, click on "New form", then "Use a template", select a template, click on "Use template", and click on "Publish".
4. Click on "Integrations", "Webhooks", click on "Connect", and provide your Test URL generated by your n8n Webhook node, and click on "Connect".
5. On n8n Webhook node click on "Listen for test event".
6. Fill the Tally form an the response will be returned at n8n.

## Configuring Nodes that depends on Google authentication and authorization
1. Access your GCP account.
2. Create a new project and select it.
3. Click on "Services and APIs", click on "Library".
4. Search for the API you want to integrate, eg. "Google Sheets", "Gmail" and so on.
5. Select the desired API and enable it.
6. Configure the Consent Screen.
7. Click on "Credentials", click on "Create", and select "Create OAuth client ID".
8. Select a Application type (generally web), provide a name, add an authorized redirect URI (should contain the HTTPS protocol), and click on "Create".
9. Copy the client id and client secret and download the generated JSON file.
10. Click on the new credential created and click on "Data access", "Add or remove scopes", and enable all scopes and the scope you want to work with, eg. "Google Sheets", "Gmail" and so on.
11. Click on "Audience" and click on "Publish".
12. On n8n, on the node that depends on Google, click on "Select credential", click on "Create new credential", and provide the client id and client secret generated.
13. Execute your service. 

## Configuring Nodes that depends on Redis
1. Create a Redis node.
2. Create a database, a role, and an user providing a name and password for this.
3. Associate this new user into a role with full access scope.
4. On N8N node select "Create new credential".
5. Inform the user, password, host for your database and port. 

## Using Templates
1. Access the left menu and click on "Templates" you'll be redirected to n8n templates website.
2. Choose a template and click on "Use for free".
3. Provide the required credentials. It can very based on the services the template requires, like access to Google Calendar, OpenAI, Google Sheets and so on (you can skip it to be configured later).  

## Using Community nodes
1. Click on your avatar image at bottom at left panel.
2. Click on "Settings", "Community Nodes", and type the name of the community node to install, example: "n8n-nodes-evolution-api" and click on install.

## Working with MCP

MCP is  and it's used to simplify a nodes chain where few nodes executes complex jobs that would be required more nodes and grant the flow keeps working even if third APIs changes if this node was built using MCP protocol. 
**MCP Client**: Is node trigger that can be used to call a MCP server.
**MCP Server**: Is a third node trigger that is used to call the necessaries nodes to execute a set of actions.

### Creating and using a MCP
1. Create your MCP server node adding the tools/nodes you want to work.
2. On the project you want to use it, create a new MCP Client node informing your MCP Server URL to connect to it.

## Calling workflows from external applications.

1. Create the workflow configuring the first node with Webhook Trigger Node and configured to responde as "Using response to Webhook Node".
2. Finishis the workflow creation using the node "Respond to Webhook".
3. Call it on your application. Example:
```typescript
  const callWebhook = async () => {
    try {
      const url =
        "https://steelless-shortsightedly-zaiden.ngrok-free.dev/webhook-test/703c8e04-c3e4-4282-92da-e6d11c0ec3ee";
      const response = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ message: "Hello from the homepage!" }),
      });
      const data: WebhookPayload = await response.json();
      console.log(data);
    } catch (error) {
      console.error("Error calling webhook:", error);
    }
  };
``` 

## PRD and BRD

RD (Product Requirements Document) or BRD (Business Requirement Document)D  are a techinical document used to define the flow scope based on the product or business.
In this example we'll use a car agency PRD.

### Objective
Automate WhatsApp conversations to qualify leads and respond instantly.

### Inputs
- Incoming WhatsApp message (Evolution API)

### Business Rules
- If user asks about price → fetch from database
- If user greets → respond friendly + ask intent
- Maintain conversation memory per user

### Integrations
- Evolution API
- Google Sheets (lead storage)
- OpenAI (response generation)

### Output
- Send contextual response via WhatsApp
- Save/update lead data

### Flow Summary
Webhook → Identify user → Load memory → Generate response → Send reply → Save interaction 

# General tips
- Prefer configuring n8n with Docker and Ngrok using [this repository](https://github.com/Joffcom/n8n-ngrok) because it configures a permanent Ngrok domain persisting the url without resetting it every time the container stops.
- Configure your URL including the protocol because it avoids conflicts and mismatching between the URL server and URL authorized on services like Google.
- At working with forms using webhooks, the form id and webhook path must be exactly the same otherwise the communication wont be succeeded. 
- You should enable each Google API/Service that you need to work with separately and add scopes for it.  
- Do not create an Ai agent with too many responsibilities (too many connected tools), prefer creating separated agents and make them communicate between themselves.
- At working on different projects, keep the each project linked to a separated Google project. Do not mix up projects.
- Avoid using gpt4 mini model for small tasks, prefer using gpt4-o.
- At working witch tools linked to an AI Agent, the ability to enable the correct tool will depend on how strong and well formed your prompt is. Having too many tools does not means all these tools will be executed, but are possible to be executed according to your prompt.
- Use PineCode to store data on vector database when RAG is needed. RAG will be needed when it's necessary to add an external/private context (like a database containing business data) to the AI model instead relying only on the global training database.
- Always configure the correct dimension of an index at working with an index database.
- If some recourse is not being listed, check if the credentials for that resource was provided.
- At working with workflows that uses webhooks and you want to put it on production, use the production URL on the webhook service and activate your flow, otherwise it won't work.
- Work with third nodes that were built using MCP protocol always as possible cause it grants the flow continues working if something changes on third APIs.
- At launching your automation to production when it's hosted in some VPS, pay attention on the webhooks production URL, it must very similar for test (with 'test' string) and production (without 'test' string) environments.
- At working with chats, use the Sentiment Analysis node to feel if your client is speaking in a positive, neutral or negative tone.
- Do not feed a vectorial database with table data.
- Pay attention to not connect nodes incorrectly otherwise the flow won't work as expected.
- At working with nodes locally that depends third containers, like Evolution API for example, you should always connect to it through host.docker.internal instead localhost.
- In test development a workflow only executes once. To execute your workflow several times you need to use production URLs and activate the workflow (it can be executed just with Docker container running, no necessary maintain the aplication running in the browser.).
- At working with file uploads, the file to upload value input should be "data" or the same name as the BLOB file.
- Never use a personal Whatsapp number to test n8n workflows, since it will trigger on every real message.
- Do not activate configs on EvolutionAPI dashboard you are not sure, since it can alter the correct flow functionality.
- Build each agent with a single responsability and conect them for solve more complex automations.
- Awalys include a path for each webhook link to easily identify it at calling it.
- Use `Filter` node instead of `If` node if you have not a false condition or decision.
- Always only starts creating an automation flow after understanding the business process through a solid PRD (Product Requirements Document) or BRD (Business Requirement Document).
- Never install an isolated n8n, or another application directly in a VPS, install the Ubuntu SO, and so install the applications you need.
- At debugging errors on EvolutionAPI, do not trust in the UI, check the container logs.
- Do not use Ngrok with Evolution API for production applications because it can invalidate session in some time. If it happens, you need to recreate the EvolutionAPI container and create, connect, and configure a new instance.
- Always install the needed community nodes before creating or importing a template to avoid conflicts.
- At working with some workflow linked to some credential, add the env in the .env file of the n8n image and create a Code node to read it instead using it directly in the workflow.
- Add a dedicated env car on the EvolutionAPI image containing its EvolutionAPI API Key to allow requests only from Evolution (avoid attacks from clients liks Postman or Insomnia)
- Always add human attendence node on all attendence overflow. 
- Use .first() instead of .item() at reading previous output data if there are IF, Merge, Redis, or another node that can changes the flow in your flow.
- Enable MESSAGE_UPSERT event on EvolutionAPI dashboard, ottherwise you will not able to see the executions on N8N and always create a filter to bypass event.message_upsert if fromMe is true.
- Use safe data reading using Optional Chaining Operator (?) at reading possible undefined data from previous nodes.
- Always use memory tied to user number and calculator on AI agent tools to a more dinamic and natural conversation.
- On finishing your workflow with RespondToWebhook node, your Webhook first node trigger must be configured to 'Using response to Webhook Node'.
- Use Redis keys to communicate between flows. Example: On a payment flow, you can store the orderId with status "pending", and so when the second flow is called, you can call the second workflow and when the webhook is called, it automaticallys updates the data on Redis.
- Always create a mind map before start creating the automations. It will help to not loose the logic.

### Human attendence flow

Client send message to the flow (owner number) => Consult Redis if there is some key block living for 4 hours for the client number => If positive, do nothing (to allow human attendence), if negative execute flow normally
Owner send message to the flow responding a client => Register on Redis a key to block the client number for 4 hours => Then owner and client can have a normal conversation out the flow