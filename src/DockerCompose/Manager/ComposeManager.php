<?php

namespace DockerCompose\Manager;

use DockerCompose\Exception\ComposeFileNotFoundException;
use DockerCompose\Exception\DockerHostConnexionErrorException;
use DockerCompose\Exception\DockerInstallationMissingException;
use Exception;

/**
 * DockerCompose\Manager\ComposeManager
 */
class ComposeManager
{

    /**
     * Start service containers
     */
    public function start()
    {
        $result = $this->execute('docker-compose up -d');
        $this->processResult($result);
    }

    public function stop()
    {
        $result = $this->execute('docker-compose stop');
        $this->processResult($result);
    }

    public function remove()
    {
        $result = $this->execute('docker-compose rm');
        $this->processResult($result);
    }

    private function processResult($result)
    {
        if ($result['returnCode'] === 127) {
            throw new DockerInstallationMissingException();
        }

        if ($result['returnCode'] === 1) {
            if (!strpos($result['output'], 'DOCKER_HOST')) {
                if (!strpos($result['output'], 'docker-compose.yml')) {
                    throw new Exception($result['output']);
                } else {
                    throw new ComposeFileNotFoundException();
                }
            } else {
                throw new DockerHostConnexionErrorException();
            }

        }
    }

    protected function execute($command)
    {
        $command = system($command . ' > output 2>&1', $retval);

        $output = fopen('output', 'r');
        $output = fread($output, filesize('output'));
        unlink('output');

        return array(
            'output' => $output,
            'returnCode' => $retval
        );
    }
}
