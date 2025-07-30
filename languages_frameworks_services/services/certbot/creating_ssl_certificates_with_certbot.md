# Creating SSL Certificates with Certbot

Certbot is a free and open-source tool for automatically using Let's Encrypt certificates on manually-administrated websites to enable HTTPS.

---

## Step-by-Step Instructions

### 1. Access Certbot Instructions

Visit the official Certbot site and select your web server and OS:  
`https://certbot.eff.org/instructions?ws=nginx&os=ubuntufocal`

---

### 2. Install Snap Core

Run the following commands:

`sudo snap install core`  
`sudo snap refresh core`

---

### 3. Install Certbot

Install Certbot and create a symlink:

`sudo snap install --classic certbot`  
`sudo ln -s /snap/bin/certbot /usr/bin/certbot`

---

### 4. Generate SSL Certificate

Run the Certbot command for NGINX:

`sudo certbot --nginx`

Then:

- Enter your email  
- Accept the terms by typing `Y`  
- Enter your domain (including subdomains if applicable)  
- Press `Enter` to let Certbot handle the rest

---

### 5. Restart NGINX and Verify

Restart your web server:

`sudo service nginx restart`

Then verify your domain in the browser to confirm SSL is working (you should see `https://`).