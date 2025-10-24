
# Configuring and Using Resend to send email on NodeJS  applications.

This guide explains how to correctly configure **Resend** to send transactional emails from your own domain — including all important details that caused issues during real-world setup.

---

### 1 — Create a Resend Account and API Key

1. Go to [https://resend.com](https://resend.com) and create an account.
2. In the **API Keys** tab, create a new key (example name: `treinahub`).
3. Give it **Full Access** permission.
4. Copy the token (it starts with `re_...`) and save it in your environment variables.

```env
RESEND_EMAIL_SENDER_API_KEY="re_YourGeneratedKey"
```

---

### 2 — Verify Your Domain

1. Navigate to **Domains** → click **Add Domain** → enter your domain, e.g. `treinahub.com.br`.
2. Resend will show **three DNS records** (TXT + MX + DKIM) that must be added in Cloudflare.
3. In Cloudflare DNS:
   - Add all Resend-provided records exactly as shown.
   - Wait until status in Resend becomes ✅ **Verified**.
4. Do not proxy these records — keep the **gray cloud (DNS only)** active.

---

### 3 — Configure Cloudflare Email Routing (Mailbox)

Resend authenticates your sender but doesn’t provide inbox hosting. You must create a real mailbox or forwarding route.

**Simplest option: Cloudflare Email Routing**

1. Go to Cloudflare → **Email Routing** → **Set up Routing**.
2. Create:
   - Address: `contato@treinahub.com.br`
   - Destination: your real email (e.g. `pscodecontato@gmail.com`).
3. Cloudflare will suggest MX records like:

```
MX  treinahub.com.br  route1.mx.cloudflare.net  Priority 10
MX  treinahub.com.br  route2.mx.cloudflare.net  Priority 20
```

4. Add them in DNS (delete any conflicting Resend MX records like `send.feedback-smtp...`).
5. Wait a few minutes for propagation.

Now `contato@treinahub.com.br` exists and forwards to your Gmail.

---

### 4 — Update Your App Environment Variables

Use your new sender address:

```env
RESEND_EMAIL_SENDER_ADDRESS="TreinaHub <contato@treinahub.com.br>"
RESEND_EMAIL_SENDER_API_KEY="re_YourResendKey"
```

❗️Don’t include extra quotes if configuring through Portainer or Docker.

---

### 5 Create an util function to format the email to be displayed correctly by email providers like Gmail and Outlook:

```typescript
export function buildEmailHtml({
  title,
  paragraphs,
  signatureDataUrl,
  companyName = "PSCode",
  companyUrl = "https://www.pscode.com.br",
  companyLinkText = "Visite nosso site",
}: {
  title: string;
  paragraphs: string[];
  signatureDataUrl?: string | null;
  companyName?: string;
  companyUrl?: string;
  companyLinkText?: string;
}) {
  const body = paragraphs
    .map(
      (p) =>
        `<p style="margin:0 0 12px 0; line-height:1.6; font-size:16px; color:#111827;">${p}</p>`
    )
    .join("");

  // Signature image row (centered)
  const signatureImgRow = signatureDataUrl
    ? `
      <tr>
        <td align="center" style="padding:8px 24px 0 24px;">
          <img src="${signatureDataUrl}"
               alt="Assinatura"
               width="320"
               style="display:block; width:320px; max-width:100%; height:auto; border:0; outline:none; text-decoration:none;" />
        </td>
      </tr>`
    : "";

  // Company info row (below the image)
  const companyInfoRow = signatureDataUrl
    ? `
      <tr>
        <td align="center" style="padding:8px 24px 16px 24px; font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;">
          <div style="font-size:12px; line-height:1.5; color:#6b7280;">
            <span>Essa solução foi desenvolvida por <strong style="color:#111827;">${companyName}</strong></span>
            &nbsp;•&nbsp;
            <a href="${companyUrl}"
               style="font-size:12px; color:#3b82f6; text-decoration:none;">${companyLinkText}</a>
          </div>
        </td>
      </tr>`
    : "";

  return `
  <!doctype html>
  <html>
  <body style="margin:0; padding:0; background:#f3f4f6;">
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#f3f4f6; padding:24px 0;">
      <tr>
        <td align="center">
          <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" style="width:600px; max-width:100%; background:#ffffff; border-radius:8px;">
            <tr>
              <td style="padding:24px 24px 8px 24px; font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;">
                <h1 style="margin:0 0 8px 0; font-size:20px; line-height:1.3; color:#111827; font-weight:700;">${title}</h1>
              </td>
            </tr>

            <tr>
              <td style="padding:0 24px 8px 24px; font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;">
                ${body}
              </td>
            </tr>

            ${signatureImgRow}
            ${companyInfoRow}

            <tr>
              <td style="padding:16px 24px 24px 24px; font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif; color:#6b7280; font-size:12px; line-height:1.5;">
                <p style="margin:0;">Este é um e-mail automático. Por favor, não responda.</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
  </html>`;
}
```

### 6 Install the resend for Node JS using the command `npm i resend`

### 7 Import the Resend and use it on your email service. Example:

```typescript
import { buildEmailHtml } from "@/utils/formatTableEmail";
import { Injectable } from "@nestjs/common";
import { ConfigService } from "@nestjs/config";
import { TEnvSchema } from "env";
import { Resend } from "resend";
interface IRecoveryPasswordEmail {
  to: string;
  from: string;
  recoveryCode: string;
}

interface IGetCompanyIdEmail {
  to: string;
  companyIdCode: string;
}

@Injectable()
export class ResendEmailSenderService {
  private resendApiKey: string;
  private senderEmailAddress: string;
  private signatureImageUrl =
    "https://i.ibb.co/HfRg8bGk/Logo-Text-Container.png";
  constructor(private configService: ConfigService<TEnvSchema, true>) {
    this.resendApiKey = this.configService.get("RESEND_EMAIL_SENDER_API_KEY");
    this.senderEmailAddress = this.configService.get(
      "RESEND_EMAIL_SENDER_ADDRESS"
    );
  }

  async sendCompanyIdEmail(data: IGetCompanyIdEmail) {
    const resendEmailSender = new Resend(this.resendApiKey);

    const htmlContent = buildEmailHtml({
      title: "Código de identificador da empresa",
      paragraphs: [
        `Seu código de identificador da empresa é <strong>${data.companyIdCode}</strong>.`,
        `É necessário informar esse código para cadastrar um novo usuário na empresa. Apenas compartilhe esse código com pessoas autorizadas, pois ele habilita o registro de novos usuários.`,
        `Você está recebendo este email porque você fez um novo cadastro na nossa plataforma.`,
        `Caso você não tenha solicitado, ignore e apague este email.`,
      ],
      signatureDataUrl: this.signatureImageUrl,
    });

    try {
      await resendEmailSender.emails.send({
        to: data.to,
        from: this.senderEmailAddress,
        subject: "Código de identificador da empresa",
        html: htmlContent,
      });
      console.log(`Company ID email sent to ${data.to}`);
    } catch (error) {
      console.error(`Error at trying to send email: ${error}`);
    }
  }

  async sendRecoveryPasswordEmail(data: IRecoveryPasswordEmail) {
    const resendEmailSender = new Resend(this.resendApiKey);

    const htmlContent = buildEmailHtml({
      title: "Código de recuperação de senha",
      paragraphs: [
        `Seu código de recuperação de senha é <strong>${data.recoveryCode}</strong>.`,
        `Você está recebendo este email porque solicitou a redefinição de sua senha.`,
        `Caso não tenha solicitado, ignore e apague este email.`,
      ],
      signatureDataUrl: this.signatureImageUrl,
    });

    try {
      await resendEmailSender.emails.send({
        to: data.to,
        from: this.senderEmailAddress,
        subject: "Código de recuperação de senha",
        html: htmlContent,
      });
      console.log(`Recovery password email sent to ${data.to}`);
    } catch (error) {
      console.error(`Error at trying to send email: ${error}`);
    }
  }
}
```


## ✅ Example Final Config

**Sender:** `TreinaHub <contato@treinahub.com.br>`  
**Domain:** `treinahub.com.br` (verified in Resend)  
**Forwarding:** Cloudflare → `pscodecontato@gmail.com`  
**Logs:** Status = Delivered (200)

## Common isssues

| Problem | Root Cause | Fix |
|----------|-------------|-----|
| Email not delivered (but logged as sent) | Domain not verified or DKIM invalid | Check domain in Resend → Status must be **Verified** |
| Email sent but not arriving | Sender mailbox doesn’t exist | Create forwarding in Cloudflare Email Routing |
| Works locally but not in production | Env vars missing in VPS | Check `.env.production` and `.env.swarm` |
| Email bounced from Hotmail | Resend suppressed address after previous failure | Go to **Suppressions → Remove from list** |
| Gmail sends to Spam | New domain reputation | Send multiple legitimate test emails to train the filter |


## General tips

- Keep sender domain and app domain the same (e.g. both under `treinahub.com.br`).
- Always use your verified domain in `from:`.
- Do not reuse old bounced emails.
- Avoid capital letters or accents in email usernames.
- Use a clear HTML structure — inline styles only to avoid be broken displayed by Gmail and Outlook.

