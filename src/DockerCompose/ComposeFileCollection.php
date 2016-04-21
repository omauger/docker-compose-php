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
     * @param array of string or ComposeFile
     *
     * @throws \Exception When a composeFile definition is invalid
     */
    public function __construct()
    {
        $args = func_get_arg(0);

        if (!is_array($args)) {
            throw new \Exception('Invalid parameter "(' . gettype($args) . ')');
        }

        foreach ($args as $composeFile) {
            if ($composeFile instanceof ComposeFile) {
                $this->add($composeFile);
            } elseif (is_string($composeFile)) {
                $this->add(new ComposeFile($composeFile));
            } else {
                throw new \Exception(
                    'Invalid composeFile definition "(' . gettype(
                        $composeFile
                    ) . ') ' . var_export(
                        $composeFile,
                        true
                    ) . '"'
                );
            }
        }
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
     *
     * @param string $projectName
     *
     * @return ComposeFileCollection
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
        return $this;
    }

    /**
     * Get Project Name
     *
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }
}
