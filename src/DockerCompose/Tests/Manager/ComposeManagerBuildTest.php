<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;

class ComposeManagerBuildTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockedManager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test simple build without error
     */
    public function testBuild()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->build(), 'ok');
    }

    /**
     * Test build success with one compose file
     */
    public function testBuildWithOneComposeFileSpecified()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->build('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test build success with two compose files
     */
    public function testBuildWithTwoComposeFilesSpecified()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->build(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }

    /**
     * Test simple build without pull
     */
    public function testBuildWithoutPull()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->build([], false), 'ok');
    }

    /**
     * Test simple build with --force-rm
     */
    public function testBuildWithForceRm()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->build([], false, true), 'ok');
    }

    /**
     * Test simple build with --no-cache
     */
    public function testBuildWithNoCache()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->build([], false, false, false), 'ok');
    }

    /**
     * Test simple build with --pull --force-rm --no-cache
     */
    public function testBuildWithPullAndForceRmAndNoCache()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->build([], true, true, false), 'ok');

    }
}
