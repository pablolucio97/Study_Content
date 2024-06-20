# Kong API Gateway

## Definition

Kong is an open source API gateway that has additional resource and it proxies (acts an intermediary) between the user request and the available services routing the user request to the correct service according to the request route.

## Kong characteristics
- Is open source
- Is a microgateway
- Allow Kubernetes integration easily
- Allow plugins

### Kong API Gateway flow:

<img src='https://i.ibb.co/MkCY69c/Screenshot-2024-06-12-at-07-14-50.png'/>



## Deployment models

**DB Less** In this model the source of truth is the declarative YAML or JSON file that includes all the configurations parsed in memory required to Kong starts.
**With database** In this model the source of truth is the shared database (generally PostgresSQL) that is a required dependency to Kong starts. Every Kong node must be in the same cluster.

## Deployment types
**Hybrid deployment** This is the most recommended deployment type because all requests bump on Kong (control plane) first touch your nodes. In this model we have one control plane and one data plane for each node.
**Distributed deployment** This is type of deployment each node can bump on the database simultaneously. Its not recommended because the requests can charge the instance's resources.

## Konga
Is the Kong dashboard that allows the user to visualize instance's metrics and user's controls.

### Konga request flow

![img](https://i.ibb.co/2c7cD16/Screenshot-2024-06-20-at-08-20-35.png)

**Downstream**: is the client consumer.
**Proxy**: is the request handler that redirects the request to the corresponding backend.
**Upstream**: is the service, the backend.

### Installing Kong and Konga

To install Kong, visit the instructions on: [Kong docs](https://docs.konghq.com/gateway/latest/install/docker/#install-kong-gateway-with-a-database)

To install Konga, clone the [Konga repository](https://github.com/pantsel/konga), install the dependencies using Node version 12 and run `npm start` to start the application. The Konga dashboard will be available at 1337 port.


### Using Konga

1. Create your connection.

2. Create a new service that must receive the same name of the container on your docker-compose file.

3. Create a new route to bind your service to the Konga's proxy.


### Konga Plugins

Plugins can be used on services, routes, consumers and globally, and are useful to manage rate limiting, requests identification and so on.

Adding a new plugin:
1. Go to [KongaHub](https://docs.konghq.com/hub/) and search for your plugin. Read the plugin documentation to understand how it works.
2. On your Konga dashboard, click on "Plugins" to add a new plugin globally or click on a service and then add a new plugin to it.
3. Select the plugin category, select the plugin, and define it configurations.

The most used Konga's plugins are: 
- CorrelationID: Adds a new header allowing to identify the request by an generated UUID. Generally it is configured globally.
- RateLimitingIp: Define the maximum allowed request that your service can receive. Generally it is configured by service.
  
## General tips
- Each node is an API/service.
- Always as possible work with hybrid deployment.
- At adding a new plugin into a service, define the rules based on each instance (local).
- At adding a new plugin, always hide the information on client headers to avoid hackers get information about your rate limits, timeout and etc.
- Avoid using heavy response formatters if you want to use Response Transformer plugin because it can consume a lot computational resources.