# Claude course

## Introduction
Claude is an AI assistant developed by Anthropic. It is designed to be helpful, harmless, and honest. Claude can assist with a wide range of tasks, including answering questions, generating text, and providing explanations. This course will guide you through the basics of using Claude effectively.

## General concepts
- Harness: Harness is a tool that allows you to interact with Claude in a structured way. It provides a user-friendly interface for sending prompts and receiving responses from Claude. It's a software layer that puts the LLM inside a loop, allowing you to interact with it in a more controlled manner. You can send files, ask questions, and receive answers in a conversational format.

## MCP, Skills, Commands, and Connectors
These four concepts are the main ways to extend what Claude can do. In short: **MCP** gives Claude new tools, **Connectors** are ready-made MCP integrations, **Skills** teach Claude how to do a task, and **Commands** are shortcuts you trigger yourself.

### MCP (Model Context Protocol)
MCP is an open standard that lets Claude talk to external systems. An **MCP server** exposes tools (actions like `query_database` or `create_issue`) and resources (data like files or records), and an **MCP client** (Claude Code, Claude Desktop) connects to it. Think of it as a "USB-C port" for AI: any app that implements MCP can be plugged into Claude.

How to use:
1. Add a server in the terminal with `claude mcp add <name> -- <command>` (local) or `claude mcp add --transport http <name> <url>` (remote). Add `--scope project` to save it in `.mcp.json` and share it with your team.
2. Run `/mcp` inside Claude Code to check if the server is connected and to authenticate if needed.
3. Ask in natural language. Claude picks the right MCP tool and asks for permission before using it.

Real use cases:
- Connect Claude Code to a local PostgreSQL database and ask: "How many users signed up last week?" — Claude calls the MCP tool that runs the SQL query.
- Connect a Playwright MCP server so Claude can open a browser, navigate your app, and check if a page works.

Simple example:
```bash
claude mcp add postgres -- npx -y @modelcontextprotocol/server-postgres postgresql://localhost/mydb
```

### Skills
A skill is a folder with a `SKILL.md` file containing instructions (and optionally scripts or templates) that teach Claude **how** to perform a specific task. Only the skill's name and description are loaded at first; Claude reads the full instructions **automatically** when a request matches the description, so skills don't waste context.

How to use:
1. Create a folder in `.claude/skills/<skill-name>/` (project) or `~/.claude/skills/<skill-name>/` (personal, available in all projects).
2. Add a `SKILL.md` file with a `name`, a clear `description` saying **when** to use it, and the instructions below the frontmatter.
3. Just make a normal request. Claude loads the skill when it matches, or you can call it directly with `/<skill-name>`.

Real use cases:
- A `commit-messages` skill that makes Claude always write commits following Conventional Commits.
- A `brand-guidelines` skill that makes every document or slide Claude creates use the company colors, fonts, and tone.

Simple example (`.claude/skills/commit-messages/SKILL.md`):
```markdown
---
name: commit-messages
description: Use when writing git commit messages.
---
Follow Conventional Commits: `type(scope): short description`.
Allowed types: feat, fix, docs, chore, refactor, test.
```

Native skills that come with Claude Code (call them with `/<skill-name>`):
- **Project setup and config**
  - **init**: creates a `CLAUDE.md` file documenting your codebase.
  - **update-config**: changes Claude Code settings (`settings.json`), like permissions, env vars, and hooks.
  - **fewer-permission-prompts**: scans past sessions and adds common safe commands to an allowlist so Claude asks for permission less often.
  - **keybindings-help**: customizes keyboard shortcuts.
- **Code quality**
  - **code-review**: reviews the current changes or a PR for bugs and cleanups (with `--fix` to apply them).
  - **simplify**: reviews changed code for reuse, simplification, and efficiency, then applies the fixes.
  - **security-review**: runs a security review of the pending changes on the branch.
- **Running and automating**
  - **run**: launches your app to see a change working (CLI, server, browser, etc.).
  - **loop**: runs a prompt repeatedly on an interval (for example, check a deploy every 5 minutes).
  - **schedule**: creates cloud agents that run on a cron schedule, or once at a set time.
  - **workflow-authoring**: reference for writing multi-agent workflow scripts.
- **Claude API**
  - **claude-api**: reference for building with the Claude API and SDK (models, pricing, tool use, caching).
- **Visual output (Artifacts)**
  - **artifact-design**: design guidance for creating HTML pages (Artifacts).
  - **artifact-diagramming**: how to draw clear diagrams inside Artifacts.
  - **artifact-capabilities**: lets an Artifact save data, be shared, or ask Claude questions.
  - **dataviz**: rules for good charts, dashboards, and color palettes.
  - **design**: creates a visual design canvas (mockups, landing pages, posters) that you can edit by hand.

### Commands
Commands (slash commands) are shortcuts you type with `/` to trigger an action or a saved prompt. There are built-in commands (`/init`, `/clear`, `/model`) and custom commands, which are Markdown prompt files you invoke **manually**. Unlike skills, a command runs only when you call it.

How to use:
1. Type `/` in Claude Code to see all available commands.
2. To create a custom one, add a Markdown file to `.claude/commands/` (project) or `~/.claude/commands/` (personal). The file name becomes the command name.
3. Run it with `/<command-name>` followed by optional arguments, which replace `$ARGUMENTS` in the file.

Real use cases:
- `/init` to generate a `CLAUDE.md` file describing your project.
- A custom `/review-pr` command that runs the same review checklist every time.

Simple example (`.claude/commands/explain.md`, used as `/explain src/app.ts`):
```markdown
Explain what $ARGUMENTS does in simple terms, listing its main functions.
```

### Connectors
Connectors are **pre-built MCP integrations** for popular apps (Gmail, Slack, Notion, GitHub...) that you enable with a few clicks in Claude's settings and authenticate via OAuth. You get MCP's power without installing or configuring any server.

How to use:
1. On claude.ai, go to **Settings > Connectors**, choose the app, and click **Connect** to log in with your account.
2. In a chat, turn the connector on or off from the tools menu.
3. Ask in natural language. Claude asks for confirmation before write actions like sending an email.

Real use cases:
- "Summarize my unread emails from today" using the Gmail connector.
- "Create a Notion page with the notes from this conversation" using the Notion connector.

See the [Connectors](#connectors) section below for the most used connectors and what each one can do.

### Agents

Agents are **autonomous entities** within Claude that can perform tasks, make decisions, and interact with tools, connectors, and subagents. They are capable of handling complex workflows and can operate independently or collaboratively to achieve goals.

How to use:
1. Define an agent with a specific role or objective.
2. Claude automatically manages the agent's lifecycle, context, and interactions.
3. Agents can spawn subagents, use tools, and leverage skills to accomplish tasks.

Real use cases:
- An agent that manages project tasks, delegating specific actions to subagents.
- An agent that monitors incoming emails and takes appropriate actions based on predefined rules.

Creating an agent:
1. Define the agent's role, objectives, and any initial context or instructions. Example yaml:
```
name: Project Manager
description: Manages project tasks and delegates to subagents.
objectives:
  - Track project progress
  - Delegate tasks to subagents
tools:
  - name: Task Delegator
    description: Delegates tasks to subagents based on project progress.
```
2. To call the agent, you can use a command or prompt that specifies the agent's role or objective. Example: @Project Manager

Agents can be global or local (per project).

### Subagents

Subagents are **smaller, specialized agents** that Claude can spawn to handle specific parts of a task. They allow Claude to break down complex tasks into manageable pieces, work in parallel, and reduce token usage by isolating context. Subagents are managed by an orchestrator within Claude, which handles their lifecycle, context, and communication.

How to use:
1. Define a subagent with a clear purpose and scope.
2. Claude automatically creates and manages subagents as needed during a conversation.
3. Each subagent can interact with tools, connectors, and skills independently.

Real use cases:
- A subagent that handles email summarization while another manages calendar scheduling.
- A subagent that queries a database while another generates a report based on the results.

### Agent teams

An agent team is the **parallel** evolution of subagents: instead of one specialist running after the other, an **orchestrator** fires several subagents at the same time over the same problem, waits for all of them, and synthesizes a single unified answer. Sequential specialists that would take around 6 minutes can finish in about 2 minutes when they run in parallel.

How the orchestrator coordinates:
1. **Analyze the task**: break the problem into independent subtasks.
2. **Select the agents**: pick the most suitable ones based on their descriptions.
3. **Fire in parallel**: invoke them all at once through the Task tool.
4. **Wait for the results**: the slowest agent sets the pace, and a failure in one does not block the others.
5. **Synthesize**: consolidate the outputs, remove duplicates, and prioritize.
6. **Deliver**: produce the final report in a fixed format (critical, warnings, approved).

Coordination patterns:
- **Fan-out** (most common): the orchestrator fires N agents in parallel and consolidates one synthesis. Use it when the task has independent dimensions, like security, quality, and tests.
- **Pipeline**: A1 → A2 → A3, where each stage enriches the previous output. Use it when each agent depends on the one before (lint, test, build, deploy).
- **Cross review**: A does the work, B reviews A, C reviews B — like a relay race, good for catching mistakes the author cannot see.
- **Dynamic specialist**: the orchestrator analyzes the problem and decides at runtime which agents to call. Use it when you have a pool of agents and don't know in advance which ones are needed.

Example 1 — pull request review team (fan-out with 4 agents):
The orchestrator receives the diff and fires `security-review`, `quality-review`, `test-validator`, and `docs-checker` in parallel, then consolidates everything into one report.

```markdown
---
name: pr-review-orchestrator
description: Coordinates the pull request review team.
tools: Task
---
Execution protocol:
1. Receive the diff.
2. Fire in parallel: security-review, quality-review, test-validator, docs-checker.
3. Wait for all of them to finish.
4. Consolidate in this format:
   - 🔴 Critical: must be fixed before merging
   - 🟡 Warnings: should be improved
   - ✅ Approved: checks that passed
```

The `orchestrator.md` file is the brain of the team: it defines who to call, in which order, and how to consolidate the results.

Example 2 — refactoring team (mixing patterns):
1. **Initial analysis**: the orchestrator reads the module, identifies the patterns to improve, and decides which agents to call.
2. **Parallel phase**: three simultaneous agents — one plans the new structure, one refactors the code, one writes the tests.
3. **Validation**: the orchestrator waits for all three and checks that the tests pass on the new structure.
4. **Cross review**: a security agent receives the refactored code and checks that the refactoring did not introduce vulnerabilities.
5. **Final report**: what changed, tests passing, vulnerabilities checked, plus a summarized diff.

Best practices:
- Keep each agent focused on a **single domain**.
- Define the output format explicitly, so the synthesis is predictable.
- Write the `orchestrator.md` explicitly: who runs, when, and how results are merged.
- Use a faster, cheaper model (like Haiku) for simple agents.
- Test each agent individually before putting it in the team.

Common pitfalls:
- Agents with **overlapping scope** (they duplicate work and findings).
- Two agents **writing to the same file**, which causes conflicts.
- Synthesis **without a defined format**, producing an unreadable report.
- Teams that are **too large** (more than 5 agents).
- Ignoring the **token cost**: parallel agents multiply consumption.

Real use cases:
- Automated pull request pipeline with 4 agents in parallel.
- Architecture analysis from 4 different angles at the same time.
- Complete feature generation (plan, code, tests, docs) in parallel.
- Security audit with 4 simultaneous perspectives.

> Quick check: if a task has 4 steps and **each one depends on the previous result**, the right pattern is the **sequential pipeline**, not fan-out.

### Tools

Tools are **external functionalities** that Claude can call to perform specific actions or retrieve data. They can be provided by MCP servers, connectors, or other integrations.

How to use:
1. Claude automatically determines when a tool is needed based on your request.
2. You can also explicitly invoke a tool if you know its name and usage.
3. Tools can be combined with skills, commands, and subagents to accomplish complex tasks.

Real use cases:
- Using a PostgreSQL MCP server to query a database.
- Calling a weather API tool to get the current weather forecast.
- Using a file management tool to upload and organize documents.

The most used tools are the built-in tools of Claude Code:
- **Read**: reads a file (code, text, images, PDFs) so Claude can see its content.
- **Write**: creates a new file or fully overwrites an existing one.
- **Edit**: changes a specific part of a file by replacing an exact piece of text, without rewriting the whole file.
- **Bash**: runs terminal commands, like `npm test`, `git status`, or build scripts.
- **Grep**: searches for text or regex patterns inside files (for example, where a function is used).
- **Glob**: finds files by name pattern (for example, `src/**/*.ts`).
- **WebFetch**: downloads a web page and reads its content.
- **WebSearch**: searches the internet for up-to-date information.
- **Agent (Task)**: starts a subagent to handle a separate task in its own context.
- **TodoWrite**: creates and updates a to-do list to track the steps of a larger task.
- **AskUserQuestion**: asks you a question with options when Claude needs a decision to continue.
- **Skill**: loads and runs a skill.

### Summary table
| Concept | What it is | Triggered by | Simple example |
| --- | --- | --- | --- |
| MCP | Open protocol that connects Claude to external tools and data | Claude, when it needs a tool | A PostgreSQL MCP server so Claude can query your database |
| Skills | Packaged instructions that teach Claude how to do a task | Claude, automatically, when the request matches | A skill that enforces Conventional Commits |
| Commands | Shortcuts that run a built-in action or saved prompt | You, typing `/command` | `/init` to create a `CLAUDE.md` file |
| Connectors | Ready-made MCP integrations for popular apps | Claude, after you enable them in settings | Gmail connector to summarize unread emails |

## Connectors
A connector is an integration that gives Claude access to an external app (Gmail, Slack, Notion, GitHub, and so on). Once connected, Claude can read data from that app and, in most cases, also write to it — creating, updating, and sending items on your behalf. Connectors are built on MCP (Model Context Protocol), so each one exposes a set of tools that Claude can call during a conversation.

Below are the 15 most used connectors and the 3 most common use cases for each.

### Gmail
- Search and list emails: find messages by sender, subject, date, or keyword, including unread and labeled ones.
- Read and summarize threads: open a specific message or full thread and get a summary of the conversation.
- Draft, reply, and send: create drafts, answer an email in context, or forward it to someone else.

### Google Calendar
- List and search events: check what is on the agenda for today, this week, or a specific person's meeting.
- Create and update events: schedule a meeting with title, time, guests, and description, or reschedule an existing one.
- Find free slots: look for a time that works across multiple calendars before booking.

### Google Drive
- Search for files: locate documents, sheets, and slides by name, owner, or content.
- Read file content: pull the text of a Doc or Sheet into the conversation to summarize, review, or extract data.
- Create and share files: generate a new document from the chat and share it with specific people.

### Slack
- Search messages and channels: find a past discussion, decision, or link across the workspace.
- Read and summarize conversations: catch up on a busy channel or a long thread.
- Send messages: post an update to a channel or send a direct message on your behalf.

### Notion
- Search pages and databases: find notes, specs, or records without leaving the chat.
- Read and summarize pages: turn a long page into a summary or extract action items.
- Create and update pages: add a new page, meeting note, or database entry with structured content.

### GitHub
- Search code and repositories: find where a function, config, or pattern is used.
- Read issues and pull requests: summarize a PR, review the diff, or list open issues by label.
- Create and comment: open an issue, comment on a PR, or draft a pull request description.

### Jira
- Search issues with JQL: find tickets by project, status, assignee, or sprint.
- Read and summarize tickets: get the context of an issue, including comments and history.
- Create and transition issues: open a ticket and move it through the workflow.

### Figma
- Read designs and frames: pull the structure and content of a file or a specific frame.
- Extract design specs: get colors, typography, spacing, and component names for implementation.
- Summarize and comment: describe what a design does or leave a comment on a frame.

### HubSpot
- Search contacts and companies: look up a lead, customer, or account record.
- Read deals and pipeline: check deal stage, value, and recent activity.
- Create and update records: log a note, create a contact, or move a deal to the next stage.

### Canva
- Search designs: find an existing design in your workspace.
- Generate designs: create a presentation, social post, or document from a prompt.
- Export and share: get a link or exported file of a design to send elsewhere.

### Stripe
- Look up customers and subscriptions: find a customer and check their plan and status.
- Read payments and invoices: check charges, refunds, failed payments, and invoice history.
- Report on revenue: summarize payouts, MRR, or transactions for a period.

### Zapier
- Discover available actions: see which of the thousands of connected apps you can trigger.
- Run an action: send data to an app that has no native connector (for example, a CRM or a spreadsheet tool).
- Chain automations: trigger an existing Zap so a multi-step workflow runs from the conversation.

### Connector tips
- Connectors are permission-based: Claude only accesses what the connected account can access, and write actions usually ask for confirmation.
- Be specific with filters (dates, senders, projects, labels) — connectors work much better with a narrow search than a broad one.
- Combine connectors in a single request, for example: read a Linear issue, find the related GitHub PR, and post a summary in Slack.

## Strategies to reduce tokens usage:

- Use the [context-mode plugin](https://github.com/mksglu/context-mode) instead of the /compact command because the compact mode will not retain edited files, notes, and the full conversation history, which can limit Claude's ability to provide accurate and context-aware responses whereas context-mode retains the full context storing on Sqlite DB ready to be used when needed, reducing the tokens consumption and increasing the session length saving up to 90% of context.

- Use the [caveman plugin](https://github.com/juliusbrussee/caveman) to manage context efficiently and reduce token usage by storing and reusing relevant conversation snippets. Caveman was develop to reduce redundant response and optimize the conversation flow.

## General tips
- Create projects to organize your work and keep track of your tasks with Claude.
- Connectors are permission-based: Claude only accesses what the connected account can access, and write actions usually ask for confirmation.
- Be specific with filters (dates, senders, projects, labels) — connectors work much better with a narrow search than a broad one.
- Combine connectors in a single request, for example: read a Linear issue, find the related GitHub PR, and post a summary in Slack.
- Use the command /btw to make quick questions without adding it to the context.
- Use the Ralph Loop when you want to iteratively refine a response or continue a conversation with context. In this mode Claude will autocorrect and build upon previous messages until you are satisfied with the result.
- Use the [context-mode plugin](https://github.com/mksglu/context-mode) instead of the /compact command because the compact mode will not retain edited files, notes, and the full conversation history, which can limit Claude's ability to provide accurate and context-aware responses whereas context-mode retains the full context storing on Sqlite DB ready to be used when needed, reducing the tokens consumption and increasing the session length saving up to 90% of context.
- Use the [context7 MCP ](https://github.com/upstash/context7) to retrieve updated code doces about technologies and frameworks to avoid working with outdated information and to know how to do something based on an up-to-date reference.
- Use subagents at working: subagents can help break down complex tasks into smaller, manageable parts, allowing Claude to handle each part more efficiently and reduce token usage. It allows to isolate context.
- Agents can be invoked using the `@AgentName` syntax in a conversation, where `AgentName` is the name of the agent you defined.
- You can also pass parameters to the agent by including them after the agent name, for example: `@Project Manager project_deadline=2024-12-31`.
- Claude harness already is a task orchestrator, so the agents teams, subagents, and orchestrators are already integrated into the harness, allowing you to manage complex workflows and tasks seamlessly just asking naturally. Only when you want the process to be repeatable and fixed so you need to create your own orchestrator and agents teams.