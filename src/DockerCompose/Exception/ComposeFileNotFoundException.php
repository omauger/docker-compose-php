<?php

namespace DockerCompose\Exception;

use Exception;

/**
 * Docker\Exception\ContainerNotFoundException
 */
class ComposeFileNotFoundException extends Exception
{
    /**
     * @param string         $containerId
     * @param null|Exception $previous
     */
    public function __construct(Exception $previous = null)
    {
        parent::__construct(sprintf('Docker compose file not found'), 404, $previous);
    }
}
