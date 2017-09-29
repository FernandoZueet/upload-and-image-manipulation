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

class Validate
{

    /*-------------------------------------------------------------------------------------
    * Other Methods
    *-------------------------------------------------------------------------------------*/

    /**
     * valid type file
     *
     * @param Core $container
     * @param array $mimeTypes
     * @return bool
     */
    public function validTypeFile(Core $container, array $mimeTypes = null) : bool
    {
        if (!in_array($container->getFileActive()['type'], $mimeTypes ?? $container->getFileClass()->getMimeTypesPermited())) {
            return false;
        }
        return true;
    }
    
    /**
     * valid size file
     *
     * @param Core $container
     * @param int $maxSize
     * @return void
     */
    public function validSize(Core $container, int $maxSize)
    {
        //convert format byte
        $formatbyte = new \Upload\Utils\FormatBytes();
        $tamanhoMb = $formatbyte->formatBytes($maxSize, 2, true);

        //file active
        $file = $container->getFileActive();

        //valid size file
        if ($container->getFileActive()['size'] > $maxSize) {
            $container->getMessage()->setFile($file)->setError('sizeFileExced', [ $file['name'], $tamanhoMb ]);
        }

        //valid type errors
        if (isset($file['error'])) {
            switch ($file['error']) {
                case 1:
                    $container->getMessage()->setFile($file)->setError('sizeFileExced', [ $file['name'], $tamanhoMb ]);
                    break;
                case 3:
                    $container->getMessage()->setFile($file)->setError('fileErrorUploadParc', [ $file['name'] ]);
                    break;
            }
        }
    }
}
