<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2018
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload\Validate\Doc;

use \Upload\Core;

class ValidateDocument
{

    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * Max size byte permitted file
     *
     * @var int
     */
    private $maxSizeByte = 2000000;


    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Get max size byte permitted file
     *
     * @return int
     */
    public function getMaxSizeByte() : int
    {
        return $this->maxSizeByte;
    }

    /**
     * Set max size byte permitted file
     *
     * @param int $maxSizeByte
     * @return void
     */
    public function setMaxSizeByte(int $maxSizeByte)
    {
        $this->maxSizeByte = $maxSizeByte;
        return $this;
    }
}
