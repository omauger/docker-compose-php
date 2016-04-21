<?php

namespace DockerCompose\Tests\mockedManager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;
use DockerCompose\Manager\ComposeManager;


class ComposeManagerRunTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockedManager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test run
     */
    public function testrun()
    {
        $this->mockedManager->method('execute')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->mockedManager->run('test', 'mycommand'), 'ok');
    }

    /**
     * Test run
     * @expectedException \DockerCompose\Exception\NoSuchServiceException
     */
    public function testrunThrowNoSuchServiceException()
    {
        $composeFiles = new ComposeFileCollection(['/var/www/docker-compose-test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->mockedManager->method('execute')->willReturn(array('output' => 'No such service : failedservice', 'code' => 1));
        $this->mockedManager->run('failedservice', 'echo test', $composeFiles);
    }

    /**
     * Test run with project
     */
    public function testRuntWithprojectOption()
    {
        $composeFiles = new ComposeFileCollection(['/var/www/docker-compose-test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->mockedManager->method('execute')->willReturn(array('output' => 'test', 'code' => 0));
        $this->assertEquals($this->mockedManager->run('test', 'echo test', $composeFiles), "test");
    }
}
