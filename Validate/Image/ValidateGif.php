<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2018
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload\Validate\Image;

use \Upload\Core;
use \Upload\Validate\Image\ValidateImage;
use \Upload\Validate\ValidadeInterface;

class ValidateGif extends ValidateImage implements ValidadeInterface
{
    
    /**
     * Mime type file
     *
     * @var string
     */
    private $mimeTypeFile = "image/gif";

    /**
     * Get mime type file
     *
     * @return string
     */
    public function getMimeTypeFile() : string
    {
        return $this->mimeTypeFile;
    }

    /**
     * Execute validate
     *
     * @param Core $container
     * @return bool
     */
    function execute(Core $container) : bool
    {
         //file active
        $file = $container->getFileActive();

        //valid type file
        if ($container->getFileActive()['type'] != $this->getMimeTypeFile()) {
            $container->getMessage()->setFile($file)->setError('fileTypeError', [$file['type']]);
            return false;
        }

        //valid size
        $container->getValidate()->validSize($container, $this->getMaxSizeByte());

        //valid dimensions
        $this->validDimension($container);

        return true;
    }
}
