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

class TextImage extends Save implements SaveInterface
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
     * Rgb color text
     *
     * @var array
     */
    private $rgbColor = [0,0,0];

    /**
     * Size font text
     *
     * @var int
     */
    private $size = 16;

    /**
     * Angle text
     *
     * @var int
     */
    private $angle = 0;

    /**
     * X
     *
     * @var int
     */
    private $x = 50;

    /**
     * Y
     *
     * @var int
     */
    private $y = 50;

    /**
     * Font file text
     *
     * @var string
     */
    private $fontFile = "";

    /**
     * Text image
     *
     * @var string
     */
    private $text = "";
   
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
     * Get rgb color text
     *
     * @return array
     */
    public function getRgbColor() : array
    {
        return $this->rgbColor;
    }

    /**
     * Set rgb color text
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
     * Get size font
     *
     * @return int
     */
    public function getSize() : int
    {
        return $this->size;
    }

    /**
     * Set size font
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
     * Get angle font
     *
     * @return int
     */
    public function getAngle() : int
    {
        return $this->angle;
    }

    /**
     * Set angle font
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
     * Get x font
     *
     * @return int
     */
    public function getX() : int
    {
        return $this->x;
    }

    /**
     * Set x font
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
     * Get y font
     *
     * @return int
     */
    public function getY() : int
    {
        return $this->y;
    }

    /**
     * Set y font
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
     * Get font file
     *
     * @return string
     */
    public function getFontFile() : string
    {
        return $this->fontFile;
    }

    /**
     * Set font file
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
     * Get text
     *
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * Set text
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

        //valid save as
        if($this->getSaveAs()) {
            $image->validIsImageSaveAs($this->getSaveAs());
        }
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
        if ($this->getSaveAs()) {
            $directory = $this->getDirectory().'/'.pathinfo($this->getDirectory().'/'.$file['new_name'], PATHINFO_FILENAME).'.'.$this->getSaveAs();
        } else {
            $directory = $this->getDirectory().'/'.$file['new_name'];
        }

        //id image resource
        $image = $imggd->imgCreateFrom($file, $file['tmp_name']);

        //transparency image
        if ($file['type'] == "image/png" || $file['type'] == "image/gif") {
            $thumb = imagecreatetruecolor($file['width'], $file['height']);
            $imggd->setTransparency($thumb);
        }

        //image text
        imagettftext($image, $this->getSize(), $this->getAngle(), $this->getX(), $this->getY(), imagecolorallocate($image, $this->getRgbColor()[0], $this->getRgbColor()[1], $this->getRgbColor()[2]), $this->getFontFile(), $this->getText());
        if ($imggd->imgGenerate($image, $file, $directory, $this->getPorc(), $this->getSaveAs())) {
            return true;
        } else {
            return false;
        }
    }
}
