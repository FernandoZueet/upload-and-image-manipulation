<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2017
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload\Langs;

class Messages
{

    /**
     * messages errors
     *
     * @var array
     */
    private $errors = [];

    /**
     * file array
     *
     * @var array
     */
    private $file;

    /**
     * get file array
     *
     * @return array
     */
    public function getFile() : array
    {
        return $this->file;
    }

    /**
     * set file array
     *
     * @param array $file
     * @return void
     */
    public function setFile(array $file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * set message array
     *
     * @param string $indiceMessage
     * @param array $args
     * @return void
     */
    public function setError(string $indiceMessage, array $args = [])
    {
        $this->errors[$this->getFile()['name']][] = vsprintf($this->$indiceMessage, $args);
    }

    /**
     * get errors messages
     *
     * @return array
     */
    public function getError() : array
    {
        if ($this->errors) {
            return $this->errors;
        } else {
            return [];
        }
    }
}
