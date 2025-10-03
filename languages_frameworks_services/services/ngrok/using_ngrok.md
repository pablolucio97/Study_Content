# Using Ngrok to generate temporary HTTPS URLs

Ngrok is a versatile tool that allows you to create secure tunnels to your localhost environment.  Ngrok provides a temporary public HTTPS URL which redirects to your local development environment without the need for additional configuration or deployment.

Ngrok can be useful to:
- Expose your application over HTTPS protocol.
- Be able to communicate with third services that works over HTTPS protocol.

## Using Ngrok

1. Create and authenticate on your Ngrok account.
2. Copy and pate the command `ngrok config add-authtoken YOUR_TOKEN` on your terminal to configure Ngrok auth credentials.
3. Run the command `ngrok/ngrok http YOUR_LOCAL_IP:PORT` to run Ngrok from a terminal. Example: `ngrok/ngrok http 192.168.2.123:3334`. 

## Using Ngrok with Docker

1. Create and sign in on your Ngrok account.
2. Generate and copy your Ngrok auth token.
3. Run the command `docker run -it --net="host" -e NGROK_AUTHTOKEN=your_auth_token ngrok/ngrok http your_machine_ip:your_application_port`, example: `docker run -it --net="host" -e NGROK_AUTHTOKEN=your_auth_token  ngrok/ngrok http 192.168.7.129:3334`


## General tips
- Provide your ip machine instead `localhost` at running the command to mount and expose your URL.
- Pay attention on the network your application is running. The flag --net must appoint to the correct network.
- The generated URL is temporary and you should exchange it on your application or REST client every time you rerun the command.
- If your internet connection network changes, you need to generate a new Ngrok URL based on your new ip because your app have been changed.