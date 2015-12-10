<?php

namespace DockerCompose\Exception;

use Exception;

/**
 * Docker\Exception\ContainerNotFoundException
 */
class NoSuchServiceException extends Exception
{
    /**
     * @param string         $containerId
     * @param null|Exception $previous
     */
    public function __construct($output, Exception $previous = null)
    {
        parent::__construct(sprintf($output), 404, $previous);
    }
}
