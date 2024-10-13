# DOING REVERSE PROXY ON EC2 LINUX INSTANCES

Your API should be open for third-party access, but it's not a good practice to open a non-default port (like 3333) on your server. A better practice is to leave the default port (80) open. To achieve this, you need to set up a **Reverse Proxy**.

Run the following command to install Nginx:

1. Run `sudo apt install nginx` to install Nginx.

2. On your AWS console, click on "Network & Security", "Security Groups",  click on your instance (probabilly launch-wizard), "Edit inbound rules", "Add rules" , select HTTP and select "Anywhere IPV4". Repeat the process for HTTPS too and click on "Save rules". You should be able to access the nginx page through your public IP after 30 seconds.

3. Logged as root user, navigates until /etc/nginx/sites-available, run touch your_site_name, run sudo vim your_site_name and define this configuration (press CTRL + C, in sequence type !wq to exit edition). Run ls and check if the new file is here.

Configuration code:

```
server {
        listen 80 default_server;
        listen [::]:80 default_server;

        location / {
                proxy_pass http://localhost:3333;
                proxy_http_version 1.1;
                proxy_set_header Upgrade $http_upgrade;
                proxy_set_header Connection 'upgrade';
                proxy_set_header Host $host;
                proxy_cache_bypass $http_upgrade;
        }
}
```

4. Backs a dir, navigates until sites-enabled, run sudo ln -s /etc/nginx/sites-available/your_site_name your_site_name. In sequence back to cd ../sites-available and run sudo rm default, repeat the process for the /sites-enabled dir.

5. On /etc/nginx/sites-enabled directory, run sudo service nginx restart, navigates until your project dir and start the server appoint to your 
server.ts file through node server_file_dir/server.js
