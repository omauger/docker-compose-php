<?php

namespace DockerCompose;

use Exception;

/**
 * DockerCompose\ComposeFileCollection
 */
class ComposeFileCollection
{
    /**
     * @var ComposeFiles
     */
    private $composeFiles = [];

    /**
     * @var projectName
     */
    private $projectName;

    /**
     * @var isNetworking
     */
    private $isNetworking = false;

    /**
     * @var networkingDriver
     */
    private $networkDriver = null;

    /**
     * @param array of string or ComposeFile
     *
     * @throws \Exception When a composeFile definition is invalid
     */
    public function __construct()
    {
        $args = func_get_arg(0);

        if (is_string($args)) {
            $this->add(new ComposeFile($args));
        } else {
            foreach ($args as $composeFile) {
                if ($composeFile instanceof ComposeFile) {
                    $this->add($composeFile);
                } elseif (is_string($composeFile)) {
                    $this->add(new ComposeFile($composeFile));
                } else {
                    throw new \Exception(
                        'Invalid composeFile definition "('.gettype(
                            $composeFile
                        ).') '.var_export(
                            $composeFile,
                            true
                        ).'"'
                    );
                }
            }
        }

        return $this;
    }

    /**
     * Return all composeFiles
     *
     * @return array
     */
    public function getAll()
    {
        return $this->composeFiles;
    }

    /**
     * Add a compose file
     */
    public function add(ComposeFile $composeFile)
    {
        $this->composeFiles[] = $composeFile;
        return $this;
    }

    /**
     * Set Project Name
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
        return $this;
    }

    /**
     * Get Project Name
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * Set is Networking
     */
    public function setIsNetworking($isNetworking)
    {
        $this->isNetworking = $isNetworking;
        return $this;
    }

    /**
     * Get if is Networking
     */
    public function isNetworking()
    {
        return $this->isNetworking;
    }

    /**
     * Set Networking driver
     *
     * @throws Exception When $networkDriver is not a valid driver
     */
    public function setNetworkDriver($networkDriver)
    {
        if ($networkDriver != 'overlay' && $networkDriver != 'bridge' && $networkDriver != 'host') {
            throw new Exception($networkDriver . ' is not a valid driver.');
        }

        $this->networkDriver = $networkDriver;
        return $this;
    }

    /**
     * Get networking driver
     */
    public function getNetworkDriver()
    {
        return $this->networkDriver;
    }
}
