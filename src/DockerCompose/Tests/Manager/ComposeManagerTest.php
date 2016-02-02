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
     * Test start with project and networking option
     */
    public function testStartWithprojectAndNetworkingOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest')->setIsNetworking(true);

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml --x-networking --project-name unittest up -d')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->start($composeFiles), 'ok');
    }

    /**
     * Test start with project, networking and network driver option
     */
    public function testStartWithprojectAndNetworkingWithDriverOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest')->setIsNetworking(true)->setNetworkDriver('overlay');

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml --x-networking --x-network-driver overlay --project-name unittest up -d')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->start($composeFiles), 'ok');
    }

    /**
     * Test start with ComposeFileNotFoundException
     *
     * @expectedException \Exception
     */
    public function testStartThrowExceptionForDriver()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest')->setIsNetworking(true)->setNetworkDriver('boom');
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
    public function testRuntWithprojectAndNetworkingWithDriverOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest')->setIsNetworking(true)->setNetworkDriver('overlay');

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml --x-networking --x-network-driver overlay --project-name unittest run --rm test mycommand')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->run('test', 'mycommand', $composeFiles), 'ok');
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

    /**
     * Test simple restart without error
     */
    public function testRestart()
    {
        $this->manager->method('execute')->with('docker-compose restart')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->restart(), 'ok');
    }

    /**
     * Test simple restart with timeout
     */
    public function testRestartWithTimeout()
    {
        $this->manager->method('execute')->with('docker-compose restart --timeout=30')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->restart([], 30), 'ok');
    }

    /**
     * Test restart success with one compose file
     */
    public function testRestartWithOneComposeFileSpecified()
    {
        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml restart')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->restart('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test restart success with two compose files
     */
    public function testRestartWithTwoComposeFilesSpecified()
    {
        $this->manager->method('execute')->with('docker-compose -f docker-compose.yml -f docker-compose.test.yml restart')->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->restart(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }

    /**
     * Test restart with project option
     */
    public function testRestartWithprojectOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->manager->method('execute')->with('docker-compose -f docker-compose.test.yml --project-name unittest restart')->willReturn(array('output' => 'ok', 'code' => 0));

        $this->assertEquals($this->manager->restart($composeFiles), 'ok');

    }
}
