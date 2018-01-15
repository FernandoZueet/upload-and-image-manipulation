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

class ResizeImage extends Save implements SaveInterface
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
     * Width resize
     *
     * @var int
     */
    private $width = 0;

    /**
     * Height resize
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
     * Get width resize
     *
     * @return int
     */
    public function getWidth() : int
    {
        return $this->width;
    }

    /**
     * Set width resize
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
     * Get height resize
     *
     * @return int
     */
    public function getHeight() : int
    {
        return $this->height;
    }

    /**
     * Set height resize
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
            throw new \UnexpectedValueException("ResizeImage - The setPorc value should be between 0 and 100");
        }

        //valid width
        if ($this->getWidth() < 0) {
            throw new \UnexpectedValueException("ResizeImage - setWidth required");
        }

        //valid height
        if ($this->getHeight() < 0) {
            throw new \UnexpectedValueException("ResizeImage - setHeight required");
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
     * Image Resize
     *
     * @param array $file
     * @link imagecreatetruecolor http://php.net/manual/pt_BR/function.imagecreatetruecolor.php
     * @link imagecopyresampled http://php.net/manual/pt_BR/function.imagecopyresampled.php
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
        }else{
            $directory = $this->getDirectory().'/'.$file['new_name'];
        }

        //id image resource
        $image = $imggd->imgCreateFrom($file, $file['tmp_name']);

        //resize calc
        $width      = $this->getWidth();
        $height     = $this->getHeight();
        $ratio_orig = $file['width'] / $file['height'];
        if ($width/$height > $ratio_orig) {
            $width = $height * $ratio_orig;
        } else {
            $height = $width / $ratio_orig;
        }

        //image create
        $thumb = imagecreatetruecolor($width, $height);

        //transparency image
        if ($file['type'] == "image/png" || $file['type'] == "image/gif") {
            $imggd->setTransparency($thumb);
        }

        //image resize
        imagecopyresampled($thumb, $image, 0, 0, 0, 0, $width, $height, $file['width'], $file['height']);
        if ($imggd->imgGenerate($thumb, $file, $directory, $this->getPorc(), $this->getSaveAs())) {
            return true;
        } else {
            return false;
        }
    }
}
