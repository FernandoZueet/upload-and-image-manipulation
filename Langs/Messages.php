<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2018
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload\Langs;

class Messages
{

    /**
     * Messages errors
     *
     * @var array
     */
    private $errors = [];

    /**
     * File array
     *
     * @var array
     */
    private $file;

    /**
     * Get file array
     *
     * @return array
     */
    public function getFile() : array
    {
        return $this->file;
    }

    /**
     * Set file array
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
     * Set message array
     *
     * @param string $indiceMessage
     * @param array $args
     * @return void
     */
    public function setError(string $indiceMessage, array $args = [])
    {
        if (!array_key_exists(vsprintf($this->$indiceMessage, $args),$this->errors[$this->getFile()['name']])) {
            $this->errors[$this->getFile()['name']][] = vsprintf($this->$indiceMessage, $args);
        }
    }

    /**
     * Get errors messages
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
