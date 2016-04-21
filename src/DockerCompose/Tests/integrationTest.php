<?php

namespace DockerCompose\Tests\Manager;

use PHPUnit_Framework_TestCase;
use DockerCompose\ComposeFile;
use DockerCompose\ComposeFileCollection;
use DockerCompose\Manager\ComposeManager;


class ComposeManagerIntegrationTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = new ComposeManager();
    }

    /**
     * Test simple start without error
     *
     *  @expectedException \DockerCompose\Exception\ComposeFileNotFoundException
     */
    public function testThrowComposeFileNotFoundException()
    {
        $this->assertEquals($this->manager->start(), '');
    }

    /**
     * Test simple start, ps, stop and rm without error
     *
     */
    public function testSuccess()
    {
        $this->assertEquals($this->manager->start('/var/www/docker-compose-test.yml'), '');
        $result = $this->manager->ps('/var/www/docker-compose-test.yml');
        $this->assertEquals(strpos($result, 'www_test_1'), 118);
        $this->assertEquals($this->manager->stop('/var/www/docker-compose-test.yml'), '');
        $this->assertEquals($this->manager->remove('/var/www/docker-compose-test.yml'), 'Going to remove www_test_1');
    }

    /**
     * Test simple run without error
     *
     */
    public function testRunSuccess()
    {
        $composeFiles = new ComposeFileCollection(['/var/www/docker-compose-test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->assertEquals($this->manager->run('test', 'echo test', $composeFiles), "test");
    }

    /**
     * Test run
     * @expectedException \DockerCompose\Exception\NoSuchServiceException
     */
    public function testrunThrowNoSuchServiceException()
    {
        $composeFiles = new ComposeFileCollection(['/var/www/docker-compose-test.yml']);
        $composeFiles->setProjectName('unittest');

        $this->manager->run('failedservice', 'echo test', $composeFiles);
    }

}
