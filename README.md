DOCKER-COMPOSE PHP
==================

**Docker-compose PHP** is a [Docker-compose](https://docs.docker.com/compose/) SDK written in PHP. This library is still a work in progress.
Not much is supported yet, but the goal is to reach 100% of docker-compose options support.

This is supported for docker version 1.9 and docker-compose version 1.5.

Versioning
----------

There is no *stable* version yet and docker-compose is rapidly evolving, but we still try to semantically version the library according to [semver](http://semver.org/), but shifted a little bit:

* **MAJOR** version number stays to 0 until all options of docker-compose 1.5 are covered
* **MINOR** version number is incremented when a backward incompatible change is made
* **PATCH** version number is incremented when a new feature is added

So basically, if you want the `0.1` version set, pull the tag`0.1.0` and you should be fine.

Installation
------------

git pull git.alterway.fr/ophelie.mauger/docker-compose-php.git@develop

**Note**: there is no stable version of Docker-compose PHP yet.

Usage
-----

### Start
#### Method `start()`

#### Parameters
* composeFiles : One docker-compose file in string or an array of docker-compose files names (optionnal, default [])

#### Examples
```
$manager = ComposeManager();
$manager->start() # This will run the command 'docker-compose up -d'
$manager->start('docker-compose.dev.yml') # This will run the command 'docker-compose -f docker-compose.dev.yml up -d'
$manager->start(['docker-compose.yml', 'docker-compose.dev.yml']) # This will run the command 'docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d'

# Example with project name and network options
$composeFiles = new DockerCompose\ComposeFileCollection('docker-compose.yml');
$composeFiles->setProjectName('myproject')->setNetworking(true)->setNetworkDriver('overlay');
$manager->start($composeFiles);
```

### Stop
#### Method `stop()`

#### Parameters
* composeFiles : One docker-compose file in string or an array of docker-compose files names (optionnal, default [])

#### Examples
```
$manager = ComposeManager();
$manager->stop() # This will run the command 'docker-compose stop'
$manager->stop('docker-compose.dev.yml') # This will run the command 'docker-compose -f docker-compose.dev.yml stop'
$manager->stop(['docker-compose.yml', 'docker-compose.dev.yml']) # This will run the command 'docker-compose -f docker-compose.yml -f docker-compose.dev.yml stop'

# Example with project name and network options
$composeFiles = new DockerCompose\ComposeFileCollection('docker-compose.yml');
$composeFiles->setProjectName('myproject')->setNetworking(true)->setNetworkDriver('overlay');
$manager->stop($composeFiles);
```

### RM
#### Method `remove()`

#### Parameters
* composeFiles : One docker-compose file in string or an array of docker-compose files names (optionnal, default [])
* force : If we have to force the remove (optionnal, default false)
* removeVolumes : If we have to remove persistent volumes (optionnal, default false)

#### Examples
```
$manager = ComposeManager();
$manager->remove() # This will run the command 'docker-compose rm'
$manager->remove('docker-compose.dev.yml') # This will run the command 'docker-compose -f docker-compose.dev.yml rm'
$manager->remove(['docker-compose.yml', 'docker-compose.dev.yml']) # This will run the command 'docker-compose -f docker-compose.yml -f docker-compose.dev.yml rm'
$manager->remove([], true) # This will run the command 'docker-compose rm -f' to force rm container even if are started
$manager->remove([], false, true) # This will run the command 'docker-compose rm -v' to remove persistent volumes
$manager->remove([], true, true) # This will run the command 'docker-compose rm -f -v'

# Example with project name and network options
$composeFiles = new DockerCompose\ComposeFileCollection('docker-compose.yml');
$composeFiles->setProjectName('myproject')->setNetworking(true)->setNetworkDriver('overlay');
$manager->remove($composeFiles);
```

All methods return the output result if it is a success.

Run tests
---------
```
./scripts/tests.sh
```

Contributing
------------
[Ophélie Mauger](https://github.com/omauger)

License
-------

View [LICENSE] (LICENSE)
