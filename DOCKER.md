# Docker

## Introduction

[Docker](https://www.docker.com/) is an open-source platform that allows you to automate the deployment, scaling, and management of applications using containerization. Containers are lightweight, isolated environments that package everything needed to run an application, including the code, runtime, system tools, and libraries.


## Getting Started

To get started with Docker, you'll need to:

1. Install Docker on your machine. You can download Docker from the [official website](https://www.docker.com/get-started).

2. Familiarize yourself with Docker concepts such as images, containers, and Dockerfiles. Check out the [Docker documentation](https://docs.docker.com/) for detailed information.


## Terminal Commands to Launch Container

### Build image with `docker build`
This command is used to build an image from a Dockerfile. For example, `docker build -t my-php-server .` will build an image with the tag `my-php-server` using the Dockerfile in the current directory. You may opt to remove any intermediate container builds by adding `--rm`.

### List images with `docker images`
This command lists all the available images on your machine. Alternative is `docker image ls`.

### Run images with `docker-compose`
This command is used to run an image: `docker-compose up`. To run in background, use `docker-compose up -d`.


## Terminal Commands to Stop/Remove Image/Container

### Remove image
This command is used to remove an image: `docker image rm image-name`.


## Other Terminal Commands for Docker

### Stop Container with `docker stop`
This command is used to stop a running container. For example, `docker stop my-container` will stop the container with the name `my-container`.

### Remove Container with `docker rm`
This command is used to remove a container. For example, `docker rm my-container` will remove the container with the name `my-container`.

### Remove Image with `docker rmi`
This command is used to remove an image. For example, `docker rmi my-image` will remove the image with the tag `my-image`.

### Run a Container with `docker run`
This command is used to run a container from an image. For example, `docker run hello-world` will run the `hello-world` image.

### Show Running Containers with `docker ps`
This command lists all the running containers. The command `docker ps -a` can be used to view all containers (running or not).

These are just a few examples of the many commands available in Docker. Refer to the [Docker documentation](https://docs.docker.com/) for a complete list of commands and their usage.