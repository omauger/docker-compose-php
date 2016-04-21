<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerRunTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test run
     */
    public function testrun()
    {
        $this->manager->method('execute')->with('docker-compose run --rm test mycommand')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->run('test', 'mycommand'), 'ok');
    }

    /**
     * Test run
     * @expectedException \DockerCompose\Exception\NoSuchServiceException
     */
    public function testrunThrowNoSuchServiceException()
    {
        $this->manager->method('execute')->with('docker-compose run --rm test mycommand')->willReturn(array('output' => 'ERROR: No such service: test', 'code' => 1));
        $this->manager->run('test', 'mycommand');
    }

    /**
     * Test run with project, networking and network driver option
     */
    public function testRuntWithprojectOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml --project-name unittest run --rm test mycommand')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->run('test', 'mycommand', $composeFiles), 'ok');
    }
}
