
# Creating and Accessing EC2 Instances

## Creating EC2 Instance

1. Log in your AWS console, search for EC2, click on "New Instance", and configure your instance settings (Ubuntu 20.64 image is a good choice).

2. Click on "Launch instance". If you have not created a key pair, you must create one by providing a name, then click "Create key pair" and save the `.pem` file.

3. Click on your created instance and then click "Connect".

4. Download and install **Putty Key Generator**, click on "Load", select your `.pem` file, choose "All Files" to see `.pem` files. Click "Save private key", give it a name and store safely.

5. Download and install **Putty**, paste your instance public IPV4 DNS into the "Host Name" field. Under "SSH" tab, select SSH protocol version 2.

6. In "SSH" on the sidebar, click "+", go to "Auth", click "Browse", select the `.ppk` private key generated earlier and click "Open".

---

## Accessing EC2 on Linux with Docker

### Linux Process

1. Log in to AWS Console, create a new instance, save `.pem` key safely.

2. [Download Putty and Puttygen](https://www.chiark.greenend.org.uk/~sgtatham/putty/latest.html)

3. Open **Puttygen**, click "Load", select `.pem` key (choose All Files), click "Open", then "Save private key".

4. Open **Putty**, go to "Connection" → "SSH", browse for `.ppk` file. Click "Open".

5. Under "Session", paste your instance public IPv4 in the "Host Name" field and click "Open".

6. Enter your username, usually `ubuntu` for Ubuntu.

7. Run `sudo apt update`, install Node.js and NPM:
   - From [NodeSource GitHub](https://github.com/nodesource/distributions)
   - `sudo apt install npm`
   - Check: `node -v`, `npm -v`

8. Install Docker and Docker Compose:
   - [Docker Engine Ubuntu](https://docs.docker.com/engine/install/ubuntu/)
   - [Docker Compose Linux](https://docs.docker.com/compose/install/linux/)
   - Check: `docker -v`, `docker compose version`

9. In `package.json`:
``"build": "tsc"``

In `tsconfig.json`:
``"outDir": "./dist"``

Run: ``yarn build``

10. Push changes to GitHub. On server, generate SSH key with:
``ssh-keygen`` → ``cat ~/.ssh/id_rsa.pub`` → Add to GitHub SSH keys.

11. On server:
``mkdir your_folder`` → ``cd your_folder`` → ``git clone git@github.com:your_repo`` → ``cd repo`` → ``npm i``

12. Rename `.env.example` to `.env` with:
``cp .env.example .env`` → edit with ``vim .env``

Repeat for `ormconfig.json` (ensure paths point to `dist`).

13. Run:
``docker-compose up``

> To run TypeORM migrations:  
``./node_modules/.bin/typeorm migration:run``

---

## Alternative Flow

1. Run:
``ssh-keygen -t rsa`` → ``cat ~/.ssh/id_rsa.pub``

Add this key on GitHub under Settings > SSH and GPG Keys.

2. On server:
``git clone git@github.com:your_repo`` → ``cd repo`` → ``npm install``

3. Set environment variables:
``export PROD_URL=https://your-prod-url.com``

4. Start server:
``node dist/server.js``

5. Access app at:
``http://<your-public-ip>:<port>``

Example:
``http://3.84.224.168:3333/``

## General Tips

- Shutting an instance down can be trick, you need be sure you selected the correct region to see if the instance is alive.

