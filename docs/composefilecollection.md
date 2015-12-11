# Class ComposeFileCollection

This class permit to set your application options with a list of docker-compose files, the project-name, if you need a network and with which network driver.

## Construct

Can have an array of string in call. The string correspond of files for docker-compose.

Examples :
```php
use DockerCompose\ComposeFileCollection;

$composeCollection1 = new ComposeFileCollection(); # The ComposeFileCollection has no one docker-compose file yet.
$composeCollection2 = new ComposeFileCollection(['docker-compose.yml', 'docker-compose.dev.yml']); # The ComposeFileCollection has two docker-compose files
```

## Methods

### add()

This method permit to add a docker-compose file to the collection.

Example:
```php
$composeCollection = new ComposeFileCollection();
$composeCollection->add('docker-compose.yml');
```

### getAll()

This method return an array of [ComposeFile](/composefile).

### setProjectName()

This method permit to set the project name for your application with a string parameter.

Example:
```php
$composeCollection = new ComposeFileCollection(['docker-compose.yml', 'docker-compose.dev.yml']);
$composeCollection->setProjectName('myproject');
```

### getProjectName()

This method return the project name.

### setIsNetworking()

This method permit to set if your application need to create a network on start (this network will have the same name of your project name).

Example:
```php
$composeCollection = new ComposeFileCollection(['docker-compose.yml', 'docker-compose.dev.yml']);
$composeCollection->setProjectName('myproject')->setIsNetworking(true);
```

### isNetworking()

This method permit to know if your application will create a network on start.

### setNetworkDriver()

This method permit to set the network driver you need to create.

Example:
```php
$composeCollection = new ComposeFileCollection(['docker-compose.yml', 'docker-compose.dev.yml']);
$composeCollection->setProjectName('myproject')->setIsNetworking(true)->setNetworkDriver('overlay');
```

### getNetworkDriver()

This method return the network driver set.

