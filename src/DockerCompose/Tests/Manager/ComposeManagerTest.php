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
     * Test start success with one compose file
     */
    public function testStartWithOneComposeFileSpecified()
    {

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml up -d')->willReturn(array('output' => 'ok', 'returnCode' => 0));
        $this->manager->start('docker-compose.test.yml');
    }

    /**
     * Test start success with two compose files
     */
    public function testStartWithTwoComposeFilesSpecified()
    {

        $this->manager->method('execute')->with('docker-compose -f docker-compose.yml -f docker-compose.test.yml up -d')->willReturn(array('output' => 'ok', 'returnCode' => 0));
        $this->manager->start(['docker-compose.yml', 'docker-compose.test.yml']);
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
        $this->manager->method('execute')->with('docker-compose up -d')->willReturn(array('output' => $error, 'returnCode' => 1));
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
        $this->manager->method('execute')->with('docker-compose up -d')->willReturn(array('output' => $error, 'returnCode' => 1));
        $this->manager->start();
    }

    /**
     * Test start with DockerInstallationMissingException
     *
     * @expectedException \DockerCompose\Exception\DockerInstallationMissingException
     */
    public function testStartThrowDockerInstallationMissingException()
    {
        $this->manager->method('execute')->with('docker-compose up -d')->willReturn(array('output' => '', 'returnCode' => 127));
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
     * Test stop success with one compose file
     */
    public function testStopWithOneComposeFileSpecified()
    {

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml stop')->willReturn(array('output' => 'ok', 'returnCode' => 0));
        $this->manager->stop('docker-compose.test.yml');
    }

    /**
     * Test stop success with two compose files
     */
    public function testStopWithTwoComposeFilesSpecified()
    {

        $this->manager->method('execute')->with('docker-compose -f docker-compose.yml -f docker-compose.test.yml stop')->willReturn(array('output' => 'ok', 'returnCode' => 0));
        $this->manager->stop(['docker-compose.yml', 'docker-compose.test.yml']);
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
        $this->manager->method('execute')->with('docker-compose stop')->willReturn(array('output' => $error, 'returnCode' => 1));
        $this->manager->stop();
    }

    /**
     * Test stop with DockerInstallationMissingException
     *
     * @expectedException \DockerCompose\Exception\DockerInstallationMissingException
     */
    public function testStopThrowDockerInstallationMissingException()
    {
        $this->manager->method('execute')->with('docker-compose stop')->willReturn(array('output' => '', 'returnCode' => 127));
        $this->manager->stop();
    }

    /**
     *  Test remove whithout error
     */
    public function testRemove()
    {
        $this->manager->method('execute')->with('docker-compose rm')->willReturn(array('output' => 'ok', 'returnCode' => 0));
        $this->manager->remove();
    }

    /**
     *  Test remove force
     */
    public function testRemoveForce()
    {
        $this->manager->method('execute')->with('docker-compose rm -f')->willReturn(array('output' => 'ok', 'returnCode' => 0));
        $this->manager->remove([], true);
    }

    /**
     * Test remove success with one compose file
     */
    public function testRemoveWithOneComposeFileSpecified()
    {

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml rm')->willReturn(array('output' => 'ok', 'returnCode' => 0));
        $this->manager->remove('docker-compose.test.yml');
    }

    /**
     * Test remove success with two compose files
     */
    public function testRemoveWithTwoComposeFilesSpecified()
    {

        $this->manager->method('execute')->with('docker-compose -f docker-compose.yml -f docker-compose.test.yml rm')->willReturn(array('output' => 'ok', 'returnCode' => 0));
        $this->manager->remove(['docker-compose.yml', 'docker-compose.test.yml']);
    }

    /**
     * Test remove with ComposeFileNotFoundException
     *
     * @expectedException \DockerCompose\Exception\ComposeFileNotFoundException
     */
    public function testRemoveThrowComposeFileNotFound()
    {
        $error = 'Can\'t find a suitable configuration file in this directory or any parent. Are you in the right directory?\n';
        $error .= 'Supported filenames: docker-compose.yml, docker-compose.yaml, fig.yml, fig.yaml';
        $this->manager->method('execute')->with('docker-compose rm')->willReturn(array('output' => $error, 'returnCode' => 1));
        $this->manager->remove();
    }

    /**
     * Test remove with DockerHostConnexionErrorException
     *
     * @expectedException \DockerCompose\Exception\DockerHostConnexionErrorException
     */
    public function testRemoveThrowDockerHostConnexionErrorException()
    {
        $error = 'Couldn\'t connect to Docker daemon at http+docker://localunixsocket - is it running?\n';
        $error .= 'If it\'s at a non-standard location, specify the URL with the DOCKER_HOST environment variable.';
        $this->manager->method('execute')->with('docker-compose rm')->willReturn(array('output' => $error, 'returnCode' => 1));
        $this->manager->remove();
    }

    /**
     * Test remove with DockerInstallationMissingException
     *
     * @expectedException \DockerCompose\Exception\DockerInstallationMissingException
     */
    public function testRemoveThrowDockerInstallationMissingException()
    {
        $this->manager->method('execute')->with('docker-compose rm')->willReturn(array('output' => '', 'returnCode' => 127));
        $this->manager->remove();
    }
}
