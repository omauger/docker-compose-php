# Class ComposeFile

This class permit to give a docker-compose file to your project. It can be used to create a [ComposeFileCollection](/composefilecollection).

## Construct

Give the name file (full path) of the docker-compose file.

Examples :
```php
use DockerCompose\ComposeFile;

$composeFile = new ComposeFile('/my/path/docker-compose.yml');
```

## Methods

### setFileName()

This method permit to change the file name of the composeFile.

Example:
```
$composeFile->setFileName('/my/new/path/docker-compose.yml')
```

### getFileName()

This method return the name of the composeFile in string format.
