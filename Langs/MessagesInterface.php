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

interface MessagesInterface
{

    /**
     * get file
     *
     * @return array
     */
    public function getFile() : array;

    /**
     * set file array
     *
     * @param array $file
     * @return void
     */
    public function setFile(array $file);

    /**
     * set message array
     *
     * @param string $indiceMessage
     * @param array $args
     * @return void
     */
    public function setError(string $indiceMessage, array $args = []);

    /**
     * get errors messages
     *
     * @return array
     */
    public function getError() : array;
}
