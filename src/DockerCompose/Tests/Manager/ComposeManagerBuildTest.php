<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerBuildTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test simple build without error
     */
    public function testBuild()
    {
        $this->manager->method('execute')->with('docker-compose build --pull')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->build(), 'ok');
    }

    /**
     * Test build success with one compose file
     */
    public function testBuildWithOneComposeFileSpecified()
    {
        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml build --pull')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->build('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test build success with two compose files
     */
    public function testBuildWithTwoComposeFilesSpecified()
    {
        $this->manager->method('execute')->with('docker-compose -f docker-compose.yml -f docker-compose.test.yml build --pull')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->build(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }

    /**
     * Test simple build without pull
     */
    public function testBuildWithoutPull()
    {
        $this->manager->method('execute')->with('docker-compose build')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->build([], false), 'ok');
    }

    /**
     * Test simple build with --force-rm
     */
    public function testBuildWithForceRm()
    {
        $this->manager->method('execute')->with('docker-compose build --force-rm')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->build([], false, true), 'ok');
    }

    /**
     * Test simple build with --no-cache
     */
    public function testBuildWithNoCache()
    {
        $this->manager->method('execute')->with('docker-compose build --no-cache')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->build([], false, false, false), 'ok');
    }

    /**
     * Test simple build with --pull --force-rm --no-cache
     */
    public function testBuildWithPullAndForceRmAndNoCache()
    {
        $this->manager->method('execute')->with('docker-compose build --pull --force-rm --no-cache')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->build([], true, true, false), 'ok');

    }
}
