# DOCKER COURSE

## CONCEPTS

Docker is a tool that helps creating containers solving conflicts that what runs locally doesn't runs remotely. Docker also shares resources from the host machine to our local machine. Without Docker we'd need to configure, for example, a virtual machine for each SO type. Using Docker, Docker will handle all SO for us just by running the Docker.

**Containers**: Are isolated environments running on your machine.

**Images**: Are instructions to create a container. These images are variables and can be customized.

**Docker Compose**: Is like a container manager that defines which services should run.

**Dockerfile**: Is the file used to build Docker images through new builds.

## CREATING AN IMAGE AND RUNNING IT IN A DOCKER CONTAINER

1. Create a `.dockerignore` file in the root of your project to ignore folders and files to not put in your container. Example:
    ```
    node_modules
    .git
    .vscode
    ```

2. In your root project folder, create a new Dockerfile will contains all instructions settings of our image to run our application inside the Docker. Example:
    ```
    FROM node

    WORKDIR /usr/app

    COPY package.json ./

    RUN npm install

    COPY . .

    EXPOSE 3333

    CMD ["npm", "run", "dev"]
    ```

3. To create the docker image according our Dockerfile, run the command:
    ```
    docker build -t yourimagename .
    ```

4. To run our created image, run:
    ```
    docker run -p 3333:3333 yourimagename
    ```

## DOCKER AND DOCKER-COMPOSE COMMANDS

- `Ctrl + C` : closes the server
- `docker-compose up -d`: Allows docker-compose image running without the server.
- `docker-compose stop`: Stops all docker-compose images
- `docker-compose down`: Deletes all docker-compose images
- `docker-compose start`: Starts all docker-compose images
- `docker ps`: List all images running
- `docker ps -a`: List all images running or not
- `docker rm containerid`: Removes the container (needs to be stopped)
- `docker start containerid`: Starts the container
- `docker stop containerid`: Stops the container
- `docker logs yourcontainername -f`: Logs all activities of your containername
- `docker exec -it yourcontainername /bin/bash`: Access the virtual machine where your container is running (the image should be running).
- `docker exec yourcontainername cat /etc/hosts`: See the IP the container is running.

## Docker working flow

<img src='https://i.ibb.co/x7GfFMv/Screenshot-2024-06-05-at-08-45-08.png'/>

## GENERAL TIPS

The container/virtual machine created by Docker has a different IP from our local machine IP.

Use the same port in your project and in the docker container.

You must to stop the server before to install or uninstall a lib.

Don't use the lib bcrypt, because this causes conflicts with Docker, use the bcryptjs lib instead.

In your project that runs using Docker, create a folder to store all database back-up and on your docker-compose.yml file, set a volume for your application pointing to this folder created, because it will store all application data in our local machine allowing recovery all data if for any reason the Docker container dies.

If you're using Windows, always install the Docker together with WSL for better performance.

If the environment/OS where the container is running dies, the container will die too. Example: If you are running the container inside an Ubuntu image, when you exit from Ubuntu image, the container will stop too.
