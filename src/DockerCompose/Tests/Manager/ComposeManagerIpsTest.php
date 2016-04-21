<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;


class ComposeManagerIpsTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = $this->getMockBuilder('\DockerCompose\Manager\ComposeManager')
            ->setMethods(['execute'])
            ->getMock();
    }

    /**
     * Test simple get ips containers
     */
    public function testIps()
    {
        $this->manager
            ->method('execute')
            ->with('for CONTAINER in $(docker-compose ps -q); do echo "$(docker inspect --format \' {{ .Name }} \' $CONTAINER)\t$(docker inspect --format \' {{ .NetworkSettings.IPAddress }} \' $CONTAINER)"; done')
            ->willReturn(array('output' => 'ok', 'code' => 0));

        $this->assertEquals($this->manager->ips(), 'ok');
    }

    /**
     * Test start success with one compose file
     */
    public function testIpsWithOneComposeFileSpecified()
    {
        $this->manager
        ->method('execute')
        ->with('for CONTAINER in $(docker-compose -f docker-compose.test.yml ps -q); do echo "$(docker inspect --format \' {{ .Name }} \' $CONTAINER)\t$(docker inspect --format \' {{ .NetworkSettings.IPAddress }} \' $CONTAINER)"; done')
        ->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->ips('docker-compose.test.yml'), 'ok');
    }

    /**
     * Test ips success with two compose files
     */
    public function testIpsWithTwoComposeFilesSpecified()
    {
        $this->manager
            ->method('execute')
            ->with('for CONTAINER in $(docker-compose -f docker-compose.yml -f docker-compose.test.yml ps -q); do echo "$(docker inspect --format \' {{ .Name }} \' $CONTAINER)\t$(docker inspect --format \' {{ .NetworkSettings.IPAddress }} \' $CONTAINER)"; done')
            ->willReturn(array('output' => 'ok', 'code' => 0));
        $this->assertEquals($this->manager->ips(['docker-compose.yml', 'docker-compose.test.yml']), 'ok');
    }

    /**
     * Test ips with project option
     */
    public function testIpsWithprojectOption()
    {
        $composeFiles = new ComposeFileCollection(['docker-compose.test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->manager
            ->method('execute')
            ->with('for CONTAINER in $(docker-compose -f docker-compose.test.yml --project-name unittest ps -q); do echo "$(docker inspect --format \' {{ .Name }} \' $CONTAINER)\t$(docker inspect --format \' {{ .NetworkSettings.IPAddress }} \' $CONTAINER)"; done')
            ->willReturn(array('output' => 'ok', 'code' => 0));

        $this->assertEquals($this->manager->ips($composeFiles), 'ok');
    }
}
