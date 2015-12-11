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
    }

    /**
     * Test create file failed
     *
     * @expectedException Exception
     */
    public function testCreateCompseFileFailed() {
        $file = new ComposeFile(25);
    }
}
