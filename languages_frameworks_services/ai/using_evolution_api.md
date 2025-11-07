# Using Evolution API

The Evolution API is an alternative to default n8n chat interface. It's more friendly and has connection to Whatsapp.

## Using the Evolution API

1. Clone [this repository](https://github.com/pablolucio97/evolution-api-container).
2. Generate a 32 characters authentication key (Encryption key 256) using the [ACTE website](https://acte.ltd/utils/randomkeygen).
3. Paste the generated authentication key as the value for the AUTHENTICATION_API_KEY variable on .env file.
4. Run the command `docker-compose up` to start the application.
5. Access the application on http://localhost:8081/manager address.
6. Paste your authentication key when prompted. If not prompted, clear the localhost.
7. Click on "New instance" to create a new instance, and provide your name, channel(choose baileys because it's free), and your phone number and lick on "Save".
8. After the instance was created, click on "Get QR Code", read it using your phone to sync your Whatsapp data. 
9. On n8n, install the `n8n-nodes-evolution-api` community node.

## Comparison table between Official Meta API and Unofficial APIs like Evolution API

| **Item**              | **Official API**                   | **Unofficial API**                              |
|-----------------------|------------------------------------|-------------------------------------------------|
| **Provider**          | Meta (WhatsApp)                    | Unauthorized developers / 3rd-party tools      |
| **Reliability**       | High                               | Variable                                        |
| **Security**          | High (end-to-end, licensed)         | Not end-to-end encrypted — risk of leaks        |
| **Costs**             | Paid (per session / conversation)  | Low or free                                     |
| **Ban Risk**          | None if you follow policies        | High if you spam or violate rules               |
| **Support**           | Official support from Meta         | Community / limited vendor support              |
| **Flexibility**       | Limited by Meta policies & templates| Very flexible (but risky)                      |

## When to choose which
- **Use the Official API when:**
  - You handle **sensitive personal data** (CPF, RG, credit card, health info).
  - You require **legal/compliance guarantees** (LGPD / data protection).
  - You need stable production support and minimal infra maintenance.
- **Consider Unofficial APIs when:**
  - You need quick experimentation, low cost or extreme customization.
  - The data is non-sensitive and you accept higher operational risk.
  - You will host on your own infra and can tolerate potential blocks.
   