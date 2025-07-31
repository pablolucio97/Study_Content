
# Sending Emails in Production with SES and Nodemailer

The advantage of using AWS Simple Email Service is that this service sends all emails in a single request, reducing the risk of being marked as spam. You will need to have a domain to use AWS SES.

## 1. Register Domain and Set Up Email

Have a registered domain (e.g., from Registro.br). Create an account on Zoho (you can use your Google account), search for Email, and get started. Link your Gmail account.

## 2. Enable SES Permissions

In the AWS console, search for "IAM" and enable all SES permissions for your user.

## 3. Create Domain and Email Identities

Search for "SES" in AWS, switch region to `sa-east-1 (São Paulo)`, click "Create Identity", and create both a domain identity and an email identity. This process can take up to 48h.

## 4. Download TXT Files

Download the legacy TXT `.csv` files for both the email and domain.

## 5. Configure DNS

Log into where you bought your domain (e.g., Registro.br), search for "DNS", go to the configuration, paste the TXT name and value in the correct fields, set the type as `TXT`, and click "Add".

## 6. Implement SES Mail Provider

Create the file `SESMailProvider.ts`:

```ts
import { injectable } from 'tsyringe';
import { IMailProvider } from '../IMailProvider';
import nodemailer, { Transporter } from 'nodemailer';
import handlebars from 'handlebars';
import fs from 'fs';
import aws from 'aws-sdk';

@injectable()
class SESMailProvider implements IMailProvider {
    private client: Transporter;

    constructor() {
      this.client = nodemailer.createTransport({
        SES: new aws.SES({
            apiVersion: '2010-12-01',
            region: process.env.AWS_REGION
        })
      });
    }

    async sendMail(to: string, subject: string, variables: any, templatePath: string): Promise<void> {
        const templateFileContent = fs.readFileSync(templatePath, 'utf8');
        const templateParse = handlebars.compile(templateFileContent);
        const templateHTML  = templateParse(variables);

         await this.client.sendMail({
            to,
            from: 'Rentx <pablojmde@gmail.com>',
            subject,
            html: templateHTML
        });
    }
}

export { SESMailProvider };
```

## 7. Register Mail Provider

```ts
import { container } from 'tsyringe';
import { SESMailProvider } from './MailProvider/implementations/SESMailProvider';

container.registerInstance<IMailProvider>(
    "SESMailProvider",
    new SESMailProvider()
);
```

## 8. Configure Email Template

Create the file `email.hbs` inside `modules/views/emails`:

```html
<!DOCTYPE html>
<html>
  <head>
    <style>
      .container {
        width: 800px;
        font-family: Arial, Helvetica, sans-serif;
      }
      span {
        margin: 10px 0;
        display: block;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <img src="https://i.imgur.com/oUAKMC5.png"/>
      <span>Oi, {{name}}</span>
      <br/>
      <span>Você solicitou alteração de senha.</span>
      <span>Para realizar a troca, clique no link 
        <a href={{link}}>{{link}}</a>
      </span>
      <span>Caso não tenha sido você quem solicitou a alteração da senha, 
        basta ignorar este e-mail.</span>
      <strong>Obrigado!</strong>
      <h3>Equipe | <strong>Rentx</strong></h3>
    </div>
  </body>
</html>
```

## 9. Authenticate and Test Email

Authenticate in your application and test the email sending process.
