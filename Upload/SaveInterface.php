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

interface SaveInterface
{
    
    /**
     * Executes validate
     *
     * @param Core $container
     * @return void
     */
    public function valid(Core $container);

    /**
     * Execute function
     *
     * @param Core $container
     * @return bool
     */
    public function execute(Core $container) : bool;

    /**
     * Get directory upload
     *
     * @return string
     */
    public function getDirectory() : string;

    /**
     * Set directory upload
     *
     * @param string $directory
     * @return void
     */
    public function setDirectory(string $directory);
}
