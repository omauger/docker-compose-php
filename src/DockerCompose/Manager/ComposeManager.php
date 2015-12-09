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
    public function start($composeFiles = array())
    {
        if (!$composeFiles instanceof ComposeFileCollection) {
            $composeFiles = new ComposeFileCollection($composeFiles);
        }

        $result = $this->execute(
            $this->formatCommand('up -d', $composeFiles)
        );

        return $this->processResult($result);
    }

    /**
     * Stop service containers
     *
     * @param mixed $composeFiles The compose files names
     */
    public function stop($composeFiles = array())
    {
        if (!$composeFiles instanceof ComposeFileCollection) {
            $composeFiles = new ComposeFileCollection($composeFiles);
        }

        $result = $this->execute(
            $this->formatCommand('stop', $composeFiles)
        );

        return $this->processResult($result);
    }

    /**
     * Stop service containers
     *
     * @param mixed   $composeFiles  The compose files names
     * @param boolean $force         If the remove need to be force (default=false)
     * @param boolean $removeVolumes If we need to remove the volumes (default=false)
     */
    public function remove($composeFiles = array(), $force = false, $removeVolumes = false)
    {
        if (!$composeFiles instanceof ComposeFileCollection) {
            $composeFiles = new ComposeFileCollection($composeFiles);
        }

        $command = 'rm';
        if ($force) {
            $command .= ' --force';
        }

        if ($removeVolumes) {
            $command .= ' -v';
        }

        $result = $this->execute(
            $this->formatCommand($command, $composeFiles)
        );

        return $this->processResult($result);
    }

    /**
     * Process result with returned code and output
     *
     * @param array $result The result of command with output and returnCode
     *
     * @throws DockerInstallationMissingException When returned code is 127
     * @throws ComposeFileNotFoundException When no compose file precise and docker-compose.yml not found
     * @throws DockerHostConnexionErrorException When we can't connect to docker host
     * @throws \Exception When an unknown error is returned
     */
    private function processResult($result)
    {
        if ($result['code'] === 127) {
            throw new DockerInstallationMissingException();
        }

        if ($result['code'] === 1) {
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

        return $result['output'];
    }

    /**
     * Format the command to execute
     *
     * @param string                $subcommand   The subcommand to pass to docker-compose command
     * @param ComposeFileCollection $composeFiles The compose files to precise in the command
     */
    private function formatCommand($subcommand, ComposeFileCollection $composeFiles)
    {
        $project = '';
        $networking = '';
        $networkDriver = '';
        # Add project name, and network options
        if ($composeFiles->getProjectName() != null) {
            $project = ' --project-name ' . $composeFiles->getProjectName();
            if ($composeFiles->isNetworking()) {
                $networking = ' --x-networking';
                if ($composeFiles->getNetworkDriver() != null) {
                    $networkDriver = ' --x-network-driver ' . $composeFiles->getNetworkDriver();
                }
            }
        }

        # Add files names
        $preciseFiles = '';
        foreach ($composeFiles->getAll() as $composeFile) {
            $preciseFiles .= ' -f ' . $composeFile->getFileName();
        }

        $command = 'docker-compose' . $preciseFiles . $networking . $networkDriver . $project . ' ' .$subcommand;

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
            'code' => $retval
        );
    }
}
