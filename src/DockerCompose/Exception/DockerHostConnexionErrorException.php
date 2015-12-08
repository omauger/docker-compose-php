<?php

namespace DockerCompose\Exception;

use Exception;

/**
 * Docker\Exception\ContainerNotFoundException
 */
class DockerHostConnexionErrorException extends Exception
{
    /**
     * @param string         $containerId
     * @param null|Exception $previous
     */
    public function __construct(Exception $previous = null)
    {
        parent::__construct(sprintf('Impossible to connect to docker host.'), 503, $previous);
    }
}
