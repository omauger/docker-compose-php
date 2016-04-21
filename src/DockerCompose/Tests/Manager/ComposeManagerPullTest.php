<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerPullTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     *  Test stop whithout error
     */
    public function testPull()
    {
        $this->manager->method('execute')->with('docker-compose pull')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->pull(), 'ok');
    }

    /**
     * Test stop success with one compose file
     */
    public function testPullWithOneComposeFileSpecified()
    {

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml pull')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->pull('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test stop success with two compose files
     */
    public function testPullpWithTwoComposeFilesSpecified()
    {

        $this->manager->method('execute')->with('docker-compose -f docker-compose.yml -f docker-compose.test.yml pull')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->pull(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }
}
