<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerRemoveTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     *  Test remove whithout error
     */
    public function testRemove()
    {
        $this->manager->method('execute')->with('docker-compose rm')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->remove(), 'ok');
    }

    /**
     *  Test remove force
     */
    public function testRemoveForce()
    {
        $this->manager->method('execute')->with('docker-compose rm --force')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->remove([], true), 'ok');
    }

    /**
     *  Test remove volumes
     */
    public function testRemoveVolumes()
    {
        $this->manager->method('execute')->with('docker-compose rm -v')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->remove([], false, true), 'ok');
    }

    /**
     *  Test remove force and volumes
     */
    public function testRemoveForceAndVolumes()
    {
        $this->manager->method('execute')->with('docker-compose rm --force -v')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->remove([], true, true), 'ok');
    }

    /**
     * Test remove success with one compose file
     */
    public function testRemoveWithOneComposeFileSpecified()
    {

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml rm')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->remove('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test remove success with two compose files
     */
    public function testRemoveWithTwoComposeFilesSpecified()
    {

        $this->manager->method('execute')->with('docker-compose -f docker-compose.yml -f docker-compose.test.yml rm')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->remove(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
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
        $this->manager->method('execute')->with('docker-compose rm')->willReturn(array('output' => $error, 'code' => 1));
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
        $this->manager->method('execute')->with('docker-compose rm')->willReturn(array('output' => $error, 'code' => 1));
        $this->manager->remove();
    }

    /**
     * Test remove with DockerInstallationMissingException
     *
     * @expectedException \DockerCompose\Exception\DockerInstallationMissingException
     */
    public function testRemoveThrowDockerInstallationMissingException()
    {
        $this->manager->method('execute')->with('docker-compose rm')->willReturn(array('output' => '', 'code' => 127));
        $this->manager->remove();
    }
}
