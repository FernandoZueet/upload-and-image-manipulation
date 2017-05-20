<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2017
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload\Validate\Doc;

use \Upload\Core;
use \Upload\Validate\Doc\ValidateDocument;
use \Upload\Validate\ValidadeInterface;

class ValidateDocx extends ValidateDocument implements ValidadeInterface
{
    
    /**
     * mime type file
     *
     * @var string
     */
    private $mimeTypeFile = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";

    /**
     * get mime type file
     *
     * @return string
     */
    public function getMimeTypeFile() : string
    {
        return $this->mimeTypeFile;
    }

    /**
     * execute validate
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

        return true;
    }
}
