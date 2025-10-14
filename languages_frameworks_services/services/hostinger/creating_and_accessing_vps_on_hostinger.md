# Hostinger

## Overview

[Hostinger](https://www.hostinger.com/) is a global web hosting provider known for its affordability, reliability, and user-friendly interface. It offers several hosting and cloud services for developers, businesses, and startups.

### Most Common Services Provided by Hostinger

- **Shared Hosting** – Best for beginners and small websites.
- **VPS Hosting (Virtual Private Server)** – Offers full control over server configuration and resources.
- **Cloud Hosting** – High performance with scalability and managed infrastructure.
- **WordPress Hosting** – Optimized environment for WordPress websites.
- **Email Hosting** – Professional email addresses for your domain.
- **Domain Registration** – Buy and manage domains directly on the platform.
- **Website Builder** – Drag-and-drop site builder with templates and AI tools.
- **Minecraft Server Hosting** – Specialized game server plans for hosting Minecraft worlds.

---

## Purchasing and configuring a VPS on Hostinger

1. Purchase your vps at [this link](https://www.hostinger.com/br/servidor-vps?utm_campaign=Brand-Phrase|NT:Se|LO:BR&utm_medium=ppc&gad_source=1&gad_campaignid=19474423173&gclid=Cj0KCQjwl5jHBhDHARIsAB0YqjwnJDaX9MBZRYvRD-bL0iwK_yQ3tcdkq27LQb-o8nI-ev6Kq6RmFcMaArDtEALw_wcB#pricing).
2. After the payment has been approved, inform your data like location, and create a new server for Ubuntu, and select Ubuntu 24.04 LTS version. 
3. Inform your password and create your SSH Key following the provided instructions and click on "Continuar".
4. Copy and save your SSH Key for future access.


## Accessing your Hostinger host machine on Mac
1. Download and install [CoreSheel](https://apps.apple.com/us/app/core-shell/id1354319581?ls=1&mt=12).
2. Create a new connection passing the user root, the machine ip and always pointing to 22 port (default port).
3. If prompted, "Are your sure you want to continue connecting" type "Yes".
4. Inform your password and wait for the connection.

## Installing and managing tools using Orion

Orion is a tool manager for terminals that allows installing and configuring useful tools like Portainer, Traefik and similar just typing it's code and providing the necessary data.

1. Access your host.
2. Install the Orion running the command `bash <(curl -sSL setup.oriondesign.art.br)`.
3. Select the option keep the local version currently installed if a screen pops up about file modification.


## Configuring Traefik using Orion (should be done only after pointing subdomains on Cloudflare)
1. On the host VPS terminal, run the command `bash <(curl -sSL setup.oriondesign.art.br)` to install/start Orion tool
2. On the installation menu, chose the Traefik option.
3. Type the user (admin is the default).
4. Provide a password, same for Portainer, internal network and server.
5. Inform a valid contact email.
6. Confirm all data and wait for the installation. Pay close attention to each informed data, otherwise it will fail. Run the command `docker swarm leave --force` if necessary to reset the Swarm container.
7. If everything get right, you can access your Portainer service at your domain,e.g. "https://portainer.yourdomain.com.br/#!/home"

## Configuring N8N on Hostinger VPS Using Orion
1. Add a records for n8n and another for webhook on your domain registered on Cloudflare.
2. With an authenticated Google account, enable 2 factors authentication.
3. Search for "App Password", click on it and create.
4. Provide a name for the app, copy and save the generated Google's password.
5. On the host VPS Terminal, run the command `bash <(curl -sSL setup.oriondesign.art.br)` to start a new session using Orion tool.
6. Select the N8N option.
7. Inform the n8n domain, webhook domain.
8. Provide the same email use to generate the Google's password for email/user SMTP (both steps).
9. Inform the generate Google's password. Inform `smpt.gmail.com.br` as host and 465 as port if you're using a Gmail account.
10. If everything get right, you can access your n8n service at your domain,e.g. "https://n8n.yourdomain.com.br/#!/home"

## Configuring Evolution API on Hostinger VPS Using Orion
1. Add a records for n8n and another for Evolution api on your domain registered on Cloudflare.
2. On the host VPS Terminal, run the command `bash <(curl -sSL setup.oriondesign.art.br)` to start a new session using Orion tool.
3. Select the Evolution option.
4. Inform the evolution api domain.
5.  If everything get right, Orion tool will provide your evolutionapi url and a global key.
6.  Save your global api key.
7.  You can access your EvolutionApi informing your API Key at your domain,e.g. "https://evolutionapi.yourdomain/manager/"
8.  Create a new Evolution API instance informing a name, selecting "Balleys" as channes and your phone number.
9.  Click on the created instance, click on the settings icon and scan the QR Code to connect your phone with Evolution API.
