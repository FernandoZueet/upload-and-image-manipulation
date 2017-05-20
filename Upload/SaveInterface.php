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

interface SaveInterface
{
    
    /**
     * executes validate
     *
     * @param Core $container
     * @return void
     */
    public function valid(Core $container);

    /**
     * execute function
     *
     * @param Core $container
     * @return bool
     */
    public function execute(Core $container) : bool;

    /**
     * get directory upload
     *
     * @return string
     */
    public function getDirectory() : string;

    /**
     * set directory upload
     *
     * @param string $directory
     * @return void
     */
    public function setDirectory(string $directory);
}
