<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerPsTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockedManager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test simple ps without error
     */
    public function testPs()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->ps(), 'ok');
    }

    /**
     * Test ps success with one compose file
     */
    public function testPsWithOneComposeFileSpecified()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->ps('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test ps success with two compose files
     */
    public function testPsWithTwoComposeFilesSpecified()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->ps(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }

    /**
     * Test ps with project option
     */
    public function testPsWithprojectOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));

        $this->assertEquals($this->mockedManager->ps($composeFiles), 'ok');
    }
}
