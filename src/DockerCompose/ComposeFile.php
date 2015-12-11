<?php


namespace DockerCompose;

use Exception;

/**
 * DockerCompose\ComposeFile
 */
class ComposeFile
{
    /**
     * @var string
     */
    private $fileName;

    /**
     * @param string
     *
     * @throws \Exception When the file name is not a string
     */
    public function __construct()
    {
        $name = func_get_arg(0);

        if (is_string($name)) {
            $this->setFileName($name);
        } else {
            throw new Exception(
                'Invalid fileName definition "(' . gettype($name) . ') ' . var_export($name, true) . '"'
            );
        }
    }

    /**
     * Get file name
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set the file name
     *
     * @param string $fileName The name of file to set
     *
     * @return ComposeFile
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }
}
