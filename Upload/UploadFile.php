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
use \Upload\Save;
use \Upload\SaveInterface;

class UploadFile extends Save implements SaveInterface
{

    /**
     * Executes validate
     *
     * @param Core $container
     * @return void
     */
    public function valid(Core $container)
    {
        //valid directory
        $this->validDiretory();

        //valid save as
        if($this->getSaveAs()) {
            throw new \UnexpectedValueException("setSaveImageAs Not supported in upload function");
        }
    }

    /**
     * File Upload
     *
     * @param array $file
     * @return bool
     */
    public function execute(Core $container) : bool
    {
        //file active
        $file = $container->getFileActive();

        //directory final
        $directory = $this->getDirectory().'/'.$file['new_name'];

        //upload
        if (copy($file['tmp_name'], $directory)) {
            return true;
        } else {
            return false;
        }
    }
}
