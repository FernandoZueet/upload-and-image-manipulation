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

use \Upload\Langs\Messages;
use \Upload\Langs\MessagesInterface;

class Eng extends Messages implements MessagesInterface
{

    private $sizeFileExced       = "File size %s exceeds %s allowed";
    private $fileErrorUploadParc = "File upload %s was partially uploaded";
    private $fileTypeError       = "File format %s is not allowed";
    private $imgErrorHeight      = "The image %s must have %s px height";
    private $imgErrorWidth       = "The image %s must have %s px Width";
    private $imgErrorDimension   = "The image %s must be in the dimensions: %s px Width by %s px Height";
    private $imgErrorMinHeight   = "The image %s must be greater than %s px Height";
    private $imgErrorMinWidth    = "The image %s must be greater than %s px Width";
    private $imgErrorMaxHeight   = "The image %s must be less than %s px Height";
    private $imgErrorMaxWidth    = "The image %s must be less than %s px Width";
    private $fileErrorMultiple   = "Only 1 file can be sent at a time";

    public function __get($atrib)
    {
        return $this->$atrib;
    }
}
