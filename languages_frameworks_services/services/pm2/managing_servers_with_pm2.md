# Managing Servers with PM2

PM2 is a production process manager for Node.js applications that allows you to keep apps alive forever and reload them without downtime.

---

## Step 1: Install PM2 Globally

Navigate to your app directory in Ubuntu and run:

`sudo npm install pm2 -g`  
`pm2` (to verify the installation)

---

## Step 2: Start Your Application with PM2

Use the following command to start your server and assign a custom script name:

`pm2 start server_file_dir/server.js --name your_start_script_name`

---

## Step 3: Stop the Server

To stop your running server, use:

`pm2 stop your_start_script_name`

---

## References

- Official site: [https://pm2.keymetrics.io/](https://pm2.keymetrics.io/)