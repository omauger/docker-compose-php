<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerPullTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockedManager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     *  Test stop whithout error
     */
    public function testPull()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->pull(), 'ok');
    }

    /**
     * Test stop success with one compose file
     */
    public function testPullWithOneComposeFileSpecified()
    {

        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->pull('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test stop success with two compose files
     */
    public function testPullpWithTwoComposeFilesSpecified()
    {

        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->pull(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }
}
