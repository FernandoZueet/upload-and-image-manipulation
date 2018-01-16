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

class FlipImage extends Save implements SaveInterface
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
     * Mode
     *
     * @link imagerotate http://php.net/manual/en/function.imageflip.php
     * @var constant
     */
    private $mode;

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
     * Get flip mode
     *
     * @return void
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set flip mode
     *
     * @param mixed $mode
     * @return void
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
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
            throw new \UnexpectedValueException("FlipImage - The setPorc value should be between 0 and 100");
        }

        //valid rotate
        if (!$this->getMode()) {
            throw new \UnexpectedValueException("FlipImage - mode required");
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
     * Image flip
     *
     * @param array $file
     * @link imagecreatetruecolor http://php.net/manual/pt_BR/function.imagecreatetruecolor.php
     * @link imageflip http://php.net/manual/en/function.imageflip.php
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

        //image flip
        imageflip($image, $this->getMode());
   
        //transparency image
        if ($file['type'] == "image/png" || $file['type'] == "image/gif") {
            $thumb = imagecreatetruecolor($file['width'], $file['height']);
            $imggd->setTransparency($thumb);
        }

        //image generate
        if ($imggd->imgGenerate($image, $file, $directory, $this->getPorc(), $this->getSaveAs())) {
            return true;
        } else {
            return false;
        }
    }
}
