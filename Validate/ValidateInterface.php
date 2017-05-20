<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2017
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload\Validate;

use \Upload\Core;

interface ValidadeInterface
{
    
    /**
     * get mime trype file
     *
     * @return string
     */
    function getMimeTypeFile() : string;

    /**
     * execute validate type file
     *
     * @param Core $container
     * @return bool
     */
    function execute(Core $container) : bool;

    /**
     * set max size byte permitted file
     *
     * @param int $maxSizeByte
     * @return void
     */
    function setMaxSizeByte(int $maxSizeByte);

    /**
     * get max size byte permitted file
     *
     * @return int
     */
    function getMaxSizeByte() : int;
}
