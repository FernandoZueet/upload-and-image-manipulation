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

class CropImage extends Save implements SaveInterface
{

    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * Porc 
     *
     * @var int
     */
    private $porc = 100;

    /**
     * X crop
     *
     * @var int
     */
    private $x = 0;

    /**
     * Y crop
     *
     * @var int
     */
    private $y = 0;

    /**
     * Width crop
     *
     * @var int
     */
    private $width = 0;

    /**
     * Height crop
     *
     * @var int
     */
    private $height = 0;

    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Get porc 
     *
     * @return int
     */
    public function getPorc() : int
    {
        return $this->porc;
    }

    /**
     * Set porc 
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
     * Get x crop
     *
     * @return int
     */
    public function getX() : int
    {
        return $this->x;
    }

    /**
     * Set x crop
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
     * Get y crop
     *
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * Set y crop
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
     * Get width crop
     *
     * @return int
     */
    public function getWidth() : int
    {
        return $this->width;
    }

    /**
     * Set width crop
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
     * Get height crop
     *
     * @return int
     */
    public function getHeight() : int
    {
        return $this->height;
    }

    /**
     * Set height crop
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
     * Executes validate
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
        $image = new \Upload\Validate\Image\ValidateImage();
        $image->validImageFormat($container);

        //valid save as
        if($this->getSaveAs()) {
            $image->validIsImageSaveAs($this->getSaveAs());
        }
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
        if ($this->getSaveAs()) {
            $directory = $this->getDirectory().'/'.pathinfo($this->getDirectory().'/'.$file['new_name'], PATHINFO_FILENAME).'.'.$this->getSaveAs();
        } else {
            $directory = $this->getDirectory().'/'.$file['new_name'];
        }

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
            if ($imggd->imgGenerate($img, $file, $directory, $this->getPorc(), $this->getSaveAs())) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
