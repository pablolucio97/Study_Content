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

## Configuring containers that depends on another containers

In this example the app container that contains a NodeJS application, depends on the db container that has the mysql configuration. The application need the database to perform its operations.

1. On the dependent container folder, inside the Dockerfile, add the Dockerize installation step [found here](https://github.com/jwilder/dockerize), example:

```yml
ENV DOCKERIZE_VERSION v0.7.0

RUN apt-get update \
    && apt-get install -y wget \
    && wget -O - https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz | tar xzf - -C /usr/local/bin \
    && apt-get autoremove -yqq --purge wget && rm -rf /var/lib/apt/lists/*
```
2. Update the docker-compose.yml file appointing the dependencies and the entrypoint. Full file example:
```yml
version: '3.7'

services:
  app:
    build:
      context: node
    container_name: app
    entrypoint: dockerize -wait tcp://db:3306 -timeout 20s docker-entrypoint.sh # wait for mysql to be ready on 3306 port for 20s
    restart: always
    tty: true
    networks: 
      - node-network
    volumes:
      - ./node:/usr/src/app
    ports:
      - "3000:3000"
    depends_on:
      - db # the app container needs the db container to work properly, it should be done using dockerize or waitforit images

  db: # starts a database service configuration
    image: mysql:8.0 # uses mysql 8.0 as the image to handle the database service
    command: --innodb-use-native-aio=0 # required command for running mysql image correctly
    container_name: db
    restart: always # automatically restarts the database container if it falls
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

In this example the Node application depends on the database and uses healthcheck programmatically to check the database condition before up the application container:
```yml
version: '3.8'

services:
  postgres:
    container_name: graphql-crud-db
    image: postgres
    ports:
      - 5432:5432
    environment:
      POSTGRES_USER: admin
      POSTGRES_PASSWORD: admin
      POSTGRES_DB: graphql-crud-db
      PGDATA: /data/postgres
    volumes:
      - ./data/pg:/data/postgres
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U admin -d graphql-crud-db"]
      interval: 10s
      timeout: 5s
      retries: 5

  graphql-crud-app:
    container_name: graphql-crud-app
    image: node:20-alpine
    working_dir: /usr/src/app
    volumes:
      - /Users/pablosilva/Desktop/coding/studies/graphql-prisma-nest-crud:/usr/src/app
    ports:
      - 3333:3333
    command: /bin/sh -c "npx prisma generate && npm run start:dev"
    depends_on:
      postgres:
        condition: service_healthy
    environment:
      DATABASE_URL: postgresql://admin:admin@graphql-crud-db:5432/graphql-crud-db?schema=public
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
- Always use dockerize or another async operations image to grant a container that depends another one will wait for.
- Use healthcheck with a repeated interval or dockerize when you have a container that depends on another. Do not use "Wait for it".
- At working with multiples docker-compose files and you have to communicate between the services inside these different files, each service inside each docker-compose.yml file must be connected in the same network. You must create a new network running the command `docker network create your-network` and assign all services to this network.