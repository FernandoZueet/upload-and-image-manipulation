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

interface MessagesInterface
{

    /**
     * Get file
     *
     * @return array
     */
    public function getFile() : array;

    /**
     * Set file array
     *
     * @param array $file
     * @return void
     */
    public function setFile(array $file);

    /**
     * Set message array
     *
     * @param string $indiceMessage
     * @param array $args
     * @return void
     */
    public function setError(string $indiceMessage, array $args = []);

    /**
     * Get errors messages
     *
     * @return array
     */
    public function getError() : array;
}
