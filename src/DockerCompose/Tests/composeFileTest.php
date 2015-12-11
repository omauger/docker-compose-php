<?php

namespace DockerCompose\Tests;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;


class ComposeFileTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test create file success
     */
    public function testCreateCompseFileSuccess() {
        $file = new ComposeFile('docker-compose.yml');
        $this->assertEquals('docker-compose.yml', $file->getFileName());
    }

    /**
     * Test create file failed
     *
     * @expectedException Exception
     */
    public function testCreateCompseFileFailed() {
        new ComposeFile(25);
    }
}
