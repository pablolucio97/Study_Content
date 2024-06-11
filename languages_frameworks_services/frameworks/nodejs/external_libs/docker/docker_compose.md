### Docker Compose basic course

Docker Compose is a tool for defining and running multi-container Docker applications. With a single command, you can configure all the services in your application and start them up. Docker Compose uses a YAML file to configure your application's services, networks, and volumes.


## Using Docker Compose to handle containers

1. Create the `docker-compose.yml` file in your root directory.
2. Declare your file's instructions. Example (In this example, Docker Compose will build tro images and up them into two different containers where the first container is inside the "laravel" folder whose contains a Dockerfile.prod and another container that is inside nginx folder. Both containers can communicate with itself because they're in the same network "laranet".):
```yml
    version: 3 #current Docker Compose version

    services:

        laravel:
          build:
            context: ./laravel #folder containing your docker file
            dockerfile: Dockerfile.prod
          image: pablolucio97/laravel:prod #your generated image name
          container_name: laravel #your container name
          networks:
                - laranet

        nginx:
          build:
            context: ./nginx
            dockerfile: Dockerfile.prod
          image: pablolucio97/nginx:prod
          container_name: nginx
          networks:
            - laranet
          ports:
            - "8080:80"

    networks:
      laranet
        driver: bridge
```
3. Run `docker-compose up` to up your containers.


### Working with Docker Compose, NodeJS and Mysql

```yml
version: '3.7'

services:
  db: # starts a database service configuration
    image: mysql:8.0 # uses mysql 5.7 as the image to handle the database service
    command: --innodb-use-native-aio=0 #required command for run  mysql image correctly
    container_name: db
    restart: always # automatically restart the database container if it falls
    tty: true # enables the container terminal
    volumes:
      - ./myapp_mysql:/var/lib/mysql # persists all data from /var/lib/mysql into myapp_mysql folder, even if the container is deleted
    environment: # are automatically generated at the container building
      MYSQL_DATABASE: ${MYSQL_DATABASE} # must come from .env file
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD} # must come from .env file
    networks:
      - node-network # defines that this container is inside the node-network

networks:
  node-network:
    driver: bridge
```


### Docker compose useful commands

`docker-compose up -d --build`: Starts all containers rebuilding images if it has any changes.
`docker-compose up -d`: Starts all containers in detached mode.
`docker-compose down`: Stops and removes all containers.
`docker-compose ps`: Lists all running containers.
`docker-compose exec YOUR COMMAND`: Executes a command in a running container.
`docker-compose logs`: Shows log output from services.
`docker-compose restart`: Restarts all stopped and running services.


## General tips

- Always configure a volume pointing to your local folder to persis data even if the container does not exist anymore.
- Create a .env file in the same directory as the docker-compose.yml file and load it into the docker-file configuration.