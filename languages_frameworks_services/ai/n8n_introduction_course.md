# N8N Introduction Course

## General Concepts

**N8N**: n8n is a digital automation platform that allows you to build, test and deploy AI agents with minimal or not coding.

**AI Agents**: AI agents are autonomous programs that can make decisions, perform tasks, and interact with third apps based on received instructions.

**Automation**: Automation is a set o predictable set of predetermined actions that transfers data from one point to another.


## N8N concepts
**Trigger** It's an event. It's used to call next block/actions. It will initiate or launch your workflow.
**Nodes** Nodes are building blocks that contains your instructions.
**Workflow** It's a set of connected nodes that defines your automation logic.
**Filtering** It's a filter that allows a block proceed or not to the next workflow point.
**Actions** Tasks you want to perform with a piece of data, such as Get, Send, Update, or Delete.
**Apps** It can be any official associated app to n8n. Examples: Notion, Slack, and so on.
**Functions Apps** It can be any function available in an official third app connected to n8n. Examples: A Google Sheet function to delete a row.

## Types of triggers
- **Manual**: It's fired manually to test or execute workflows on demand.
- **Scheduled**: It's fired by a schedule on specific day and date. Ex: Every Friday, every 1 hour, every Monday 5PM.
- **Instant**: It's instantly fired based on some event. Ex: On form submission, on Google Sheet property updated.

## Types of nodes
- **Entry point**: It's the first node of your workflow, the trigger node.
- **Function**: It's a node that executes an actions app function.
- **Exit point**: It's the last node of your workflow. It should be executed to tell your workflow was executed successfully.

## Useful Nodes
- **HTTP Request**: Send or receive data via APIs.
- **Set**: Define or update data within the workflow.
- **IF**: Add conditional logic to control the flow.
- **Webhook**: Receive real-time data from external sources.
- **Merge**: Combine data from multiple branches.
- **Code**: Add custom JavaScript for advanced logic.
- **Wait**: Pause workflow execution for a defined duration.
