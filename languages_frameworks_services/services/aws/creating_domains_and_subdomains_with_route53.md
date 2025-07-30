# Creating and Configuring Domains and Subdomains on AWS Route 53

## Step-by-step Instructions

1. **Create Hosted Zone**
    - Go to the AWS Console and search for **"Route 53"**.
    - Click on **"Create hosted zone"**.
    - Enter your existing domain name (e.g., `pablosilvadev.com.br`).
    - Select **"Public hosted zone"**.
    - Click **"Create hosted zone"**.

---

2. **Create Subdomain Record**
    - Inside your hosted zone, click on the zone record.
    - Click **"Create Record"**.
    - For **Name**, type your desired subdomain (e.g., `api.pablosilvadev.com.br`).
    - For **Value**, enter the **Public IPv4 address** of your EC2 instance.
    - Click **"Create record"**.

---

3. **Configure Domain DNS (e.g., Registro.br)**
    - Log in to the registrar where your domain is registered (e.g., RegistroBr).
    - Look for the **DNS settings** or **Configure DNS**.
    - Add a **new record** with the following details:
        - **Type**: A (Alias)
        - **Name**: Your subdomain name (e.g., `api`)
        - **Value**: Public IPv4 of the EC2 instance
    - Save the record.

---

4. **Verify DNS Propagation**
    - Use the tool [https://www.whatsmydns.net/](https://www.whatsmydns.net/) to confirm that your domain or subdomain points to the correct IP.

---

## Notes

- The process is the same whether you're pointing a domain or a subdomain.
- DNS changes may take a few minutes to propagate globally.
