<?php

namespace DockerCompose\Tests;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeFileCollectionTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test create file success from array
     */
    public function testCreateCompseFileCollectionSuccess() {
        $file = new ComposeFile('docker-compose.yml');
        $composeFiles = new ComposeFileCollection([$file, 'docker-compose.test.yml']);

        $this->assertEquals('docker-compose.yml', $composeFiles->getAll()[0]->getFileName());
        $this->assertEquals('docker-compose.test.yml', $composeFiles->getAll()[1]->getFileName());
    }

    /**
     * Test create file failed because is not an array
     *
     * @expectedException Exception
     */
    public function testCreateCompseFileCollectionFailedNotArray() {
        $file = new ComposeFileCollection('docker-compose.yml');
    }

    /**
     * Test create file failed because is not string or ComposeFile
     *
     * @expectedException Exception
     */
    public function testCreateCompseFileCollectionFailedInvalidTypeOfData() {
        $file = new ComposeFileCollection(['docker-compose.yml', 12]);
    }
}
