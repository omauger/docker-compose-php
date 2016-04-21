<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerRestartTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test simple restart without error
     */
    public function testRestart()
    {
        $this->manager->method('execute')->with('docker-compose restart')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->restart(), 'ok');
    }

    /**
     * Test simple restart with timeout
     */
    public function testRestartWithTimeout()
    {
        $this->manager->method('execute')->with('docker-compose restart --timeout=30')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->restart([], 30), 'ok');
    }

    /**
     * Test restart success with one compose file
     */
    public function testRestartWithOneComposeFileSpecified()
    {
        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml restart')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->restart('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test restart success with two compose files
     */
    public function testRestartWithTwoComposeFilesSpecified()
    {
        $this->manager->method('execute')->with('docker-compose -f docker-compose.yml -f docker-compose.test.yml restart')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->restart(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }

    /**
     * Test restart with project option
     */
    public function testRestartWithprojectOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml --project-name unittest restart')->willReturn(array('output' => 'ok', 'code' => 0));

        $this->assertEquals($this->manager->restart($composeFiles), 'ok');

    }
}
