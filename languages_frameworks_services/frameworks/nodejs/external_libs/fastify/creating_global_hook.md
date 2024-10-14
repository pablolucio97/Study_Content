# USING HOOKS ON FASTIFY

Hooks can be used globally or for a specific set of routes. They can execute a function as middleware when an error or another server event occurs, and must be called before the execution of the route. 

**Example**: 

Global middleware hook that logs the current method and route path of each route in the whole application:

`app.addHook('preHandler', async (req, res) => { console.log(`[${req.method}] ${req.url}`) })`
