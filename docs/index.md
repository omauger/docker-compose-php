# Welcome to the docker-compose-php documentation!

This is the documentation for [docker-compose-php](https://github.com/omauger/docker-compose-php) library.
This library permit you to do docker-compose command from your php application.

## Compatibility

The versions  <= 1.0 are compatible with docker client 1.9, docker-compose 1.5 and php 5.6.
The version 2.0 is compatible with docker client >= 1.10, docker-compose >= 1.6 and php 5.6.

## Contents

* [Installation](/installation)
    * [Installing with composer](/installation#installing-with-composer)
* [Basic Usage](/basic)
    * [Start your containers from docker-compose.yml](/basic#start)
    * [Stop your containers from docker-compose.yml](/basic#stop)
    * [Restart your running containers from docker-compose.yml](/basic#restart)
    * [Remove your containers from docker-compose.uml](/basic#remove)
    * [Kill your containers from docker-compose.yml](/basic#kill)
    * [Run a command in a container from docker-composer.yml](/basic#run)
    * [Build images for services from docker-composer.yml](/basic#build)
    * [Pull images for services from docker-composer.yml](/basic#pull)
    * [List the containers from docker-compose.yml](/basic#List_containers)
    * [List the containers ip addresses for docker-compose.yml](/basic#List_containers_IPs)
* [Class ComposeFile](/composefile)
* [Class ComposeFileCollection](/composefilecollection)
* [Class ComposeManager](/composemanager)
