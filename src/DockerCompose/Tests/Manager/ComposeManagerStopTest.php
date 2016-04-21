<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerTest extends PHPUnit_Framework_TestCase
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
    public function testStop()
    {
        $this->manager->method('execute')->with('docker-compose stop')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->stop(), 'ok');
    }

    /**
     * Test stop success with one compose file
     */
    public function testStopWithOneComposeFileSpecified()
    {

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml stop')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->stop('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test stop success with two compose files
     */
    public function testStopWithTwoComposeFilesSpecified()
    {

        $this->manager->method('execute')->with('docker-compose -f docker-compose.yml -f docker-compose.test.yml stop')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->stop(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
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
        $this->manager->method('execute')->with('docker-compose stop')->willReturn(array('output' => $error, 'code' => 1));
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
        $this->manager->method('execute')->with('docker-compose stop')->willReturn(array('output' => $error, 'code' => 1));
        $this->manager->stop();
    }

    /**
     * Test stop with DockerInstallationMissingException
     *
     * @expectedException \DockerCompose\Exception\DockerInstallationMissingException
     */
    public function testStopThrowDockerInstallationMissingException()
    {
        $this->manager->method('execute')->with('docker-compose stop')->willReturn(array('output' => '', 'code' => 127));
        $this->manager->stop();
    }
}
