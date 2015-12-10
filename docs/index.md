# Welcome to the docker-compose-php documentation!

This is the documentation for [docker-compose-php](https://github.com/omauger/docker-compose-php) library.
This library permit you to do docker-compose command from your php application.

## Compatibility

This module is compatible with docker client 1.9, docker-compose 1.5 and php 5.6.

## Contents

* [Installation](/installation)
    * [Installing with composer](/installation#installing-with-composer)

* [Basic Usage](/basic)
    * [Start your containers from docker-compose.yml](/basic#start-containers)
    * [Stop your containers from docker-compose.yml](/basic#stop-containers)
    * [Remove your containers from docker-compose.uml](/basic#remove-containers)
    * [Run a command in a container from docker-composer.yml](/basic#run-command-in-container)
    * [Create a docker-compose files collection](/docker-compose files#create-composefiles-collection)

* [Class ComposeFileCollection](/class-composefilecollection)
    * [Create an instance of ComposeFileCollection](/class-composefilecollection#construc)
    * [Add a docker-compose file to the collection](/class-composefilecollection#add())
    * [Set the project name](/class-composefilecollection#setprojectname)
    * [Active the networking](/class-composefilecollection#setisnetworking())
    * [Set the network driver](/class-composefilecollection#setnetworkdriver())
