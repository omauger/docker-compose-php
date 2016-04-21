<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerPsTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test simple ps without error
     */
    public function testPs()
    {
        $this->manager->method('execute')->with('docker-compose ps')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->ps(), 'ok');
    }

    /**
     * Test ps success with one compose file
     */
    public function testPsWithOneComposeFileSpecified()
    {
        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml ps')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->ps('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test ps success with two compose files
     */
    public function testPsWithTwoComposeFilesSpecified()
    {
        $this->manager->method('execute')->with('docker-compose -f docker-compose.yml -f docker-compose.test.yml ps')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->ps(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }

    /**
     * Test ps with project option
     */
    public function testPsWithprojectOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml --project-name unittest ps')->willReturn(array('output' => 'ok', 'code' => 0));

        $this->assertEquals($this->manager->ps($composeFiles), 'ok');
    }
}
