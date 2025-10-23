## Handling production applications on VPSs

Managing applications on a VPS (Virtual Private Server) requires attention to configuration, security, and consistency. Follow these best practices to avoid common mistakes and keep your environment stable.

## Docker Swarm vs Docker Compose

| Feature | Docker Compose | Docker Swarm |
|----------|----------------|---------------|
| **Purpose** | Local development and small deployments | Scalable, production-ready orchestration |
| **File** | `docker-compose.yml` | `swarm-stack.yml` |
| **Scaling** | Manual (`docker compose up --scale`) | Built-in with load balancing |
| **Networking** | Simple bridge networks | Automatic overlay networks across nodes |
| **High Availability** | ❌ Not supported | ✅ Built-in redundancy and service recovery |
| **Load Balancing** | ❌ Manual setup | ✅ Automatic load balancing |
| **Deploy Command** | `docker compose up -d` | `docker stack deploy -c swarm-stack.yml <stack_name>` |

## Configuring NodeJS + PostgreSQL application on VPS using Docker Swarm and Traefik SSL
1. Install node v+20, docker-swarm postgresql, and traefik on the vps.
2. Initialize Docker Swarm and Network: 
```bash
docker swarm init
docker network create --driver overlay proxy
```
3. Provide a traefik.yaml file on root vps repository to handle reverse proxy to your service:
```yml
version: "3.8"

services:
  traefik:
    image: traefik:v3.1
    command:
      - "--providers.docker.swarmMode=true"
      - "--providers.docker.exposedbydefault=false"
      - "--entrypoints.web.address=:80"
      - "--entrypoints.websecure.address=:443"
      - "--certificatesresolvers.letsencryptresolver.acme.httpchallenge=true"
      - "--certificatesresolvers.letsencryptresolver.acme.httpchallenge.entrypoint=web"
      - "--certificatesresolvers.letsencryptresolver.acme.email=you@example.com"
      - "--certificatesresolvers.letsencryptresolver.acme.storage=/letsencrypt/acme.json"
      - "--api.dashboard=true"
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock:ro
      - /letsencrypt:/letsencrypt
    networks:
      - proxy
    deploy:
      placement:
        constraints: [node.role == manager]

networks:
  proxy:
    external: true

```
3. Run the command `docker stack deploy -c /root/traefik.yaml traefik` to start the traefik service.
4. Provide a Dockerfile that will be use to work together with Docker Swarm. Example:
```yml
   # ---------- build ----------
FROM node:20-bookworm-slim AS build
WORKDIR /app

RUN apt-get update && apt-get install -y python3 make g++ openssl ca-certificates && rm -rf /var/lib/apt/lists/*

COPY package*.json ./
RUN npm ci
COPY . .
RUN npx prisma generate
RUN npm run build

# ---------- runtime ----------
FROM node:20-bookworm-slim AS runtime
WORKDIR /app
ENV NODE_ENV=production PORT=3334

RUN apt-get update && apt-get install -y openssl ca-certificates && rm -rf /var/lib/apt/lists/*

COPY package*.json ./
RUN npm ci --omit=dev
COPY --from=build /app/dist ./dist
COPY --from=build /app/prisma ./prisma
COPY --from=build /app/node_modules/.prisma /app/node_modules/.prisma
COPY --from=build /app/node_modules/@prisma /app/node_modules/@prisma
COPY --from=build /app/node_modules/prisma /app/node_modules/prisma
COPY --from=build /app/node_modules/.bin/prisma /usr/local/bin/prisma

EXPOSE 3334
CMD ["node", "dist/main"]
```
4. Create a regular .env.swarm file to store your env vars on the ame service repository.
5. Create the stack file for up the stack service for your service. Example:
```yaml
version: "3.8"

networks:
  proxy:
    external: true
  internal:
    driver: overlay

services:
  postgres:
    image: postgres:16
    environment:
      POSTGRES_USER: admin
      POSTGRES_PASSWORD: password
      POSTGRES_DB: app_db
    volumes:
      - /var/lib/app/postgres:/var/lib/postgresql/data
    networks: [internal]
    deploy:
      restart_policy: { condition: on-failure }

  api:
    image: myapp-api:latest
    env_file:
      - .env.swarm
    environment:
      DATABASE_URL: postgresql://admin:password@postgres:5432/app_db?schema=public
    depends_on: [postgres]
    deploy:
      replicas: 1
      restart_policy: { condition: on-failure }
      labels:
        - traefik.enable=true
        - traefik.docker.network=proxy
        - traefik.http.routers.api.rule=Host(`api.example.com`)
        - traefik.http.routers.api.entrypoints=websecure
        - traefik.http.routers.api.tls.certresolver=letsencryptresolver
        - traefik.http.services.api.loadbalancer.server.port=3334
    networks: [proxy, internal]
   ```
6. Run the command `docker build -t myapp-api:latest .` to build your image and `docker stack deploy -c stack.yaml myapp` to up your service stack.
7. Run the command `docker run --rm \
  --network myapp_internal \
  --env-file .env.swarm \
  myapp-api:latest \
  npx prisma migrate deploy` to run your database migrations inside the network inside Swarm.
8. Run the commands `docker service ls
docker service ps myapp_api
docker service logs myapp_api -n 80 --raw` to check if your service is routed and correctly available.


## Accessing your database
Connect to your database using a GUI software like Beekeeper or DBeaver, make sure the referent database service for your application is available on the host (not only internal) network. Maybe it can be necessary map a new port to be available on host.

1. On Portainer dashboard, go to Services → your_service_db.
2. In the right “Quick navigation” panel click Network & published ports.
3. In Published ports click + port mapping and add:
Target port: 5432
Published port: 5432
Protocol: tcp
(If there’s a Publish mode dropdown, choose Host. If not shown, it will use the routing mesh, which is fine on a single VPS.)
4. Scroll up, click Update the service → confirm (Force update) so Swarm rolls the task.

## Making changes on your server
1. Edit your code **locally** (never inside a live container).
2. Rebuild the image:
   ```bash
   docker build -t myapp-api:latest .
   ```
3. Update the running service:
   ```bash
   docker service update --image myapp-api:latest --force myapp_api
   ```
4. If migrations or environment variables changed:
   - Update `.env.swarm`
   - Redeploy the stack:
     ```bash
     docker stack deploy -c stack.yaml myapp
     ```

⚠️ **Never edit containers directly** — changes will be lost after a redeploy.

## Mistakes to avoid

| **Problem** | **Root Cause** | **Fix** |
|--------------|----------------|----------|
| **Can't reach database server at `postgres:5432`** | Prisma ran from host instead of inside Docker network | Run migrations **inside the container**:<br>`docker run --network treinahub_internal ...` |
| **Invalid mount config** | Local folder permissions mismatch | Fix folder ownership:<br>`sudo chown -R 999:999 /var/lib/treinahub/postgres` |
| **Prisma engine error (debian-openssl-1.1.x)** | Image missing OpenSSL | Install OpenSSL in the **Dockerfile runtime stage** |
| **Environment variables not loaded** | `.env` not referenced or missing in Swarm stack | Use `env_file: .env.swarm` or explicitly define under `environment:` |
| **HTTP 404 from Traefik** | Traefik not started or wrong router rule | Ensure **Traefik stack** is up first and domain **DNS points** to your VPS IP |
| **Company does not exist error** | Database schema missing | Run inside container:<br>`npx prisma migrate deploy` |




## General tips
- Do not work with Docker Compose and Docker Swarm, pick just one configuration. If you decide working with Swarm (recommended for production environment) put your all services inside a swarm-stack.yml file to be configured by Swarm. Even if your VPS will be used only for server a single application, prefer using Docker Swarm.
- Do not use Ngnix with Traefik because they will conflict, pick one. Traefik is generally recommended because it automatically handles SSL certificates, routing, and load balancing for Docker services with minimal manual setup.
- Never expose your internal Docker services ports (ex: 5432 for Postgres, or 3334 for your application), always expose 22, 443, and 80 ports only. The other ports will be managed by Docker internally.
- You need to expose the 22 port otherwise you wont be able to connect to your VPS.
- Use SSH root and password to connect to your VPS and database. 
- Regularly check your containers and logs through the commands `docker ps -a`, or `docker logs <container_name>` or use the Portainer dashboard.
- Automate backups of your database and critical data to avoid loss during redeployments or VPS migrations.
- Avoid making manual changes inside a running container, such as installing a package or redefined a env var. Instead of it, update your code, Dockerfile, .env or configuration files, rebuild and redeploy the updated container (update the whole stack only if some network or related services configuration has changed).
- If you manage more than one application on the same VPS, **Docker Swarm + Traefik** is the most stable, secure, and scalable approach. Kubbernets also works, but is way more complex than using Docker Swarm, prefer using Docker Swarm.