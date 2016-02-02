# Class ComposeManager

This class permit to do docker-compose command.

## Construct

```php
use DockerCompose\Manager\ComposeManager

$manager = new ComposeManager();
```

## Methods

### start()
#### parameters
* $composeFiles : array of string | ComposeFileCollection - This is an optionnal parameter, default is an empty array.

#### returned type
This method return the output for the command `docker-compose ... up -d` in string.

#### Examples:
```php
# Up from a standard docker-compose file (docker-compose.yml)
$manager->start();

# Up from a multiple docker-compose files
$manager->start(['docker-compose.yml', 'docker-compose.dev.yml']);

# Up with a ComposeFileCollection
$composeCollection = new ComposeFileCollection(['docker-compose.yml', 'docker-compose.dev.yml']);
$manager->start($composeCollection);
```

The ComposeFileCollection can be used to set the project name and the docker network for your application. For more information, please read the doc about [ComposeFileCollection](/composefilecollection).

### stop()
#### parameters
* $composeFiles : array of string | ComposeFileCollection - This is an optionnal parameter, default is an empty array.

#### returned type
This method return the output for the command `docker-compose ... stop` in string.

#### Examples:
```php
# Stop from a standard docker-compose file (docker-compose.yml)
$manager->stop();

# Stop from a multiple docker-compose files
$manager->stop(['docker-compose.yml', 'docker-compose.dev.yml']);

# Stop with a ComposeFileCollection
$composeCollection = new ComposeFileCollection(['docker-compose.yml', 'docker-compose.dev.yml']);
$manager->stop($composeCollection);
```

The ComposeFileCollection can be used to set the project name and the docker network for your application. For more information, please read the doc about [ComposeFileCollection](/composefilecollection).

### restart()
#### parameters
* $composeFiles : array of string | ComposeFileCollection - This is an optionnal parameter, default is an empty array.
* timeout : integer - Spécify a shutdown timeout in seconds - This is an optionnal parameter, default is 10.

#### returned type
This method return the output for the command `docker-compose ... restart` in string.

#### Examples:
```php
# Up from a standard docker-compose file (docker-compose.yml)
$manager->restart();

# Up from a multiple docker-compose files
$manager->restart(['docker-compose.yml', 'docker-compose.dev.yml']);

# Up with a ComposeFileCollection
$composeCollection = new ComposeFileCollection(['docker-compose.yml', 'docker-compose.dev.yml']);
$manager->restart($composeCollection);
```

The ComposeFileCollection can be used to set the project name and the docker network for your application. For more information, please read the doc about [ComposeFileCollection](/composefilecollection).

### remove()
#### parameters
* $composeFiles : array of string | ComposeFileCollection - This is an optionnal parameter, default is an empty array.
* force : boolean (if you need to force the remove of containers, optionnal and default false).
* remove_volumes : boolean (if you need to remove the persistent volumes, optionnal and default false)

#### returned type
This method return the output for the command `docker-compose ... rm` in string.

#### Examples:
```php
# Remove from a standard docker-compose file (docker-compose.yml)
$manager->remove();

# Remove from a multiple docker-compose files
$manager->remove(['docker-compose.yml', 'docker-compose.dev.yml']);

# Remove with a ComposeFileCollection
$composeCollection = new ComposeFileCollection(['docker-compose.yml', 'docker-compose.dev.yml']);
$manager->remove($composeCollection);

# Remove with force and remove persistent volumes
$composeCollection = new ComposeFileCollection(['docker-compose.yml', 'docker-compose.dev.yml']);
$manager->remove($composeCollection, true, true);
```

The ComposeFileCollection can be used to set the project name and the docker network for your application. For more information, please read the doc about [ComposeFileCollection](/composefilecollection).

### run()
#### parameters
* sevice : string (the service name to launch)
* command : string (the command to execute to the service)
* $composeFiles : array of string | ComposeFileCollection - This is an optionnal parameter, default is an empty array.

#### returned type
This method return the output for the command `docker-compose ... run --rm ...` in string.

#### Examples:
```php
# Run from a standard docker-compose file (docker-compose.yml)
$manager->run('composer', 'install');

# Run from a multiple docker-compose files
$manager->run('composer', 'install', ['docker-compose.yml', 'docker-compose.dev.yml']);

# Run with a ComposeFileCollection
$composeCollection = new ComposeFileCollection(['docker-compose.yml', 'docker-compose.dev.yml']);
$manager->run('composer', 'install', $composeCollection);
```

The ComposeFileCollection can be used to set the project name and the docker network for your application. For more information, please read the doc about [ComposeFileCollection](/composefilecollection).


### build()
#### parameters
* composeFiles : array of string | ComposeFileCollection - This is an optionnal parameter, default is an empty array.
* pull : boolean - If you need to attempt to pull the from image. This is an optionnal parameter, default is true.
* forceRm : boolean - If you need to remove intermediate containers . This is an optionnal parameter, default is false.
* cache : boolean - If you want to use cache. This is an optionnal parameter, default is true.

#### returned type
This method return the output for the command `docker-compose ... build` in string.

#### Examples:
```php
# Build from a standard docker-compose file (docker-compose.yml)
$manager->build();

# Build without pull from image
$manager->build([], false)

# Build with force remove intermediate containers
$manager->build([], true, true)

# Build without use the cache
$manager->build([], true, false, false)

# Build from a multiple docker-compose files
$manager->build(['docker-compose.yml', 'docker-compose.dev.yml']);

# Build with a ComposeFileCollection
$composeCollection = new ComposeFileCollection(['docker-compose.yml', 'docker-compose.dev.yml']);
$manager->build($composeCollection);
```

The ComposeFileCollection can be used to set the project name and the docker network for your application. For more information, please read the doc about [ComposeFileCollection](/composefilecollection).

### ps()
#### parameters
* composeFiles : array of string | ComposeFileCollection - This is an optionnal parameter, default is an empty array.

#### returned type
This method return the output for the command `docker-compose ... ps` in string.

#### Examples:
```php
# List containers from a standard docker-compose file (docker-compose.yml)
$manager->ps();

# List containers from a multiple docker-compose files
$manager->ps(['docker-compose.yml', 'docker-compose.dev.yml']);

# List containers with a ComposeFileCollection
$composeCollection = new ComposeFileCollection(['docker-compose.yml', 'docker-compose.dev.yml']);
$manager->ps($composeCollection);
```

The ComposeFileCollection can be used to set the project name and the docker network for your application. For more information, please read the doc about [ComposeFileCollection](/composefilecollection).
