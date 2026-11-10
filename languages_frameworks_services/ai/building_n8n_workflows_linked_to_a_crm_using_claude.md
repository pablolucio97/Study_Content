# Building n8n WhatsApp AI agents with Claude Code: from zero to production

**Meta's screens and prices change often.** Button names below are the ones seen in November 2026. Prices and rules were read from [Meta's pricing page](https://developers.facebook.com/documentation/business-messaging/whatsapp/pricing) on 2026-11-09, so check it again before you quote a cost.

## Contents

- [Building n8n WhatsApp AI agents with Claude Code: from zero to production](#building-n8n-whatsapp-ai-agents-with-claude-code-from-zero-to-production)
  - [Contents](#contents)
  - [1. The overall plan](#1-the-overall-plan)
  - [2. Who does what: you or Claude Code](#2-who-does-what-you-or-claude-code)
    - [Setting up Claude Code](#setting-up-claude-code)
    - [A good first brief](#a-good-first-brief)
  - [3. Decisions to make first](#3-decisions-to-make-first)
  - [4. Local n8n and tunnel](#4-local-n8n-and-tunnel)
  - [5. Development WhatsApp with Evolution API](#5-development-whatsapp-with-evolution-api)
  - [6. Knowledge base](#6-knowledge-base)
  - [7. Backend routes for the agent](#7-backend-routes-for-the-agent)
  - [8. Generate the workflows from code](#8-generate-the-workflows-from-code)
  - [9. Anatomy of the agent workflow](#9-anatomy-of-the-agent-workflow)
    - [Normalizing the message](#normalizing-the-message)
    - [Grouping quick messages](#grouping-quick-messages)
    - [The AI request](#the-ai-request)
    - [Sending like a person](#sending-like-a-person)
    - [Human in the loop](#human-in-the-loop)
    - [Prompt rules that improved the conversation](#prompt-rules-that-improved-the-conversation)
  - [10. Test in development](#10-test-in-development)
  - [11. Deploy the backends](#11-deploy-the-backends)
    - [Create the agent user 🤝](#create-the-agent-user-)
  - [12. Create the Meta app](#12-create-the-meta-app)
    - [Accept the WhatsApp terms](#accept-the-whatsapp-terms)
  - [13. Register the production number](#13-register-the-production-number)
  - [14. Message templates](#14-message-templates)
  - [15. Payment method](#15-payment-method)
  - [16. System user and token](#16-system-user-and-token)
    - [Create the system user](#create-the-system-user)
    - [Assign all three assets](#assign-all-three-assets)
    - [Generate the token](#generate-the-token)
    - [Verify it 🤖](#verify-it-)
  - [17. Production n8n on the VPS](#17-production-n8n-on-the-vps)
    - [DNS](#dns)
    - [Compose](#compose)
    - [Start, and create the owner straight away](#start-and-create-the-owner-straight-away)
  - [18. Move workflows and credentials to production](#18-move-workflows-and-credentials-to-production)
    - [1. Export on your Mac](#1-export-on-your-mac)
    - [2. Upload](#2-upload)
    - [3. Import on the VPS](#3-import-on-the-vps)
    - [4. Publish and restart](#4-publish-and-restart)
    - [5. Delete every plain-text copy](#5-delete-every-plain-text-copy)
    - [6. Test the webhook](#6-test-the-webhook)
    - [Credentials shared with development](#credentials-shared-with-development)
  - [19. Connect the Meta webhook](#19-connect-the-meta-webhook)
  - [20. Publish and run the first real test](#20-publish-and-run-the-first-real-test)
    - [Before you publish](#before-you-publish)
    - [Publish](#publish)
    - [The first real test](#the-first-real-test)
  - [21. After launch](#21-after-launch)
  - [22. General tips and best practices](#22-general-tips-and-best-practices)
    - [Grouping messages to save money](#grouping-messages-to-save-money)
    - [What Meta charges for](#what-meta-charges-for)
    - [Making it feel natural](#making-it-feel-natural)
    - [Which model to use](#which-model-to-use)
    - [Do you need RAG?](#do-you-need-rag)
    - [Reliability](#reliability)
    - [Security](#security)
    - [Conversation rules](#conversation-rules)
    - [Working with Claude Code](#working-with-claude-code)
  - [23. Troubleshooting: real errors and their causes](#23-troubleshooting-real-errors-and-their-causes)
  - [24. Reusable Claude Code prompts](#24-reusable-claude-code-prompts)
  - [25. Launch checklist](#25-launch-checklist)
  - [Sources](#sources)

---

## 1. The overall plan

```text
Customer on WhatsApp
      │
      ▼
Meta Cloud API ── webhook ──► n8n on the VPS ──► your CRM and product APIs
      ▲                           │
      │                           ▼
      └──── reply messages ◄── OpenAI (knowledge base + context)
```

| Stage | Parts | Outcome |
|---|---|---|
| **Build locally** | 3–10 | The agent answers on a test number |
| **Prepare production** | 11–16 | Backends live, Meta account ready |
| **Go live** | 17–20 | Agent on the VPS, app published, real reply confirmed |
| **Operate** | 21–25 | Backups, rotated secrets, cost control |

**Order that would have saved time:** set up the VPS n8n (Part 17) *before* the Meta webhook (Part 19). In the original launch we pointed Meta at ngrok first and moved later. It worked, but it meant one extra cutover and a period when the agent depended on a laptop.

---

## 2. Who does what: you or Claude Code

Tags used in this guide:

- 🤖 **Claude Code** can do it.
- 🧑 **You** must do it.
- 🤝 **Both:** Claude prepares it and you do the final action.

Claude Code can't type passwords, tokens or card details into a website or production system, even when you ask. Its safety checks may also block some high-impact clicks, as happened with **Publish** in Meta and **Save** on a DNS record. Plan for those moments.

| Task | Who | Note |
|---|---|---|
| Write the generator, prompts and docs | 🤖 | |
| Docker, n8n CLI and API checks | 🤖 | |
| Fill in Meta forms and templates | 🤖 | Through the browser extension |
| Accept terms and policies | 🤝 | Claude asks first, then clicks |
| Meta password prompts and SMS codes | 🧑 | |
| Card details | 🧑 | |
| Generate the system user token | 🧑 | Paste it directly into n8n, never into chat |
| Verify token in Meta's form | 🤝 | Claude puts it on your clipboard, you paste and save |
| n8n owner account | 🧑 | |
| Create production users with passwords | 🤝 | Claude writes a command with a hidden prompt, you run it |
| Publish the Meta app | 🧑 | Blocked for Claude in our launch |
| Create the DNS record | 🤝 | Claude filled in the form, you click **Save** |
| Upload secret files to the VPS | 🧑 | With `scp` and your VPS password |

### Setting up Claude Code

- **Browser access.** Use the **Claude in Chrome** extension, which also ran in Microsoft Edge in our launch and uses your existing sign-ins. Computer use can only *view* browsers, not click in them, so ask for "Claude in Edge" or "Claude in Chrome" by name.
- **Server access.** Keep one signed-in terminal app for the VPS and let Claude drive it through computer use. Grant access to that app when asked.
- **Memory.** Ask Claude to remember your deploy layout, branch rules and access method, so you don't have to explain them in every session.
- **Secrets.** Never paste secrets into chat. Everything pasted stays in the transcript. In our launch, several keys ended up in chat and all needed rotating afterward.

### A good first brief

Give Claude the flow, the rules and the addresses at the start, including which AI provider to use. Without that, it may default to a provider you don't have a key for, as happened in our first version.

```text
Create the commercial agent n8n flow, generating the JSON to import.
It must match these routes and this flowchart: <paste>.

Rules:
- AI provider: OpenAI, model <model>. Key lives only in an n8n credential.
- Wait 5 seconds before answering. If more messages arrive, answer them together.
- Human handoff must look natural.
- Development: Evolution API. Production: WhatsApp Cloud API.
- Agent number: <number>. Test number: <number>.
- n8n: http://localhost:3335. Evolution: http://localhost:8081/manager.
- Clear variable names. Generate workflows from a script, not by hand.
Do not activate workflows or set webhooks without asking me.
```

---

## 3. Decisions to make first

| Decision | What we chose | Why |
|---|---|---|
| **Production WhatsApp access** | Cloud API directly | No extra vendor fee, one less dependency |
| **BSP and coexistence** | No | A BSP is only needed to keep the same number in the WhatsApp app and the API at once |
| **Production number** | Dedicated to agents | Once on the Cloud API, it can't be used in the WhatsApp app or WhatsApp Web |
| **Development number** | **Use a different number** | We used the same one, so moving it to the Cloud API killed the development setup |
| **AI model** | Small model with low reasoning | See [Part 22](#which-model-to-use) |
| **Knowledge retrieval** | Full document in the prompt, no RAG | See [Part 22](#do-you-need-rag) |
| **Workflow authoring** | Generated by a Python script | Reviewable, repeatable, keeps development and production aligned |
| **Hosting** | VPS with Docker Compose and Traefik | Webhooks must be reachable at all times |

**Number rules to accept before you start:**
- The number must receive an SMS or a call for verification.
- It stops working in the regular WhatsApp app. On some phones, an old chat with it showed "Esta pessoa não está mais no WhatsApp", so test from a phone with no old chat. We didn't find out what that message means for other contacts: **Not validated.**
- A phone number can be reused for other agents later, as long as they share one webhook and a router decides which agent answers.

---

## 4. Local n8n and tunnel

🤖 Claude can create and run this. You provide the ngrok token in `.env`.

`docker-compose.yaml`:

```yaml
services:
  n8n:
    container_name: n8n
    image: docker.n8n.io/n8nio/n8n:2.16.1   # Pin the version
    ports:
      - "3335:5678"
    environment:
      - WEBHOOK_URL=${URL}                  # Your public ngrok URL
      - TZ=${TIMEZONE}
      - GENERIC_TIMEZONE=${TIMEZONE}
      - N8N_PROXY_HOPS=1
    networks:
      - n8n-network
    volumes:
      - n8n_data:/home/node/.n8n

  ngrok:
    container_name: ngrok
    image: ngrok/ngrok:latest
    environment:
      - NGROK_AUTHTOKEN=${NGROK_AUTHTOKEN}
    command: ["start", "--all", "--config", "/etc/ngrok.yml"]
    networks:
      - n8n-network
    volumes:
      - ./ngrok.yml:/etc/ngrok.yml

volumes:
  n8n_data:

networks:
  n8n-network:
    driver: bridge
```

`ngrok.yml`:

```yaml
version: 2
tunnels:
  n8n:
    proto: http
    addr: n8n:5678
    domain: <your-free-domain>.ngrok-free.dev
```

Start it, then open `http://localhost:3335` and create your local owner account:

```bash
docker compose up -d
```

**From a container, your Mac's other services are at `host.docker.internal`**, not `localhost`. In our dev config, the CRM was `http://host.docker.internal:3341`.

**Docker Desktop note:** when launched from Claude Code's shell, use `env -u ELECTRON_RUN_AS_NODE open -a Docker`. Otherwise the dashboard can fail to open.

---

## 5. Development WhatsApp with Evolution API

Evolution API links to a WhatsApp number through a QR code, so you can test without Meta. It's an unofficial connection, so **use it only for development, on a number you can afford to lose**.

1. 🤖 Run Evolution with its Postgres and Redis containers. We used `evoapicloud/evolution-api:v2.3.7` on port 8081.
2. 🧑 Open `http://localhost:8081/manager`, create an instance and scan the QR code with the test phone.
3. 🤖 After the workflow is active, point the instance at n8n. Only `MESSAGES_UPSERT` is needed:

```bash
curl -X POST http://localhost:8081/webhook/set/<instance> \
  -H "apikey: $EVOLUTION_API_KEY" -H "Content-Type: application/json" \
  -d '{"webhook":{"enabled":true,"url":"http://host.docker.internal:3335/webhook/<your-path>","byEvents":false,"base64":false,"events":["MESSAGES_UPSERT"]}}'
```

**Protect real contacts.** An Evolution instance is a real number, so keep an allowlist in the workflow's config while testing:

```js
restrictToAllowed: true,
allowedNumbers: ['55DDDNNNNNNNN'],
```

---

## 6. Knowledge base

The agent's answers are only as good as this document.

1. 🤖 Ask Claude to write it from the real system, not from marketing copy:

   ```text
   Read the code, seeds and FAQ, and write a knowledge base for the sales and support agents.
   Every fact must match how the system really behaves. No technical details for the customer.
   Give each entry a fixed code, such as FAQ-ENC-02, and verify each entry against the code.
   ```

2. 🧑 Review the business rules yourself. We caught two segments the business no longer accepts, which had to be removed.
3. 🤖 Save it as **Markdown**, even if you also want a PDF. PDF tables can come out jumbled, so give the agent plain text.
4. Add: when to hand off to a human, what never to promise, and exact links.

**What goes in it:** eligibility, plans and prices, signup links, payment statuses, refunds, cancellation, onboarding, a map of the product, FAQ and troubleshooting.

**What doesn't:** anything specific to one customer, like "was my payment approved?". Those need live API lookups.

Ours was 76 KB of Markdown with 87 coded entries, about 21k input tokens per reply including instructions.

---

## 7. Backend routes for the agent

🤖 Map the flowchart to your API before writing any workflow:

```text
Based on this flow and the routes in <repo1> and <repo2>, list every route the workflow
must call. Return a table showing when each is called and which route. Then write a spec of the gaps.
```

**What an agent typically needs:**

| Need | Our route | Purpose |
|---|---|---|
| Service account | `POST /authenticate` | Sign in with a user that has the `agent` profile |
| Find or create the conversation | `POST /conversations/resolve` | Keyed by phone number |
| Record each message | `POST /conversations/:id/events` | Inbound, outbound, intent, notes |
| Read state and history | `GET /conversations/:id`, `/events` | Attendance mode, opt-out, context |
| Hand to or from a human | `PATCH /conversations/:id/handoff` | AI stays silent while a person attends |
| Opt-out | `PATCH /conversations/:id/opt-out` | Never message them again |
| Customer lookup | `GET /companies/lookup?phone=` | Is this person already a customer? |
| Lead management | CRM lead routes | Create and move through the funnel |
| Events from the product | `GET /integration-events` | CRM and agents poll for changes |

**Lessons:**
- **An `agent` user profile is worth having.** It gets its own limited permissions and no company binding, and it's clearly separate from human accounts.
- **Polling can replace webhooks between your own systems.** We dropped signed webhooks and let the CRM poll every 5–10 seconds, which removed two secrets and the retry handling.
- **Cache tokens in n8n's static data** until about 5 minutes before they expire. Our `/authenticate` allowed only 10 requests a minute, so signing in per message would fail under load.
- **The conversation must have an `attendance` state** (`ai` or `human`). A CRM screen with a "give back to AI" button needs it too.

---

## 8. Generate the workflows from code

Don't hand-build big flows in the editor. Our agent has 52 nodes in production and 58 in development.

**Project layout:**

```text
docs/agents-integration/n8n/
├── build_workflows.py          # Single source
├── README.md
├── whatsapp-templates.md
├── agent.dev.json              # Generated
└── agent.prod.json             # Generated
```

**Generator rules that paid off:**

1. **One `DEV` config and one `PROD` config.** Everything that differs lives there, and the script writes a `Config` node with those values.

   ```python
   PROD = {
       "env": "prod",
       "crmUrl": "https://crmapi.example.com",
       "solutionId": "<CRM solution id>",
       "agentNumber": "<number>",
       "graphUrl": "https://graph.facebook.com/v23.0",
       "phoneNumberId": "<Phone number ID>",
       "notifyNumbers": ["<team number>"],
       "notifyTemplate": "<template name>",
       "templateLanguage": "pt_BR",
       "allowedNumbers": [],
       "restrictToAllowed": False,
       "openaiModel": "gpt-5.4-mini",
       "openaiReasoningEffort": "low",
       "typing": {"minMs": 1500, "perCharMs": 35, "maxMs": 7000},
       "historyLimit": 30,
   }
   ```

2. **Stable IDs.** Generate workflow and node IDs from their names, so re-importing updates in place:

   ```python
   stable_id = uuid.uuid5(uuid.NAMESPACE_URL, f"myproject/{path.name}").hex[:16]
   ```

3. **Fixed credential IDs.** Map credential names to fixed IDs, like `whatsappCloud001`, so imported nodes link automatically.
4. **Never put secrets in the generator.** Keep placeholders like `TROQUE_PELO_SEU_VERIFY_TOKEN`. The real values live only in n8n.
5. **Readable code in the Code nodes.** Ask for it at the start: `config`, not `cfg`. Then ask Claude to prove any big rename kept the behavior. It ran old and new code on the same inputs and compared the outputs.

**Import from the command line:**

```bash
docker cp agent.dev.json n8n:/tmp/agent.dev.json && docker exec -u root n8n chown node /tmp/agent.dev.json && docker exec n8n n8n import:workflow --input=/tmp/agent.dev.json
```

**Activate:** publish, then restart so n8n registers the webhook.

```bash
docker exec n8n n8n publish:workflow --id=<workflow id> && docker restart n8n
```

**Create credentials:** in n8n, go to **Credentials → Add credential**.

| Name | Type | Value |
|---|---|---|
| `OpenAI API` | Header Auth | `Authorization` = `Bearer <key>` |
| `CRM login` | Custom Auth | `{"body": {"email": "…", "password": "…"}}` |
| `Product login` | Custom Auth | Same shape |
| `Evolution API` (dev) | Header Auth | `apikey` = Evolution key |
| `WhatsApp Cloud API` (prod) | Header Auth | `Authorization` = `Bearer <system user token>` |

**⚠️ If you edit workflows by hand in n8n, tell Claude.** Re-importing would overwrite your edits. We used a merge instead: compare the old generated file, the new generated file and n8n's current database, and only apply parameters that changed in the generator. It stops if your edit touched the same value.

---

## 9. Anatomy of the agent workflow

```text
Webhook → Config → Normalize message → Tokens (cached sign-in)
  → CRM: resolve conversation → CRM: record inbound message
  → Wait 5 s
  → CRM: read conversation + history → Decide attendance
  → WhatsApp: mark read + typing → Route
  → Product: find company → Build AI request → OpenAI → Interpret reply
  → Send plan → Split messages → One at a time:
        Typing → Typing delay → Send text → Record outbound
  → CRM upkeep: intent, lead stage, handoff, opt-out
```

### Normalizing the message

Ignore everything that isn't a real message from a contact: groups, delivery statuses, reactions and edits. Without this filter, every status update would run the whole flow.

```js
const webhookBody = $('Webhook WhatsApp').first().json.body || {};
if (webhookBody.object !== 'whatsapp_business_account') return [];
// Skip delivery statuses, which arrive without `messages`
if (change.field !== 'messages' || !changeValue.messages?.length) continue;
```

Also drop events for a different `phone_number_id`. That's what makes Meta's **Test** button safe to use: its sample has a fake ID, so it stops here with no production calls.

**Brazilian numbers come with or without the 9th digit.** Meta returned `5531XXXXXXXX` for a number we sent as `55319XXXXXXXX`. Normalize every phone before comparing:

```js
function toWhatsAppPhone(rawPhone) {
  let digits = String(rawPhone || '').replace(/\D/g, '');
  if (digits.length === 10 || digits.length === 11) digits = '55' + digits;
  if (digits.length === 12 && digits.startsWith('55') && /[6-9]/.test(digits[4])) {
    digits = digits.slice(0, 4) + '9' + digits.slice(4);
  }
  return digits;
}
```

**Media:** we don't transcribe audio. The model sees `[áudio sem texto]` and politely asks the person to type.

### Grouping quick messages

People send "oi", "tudo bem?", "quanto custa?" in a row. Each one starts a run, and only the newest should answer.

1. Record the message in the CRM.
2. Wait 5 seconds.
3. Check whether a newer message arrived. If so, stop; the newer run answers them all.

```js
const latestInbound = latestFirstEvents.find((event) => event.type === 'inbound_message');
if (recordedMessage && latestInbound && latestInbound.id !== recordedMessage.id) return [];

// A person is attending, or the contact opted out: stay silent
if (conversation.attendance === 'human' || conversation.optedOut) return [];
```

### The AI request

- **Static part first:** instructions and knowledge base, identical on every request. OpenAI caches that prefix automatically, which makes repeated input cheaper.
- **Per-conversation context last:** contact, company data, summary and history.
- **`response_format: json_schema` with `strict: true`:** the answer always has the same shape.

```text
messages[], intent, action, plan, cycle, kbCodes, summary, handoffReason, leadData
```

**Never let the model write links.** It writes `{{LINK_CADASTRO}}`, and the workflow inserts the official URL. For the same reason, it sends the `action` field, and the workflow decides what happens.

**Every AI failure must end in a natural handoff:** a refusal, `finish_reason: "length"`, an unparseable answer or an API error. On the OpenAI node, use retries and `onError: continueErrorOutput`:

```python
retryOnFail=True, maxTries=3, waitBetweenTries=3000, onError="continueErrorOutput", timeout=120000
```

### Sending like a person

Each reply becomes 1–3 short messages, sent one at a time with a typing indicator:

```js
const typingMs = Math.min(typing.maxMs, typing.minMs + text.length * typing.perCharMs);
// With our config: 1.5 s + 35 ms per character, 7 s at most
```

Cloud API "typing" call, which also marks the message as read:

```json
{
  "messaging_product": "whatsapp",
  "status": "read",
  "message_id": "<wamid of the received message>",
  "typing_indicator": { "type": "text" }
}
```

Set non-essential nodes like this one to `onError: continueRegularOutput`, so a failed typing call doesn't lose the reply. Meta clears the indicator when you respond, or after 25 seconds. Only show it if you're really going to answer.

### Human in the loop

**Handing off:** the contact gets a natural message from the same number, the CRM flips to `human`, and the team gets an alert with the reason, a summary and a link.

> Vou chamar o pessoal aqui do time para te ajudar com isso, tá? Já já alguém continua com você por aqui.

Hand off when the contact asks for a person or something special, when the model fails to understand twice in a row, or when the AI call fails.

**⚠️ Decide how your team replies before launch.** With the Cloud API, nobody can type from the agent's number in a WhatsApp app. So either the CRM needs a reply box that sends through the API, or the team contacts the customer from another number. If it's another number, don't say "por aqui" in the handoff message. We launched with this mismatch still open.

**Honesty:** if asked, the agent should say it's the team's virtual assistant.

### Prompt rules that improved the conversation

- "Answer only from the knowledge base. If it isn't covered, ask for clarification or call the team."
- "Portuguese, warm and direct, like someone on the team writing from their phone. Short sentences."
- "1 to 3 short messages. At most one emoji. One question at a time."
- "WhatsApp only understands `*bold*` and `_italic_`: no headings, tables or Markdown links."
- "Never say you'll send something later. What you offer goes in this same reply."
- "Use the person's name and store when you know them. Don't repeat greetings."
- "After answering, move to the next step with one short question."

---

## 10. Test in development

1. **Test the AI alone first.** Claude built a temporary workflow from fixed test data with no send node, so nothing went out and nothing was written to the CRM. It ran 24 times to compare models and prompts. Delete it afterward.
2. **Send real messages from the allowlisted number.** Cover these scenarios:

   | Scenario | Expected result |
   |---|---|
   | Three quick messages | One AI call, one answer to all three |
   | Eligible customer asks about the product | Answer from the knowledge base |
   | Ineligible segment | Polite explanation, no flat refusal |
   | Wants to sign up | Official link, inserted by the workflow |
   | "Quero falar com uma pessoa" | Natural handoff; AI then stays silent |
   | Team hands back in the CRM | AI resumes with context |
   | "Não quero mais receber" | Opt-out; no more messages |
   | Audio or image | Asks the person to type |
   | AI key removed | Natural handoff, not silence |

3. **Read runs node by node.** In n8n, open **Executions** and see which node failed. You can ask Claude to do this for you:

   ```text
   The workflow stopped at node "<name>" when I sent "<message>". Find out why and fix it.
   ```

4. **Run 30–50 real customer questions** and check each answer against the knowledge base before launch.

---

## 11. Deploy the backends

**Do this before publishing the Meta app.** In our launch, the production API didn't have the agent routes yet, so the `agent` user couldn't be created until this was deployed.

**Check what production really has.** A request with no login tells you if a route exists: `401` means it does, `404` means it doesn't.

```bash
curl -s -o /dev/null -w '%{http_code}\n' https://api.example.com/integration-events
```

**Release sequence** 🤖:

1. Commit, and bump the version: `npm version minor`.
2. Merge up to `main` and push with tags: `git push --follow-tags origin develop staging main`.
3. Build for the server's architecture. From an Apple Silicon Mac, that's `linux/amd64`, even for an Ubuntu server:

   ```bash
   docker buildx build --platform linux/amd64 -t <user>/<api>:<version> -t <user>/<api>:latest --push .
   ```

4. Check migrations before applying them. Read for `DROP`, `TRUNCATE` and new required columns. Compare new environment variables with what the server has.
5. On the server: back up the database and `.env`, set the new tag, pull, migrate and restart.

   ```bash
   docker compose exec -T postgres sh -c 'pg_dump -U "$POSTGRES_USER" "$POSTGRES_DB"' | gzip > backup-before-<version>.sql.gz
   ```

   ```bash
   cp -p .env .env.bak-$(date +%Y%m%d)
   ```

6. Confirm with the same `curl` check. `404` should now be `401`.

**Pin versions** instead of using `latest`, so rollback only means changing one tag back.

### Create the agent user 🤝

Claude writes the command, and you run it so the password never passes through chat. The password prompt is hidden, and only the hash reaches the database:

```bash
read -rs -p 'Senha do agente: ' PW; echo; export PW
```

```bash
HASH=$(docker compose exec -T -e PW api node -e "process.stdout.write(require('bcryptjs').hashSync(process.env.PW,10))"); unset PW
```

Then insert the row with `$HASH`, in your own table layout. Test the SQL first locally inside `BEGIN; … ROLLBACK;`. Use an email alias like `name+agente@gmail.com` if the main address is already taken, because emails must be unique.

---

## 12. Create the Meta app

**Use a new app for the agents** if another app of yours is in App Review, so you don't extend or mix up that review.

**Prerequisite:** a Meta business portfolio. Ours was already verified, which removes some limits.

🤖 Claude can do this, stopping at the password prompt:

1. Go to [developers.facebook.com/apps/creation](https://developers.facebook.com/apps/creation/).
2. **App details:** type the name, like `mycompany-agents`, and click **Next**.
3. **Use cases:** select **Connect with customers through WhatsApp**, then **Next**.
4. **Business:** select your portfolio, then **Next**.
5. **Requirements:** click **Next**.
6. **Overview:** click **Create app**.
7. 🧑 **Re-enter your password** if Meta asks.

**Set what publishing requires.** Under **App settings → Basic**:
- **Privacy Policy URL**
- **Category:** Messaging

Don't publish yet. You'll publish at the end (Part 20).

### Accept the WhatsApp terms

1. Go to **Use cases → Connect with customers through WhatsApp → Customize**.
2. In the left menu, open **Basic setup → Step 2. Production setup**.
3. Accept the terms when asked, under your portfolio.

**Meta creates a "Test Messaging Account" with a test number at this point. It's not your real account.** Don't submit templates there. Your real account gets created in the next part, when you add your number.

---

## 13. Register the production number

Before starting, decide on the display name and make sure the phone can receive the code.

Go to **Use cases → Customize → Step 2. Production setup → Register your WhatsApp phone number**:

1. 🤖 Click **Add new number**.
2. 🤖 Choose the country code and type the number.
3. 🤖 Submit, and Meta sends a code by SMS.
4. 🧑 Type the code in **Verify your phone number**, then click **Next**.
5. 🤖 Choose to continue with a **new WhatsApp account** under your portfolio.
6. 🤖 Pick the business category, like **Professional Services**, then keep or edit the name and website.
7. Submit. The number should show **Registered**.

**Collect these IDs** 🤖. Put them in the `PROD` config:

| Value | Where to find it |
|---|---|
| **Phone Number ID** | Next to the number, in the Register section |
| **WhatsApp/Messaging account ID** | Under the account name, in the same section |
| **App ID** | In the app's URL or under **App settings → Basic** |

**Confirm in WhatsApp Manager:** **Account tools → Phone numbers** should show **Connected**. In our case, Meta allowed the display name without review (`AVAILABLE_WITHOUT_REVIEW`).

**Number format:** Meta displayed our number without the 9th digit (`+55 31 9XXX-XXXX`) although we registered it with the digit (`31 99XXX-XXXX`). Contacts reached it either way.

**Add the profile picture** 🤖 (optional, a square JPG or PNG). It's a three-step API call. Meta converted our PNG to JPEG and turned the transparent corners white, which the circular crop hides:

```bash
# 1. Open an upload session: the response has the session id
curl -X POST -H "Authorization: Bearer $TOKEN" "https://graph.facebook.com/v23.0/$APP_ID/uploads?file_name=logo.png&file_length=$BYTES&file_type=image/png"
# 2. Send the file: the response has the handle "h"
curl -X POST -H "Authorization: OAuth $TOKEN" -H 'file_offset: 0' --data-binary @logo.png "https://graph.facebook.com/v23.0/$SESSION_ID"
# 3. Set it on the number
curl -X POST -H "Authorization: Bearer $TOKEN" -H 'Content-Type: application/json' -d "{\"messaging_product\":\"whatsapp\",\"profile_picture_handle\":\"$HANDLE\"}" "https://graph.facebook.com/v23.0/$PHONE_NUMBER_ID/whatsapp_business_profile"
```

---

## 14. Message templates

You need templates to message anyone outside the 24-hour window: abandoned-cart reminders and team alerts, for example.

🤖 **WhatsApp Manager → Message templates → Manage templates → Create template:**

1. **Category:** Marketing for promotions and reminders, Utility for transactional notices.
2. Continue with the **Default** type.
3. **Name:** lowercase with underscores, like `recuperacao_checkout_1`.
4. **Language:** Portuguese (BR).
5. **Body:** write the text with variables.
6. **Sample values:** one per variable. Reviewers use these, so make them realistic.
7. **Footer** (Marketing): `Responda SAIR para não receber mais mensagens.`
8. Click **Submit for review**.

**⚠️ Typing tip for Claude:** in Meta's editor, typing `{{` creates the next numbered variable automatically. Typing `{{1}}` by hand broke the text.

**Use one template with a variable** rather than one per segment. Three templates covered all our segments, with `{{2}}` filled from a segment-to-text table in the workflow.

**Example (Utility, team alert):**

```text
Novo atendimento para assumir.

Contato: {{1}}
Motivo: {{2}}
Conversa no CRM: {{3}}

A IA fica em silêncio até a conversa ser devolvida no CRM.
```

**Review time:** Meta says "up to 24 hours". All three of ours were still in review a few hours later and approved when we checked the next day. Keep them in the repo with the variable order, because the workflow fills them by position.

**Sanitize template variables.** Remove line breaks from values before sending, using a helper like `singleLine()`.

**Check status** (needs token access to the Messaging account):

```bash
curl -s -H "Authorization: Bearer $TOKEN" "https://graph.facebook.com/v23.0/$WABA_ID/message_templates?fields=name,status,category"
```

---

## 15. Payment method

🧑 You enter the card. 🤖 Claude can open the form.

**Use cases → Customize → Step 2. Production setup → Add payment to send business-initiated messages → Add payment method.**

Then confirm it's attached: **Business Settings → Accounts → Messaging accounts → (your account) → Summary** shows the card, or use **Payment Settings**.

Without a payment method, Meta stops delivering service messages once the free tier is used up. Add one before you rely on paid templates.

---

## 16. System user and token

**This is where we lost the most time.** Get the permissions right on the first try.

### Create the system user

**[business.facebook.com/latest/settings](https://business.facebook.com/latest/settings) → Users → System users → Add:**

1. 🤝 Accept the **Non-discrimination policy** if it appears.
2. 🤖 **Name:** `agente-whatsapp`. **Role:** Employee.

Claude's safety check blocked the Admin role in our launch, and Employee was enough.

### Assign all three assets

Select the system user, then **Assign assets**. **A system user needs access in three places:**

| Asset type | Asset | Permission | If it's missing |
|---|---|---|---|
| **Apps** | Your app | **Develop app** | The token can't be tied to the app |
| **WhatsApp accounts** | Your account | **Messages** (and the default view-only phone numbers) | Expect send errors; we always had this one on |
| **Messaging accounts** | Your account | **Everything** | `(#10)` errors on send |

**⚠️ The Messaging account is the trap.** Meta lists it separately from the WhatsApp account, under **Accounts → Messaging accounts**. The errors we saw, in order:

```text
No access:          (#10) Viewer cannot access the provided Paid Message Account <id>
Templates view-only: (#10) You do not have WhatsApp granular permission for sending messages on behalf of this WhatsApp Business Account
Everything:         200 OK
```

To add it: **Messaging accounts → (your account) → Assign people → (your system user) → Everything → Assign.** The same token started working right after, so you don't need a new one. "Everything" is broad, since it also covers settings, users and payment information, so **treat that token like a master key**.

**The missing access also seemed to block incoming messages.** Real messages started reaching the webhook about two minutes after we added Messaging account access. We can't prove that was the cause.

### Generate the token

🧑 **System users → (your system user) → Generate token:**

1. **App:** your app.
2. **Expiration:** Never.
3. **Permissions:** at least `whatsapp_business_messaging` and `whatsapp_business_management`.
4. Copy it once, and paste it straight into n8n's `WhatsApp Cloud API` credential as `Bearer <token>`.

**Assign the assets first, then generate the token.** **Never paste it in chat.**

### Verify it 🤖

Each check tells you something different:

```bash
# Is the token valid, and what are its scopes?
curl -s -G --data-urlencode "input_token=$TOKEN" -H "Authorization: Bearer $TOKEN" https://graph.facebook.com/v23.0/debug_token
# Can it see the number and its webhook?
curl -s -H "Authorization: Bearer $TOKEN" "https://graph.facebook.com/v23.0/$PHONE_NUMBER_ID?fields=status,account_mode,webhook_configuration"
# Can it see the account and the subscribed apps?
curl -s -H "Authorization: Bearer $TOKEN" "https://graph.facebook.com/v23.0/$WABA_ID/subscribed_apps"
```

**A valid token isn't proof it can send.** Ours passed `debug_token` and could read the number, and it still couldn't send. Only a real send proves it, and that's a real message, so send it only to your own test number. If no 24-hour window is open, a free-form send won't arrive, so write to the agent first.

---

## 17. Production n8n on the VPS

Our VPS uses Docker Compose behind Traefik. If yours is different, adapt the labels.

### DNS

🤝 In Cloudflare: **(your domain) → DNS → Records → Add record:**

- **Type:** A
- **Name:** `n8n`
- **IPv4 address:** your VPS IP
- **Proxy status:** turn it **off**, so it shows **DNS only**. It defaults to Proxied, but Let's Encrypt has to reach the VPS directly.
- 🧑 Click **Save**. Claude's safety check blocked this click.

### Compose

🤖 First, look for what's already there:

```bash
docker ps -a --format '{{.Names}}' | grep -i n8n; docker network ls | grep -i traefik; ls -la /apps/n8n
```

Create `/apps/n8n/docker-compose.yml`:

```yaml
name: n8n
services:
  n8n:
    image: docker.n8n.io/n8nio/n8n:2.16.1     # Same version as development
    container_name: n8n
    restart: unless-stopped
    env_file: .env
    environment:
      N8N_HOST: n8n.example.com
      N8N_PROTOCOL: https
      WEBHOOK_URL: https://n8n.example.com/
      N8N_PROXY_HOPS: 1
      TZ: America/Sao_Paulo
      GENERIC_TIMEZONE: America/Sao_Paulo
      EXECUTIONS_DATA_PRUNE: "true"
      EXECUTIONS_DATA_MAX_AGE: 168            # Delivery statuses create many runs
    volumes:
      - n8n_data:/home/node/.n8n
    networks:
      - traefik
    labels:
      - traefik.enable=true
      - traefik.docker.network=traefik
      - traefik.http.routers.n8n.rule=Host(`n8n.example.com`)
      - traefik.http.routers.n8n.entrypoints=websecure
      - traefik.http.routers.n8n.tls=true
      - traefik.http.routers.n8n.tls.certresolver=letsencrypt
      - traefik.http.services.n8n.loadbalancer.server.port=5678
volumes:
  n8n_data:
networks:
  traefik:
    external: true
```

Create the encryption key with root-only permissions, and validate:

```bash
cd /apps/n8n && (umask 077; [ -e .env ] || printf 'N8N_ENCRYPTION_KEY=%s\n' "$(openssl rand -hex 32)" > .env) && docker compose config --quiet && docker compose pull -q && echo READY
```

**⚠️ Typing through a terminal app on a Mac:** macOS can turn two spaces into `. `, which breaks YAML indentation. To avoid it, send the file base64-encoded and compare checksums:

```bash
echo <base64 of the file> | base64 -d > docker-compose.yml && sha256sum docker-compose.yml
```

### Start, and create the owner straight away

**Wait until the DNS record exists.** Otherwise, Traefik requests a certificate for a name that doesn't resolve.

```bash
docker compose up -d
```

🧑 **Be ready to act right away.** Until you create the owner, anyone who opens the URL could create it instead. Open `https://n8n.example.com`, create the owner with a strong password, and turn on two-factor login.

**Verify** 🤖:

```bash
curl -s -o /dev/null -w '%{http_code}\n' https://n8n.example.com/healthz
curl -s https://n8n.example.com/rest/settings | grep -o '"showSetupOnFirstLoad":[a-z]*'
```

You want `200`, and `showSetupOnFirstLoad` should be `false` once the owner exists.

**Back up the key:**

```bash
(umask 077; mkdir -p /root/backups/n8n; cp -p /apps/n8n/.env /root/backups/n8n/env-$(date +%Y%m%d))
```

🧑 **Also save `N8N_ENCRYPTION_KEY` off the server**, in your password manager. Without it, the stored credentials can't be read.

A harmless log line you may see: `Failed to start Python task runner…`. It doesn't matter if your workflows don't use Python.

---

## 18. Move workflows and credentials to production

Skip this if you create everything directly on the VPS. Import only what production needs. Don't copy the whole database, or you bring along test data and unrelated workflows.

**⚠️ Export from the live n8n, not from the repo's JSON files.** The repo holds placeholders, while the live workflow holds the real verify token and config.

### 1. Export on your Mac

```bash
mkdir -p ~/n8n-move && chmod 700 ~/n8n-move
```

```bash
docker exec n8n sh -c 'umask 077; n8n export:workflow --id=<id> --output=/tmp/agent.json; for id in <credential ids>; do n8n export:credentials --id=$id --decrypted --output=/tmp/cred-$id.json; done'
```

Copy each file out with `docker cp n8n:/tmp/<file> ~/n8n-move/`, and delete them from the container. **`cred-*` files hold your keys in plain text**, so never commit or share them.

```bash
tar -C "$HOME" -czf "$HOME/n8n-move.tgz" n8n-move && shasum -a 256 "$HOME/n8n-move.tgz"
```

### 2. Upload

🤖 First create a private folder on the VPS:

```bash
(umask 077; mkdir -p /root/n8n-move-in)
```

🧑 Then upload it from your Mac, which needs your VPS password:

```bash
scp ~/n8n-move.tgz root@<VPS_IP>:/root/n8n-move-in/
```

Compare the checksum on the VPS. Don't paste the file through a terminal, since that would pass your secrets through Claude.

### 3. Import on the VPS

The owner has to exist first.

```bash
cd /root/n8n-move-in && tar -xzf n8n-move.tgz && cd n8n-move && for f in *.json; do docker cp "$f" n8n:/tmp/"$f"; done
```

```bash
docker exec -u root n8n sh -c 'chown node /tmp/*.json; chmod 600 /tmp/*.json' && docker exec n8n sh -c 'for f in /tmp/cred-*.json; do n8n import:credentials --input=$f; done; n8n import:workflow --input=/tmp/agent.json'
```

`tar: Ignoring unknown extended header keyword 'LIBARCHIVE.xattr…'` is harmless Mac metadata. The credentials get re-encrypted with the VPS key.

### 4. Publish and restart

```bash
docker exec n8n n8n publish:workflow --id=<id> && cd /apps/n8n && docker compose restart n8n
```

### 5. Delete every plain-text copy

On the container and the VPS:

```bash
docker exec -u root n8n sh -c 'rm -f /tmp/*.json'; rm -rf /root/n8n-move-in
```

On your Mac:

```bash
rm -rf ~/n8n-move ~/n8n-move.tgz
```

### 6. Test the webhook

Quote the URL, since `?` breaks in zsh otherwise. We lost a test run to that.

```bash
curl -s -o /dev/null -w '%{http_code}\n' -G --data-urlencode 'hub.mode=subscribe' --data-urlencode 'hub.verify_token=wrong' --data-urlencode 'hub.challenge=1' 'https://n8n.example.com/webhook/<path>'
```

A wrong token should get **403**. The real token should echo the challenge with **200**.

### Credentials shared with development

If you keep development on your Mac, keep separate credentials for it. If you reuse the names, updating the production login would break your local tests. We saved copies as `CRM login (dev)` and repointed the development workflows.

---

## 19. Connect the Meta webhook

**Use cases → Customize → Step 2. Production setup → Configure Webhooks:**

1. 🤖 **Callback URL:** `https://n8n.example.com/webhook/<path>`
2. 🤝 **Verify token:** the value in your workflow's verification node. Claude can put it on your clipboard without printing it, and you paste it. To change the callback later, you must **re-enter the token**, because **Verify and save** stays disabled otherwise.
3. 🧑 Click **Verify and save**. Meta calls your GET route to check.
4. 🤖 Further down, under **Webhook fields**, turn on **`messages`** only, at the latest version.
5. 🤖 Under **Register your WhatsApp phone number**, turn on **Subscribe webhooks** for your account.

**You need both switches: the field and the account subscription.**

**Test Meta's connection** 🤖: on the `messages` row, click **Test**, then **Send to server**. A successful run in n8n proves Meta can reach you. Check that the sample's fake `phone_number_id` gets filtered out, as in [Part 9](#normalizing-the-message), so it doesn't touch production data.

**Confirm from the API:**

```bash
curl -s -H "Authorization: Bearer $TOKEN" "https://graph.facebook.com/v23.0/$PHONE_NUMBER_ID?fields=status,webhook_configuration"
```

---

## 20. Publish and run the first real test

### Before you publish

Once published, real messages reach the workflow. **If something's missing, people get silence**, so check:

- [ ] Backend routes deployed (Part 11)
- [ ] Production logins in n8n credentials
- [ ] `solutionId`, `phoneNumberId` and `notifyNumbers` set for production
- [ ] Team alert template approved
- [ ] System user has all three assets (Part 16)
- [ ] Real test send worked
- [ ] Verification and `messages` subscription done

### Publish

🧑 **Left menu → Publish → Publish.** The menu then shows **Published**, and **Alert Inbox** shows "switched to live mode". Meta only sends real webhooks to a live app ("some webhooks will not be sent if your app is in Dev mode"). While unpublished, the **Test** button is all you'll get.

### The first real test

Send from a number that **isn't** in `notifyNumbers`, since the agent ignores those. Then trace it:

| Symptom | Where the problem is |
|---|---|
| No run in n8n, one tick | Message isn't reaching the number |
| No run in n8n, two ticks | Meta isn't forwarding: check the app is live, permissions and subscription |
| Run stops at a CRM or product node | Login, route or `solutionId` |
| Run stops at OpenAI | Key or model |
| Run stops at **WhatsApp · Enviar texto**, lead created, gray ticks | Token permissions (Part 16) |
| Reply arrives, blue ticks | ✅ Working |

**Use the run list to read this quickly** 🤖. Ask Claude:

```text
List the last runs with status, step count and failing nodes. Don't print message contents or secrets.
```

A healthy reply run in our case: **33 nodes, 2 sends, no errors**, followed by small 3-node runs for each delivery status.

---

## 21. After launch

**Do these in the first days:**

- [ ] **Rotate anything that passed through chat:** tokens, API keys and passwords. Generate new ones, update n8n, then revoke the old ones.
- [ ] **Test a real handoff** end to end, including the team alert reaching the phone. **Not validated** in our launch.
- [ ] **Save the n8n key** off the server.
- [ ] **Back up the `n8n_data` volume** on a schedule. We hadn't set this up at launch.
- [ ] **Check file permissions:** `chmod 600` on `.env` files holding secrets. We found one readable by all users.
- [ ] **Add webhook signature checks** (Part 22).
- [ ] **Turn off the old instance:** unpublish the workflow on your Mac after the VPS passes the test.

**Scheduled and marketing workflows stay off until the agent has proven stable.** Our checkout recovery workflow is built, but it isn't active in production: **Not validated.** It should skip events older than 6 hours, so a first run doesn't send late reminders.

---

## 22. General tips and best practices

### Grouping messages to save money

Grouping happens in **two different places** for **two different costs**:

| What | Saves | How |
|---|---|---|
| **Group incoming messages** | **OpenAI**: one call for several messages | Wait, and let only the newest run answer ([Part 9](#grouping-quick-messages)) |
| **Limit outgoing messages** | **Meta**: fewer billed messages | Answer in fewer messages |

**Our 5-second wait only groups quick bursts.** Someone typing slowly still triggers two AI calls. A longer wait (8–15 s) saves more but feels slower, so test it with your audience.

**Limit outgoing messages to 1–3.** Splitting looks human, but each delivered message counts toward Meta's billing. Use 3 only when it reads better; one or two is often enough. If volume grows past the free tier, this limit has a direct cost.

### What Meta charges for

From [Meta's pricing page](https://developers.facebook.com/documentation/business-messaging/whatsapp/pricing), read on 2026-11-09. **Rates vary by country and change, so check them.**

| Message | Cost |
|---|---|
| **Free-form reply** (service) | **1,000 free per month per number**, then charged per delivered message. Only possible inside the 24-hour window |
| **Utility template in the window** | **Charged again since Oct 1, 2026.** It had been free |
| **Utility template outside the window** | Charged |
| **Marketing template** | Charged per delivered message |
| **Authentication template** | Charged per delivered message |
| **Anything in a free entry point window** | Free for up to 7 days after a Click-to-WhatsApp ad on Android or iOS |

**The window:** 24 hours, reset each time the customer messages or calls you. Outside it, you can only send templates.

**Practical advice:**
- **Run ads with Click-to-WhatsApp** if you can. The free entry window also covers your marketing and utility messages for up to 7 days.
- **Check whether the window is open** before a paid template. Inside it, a free-form message can be cheaper.
- **Without a payment method**, service messages stop being delivered when the free tier runs out.
- **Your bigger cost may be AI.** We sent about 21k input tokens per reply. Track both.

### Making it feel natural

| Technique | Value we used | Why |
|---|---|---|
| Wait before answering | 5 s | Avoids instant bot replies and groups messages |
| Mark as read + typing | On | Looks like a person who's seen it |
| Typing time per message | 1.5 s + 35 ms per character, 7 s at most | Longer text "takes" longer |
| Short messages | 1–3, one question | WhatsApp style |
| Natural handoff text | No "transferring you" wording | Sounds like a colleague stepping in |
| Silence during human attendance | Always | AI and a person must never both answer |
| Say it's virtual if asked | Always | Honest |

**Keep the typing delay under 25 seconds per message**, since Meta clears the indicator after that.

### Which model to use

**Our choice:** `gpt-5.4-mini` with `reasoning_effort: low`.

- **A small model is enough** when the answer is in the document and the output is structured.
- **Check what your key can use.** A model name someone tells you may not exist on your account. "4.5 mini" didn't exist on ours, so we chose from the key's model list.
- **It must support strict structured output** (`json_schema`), or you'll parse free text and break more often.
- **Prompt the same way across models, but read each model's rules.** `gpt-5.4-mini` rejected `max_tokens` and needed `max_completion_tokens`. With reasoning on, it only accepted the default temperature. Reasoning counts toward the token limit, so we set 6000. Models without reasoning, such as `gpt-4o-mini`, leave `reasoning_effort` out.
- **Keep the model in `Config`,** so changing it is one value.
- **Compare with real questions** before switching. Results from 30–50 questions beat any benchmark.

### Do you need RAG?

**Probably not at first.** Decide by size:

| Knowledge size | Approach |
|---|---|
| **Up to about 30–50 pages** | Full document in the prompt, with caching. **This is what we did** |
| **Hundreds of pages or many products** | Consider RAG |
| **Data specific to one customer** | Neither. Use live API calls |

**Why full context works:** the model sees everything, while RAG can fetch the wrong passage or miss one, and it adds a system to maintain.

**To keep the cost down:**
- Keep the instructions and knowledge first and unchanged, so OpenAI's automatic prompt cache applies.
- Limit the history. We send 30 events.
- Cut the document before reaching for RAG. Sending only relevant sections could save the most, but it may lower quality and reduce cache hits.

### Reliability

- **Answer the webhook at once**, then do the work. Meta expects a `200`, and it retries failures with decreasing frequency for up to 7 days.
- **Expect duplicates.** Retries can deliver the same message twice, so skip a `wamid` you've already handled. **We didn't add explicit deduplication; add it.**
- **Filter statuses early** so they don't run the expensive path.
- **Retry the AI and send nodes.** Let non-essential calls continue on error.
- **Prune executions** (`EXECUTIONS_DATA_MAX_AGE`).
- **Don't let the agent depend on your laptop.** ngrok is fine for development only.
- **One number, one webhook URL.** Several agents on one number need a router in front.
- **Pin image versions** in production.

### Security

- **Verify `X-Hub-Signature-256`.** Anyone who finds your webhook URL can otherwise send fake messages and spend your AI budget. Each POST carries `sha256=…`, computed from the payload with your **App Secret**. To check it, n8n needs the raw body. **We skipped this at launch; do it before heavy traffic.**
- **Keep secrets only in n8n credentials or server `.env` files.** Never in generators, repos or chat.
- **Limit each system user's access.** Note that Meta's "Everything" level is what sending required for us, so replace that token if it was ever exposed.
- **Rotate after any exposure.**
- **Give the agent user limited API permissions** on your backend.
- **Decrypted exports are temporary.** Delete them right after import and check that they're gone.
- **Use `read -rs` for passwords** and hash them inside the container.

### Conversation rules

- **Only link what's in the knowledge base.** Or better, insert links in the workflow.
- **Respect opt-outs permanently,** and include an opt-out line in marketing templates.
- **Don't let the model promise later actions.** "I'll send it to you" with nothing to send it creates dead ends.
- **Ineligible leads:** explain kindly and hand off instead of refusing outright.
- **Check before reminders:** already paid? Opted out? Person attending? Already sent? Wrote recently? Our recovery workflow checks all of these.

### Working with Claude Code

- **Ask short questions when you only need a decision:** "Just reply me: do I need a RAG? Don't extend."
- **Give it real failures:** the node's name, the message you sent and the error.
- **Ask for proof, not reassurance:** "Show the run", "Compare old and new outputs".
- **Say what needs approval** at the start: commits, merges, activating workflows.
- **Commit only when you say so,** on your dev branch.
- **Temporary test workflows** are useful. Ask Claude to name them clearly and delete them afterward.
- **Tell it about the things you edit by hand** so it merges rather than overwrites.
- **If a browser action is blocked,** let it tell you which click is left. Don't push it to work around a safety check.
- **Have it check the result after you act.** In our launch, a check right after "Saved" still showed the old callback URL, and a second look confirmed the new one.

---

## 23. Troubleshooting: real errors and their causes

| Symptom | Cause | Fix |
|---|---|---|
| `Found credential with no ID` on a node | The credential doesn't exist in this n8n | Create it with the exact name, or import it with its fixed ID |
| Credential "saved" but n8n still can't find it | It didn't reach this n8n; a different instance is the likely reason | Check you're in the right instance, then check again |
| Every message goes to a human | The AI call is failing, and failure means handoff by design | Check the AI node's run for a missing key or wrong model |
| Replies come from the wrong agent path | A test left `aiAgent: "suporte"` on the CRM conversation | Reset the test conversation |
| Agent goes silent at the decision node after a handback | Not a failure: the conversation was marked opted out, and "give back to AI" doesn't clear an opt-out | Check `optedOut` on the conversation; clear it deliberately if it was a mistake |
| The model lists invented or wrong codes | Model noise | Keep only values matching the expected pattern, like `PRD-01` |
| `max_tokens` rejected | Model needs `max_completion_tokens` | Change the parameter |
| Temperature rejected | Reasoning models only accept the default | Don't send it |
| "Mensagem ignorada" in development | Number isn't in `allowedNumbers` | Add it, with or without the 9th digit |
| Webhook won't verify | Wrong token, or workflow not published | Compare the token, publish and restart n8n |
| Test webhook works, real messages don't arrive | App not live, or permissions missing | Publish; check Part 16 |
| `(#10) Viewer cannot access the provided Paid Message Account` | No Messaging account access | Assign the system user to it |
| `(#10) …granular permission for sending messages` | Only view-only template access | Grant **Everything** on the Messaging account |
| `(#10) Application does not have permission` on the profile | Partial access | Same; it worked after Everything |
| `Object with ID … does not exist` reading the account | The token can't see that account | Assign the Messaging account |
| Lead created, no reply, gray ticks | Send and read calls failing on permissions | Open the send node's run and read the error |
| "Esta pessoa não está mais no WhatsApp" | Seen on a phone with an old chat with that number | Test from another phone; cause unconfirmed |
| Template text breaks when typed | Editor auto-numbers variables | Type `{{` and let it number them |
| **Verify and save** disabled | Token not re-entered | Paste the verify token again |
| `.yml` errors after typing through a terminal | macOS double-space substitution | Send it base64-encoded and compare checksums |
| Upload option disabled in the terminal app | App needs its window in front, or other conditions | Use `scp` |
| `no matches found` from `curl` in zsh | Unquoted `?` in a URL | Quote the URL |
| Can't read imported file in the container | Root owns it | `docker exec -u root n8n chown node /tmp/file.json` |
| Workflow doesn't respond after import | Not published or not restarted | `publish:workflow`, then restart |
| Build killed with exit 137 | Docker ran out of memory during an amd64 build | Give the Docker VM more memory for the build |
| Production insert fails with invalid enum | Migration not deployed | Deploy the backend first |

---

## 24. Reusable Claude Code prompts

**Start**

```text
Read <reference project>/docs/agents-integration/n8n (generator, README, templates) as the example.
I want the same kind of agent for <product>. Flow: <paste>. Ask me only what you can't work out.
Summarize your plan and the differences before building.
```

**Knowledge base**

```text
Generate a knowledge base from the seeds, code and FAQ. It's the source of truth for the agents.
All data must match how the system really works, with no technical details for the end user.
Give me Markdown. Then verify every entry against the code.
```

**Gaps**

```text
Based on the flow and the routes in <repos>, list what the workflow must call, in a table with
when it's called and which route. Spec the gaps. Don't implement yet.
```

**Workflow**

```text
Create the workflow generator following the first brief in this guide. Use clear variable names.
Add a README that describes each step and the setup.
```

**Debugging**

```text
The workflow stops at node "<name>" when I send "<message>". Read the run, find why and fix it.
Show me which values caused it, without printing secrets.
```

**Meta setup**

```text
Open my browser using Claude in Chrome. Check what's missing for the WhatsApp Cloud API in app <name>:
number, display name, templates, payment, webhook, system user. Show a table and change nothing yet.
```

**Templates**

```text
Create templates from this workflow's reminders and alerts, one with a segment variable.
Submit them in the real WhatsApp account, not the test account. Save the texts to the repo.
```

**System user**

```text
Create the system user with access to the app, the WhatsApp account and the Messaging account.
Stop at token generation; I'll paste it directly into n8n. Then verify it with a read and a test send to <my number>.
```

**Move to the VPS**

```text
Read the setup of both machines, then give me the migration steps. Don't copy the whole database.
Keep the current instance live until I switch the callback.
```

**Launch trace**

```text
I sent a message. Trace the run step by step on the VPS, reporting status and failed nodes only.
```

**Security pass**

```text
Check that no secrets are in the repo, generated files, shell history or temp files.
List everything that was exposed in this chat, so I can rotate it.
```

---

## 25. Launch checklist

**Accounts**
- [ ] Verified business portfolio
- [ ] Dedicated production number, and a separate development number
- [ ] New Meta app with the WhatsApp use case
- [ ] Privacy Policy URL and category set

**Backend**
- [ ] Routes deployed, confirmed with `401` instead of `404`
- [ ] Database and `.env` backed up before migrations
- [ ] Agent user created in each system
- [ ] Integrations turned on and checked in logs

**Meta**
- [ ] Number **Registered** and **Connected** in the real account
- [ ] Templates approved
- [ ] Payment method added
- [ ] System user with app, WhatsApp account **and** Messaging account access
- [ ] Token created after that, and stored only in n8n
- [ ] Callback verified on the production URL
- [ ] `messages` field on, **Subscribe webhooks** on

**n8n**
- [ ] VPS instance on a pinned version, with HTTPS
- [ ] Owner with two-factor login
- [ ] Encryption key saved off the server
- [ ] Credentials imported and encrypted
- [ ] Production config complete: IDs, numbers, `restrictToAllowed`
- [ ] Only the intended workflows active
- [ ] Execution pruning on

**Tests**
- [ ] Wrong verify token gets 403, right one gets the challenge
- [ ] Meta's **Test** webhook reaches n8n
- [ ] Real send from the API arrives
- [ ] App published
- [ ] Real message gets a reply, with no failed nodes
- [ ] Handoff reaches the team's phone
- [ ] Opt-out stops messages
- [ ] 30–50 real questions checked against the knowledge base

**Afterward**
- [ ] Rotated all secrets that passed through chat
- [ ] Webhook signature check added
- [ ] Message deduplication added
- [ ] Volume backups scheduled
- [ ] Old instance's workflow unpublished
- [ ] Meta and AI costs reviewed after the first week

---

## Sources

- [Meta: WhatsApp pricing](https://developers.facebook.com/documentation/business-messaging/whatsapp/pricing)
- [Meta: Webhooks overview](https://developers.facebook.com/documentation/business-messaging/whatsapp/webhooks/overview)
- [Meta: Getting started with webhooks](https://developers.facebook.com/docs/graph-api/webhooks/getting-started)
- [Meta: Templates overview](https://developers.facebook.com/documentation/business-messaging/whatsapp/templates/overview)
- [Meta: Typing indicators](https://developers.facebook.com/documentation/business-messaging/whatsapp/typing-indicators)
