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

class TextImage extends Save implements SaveInterface
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
     * rgb color text
     *
     * @var array
     */
    private $rgbColor = [0,0,0];

    /**
     * size font text
     *
     * @var int
     */
    private $size = 16;

    /**
     * angle text
     *
     * @var int
     */
    private $angle = 0;

    /**
     * x
     *
     * @var int
     */
    private $x = 50;

    /**
     * y
     *
     * @var int
     */
    private $y = 50;

    /**
     * font file text
     *
     * @var string
     */
    private $fontFile = "";

    /**
     * text image
     *
     * @var string
     */
    private $text = "";
   
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
     * get rgb color text
     *
     * @return array
     */
    public function getRgbColor() : array
    {
        return $this->rgbColor;
    }

    /**
     * set rgb color text
     *
     * @param array $rgbColor
     * @return void
     */
    public function setRgbColor(array $rgbColor)
    {
        $this->rgbColor = $rgbColor;
        return $this;
    }

    /**
     * get size font
     *
     * @return int
     */
    public function getSize() : int
    {
        return $this->size;
    }

    /**
     * set size font
     *
     * @param int $size
     * @return void
     */
    public function setSize(int $size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * get angle font
     *
     * @return int
     */
    public function getAngle() : int
    {
        return $this->angle;
    }

    /**
     * set angle font
     *
     * @param int $angle
     * @return void
     */
    public function setAngle(int $angle)
    {
        $this->angle = $angle;
        return $this;
    }

    /**
     * get x font
     *
     * @return int
     */
    public function getX() : int
    {
        return $this->x;
    }

    /**
     * set x font
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
     * get y font
     *
     * @return int
     */
    public function getY() : int
    {
        return $this->y;
    }

    /**
     * set y font
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
     * get font file
     *
     * @return string
     */
    public function getFontFile() : string
    {
        return $this->fontFile;
    }

    /**
     * set font file
     *
     * @param string $fontFile
     * @return void
     */
    public function setFontFile(string $fontFile)
    {
        $this->fontFile = $fontFile;
        return $this;
    }

    /**
     * get text
     *
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * set text
     *
     * @param string $text
     * @return void
     */
    public function setText(string $text)
    {
        $this->text = $text;
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
            throw new \UnexpectedValueException("TextImage - The setPorc value should be between 0 and 100");
        }

        //valid size
        if ($this->getSize() < 0) {
            throw new \UnexpectedValueException("TextImage - setSize required");
        }

        //valid font file
        if (!$this->getFontFile()) {
            throw new \UnexpectedValueException("TextImage - setFontFile required");
        }

        //valid is image
        $image = new \Upload\Validate\Image\ValidateImage();
        $image->validImageFormat($container);
    }

    /**
     * Image Text
     *
     * @param array $file
     * @link imagecreatetruecolor http://php.net/manual/pt_BR/function.imagecreatetruecolor.php
     * @link imagettftext http://php.net/manual/pt_BR/function.imagettftext.php
     * @link imagecolorallocate http://php.net/manual/pt_BR/function.imagecolorallocate.php
     * @return bool
     */
    public function execute(Core $container) : bool
    {
        //gd instance
        $imggd = new \Upload\Utils\ImageGd();

        //file active
        $file = $container->getFileActive();

        //directory final
        $directory = $this->getDirectory().'/'.$file['new_name'];

        //id image resource
        $image = $imggd->imgCreateFrom($file, $file['tmp_name']);

        //transparency image
        if ($file['type'] == "image/png" || $file['type'] == "image/gif") {
            $thumb = imagecreatetruecolor($file['width'], $file['height']);
            $imggd->setTransparency($thumb);
        }

        //image text
        imagettftext($image, $this->getSize(), $this->getAngle(), $this->getX(), $this->getY(), imagecolorallocate($image, $this->getRgbColor()[0], $this->getRgbColor()[1], $this->getRgbColor()[2]), $this->getFontFile(), $this->getText());
        if ($imggd->imgGenerate($image, $file, $directory, $this->getPorc())) {
            return true;
        } else {
            return false;
        }
    }
}
