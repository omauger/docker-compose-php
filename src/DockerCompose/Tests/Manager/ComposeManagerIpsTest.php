<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerIpsTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockedManager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test simple get ips containers
     */
    public function testIps()
    {
        $this->mockedManager
            ->method('execute')
            ->willReturn(array('output' => 'ok', 'code' => 0));

        $this->assertEquals($this->mockedManager->ips(), 'ok');
    }

    /**
     * Test start success with one compose file
     */
    public function testIpsWithOneComposeFileSpecified()
    {
        $this->mockedManager
        ->method('execute')
        ->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->ips('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test ips success with two compose files
     */
    public function testIpsWithTwoComposeFilesSpecified()
    {
        $this->mockedManager
            ->method('execute')
            ->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->ips(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }

    /**
     * Test ips with project option
     */
    public function testIpsWithprojectOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->mockedManager
            ->method('execute')
            ->willReturn(array('output' => 'ok', 'code' => 0));

        $this->assertEquals($this->mockedManager->ips($composeFiles), 'ok');
    }
}
