# Kong API Gateway

## Definition

Kong is an open source API gateway that has additional resource and it proxies (acts an intermediary) between the user request and the available services routing the user request to the correct service according to the request route.

## Kong characteristics
- Is open source
- Is a microgateway
- Allow Kubernetes integration easily
- Allow plugins

## Kong API Gateway flow:

<img src='https://i.ibb.co/MkCY69c/Screenshot-2024-06-12-at-07-14-50.png'/>


## Deployment models

**DB Less** In this model the source of truth is the declarative YAML or JSON file that includes all the configurations parsed in memory required to Kong starts.
**With database** In this model the source of truth is the shared database (generally PostgresSQL) that is a required dependency to Kong starts. Every Kong node must be in the same cluster.


## Deplyment types
**Hybrid deployment** This is the most recommended deployment type because all requests bump on Kong (control plane) first touch your nodes. In this model we have one control plane and one data plane for each node.
**Distributed deployment** This is type of deployment each node can bump on the database simultaneously. Its not recommended because the requests can charge the instance's resources.

## General tips
- Each node is an API/service.
- Always as possible work with hybrid deployment.