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

class CropImage extends Save implements SaveInterface
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
     * x crop
     *
     * @var int
     */
    private $x = 0;

    /**
     * y crop
     *
     * @var int
     */
    private $y = 0;

    /**
     * width crop
     *
     * @var int
     */
    private $width = 0;

    /**
     * height crop
     *
     * @var int
     */
    private $height = 0;

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
     * get x crop
     *
     * @return int
     */
    public function getX() : int
    {
        return $this->x;
    }

    /**
     * set x crop
     *
     * @param int $x
     * @return void
     */
    public function setX(int $x)
    {
        $this->x = $x;
        return $this;
    }

    /**
     * get y crop
     *
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * set y crop
     *
     * @param int $y
     * @return void
     */
    public function setY(int $y)
    {
        $this->y = $y;
        return $this;
    }

    /**
     * get width crop
     *
     * @return int
     */
    public function getWidth() : int
    {
        return $this->width;
    }

    /**
     * set width crop
     *
     * @param int $width
     * @return void
     */
    public function setWidth(int $width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * get height crop
     *
     * @return int
     */
    public function getHeight() : int
    {
        return $this->height;
    }

    /**
     * set height crop
     *
     * @param int $height
     * @return void
     */
    public function setHeight(int $height)
    {
        $this->height = $height;
        return $this;
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
            throw new \UnexpectedValueException("CropImage - The setPorc value should be between 0 and 100");
        }

        //valid width
        if ($this->getWidth() < 0) {
            throw new \UnexpectedValueException("CropImage - setWidth required");
        }

        //valid height
        if ($this->getHeight() < 0) {
            throw new \UnexpectedValueException("CropImage - setHeight required");
        }
       
        //valid is image
        $image = new \Upload\ValidateImage();
        $image->validImageFormat($container);
    }

    /**
     * Image Crop
     *
     * @param array $file
     * @link imagecreatetruecolor http://php.net/manual/pt_BR/function.imagecreatetruecolor.php
     * @link imagecrop http://php.net/manual/pt_BR/function.imagecrop.php
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

        //transparency image
        if ($file['type'] == "image/png" || $file['type'] == "image/gif") {
            $thumb = imagecreatetruecolor($this->getWidth(), $this->getHeight());
            $imggd->setTransparency($thumb);
        }

        //image crop
        $img = imagecrop($image, ['x' => $this->getX(), 'y' => $this->getY(), 'width' => $this->getWidth(), 'height' => $this->getHeight()]);
        if ($img !== false) {
            if ($imggd->imgGenerate($img, $file, $directory, $this->getPorc())) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
