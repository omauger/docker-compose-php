# Class ComposeManager

This class permit to do docker-compose command.

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
This method return the output for the command `docker-compose ... rm` in string.

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
