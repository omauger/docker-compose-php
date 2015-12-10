# Basic Usage

## Import ComposeManager

Assume you have installed docker-compose-php with composer.

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

## Run

To run a service for your application from a docker-compose file named docker-compose.yml and if you have this file in the root of your project,
you need to call the method `run` on the ComposeManager.

Example:
```php
$manager = new ComposeManager();
$manager->run('composer', 'install'); # 'composer' is my service and 'install' is the command to execute
```

To view more informations and all possible parameters for this method, please check this [page](/ComposeManager#stop)
