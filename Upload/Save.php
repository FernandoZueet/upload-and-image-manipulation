<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2017
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload;

use \Upload\Core;

class Save
{
    
    /**
     * directory upload
     *
     * @var string
     */
    private $directory = "";

    /**
     * get directory upload
     *
     * @return string
     */
    public function getDirectory() : string
    {
        return $this->directory;
    }

    /**
     * set directory upload
     *
     * @param string $directory
     * @return void
     */
    public function setDirectory(string $directory)
    {
        $this->directory = $directory;
        return $this;
    }

    /**
     * valid diretory upload
     *
     * @param array $param
     * @throws Exception
     * @return void
     */
    public function validDiretory()
    {
        if (!is_dir($this->getDirectory())) {
            throw new \UnexpectedValueException("{$this->getDirectory()} directory not found.");
        }
    }
}
