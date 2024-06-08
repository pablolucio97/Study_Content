# DOCKER COURSE

## CONCEPTS

Docker is a tool that helps creating containers solving conflicts that what runs locally doesn't runs remotely. Docker also shares resources from the host machine to our local machine. Without Docker we'd need to configure, for example, a virtual machine for each SO type. Using Docker, Docker will handle all SO for us just by running the Docker.

**Containers**: Are isolated environments running on your machine.

**Images**: Are instructions to create a container. These images are variables and can be customized.

**Volumes**: Are the dedicated storages on your machine that can be bound between images.

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

## Running and editing files images from terminal using vim

In this example Nginx image will be used.

1. Open the Docker desktop app.
2. Run the command `docker run -d --name nginx -p 8080:80 nginx` to build the nginx image and it be accessible through your 8080 port with free terminal.
3. Run the command ` docker exec -it nginx bash` to execute nginx bash with integrated and interactive terminal.
4. Run the command `apt-get update`to update the image and `apt-get install vim` to install the VIM Editor.
5. Run the command `vim "filename"` to edit the desired file. Ex: `vim index.html`.
6. Press `i` to enable editing, edit your file, and then press `:wq` to write the file and exit Vim.

## Working with volumes

1. Create a volume running `docker volume create my_volume`. You can inspect your volume info running `docker volume inspect my_volume`
2. Run the command `docker run -d --name nginx -p 8080:80 -v my_volume:/app mynginx` to build a new image (in this case nginx), and it be accessible through your 8080 port with free terminal.
3. Run the command ` docker exec -it mynginx bash` to execute nginx bash with integrated and interactive terminal.
4. Inside your image dir, create the files you want to persist inside the `app` folder. All files created here will be shared with your local volume.

## Working with mages

Run `docker pull your_image_name` to download the desired image.
You can check the current images on your machine by running `docker images`.
Run `docker rmi your_image_id`to remove an image.

### Creating a new own image

Creating a new image is useful to have an existing image modified according to your needs. A new image always be created thorough an existing image.

1.  Create a file named `Dockerfile` in your directory.
2.  Inside it, declare the actions. Example:

```yml
  FROM nginx:latest
  WORKDIR /app //creates a dir named 'app' and define it has default
  RUN apt-get update && \
      apt-get install vim -y
  COPY html /usr/share/nginx  //copies the local html folder to /usr/share/nginx directory

  ```
3. Run the command `docker build -t your_docker_hub_user/your_new_image_name .` to execute the Dockerfile from your directory building the new image based on the provided commands. Example : `docker build -t pablolucio97/nginx_with_vim:latest .`
4. To run your image run `docker run -it your_image_name bash`. Example: `docker run -it pablolucio97/nginx_with_vim bash`


### Understanding Dockerfile

ENV: Allows to use environment variables. Example:
```yml
  ENV URL_PROD https://www.mysite.com
```

EXPOSE: Allows another application to reach this image port. Example:

```yml
EXPOSE 3000
```

CMD: Is a variable executable command that runs after the image runs and allows receive commands and parameters from the cmd. Examples:

```yml
CMD [ "echo", "pscode" ] //prinths "pscode", but can print "pscode2" with the command docker run myimagename echo "pscode2"
```

ENTRYPOINT: Is a fixed command that runs after the image runs. Examples:

```yml
ENTRYPOINT [ "echo", "pscode" ] //prints "pscode"
```

Obs: CMD and ENTRYPOINT can be combined, example:

```yml
ENTRYPOINT [ "echo", "Hello" ]
CMD [ "pscode" ] // prints "Hello pscode"
```

## GENERAL TIPS

The container/virtual machine created by Docker has a different IP from our local machine IP.

Use the same port in your project and in the docker container.

You must to stop the server before to install or uninstall a lib.

Don't use the lib bcrypt, because this causes conflicts with Docker, use the bcryptjs lib instead.

In your project that runs using Docker, create a folder to store all database back-up and on your docker-compose.yml file, set a volume for your application pointing to this folder created, because it will store all application data in our local machine allowing recovery all data if for any reason the Docker container dies.

If you're using Windows, always install the Docker together with WSL for better performance.

If the environment/OS where the container is running dies, the container will die too. Example: If you are running the container inside an Ubuntu image, when you exit from Ubuntu image, the container will stop too.

At working with Docker and you need to access some service or application that is running in the Docker container, you must mirror this port to be accessible on your machine (because Docker container is a virtual machine and your machine is another one). Example: docker run nginx -p 8080:80 (From 8080 of our machine we can access nginx 80 port).

At writing image files, keep in mind that images are imutable, and if the container that is running the image downs, the image will not persist with changes unless you did a bind mounting (mirrored a local folder to Docker).

At working with Docker on development environment you always must maintain a folder on your local machine to be mirrored to the docker through bind mounting.

The docker arguments orders matters and affects the command result.

At working with images, you must to upload two images, one with :latest and another one with the current version you finished.

The default Docker's container register is the Docker Hub. Some big techs has its own container register with data.

The `run` command is to run images with and `exec` to execute actions in containers.

At working with Docker images, you probably want to execute a command after the image runs.

All Docker's file that contains `exec "$@"` at its end allows that command can be executed after the image. None command will work if the file does not contain the `exec "$@"` declaration.
