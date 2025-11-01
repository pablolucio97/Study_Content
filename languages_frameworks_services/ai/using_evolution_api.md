# Using Evolution API

The Evolution API is an alternative to default n8n chat interface. It's more friendly and has connection to Whatsapp.

## Using the Evolution API

1. Clone [this repository](https://github.com/pablolucio97/evolution-api-container).
2. Generate a 32 characters authentication key (Encryption key 256) using the [ACTE website](https://acte.ltd/utils/randomkeygen).
3. Paste the generated authentication key as the value for the AUTHENTICATION_API_KEY variable on .env file.
4. Run the command `docker-compose up` to start the application.
5. Access the application on http://localhost:8081/manager address.
6. Paste your authentication key when prompted.
7. Click on "New instance" to create a new instance, and provide your name, channel(choose baileys because it's free), and your phone number and lick on "Save".
8. After the instance was created, click on "Get QR Code", read it using your phone to sync your Whatsapp data. 
9. On n8n, install the `n8n-nodes-evolution-api` community node.

   