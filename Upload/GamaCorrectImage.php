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

class GamaCorrectImage extends Save implements SaveInterface
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
     * Inputgrama
     *
     * @var float
     */
    private $inputgamma = 0;

    /**
     * Outputgamma
     *
     * @var float
     */
    private $outputgamma = 0;

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
     * Get inputgrama
     *
     * @return float
     */
    public function getInputgamma() : float
    {
        return $this->inputgamma;
    }

    /**
     * Set inputgrama
     *
     * @param float $inputgamma
     * @return void
     */
    public function setInputgamma(float $inputgamma)
    {
        $this->inputgamma = $inputgamma;
        return $this;
    }

    /**
     * Get outputgamma
     *
     * @return float
     */
    public function getOutputgamma() : float
    {
        return $this->outputgamma;
    }

    /**
     * Set outputgamma
     *
     * @param float $outputgamma
     * @return void
     */
    public function setOutputgamma(float $outputgamma)
    {
        $this->outputgamma = $outputgamma;
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
            throw new \UnexpectedValueException("GamaCorrectImage - The setPorc value should be between 0 and 100");
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
     * Image Correct Image
     *
     * @param array $file
     * @link imagecreatetruecolor http://php.net/manual/pt_BR/function.imagecreatetruecolor.php
     * @link imagegammacorrect http://php.net/manual/pt_BR/function.imagegammacorrect.php
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

        //gama correct image
        imagegammacorrect($image, $this->getInputgamma(), $this->getOutputgamma());

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
