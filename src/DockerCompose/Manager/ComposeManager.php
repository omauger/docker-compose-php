<?php

namespace DockerCompose\Manager;

use DockerCompose\Exception\ComposeFileNotFoundException;
use DockerCompose\Exception\DockerHostConnexionErrorException;
use DockerCompose\Exception\DockerInstallationMissingException;
use DockerCompose\Exception\NoSuchServiceException;
use DockerCompose\ComposeFileCollection;
use mikehaertl\shellcommand\Command;
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
        return $this->processResult(
            $this->execute(
                $this->formatCommand('up -d', $this->createComposeFileCollection($composeFiles))
            )
        );
    }

    /**
     * Stop service containers
     *
     * @param mixed $composeFiles The compose files names
     */
    public function stop($composeFiles = array())
    {
        return $this->processResult(
            $this->execute(
                $this->formatCommand('stop', $this->createComposeFileCollection($composeFiles))
            )
        );
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
        $command = 'rm';
        if ($force) {
            $command .= ' --force';
        }

        if ($removeVolumes) {
            $command .= ' -v';
        }

        return $this->processResult(
            $this->execute(
                $this->formatCommand($command, $this->createComposeFileCollection($composeFiles))
            )
        );
    }

    /**
     * Build service images
     *
     * @param mixed   $composeFiles  The compose files names
     * @param boolean $pull          If we want attempt to pull a newer version of the from image
     * @param boolean $forceRemove   If we want remove the intermediate containers
     * @param bollean $cache         If we can use the cache when building the image
     */
    public function build($composeFiles = array(), $pull = true, $forceRemove = false, $cache = true)
    {
        $command = 'build';

        if ($pull) {
            $command .= ' --pull';
        }

        if ($forceRemove) {
            $command .= ' --force-rm';
        }

        if (!$cache) {
            $command .= ' --no-cache';
        }

        return $this->processResult(
            $this->execute(
                $this->formatCommand($command, $this->createComposeFileCollection($composeFiles))
            )
        );
    }


    /**
     * Restart running containers
     *
     * @param mixed   $composeFiles  The compose files names
     * @param integer $timeout       If we want attempt to pull a newer version of the from image
     */
    public function restart($composeFiles = array(), $timeout = 10)
    {
        $command = 'restart';

        if ($timeout != 10) {
            $command .= ' --timeout='.$timeout;
        }

        return $this->processResult(
            $this->execute(
                $this->formatCommand($command, $this->createComposeFileCollection($composeFiles))
            )
        );
    }

    /**
     * Run service with command
     *
     * @param string $service Service name
     * @param string $command Command to pass to service
     * @param mixed   $composeFiles  The compose files names
     */
    public function run($service, $command, $composeFiles = array())
    {
        $command = 'run --rm ' . $service . ' ' . $command;
        $result = $this->execute(
            $this->formatCommand($command, $this->createComposeFileCollection($composeFiles))
        );

        if ($result['code'] == 1 && strpos($result['output'], 'No such service') != false) {
            throw new NoSuchServiceException($result['output']);
        }

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
     * Create the composeFileCollection from the type of value given
     *
     * @param mixed $composeFiles The docker-compose files (can be array, string or ComposeFile)
     *
     * @return ComposeFileCollection
     */
    private function createComposeFileCollection($composeFiles)
    {
        if (!$composeFiles instanceof ComposeFileCollection) {
            if (!is_array($composeFiles)) {
                return new ComposeFileCollection([$composeFiles]);
            } else {
                return new ComposeFileCollection($composeFiles);
            }
        } else {
            return $composeFiles;
        }
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

        $command = 'docker-compose' . $preciseFiles . $networking . $networkDriver . $project . ' ' . $subcommand;

        return $command;
    }

    /**
     * Execute docker-compose commande
     * @codeCoverageIgnore
     * @param string                $command      The command to execute
     */
    protected function execute($command)
    {
        $exec = new Command($command);

        if ($exec->execute()) {
            $output = $exec->getOutput();
        } else {
            $output = $exec->getError();
        }

        return array(
            'output' => $output,
            'code' => $exec->getExitCode()
        );
    }
}
