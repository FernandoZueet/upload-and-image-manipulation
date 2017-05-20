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

class GamaCorrectImage extends Save implements SaveInterface
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
     * inputgrama
     *
     * @var float
     */
    private $inputgamma = 0;

    /**
     * outputgamma
     *
     * @var float
     */
    private $outputgamma = 0;

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
     * get inputgrama
     *
     * @return float
     */
    public function getInputgamma() : float
    {
        return $this->inputgamma;
    }

    /**
     * set inputgrama
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
     * get outputgamma
     *
     * @return float
     */
    public function getOutputgamma() : float
    {
        return $this->outputgamma;
    }

    /**
     * set outputgamma
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
            throw new \UnexpectedValueException("GamaCorrectImage - The setPorc value should be between 0 and 100");
        }
        
        //valid is image
        $image = new \Upload\ValidateImage();
        $image->validImageFormat($container);
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
        if ($imggd->imgGenerate($image, $file, $directory, $this->getPorc())) {
            return true;
        } else {
            return false;
        }
    }
}
