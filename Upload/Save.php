<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2018
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload;

use \Upload\Core;

class Save
{
    
    /**
     * Directory upload
     *
     * @var string
     */
    private $directory = "";

    /**
     * Save  as
     *
     * @var string
     */
    private $saveAs = "";

    /**
     * Get directory upload
     *
     * @return string
     */
    public function getDirectory() : string
    {
        return $this->directory;
    }

    /**
     * Set directory upload
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
     * Valid diretory upload
     *
     * @param array $param
     * @throws Exception
     * @return void
     */
    public function validDiretory()
    {
        if (!is_dir($this->getDirectory())) {
            mkdir($this->getDirectory(), 0777, true);
        }
    }

    /**
     * Save as
     *
     * @param string $saveAs (jpg | png | gif | webp)
     * @return void
     */
    public function setSaveAs(string $saveAs) {
        $this->saveAs = $saveAs;
        return $this;
    }

    /**
     * Get save as
     *
     * @return string
     */
    public function getSaveAs() : string {
        return $this->saveAs;
    }

}
