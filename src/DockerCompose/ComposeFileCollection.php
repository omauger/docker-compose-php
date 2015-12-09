<?php

namespace DockerCompose;

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
                    throw new \Exception('Invalid composeFile definition "('.gettype($composeFile).') '.var_export($composeFile, true).'"');
                }
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

}
