<?php

namespace DockerCompose\Manager;

use DockerCompose\Exception\ComposeFileNotFoundException;
use DockerCompose\Exception\DockerHostConnexionErrorException;
use DockerCompose\Exception\DockerInstallationMissingException;
use DockerCompose\ComposeFileCollection;
use Exception;

/**
 * DockerCompose\Manager\ComposeManager
 */
class ComposeManager
{

    /**
     * Start service containers
     *
     * @param mixed $composeFiles The compose files names
     */
    public function start($composeFiles=array())
    {
        $result = $this->execute(
            $this->formatCommand('up -d', new ComposeFileCollection($composeFiles))
        );
        $this->processResult($result);
    }

    /**
     * Stop service containers
     *
     * @param mixed $composeFiles The compose files names
     */
    public function stop($composeFiles=array())
    {
        $result = $this->execute(
            $this->formatCommand('stop', new ComposeFileCollection($composeFiles))
        );
        $this->processResult($result);
    }

    /**
     * Stop service containers
     *
     * @param mixed $composeFiles The compose files names
     */
    public function remove($composeFiles=array(), $force=false)
    {
        $command = 'rm';
        if ($force) {
            $command .= ' -f';
        }

        $result = $this->execute(
            $this->formatCommand($command, new ComposeFileCollection($composeFiles), $extraArgs)
        );
        $this->processResult($result);
    }

    /**
     * Process result with returned code and output
     *
     * @throws DockerInstallationMissingException When returned code is 127
     * @throws ComposeFileNotFoundException When no compose file precise and docker-compose.yml not found
     * @throws DockerHostConnexionErrorException When we can't connect to docker host
     * @throws \Exception When an unknown error is returned
     */
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

    private function formatCommand($subcommand, ComposeFileCollection $composeFiles)
    {
        $preciseFiles = '';
        foreach ($composeFiles->getAll() as $composeFile) {
            $preciseFiles .= '-f ' . $composeFile->getFileName() . ' ';
        }

        $command = 'docker-compose ' . $preciseFiles . $subcommand;

        return $command;
    }

    /**
     * Execute docker-compose commande
     *
     * @param string                $command      The command to execute
     * @param ComposeFileCollection $composeFiles The compose files to use for command
     */
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
