<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2018
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload\Validate;

use \Upload\Core;

interface ValidadeInterface
{
    
    /**
     * Get mime trype file
     *
     * @return string
     */
    function getMimeTypeFile() : string;

    /**
     * Execute validate type file
     *
     * @param Core $container
     * @return bool
     */
    function execute(Core $container) : bool;

    /**
     * Set max size byte permitted file
     *
     * @param int $maxSizeByte
     * @return void
     */
    function setMaxSizeByte(int $maxSizeByte);

    /**
     * Get max size byte permitted file
     *
     * @return int
     */
    function getMaxSizeByte() : int;
}
