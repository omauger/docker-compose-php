<?php

namespace DockerCompose\Tests\mockedManager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerRestartTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockedManager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test simple restart without error
     */
    public function testRestart()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->restart(), 'ok');
    }

    /**
     * Test simple restart with timeout
     */
    public function testRestartWithTimeout()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->restart([], 30), 'ok');
    }

    /**
     * Test restart success with one compose file
     */
    public function testRestartWithOneComposeFileSpecified()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->restart('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test restart success with two compose files
     */
    public function testRestartWithTwoComposeFilesSpecified()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->restart(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }

    /**
     * Test restart with project option
     */
    public function testRestartWithprojectOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));

        $this->assertEquals($this->mockedManager->restart($composeFiles), 'ok');

    }
}
