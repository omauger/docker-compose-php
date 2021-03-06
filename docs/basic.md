# Basic Usage

## Import ComposeManager

Assume you have installed docker-compose-php with composer or see installation guide [here](/installation#installing-with-composer).

```php
require __DIR__.'/vendor/autoload.php';

use DockerCompose\Manager\ComposeManager;
```

## Start

To start all containers for your application from a docker-compose file named docker-compose.yml and if you have this file in the root of your project,
you can start with the method `start` on the ComposeManager.

Example:
```php
$manager = new ComposeManager();
$manager->start();
```

To view more informations and all possible parameters for this method, please check this [page](/ComposeManager#start)

## Stop

To stop all containers for your application from a docker-compose file named docker-compose.yml and if you have this file in the root of your project,
you can stop with the method `stop` on the ComposeManager.

Example:
```php
$manager = new ComposeManager();
$manager->stop();
```

## Restart

To restart all running containers for your application from a docker-compose file named docker-compose.yml and if you have this file in the root of your project,
you need to run the method `restart` on the ComposeManager.

Example:
```php
$manager = new ComposeManager();
$manager->restart();
```

To view more informations and all possible parameters for this method, please check this [page](/ComposeManager#start)

To view more informations and all possible parameters for this method, please check this [page](/ComposeManager#stop)

## Remove

To remove all containers for your application from a docker-compose file named docker-compose.yml and if you have this file in the root of your project,
you can remove with the method `remove` on the ComposeManager.

Example:
```php
$manager = new ComposeManager();
$manager->remove();
```

To view more informations and all possible parameters for this method, please check this [page](/ComposeManager#stop)

## Kill

To kill all containers for your application from a docker-compose file named docker-compose.yml and if you have this file in the root of your project,
you can remove with the method `kill` on the ComposeManager.

Example:
```php
$manager = new ComposeManager();
$manager->kill();
```

To view more informations and all possible parameters for this method, please check this [page](/ComposeManager#stop)

## Run

To run a service for your application from a docker-compose file named docker-compose.yml and if you have this file in the root of your project,
you need to call the method `run` on the ComposeManager.

Example:
```php
$manager = new ComposeManager();
$manager->run('composer', 'install'); # 'composer' is my service and 'install' is the command to execute
```

To view more informations and all possible parameters for this method, please check this [page](/ComposeManager#stop)

## Build

To build all images for your application from a docker-compose file named docker-compose.yml and if you have this file in the root of your project,
you need to call the method `build` on the ComposeManager.

Example:
```php
$manager = new ComposeManager();
$manager->build();
```

To view more informations and all possible parameters for this method, please check this [page](/ComposeManager#build)

## Pull

To pull all images for your application from a docker-compose file named docker-compose.yml and if you have this file in the root of your project,
you need to call the method `pull` on the ComposeManager.

Example:
```php
$manager = new ComposeManager();
$manager->pull();
```

To view more informations and all possible parameters for this method, please check this [page](/ComposeManager#pull)

## List containers

To list the started containers of your application from a docker-compose file named docker-compose.yml and if you have this file in the root of your project,
you need to call the method `ps` on the ComposeManager.

Exemple:
```php
$manager = new ComposeManager();
$manager->ps();
```

## List containers IPs

To list the IP addresses of started containers of your application from a docker-compose file named docker-compose.yml and if you have this file in the root of your project,
you need to call the method `ps` on the ComposeManager.

Exemple:
```php
$manager = new ComposeManager();
$manager->ips();
```
