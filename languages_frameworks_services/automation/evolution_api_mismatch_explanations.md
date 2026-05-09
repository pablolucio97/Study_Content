# Evolution API Configuration Guide

This guide explains the main concepts you need to understand so you do not keep suffering with Evolution API setup, routing, ports, SSL, and QR code generation.

---

# 1. The main mental model

There are **3 different layers** involved in your setup:

1. **Evolution API application**
2. **Docker/Swarm networking**
3. **Public access layer (direct port or Traefik + SSL)**

If these 3 layers are mixed up, the setup becomes confusing very quickly.

---

# 2. Evolution API listens internally first

Inside the container, Evolution API usually runs on:

```env
SERVER_PORT=8080
```

That means:

- the app itself is listening on port `8080` **inside the container**
- this does **not** automatically mean your browser should access `:8080`
- container internal port and browser public port are not necessarily the same thing

This was one of the main points of confusion.

---

# 3. Internal port is not the same as public port

There are 2 different kinds of ports:

## Internal container port

```env
SERVER_PORT=8080
```

This is the port used **inside the container**.

## Public VPS/browser port

```yaml
ports:
  - "8081:8080"
```

This means:

- browser/VPS public side = `8081`
- container internal side = `8080`

So:

- inside container: `8080`
- outside browser access: `8081`

---

# 4. Two valid architectures exist

You must choose **one** and configure it consistently.

## Option A — Direct port access

Example:

```text
http://your-domain-or-ip:8081
```

In this mode:

- Docker publishes a port like `8081`
- browser accesses that port directly
- usually no Traefik
- usually no HTTPS unless you build SSL separately

### Typical config

```yaml
ports:
  - "8081:8080"
```

```env
SERVER_URL=http://your-domain-or-ip:8081
SERVER_TYPE=http
SERVER_PORT=8080
```

### Browser access

```text
http://your-domain-or-ip:8081
```

## Option B — Reverse proxy with Traefik and SSL

Example:

```text
https://evolutionapi.plssistemas.com.br
```

In this mode:

- browser does **not** access `:8081`
- browser goes to domain on standard ports `80/443`
- Traefik receives the request
- Traefik handles SSL certificate
- Traefik forwards internally to Evolution on port `8080`

### Typical config

No public `ports:` needed on Evolution service.

```env
SERVER_URL=https://evolutionapi.plssistemas.com.br
SERVER_TYPE=http
SERVER_PORT=8080
```

Traefik labels must forward to:

```yaml
traefik.http.services.evolutionapi.loadbalancer.server.port=8080
```

### Browser access

```text
https://evolutionapi.plssistemas.com.br/manager
```

---

# 5. The mistake that caused repeated confusion

You were mixing both architectures at the same time.

Example of wrong thinking:

- wanting browser access through `https://evolutionapi.plssistemas.com.br`
- but configuring Evolution as if it should be accessed directly on `:8081`
- or using `SERVER_URL=https://domain.com` while removing the reverse proxy
- or expecting SSL to work without Traefik or another HTTPS termination layer

## Rule

If you use:

```text
https://domain.com
```

then you need:

- DNS correct
- Traefik or another reverse proxy
- certificate resolver
- ports `80` and `443` available
- Evolution reachable internally by Traefik

If you use:

```text
http://domain.com:8081
```

then you are doing direct exposure and should not expect the same reverse-proxy behavior.

---

# 6. What `SERVER_URL` really means

`SERVER_URL` must describe the **real public URL** by which the application is reached.

## Correct examples

### Direct port mode

```env
SERVER_URL=http://evolutionapi.plssistemas.com.br:8081
```

### Traefik + SSL mode

```env
SERVER_URL=https://evolutionapi.plssistemas.com.br
```

## Wrong examples

### Wrong if there is no SSL proxy

```env
SERVER_URL=https://evolutionapi.plssistemas.com.br
```

when the app is actually only exposed on `http://domain:8081`

### Wrong if browser access is through 443

```env
SERVER_URL=http://evolutionapi.plssistemas.com.br:8081
```

when you actually want `https://evolutionapi.plssistemas.com.br`

---

# 7. Why SSL was failing

SSL does not come from Evolution API itself in your setup.

SSL usually comes from **Traefik**.

That means:

- Evolution API can remain plain `http` internally
- Traefik receives `https`
- Traefik terminates TLS
- Traefik forwards request internally to Evolution on port `8080`

So this is normal:

```env
SERVER_TYPE=http
SERVER_PORT=8080
```

even when public browser access is:

```text
https://evolutionapi.plssistemas.com.br
```

Because HTTPS is handled by Traefik, not by Evolution directly.

---

# 8. What Traefik is doing

Traefik is the layer that:

- listens on public port `80`
- listens on public port `443`
- gets Let's Encrypt certificate
- routes requests by hostname
- forwards traffic to the correct Docker service

So for this URL:

```text
https://evolutionapi.plssistemas.com.br
```

Traefik looks at the hostname and forwards the request to the Evolution container.

If Traefik is missing or misconfigured, the domain may:

- not load
- show certificate errors
- show 404
- route to the wrong service

---

# 9. What the Traefik labels mean

These labels define how the domain reaches Evolution.

Example:

```yaml
- traefik.enable=true
- traefik.docker.network=PLSNetwork
- traefik.http.routers.evolutionapi.rule=Host(`evolutionapi.plssistemas.com.br`)
- traefik.http.routers.evolutionapi.entrypoints=websecure
- traefik.http.routers.evolutionapi.tls=true
- traefik.http.routers.evolutionapi.tls.certresolver=letsencryptresolver
- traefik.http.services.evolutionapi.loadbalancer.server.port=8080
```

## Meaning

- `traefik.enable=true`  
  Enables Traefik routing for this service

- `traefik.docker.network=PLSNetwork`  
  Tells Traefik which Docker network to use to reach the container

- `rule=Host(...)`  
  Says which domain belongs to this service

- `entrypoints=websecure`  
  Says HTTPS entrypoint is used

- `tls=true`  
  Enables HTTPS routing

- `certresolver=letsencryptresolver`  
  Says Traefik should obtain the SSL certificate

- `loadbalancer.server.port=8080`  
  Says the container app is listening internally on port `8080`

---

# 10. Why Docker network matters

Your app containers must be on the right networks.

Usually:

- Evolution, Postgres, Redis share an internal network
- Evolution and Traefik also share an external network like `PLSNetwork`

If Evolution is not attached to the same network as Traefik, Traefik may see the service but fail to actually reach it.

That causes issues like:

- bad gateway
- timeouts
- certificate created but app does not load
- weird 404 behavior

---

# 11. Why Postgres and Redis names matter

Inside Docker Swarm, services talk to each other by **service name**, not by localhost.

Correct examples:

```env
DATABASE_CONNECTION_URI=postgresql://postgres:password@evolution_postgres:5432/evolution_db?schema=public
CACHE_REDIS_URI=redis://evolution_redis:6379/2
```

## Important

Do not use:

```env
localhost
127.0.0.1
```

for Postgres or Redis unless they are inside the same container, which they are not.

This is another common mistake in container setups.

---

# 12. The API key confusion

You were dealing with **two different keys**.

## Global API key

```env
AUTHENTICATION_API_KEY=...
```

This is the server-level API key.

Used for:

- authenticating requests to Evolution API
- dashboard/backend authentication

## Instance key

This is tied to a specific instance.

Used for:

- instance-level actions
- message operations tied to that instance

## Main lesson

Do not confuse:

- app auth
- instance auth
- dashboard login behavior

They are related, but not the same thing.

---

# 13. Why QR code was not generating

There are multiple possible causes for QR problems:

1. broken or stale instance session
2. bad app version
3. frontend manager bug
4. incorrect session version config
5. auth working but session not entering QR generation flow
6. reverse proxy issues hiding the real backend response

## Important lesson

“Service is running” does **not** mean “QR generation is working”.

A container can be healthy while:

- the manager UI is broken
- the instance is stale
- the session is corrupted
- the connect endpoint returns no QR

---

# 14. Why `{"count":0}` mattered

When the `/instance/connect/...` request returned:

```json
{"count":0}
```

that meant:

- API was reachable
- auth was accepted
- but no QR payload was being returned

So the issue was no longer just “wrong API key”.

This was an important turning point in diagnosis.

---

# 15. Why a newer image version matters

Using an outdated image can cause:

- QR code bugs
- manager UI bugs
- incompatibility with current WhatsApp/Baileys behavior
- missing fixes already solved in newer versions

## Lesson

If you suspect a bug in the app behavior itself, do not keep spending hours debugging only the infrastructure. Sometimes the image version is part of the problem.

---

# 16. Why `CONFIG_SESSION_PHONE_VERSION` matters

For WhatsApp/Baileys-based integrations, version-related config may affect connection behavior.

Typical config:

```env
CONFIG_SESSION_PHONE_CLIENT=EvolutionAPI
CONFIG_SESSION_PHONE_NAME=Chrome
CONFIG_SESSION_PHONE_VERSION=2.3000.1015901307
```

If the version is missing or mismatched, QR/session behavior may fail or behave inconsistently.

---

# 17. Why direct access is useful for debugging

Even if your final goal is:

```text
https://evolutionapi.plssistemas.com.br
```

direct access like:

```text
http://your-ip:8081
```

is useful for debugging because it removes:

- SSL
- Traefik
- domain routing
- certificate problems

This helps isolate whether the problem is:

- app layer
- or proxy/domain layer

The direct port is not always the final architecture, but it is often a good diagnostic step.

---

# 18. Why `/manager` may 404

A 404 on `/manager` can happen because:

1. wrong path for that image/version
2. request is hitting the wrong service
3. Traefik is routing to the wrong backend
4. the container exposes only API routes, not the manager frontend the way you expect
5. domain is still pointing to an old route or old proxy path

So `/manager` returning 404 does **not** automatically mean the API is dead.

You must test separately:

- root path
- manager path
- API endpoint

Example:

```bash
curl -i http://localhost:8080
curl -i http://localhost:8080/manager
curl -i http://localhost:8080/instance/fetchInstances -H "apikey: YOUR_KEY"
```

---

# 19. The safest troubleshooting order

When things are not working, use this sequence:

## Step 1 — Check service status

```bash
docker service ls
docker service ps <service_name>
docker service logs -f <service_name>
```

## Step 2 — Test API internally

```bash
curl http://localhost:8080/instance/fetchInstances -H "apikey: YOUR_KEY"
```

or through the published port:

```bash
curl http://localhost:8081/instance/fetchInstances -H "apikey: YOUR_KEY"
```

## Step 3 — Test public routing

```text
http://domain:8081
```

or

```text
https://domain
```

depending on architecture

## Step 4 — Test the exact QR/connect endpoint

```bash
curl http://localhost:8080/instance/connect/INSTANCE_NAME -H "apikey: YOUR_KEY"
```

## Step 5 — Only then debug the UI

The browser UI should be the last confirmation layer, not the first diagnosis layer.

---

# 20. The biggest mistakes that were happening

## Mistake 1

Using `https://domain` logic while the service was configured for direct `http://domain:8081`

## Mistake 2

Expecting SSL to work without a reverse proxy managing certificates

## Mistake 3

Mixing internal container port `8080` with public browser port `8081`

## Mistake 4

Using `SERVER_URL` that did not match the real public access URL

## Mistake 5

Trying to diagnose everything through the browser UI only

## Mistake 6

Assuming “service is running” means “QR generation is working”

## Mistake 7

Not separating:

- app issue
- network issue
- reverse proxy issue
- version issue

---

# 21. Practical decision rule

Use this simple rule:

## If you want this:

```text
https://evolutionapi.plssistemas.com.br/manager
```

Then use:

- Traefik
- SSL certificate
- `SERVER_URL=https://evolutionapi.plssistemas.com.br`
- no direct public browser dependency on `:8081`

## If you want this:

```text
http://evolutionapi.plssistemas.com.br:8081
```

Then use:

- direct port publishing
- no Traefik requirement
- `SERVER_URL=http://evolutionapi.plssistemas.com.br:8081`

Do not mix them.

---

# 22. Recommended mindset going forward

Whenever something breaks, ask:

1. Is the app running?
2. Is the internal API reachable?
3. Is Docker networking correct?
4. Is the reverse proxy correctly routing?
5. Does the public URL match `SERVER_URL`?
6. Am I debugging the app, or just the browser symptom?

If you answer those in order, the configuration becomes much easier.

---

# 23. Final summary

The key idea is this:

**Evolution API, Docker networking, and public HTTPS routing are separate concerns.**

You need to configure each one correctly and consistently.

## Short version

- `8080` usually = internal app port
- `8081` can be a published VPS port
- `https://domain.com` usually requires Traefik/reverse proxy
- SSL is usually handled by Traefik, not Evolution
- `SERVER_URL` must match the real public URL
- Postgres/Redis should use Docker service names
- QR issues may be app/session/version issues, not just browser issues

---

# 24. Copyable checklist

## Direct access mode checklist

```text
[ ] ports: 8081:8080 published
[ ] SERVER_TYPE=http
[ ] SERVER_PORT=8080
[ ] SERVER_URL=http://domain-or-ip:8081
[ ] browser uses http://domain-or-ip:8081
[ ] no expectation of automatic SSL
```

## Traefik + SSL mode checklist

```text
[ ] DNS points domain to VPS
[ ] Traefik running on 80 and 443
[ ] cert resolver configured
[ ] Evolution attached to Traefik network
[ ] SERVER_TYPE=http
[ ] SERVER_PORT=8080
[ ] SERVER_URL=https://domain
[ ] Traefik labels point to internal port 8080
[ ] browser uses https://domain
```

---

# 25. One sentence to remember

**Choose either direct port access or reverse-proxy HTTPS, and make every part of the configuration agree with that choice.**
