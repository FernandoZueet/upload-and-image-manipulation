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
use \Upload\Save;
use \Upload\SaveInterface;

class RotateImage extends Save implements SaveInterface
{

    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * porc
     *
     * @var int
     */
    private $porc = 100;

    /**
     * rotate image
     *
     * @var int
     */
    private $rotate = 0;

    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * get porc
     *
     * @return int
     */
    public function getPorc() : int
    {
        return $this->porc;
    }

    /**
     * set porc
     *
     * @param int $porc
     * @return void
     */
    public function setPorc(int $porc)
    {
        $this->porc = $porc;
        return $this;
    }

    /**
     * get rotate image
     *
     * @return int
     */
    public function getRotate() : int
    {
        return $this->rotate;
    }

    /**
     * set rotate image
     *
     * @param int $rotate
     * @return void
     */
    public function setRotate(int $rotate)
    {
        $this->rotate = $rotate;
    }

    /*-------------------------------------------------------------------------------------
    * Other Methods
    *-------------------------------------------------------------------------------------*/

    /**
     * executes validate
     *
     * @param Core $container
     * @throws Exception
     * @return void
     */
    public function valid(Core $container)
    {
        //valid directory
        $this->validDiretory();

        //valid porc
        if ($this->getPorc() < 0 || $this->getPorc() > 100) {
            throw new \UnexpectedValueException("RotateImage - The setPorc value should be between 0 and 100");
        }

        //valid rotate
        if ($this->getRotate() > 360 || $this->getRotate() < 0) {
            throw new \UnexpectedValueException("RotateImage - The setRotate value should be between 0 and 360");
        }

        //valid is image
        $image = new \Upload\Validate\Image\ValidateImage();
        $image->validImageFormat($container);
    }

    /**
     * Image Rotate
     *
     * @param array $file
     * @link imagecreatetruecolor http://php.net/manual/pt_BR/function.imagecreatetruecolor.php
     * @link imagerotate http://php.net/manual/pt_BR/function.imagerotate.php
     * @link imagecolorallocatealpha http://php.net/manual/pt_BR/function.imagecolorallocatealpha.php
     * @return bool
     */
    public function execute(Core $container) : bool
    {
        //gd instance
        $imggd = new \Upload\Utils\ImageGd();

        //active file
        $file = $container->getFileActive();

        //directory final
        $directory = $this->getDirectory().'/'.$file['new_name'];

        //id image resource
        $image = $imggd->imgCreateFrom($file, $file['tmp_name']);

        //image rotate
        $rotation = imagerotate($image, $this->getRotate(), imageColorAllocateAlpha($image, 0, 0, 0, 127));

        //transparency image
        if ($file['type'] == "image/png" || $file['type'] == "image/gif") {
            $thumb = imagecreatetruecolor($file['width'], $file['height']);
            $imggd->setTransparency($thumb);
        }

        //image generate
        if ($imggd->imgGenerate($rotation, $file, $directory, $this->getPorc())) {
            return true;
        } else {
            return false;
        }
    }
}
