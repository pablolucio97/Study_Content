FROM ubuntu:latest

WORKDIR /app

RUN apt-get update && \
    apt-get install vim -y

COPY copycopy /usr/share/nginx

CMD [ "echo", "pscode" ]

