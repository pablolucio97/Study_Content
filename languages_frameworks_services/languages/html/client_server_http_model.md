# CLIENT SERVER MODEL

## CONCEPTS

**HTTP**: Hypertext Transfer Protocol, is the protocol that allows communication between clients and servers, fetching data and loading resources such as HTML documents.

**SOAP**: Stands for Simple Object Access Protocol and is used for allowing messaging exchange and clients invoking web services and receiving responses over the HTTP protocol.

**P2P PROTOCOL**: A protocol where the clients can connect themselves. Example: A phone connecting to another phone via Bluetooth.

**CLIENT**: Uses the resources of the network by making requests to the server and waiting for responses.

**SERVER**: Provides resources for the client, receives, and responds to requests.

## REQUEST RESPONSE PATTERN

The request and response pattern involves the client making requests and waiting for the server to provide a response, which can include different status codes for the browser.

Main response status codes:

- **Informational responses**: (100–199)
- **Successful responses**: (200–299)
- **Redirects**: (300–399)
- **Client errors**: (400–499)
- **Server errors**: (500–599)

- **200**: The request has succeeded, and the method was called.
- **201**: Request is OK, and a new resource has been created.
- **202**: The request has been received but not yet acted upon.
- **203**: The returned metadata is not exactly the same as available from the origin server, but collected from a local or a third-party copy.
- **204**: There is no content to send for this request, but the headers may be useful.
- **205**: Tells the user-agent to reset the document which sent this request.

- **400**: The server could not understand the request due to invalid syntax.
- **401**: Unauthorized. The client must authenticate itself to get the requested response.
- **403**: Forbidden. The client does not have access rights to the content.
- **404**: The server can not find the requested resource. In browsers, this means the URL is not recognized. In an API, this can also mean that the endpoint is valid but the resource itself does not exist.
- **405**: The request method is known by the server but is not supported by the target resource.
- **407**: Proxy Authentication Required.
- **409**: Conflict. The request conflicts with the current state of the server.
- **413**: Payload Too Large.
- **414**: URI Too Long.
- **415**: Unsupported Media Type.
- **419**: Too Many Requests.
- **451**: Unavailable For Legal Reasons.

- **500**: Internal Server Error.
- **503**: The server is not ready to handle the request.
- **504**: Gateway Timeout.
- **505**: HTTP Version Not Supported.
- **511**: Network Authentication Required.

## GENERAL TIPS

- A client can be a PC, phone, IoT devices, or anything else connected to the internet.
- When we're a back-end server, this can also be a client of a database server provider.
- The client always waits for the server's response to requests.
