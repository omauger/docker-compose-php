<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerKillTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test simple kill without error
     */
    public function testKill()
    {
        $this->manager->method('execute')->with('docker-compose kill')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->kill(), 'ok');
    }

    /**
     * Test simple kill with specific SIGNAL
     */
    public function testKillWithSpecificSIGNAL()
    {
        $this->manager->method('execute')->with('docker-compose kill -s SIGALRM')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->kill([], 'SIGALRM'), 'ok');
    }

    /**
     * Test kill success with one compose file
     */
    public function testKillWithOneComposeFileSpecified()
    {
        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml kill')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->kill('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test kill success with two compose files
     */
    public function testKillWithTwoComposeFilesSpecified()
    {
        $this->manager->method('execute')->with('docker-compose -f docker-compose.yml -f docker-compose.test.yml kill')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->kill(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }

    /**
     * Test kill with project option
     */
    public function testKillWithprojectOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml --project-name unittest kill')->willReturn(array('output' => 'ok', 'code' => 0));

        $this->assertEquals($this->manager->kill($composeFiles), 'ok');

    }
}
