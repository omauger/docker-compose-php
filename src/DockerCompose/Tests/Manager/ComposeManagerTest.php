<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;


class ComposeManagerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test start without error
     */
    public function testStart()
    {

        $this->manager->method('execute')->with('docker-compose up -d')->willReturn(array('output' => 'ok', 'returnCode' => 0));
        $this->manager->start();
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
        $this->manager->method('execute')->willReturn(array('output' => $error, 'returnCode' => 1));
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
        $this->manager->method('execute')->willReturn(array('output' => $error, 'returnCode' => 1));
        $this->manager->start();
    }

    /**
     * Test start with DockerInstallationMissingException
     *
     * @expectedException \DockerCompose\Exception\DockerInstallationMissingException
     */
    public function testStartThrowDockerInstallationMissingException()
    {
        $this->manager->method('execute')->willReturn(array('output' => '', 'returnCode' => 127));
        $this->manager->start();
    }

    /**
     *  Test stop whithout error
     */
    public function testStop()
    {
        $this->manager->method('execute')->with('docker-compose stop')->willReturn(array('output' => 'ok', 'returnCode' => 0));
        $this->manager->stop();
    }

    /**
     * Test stop with ComposeFileNotFoundException
     *
     * @expectedException \DockerCompose\Exception\ComposeFileNotFoundException
     */
    public function testStopThrowComposeFileNotFound()
    {
        $error = 'Can\'t find a suitable configuration file in this directory or any parent. Are you in the right directory?\n';
        $error .= 'Supported filenames: docker-compose.yml, docker-compose.yaml, fig.yml, fig.yaml';
        $this->manager->method('execute')->with('docker-compose stop')->willReturn(array('output' => $error, 'returnCode' => 1));
        $this->manager->stop();
    }

    /**
     * Test stop with DockerHostConnexionErrorException
     *
     * @expectedException \DockerCompose\Exception\DockerHostConnexionErrorException
     */
    public function testStopThrowDockerHostConnexionErrorException()
    {
        $error = 'Couldn\'t connect to Docker daemon at http+docker://localunixsocket - is it running?\n';
        $error .= 'If it\'s at a non-standard location, specify the URL with the DOCKER_HOST environment variable.';
        $this->manager->method('execute')->willReturn(array('output' => $error, 'returnCode' => 1));
        $this->manager->stop();
    }

    /**
     * Test stop with DockerInstallationMissingException
     *
     * @expectedException \DockerCompose\Exception\DockerInstallationMissingException
     */
    public function testStopThrowDockerInstallationMissingException()
    {
        $this->manager->method('execute')->willReturn(array('output' => '', 'returnCode' => 127));
        $this->manager->stop();
    }
}
