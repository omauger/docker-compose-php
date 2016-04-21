<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerStartTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test simple start without error
     */
    public function testStart()
    {
        $this->manager->method('execute')->with('docker-compose up -d')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->start(), 'ok');
    }

    /**
     * Test start success with one compose file
     */
    public function testStartWithOneComposeFileSpecified()
    {
        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml up -d')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->start('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test start success with two compose files
     */
    public function testStartWithTwoComposeFilesSpecified()
    {
        $this->manager->method('execute')->with('docker-compose -f docker-compose.yml -f docker-compose.test.yml up -d')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->start(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }

    /**
     * Test start with project option
     */
    public function testStartWithprojectOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml --project-name unittest up -d')->willReturn(array('output' => 'ok', 'code' => 0));

        $this->assertEquals($this->manager->start($composeFiles), 'ok');

    }

    /**
     * Test start with ComposeFileNotFoundException
     *
     * @expectedException \DockerCompose\Exception\ComposeFileNotFoundException
     */
    public function testStartThrowComposeFileNotFound()
    {
        $error = 'Can\'t find a suitable configuration file in this directory or any parent. Are you in the right directory?\n';
        $error .= 'Supported filenames: docker-compose.yml, docker-compose.yaml, fig.yml, fig.yaml';
        $this->manager->method('execute')->with('docker-compose up -d')->willReturn(array('output' => $error, 'code' => 1));
        $this->manager->start();
    }

    /**
     * Test start with DockerHostConnexionErrorException
     *
     * @expectedException \DockerCompose\Exception\DockerHostConnexionErrorException
     */
    public function testStartThrowDockerHostConnexionErrorException()
    {
        $error = 'Couldn\'t connect to Docker daemon at http+docker://localunixsocket - is it running?\n';
        $error .= 'If it\'s at a non-standard location, specify the URL with the DOCKER_HOST environment variable.';
        $this->manager->method('execute')->with('docker-compose up -d')->willReturn(array('output' => $error, 'code' => 1));
        $this->manager->start();
    }

    /**
     * Test start with DockerInstallationMissingException
     *
     * @expectedException \DockerCompose\Exception\DockerInstallationMissingException
     */
    public function testStartThrowDockerInstallationMissingException()
    {
        $this->manager->method('execute')->with('docker-compose up -d')->willReturn(array('output' => '', 'code' => 127));
        $this->manager->start();
    }

    /**
     * Test start with DockerInstallationMissingException
     *
     * @expectedException \Exception
     */
    public function testStartThrowUnknownException()
    {
        $this->manager->method('execute')->with('docker-compose up -d')->willReturn(array('output' => '', 'code' => 1));
        $this->manager->start();
    }
}
