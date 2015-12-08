<?php

namespace DockerCompose\Exception;

use Exception;

/**
 * Docker\Exception\ContainerNotFoundException
 */
class DockerInstallationMissingException extends Exception
{
    /**
     * @param string         $containerId
     * @param null|Exception $previous
     */
    public function __construct(Exception $previous = null)
    {
        parent::__construct(sprintf('Please install docker and docker-compose.'), 503, $previous);
    }
}
