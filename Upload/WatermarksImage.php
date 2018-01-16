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

class WatermarksImage extends Save implements SaveInterface
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
     * Image logo path
     *
     * @var string|array
     */
    private $imageLogo = "";

    /**
     * Right position logo
     *
     * @var int
     */
    private $right = 10;

    /**
     * Bottom position logo
     *
     * @var int
     */
    private $bottom = 10;

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
     * Get image string logo
     *
     * @return string|array
     */
    public function getImageLogo()
    {
        return $this->imageLogo;
    }

    /**
     * Set image string logo
     *
     * @param string|array $imageLogo
     * @return void
     */
    public function setImageLogo($imageLogo)
    {
        $this->imageLogo = $imageLogo;
        return $this;
    }

    /**
     * Get right position logo
     *
     * @return int
     */
    public function getRight() : int
    {
        return $this->right;
    }

     /**
     * Set right position logo
     *
     * @return int
     */
    public function setRight(int $right)
    {
        $this->right = $right;
        return $this;
    }

    /**
     * Get bottom position logo
     *
     * @return int
     */
    public function getBottom() : int
    {
        return $this->bottom;
    }

    /**
     * Set bottom position logo
     *
     * @param int $bottom
     * @return void
     */
    public function setBottom(int $bottom)
    {
        $this->bottom = $bottom;
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
            throw new \UnexpectedValueException("WatermarksImage - The setPorc value should be between 0 and 100");
        }

        //valid image logo path
        if (!$this->getImageLogo()) {
            throw new \UnexpectedValueException("WatermarksImage - setImageLogo required");
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
     * Watermarks image
     *
     * @param Core $container
     * @link imagecopy http://php.net/manual/pt_BR/function.imagecopy.php
     * @link imagesx http://php.net/manual/pt_BR/function.imagesx.php
     * @link imagesy https://secure.php.net/manual/pt_BR/function.imagesy.php
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

        //reorganized image logo array
        if (is_string($this->getImageLogo())) {
            $imglogo['tmp_name'] = $this->getImageLogo(); //set url
            $imglogo['type']     = $container->fileClass->getTypeFile($imglogo); //set mime type
            $this->setImageLogo($imglogo); //set new imagelogo normalized
        }

        //id image resource
        $im    = $imggd->imgCreateFrom($file, $file['tmp_name']);
        $stamp = $imggd->imgCreateFrom($this->getImageLogo(), $this->getImageLogo()['tmp_name']);

        // Set the margins for the stamp and get the height/width of the stamp image
        $marge_right  = $this->getRight();
        $marge_bottom = $this->getBottom();
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);

        // Copy the stamp image onto our photo using the margin offsets and the photo
        // width to calculate positioning of the stamp.
        imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
        if ($imggd->imgGenerate($im, $file, $directory, $this->getPorc(), $this->getSaveAs())) {
            return true;
        } else {
            return false;
        }
    }
}
