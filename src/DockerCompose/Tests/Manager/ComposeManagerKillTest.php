<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerKillTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockedManager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test simple kill without error
     */
    public function testKill()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->kill(), 'ok');
    }

    /**
     * Test simple kill with specific SIGNAL
     */
    public function testKillWithSpecificSIGNAL()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->kill([], 'SIGALRM'), 'ok');
    }

    /**
     * Test kill success with one compose file
     */
    public function testKillWithOneComposeFileSpecified()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->kill('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test kill success with two compose files
     */
    public function testKillWithTwoComposeFilesSpecified()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->kill(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }

    /**
     * Test kill with project option
     */
    public function testKillWithprojectOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));

        $this->assertEquals($this->mockedManager->kill($composeFiles), 'ok');

    }
}
