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

class FilterImage extends Save implements SaveInterface
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
     * filter image
     *
     * @link http://us2.php.net/manual/en/function.imagefilter.php
     * @var constant
     */
    private $filter;

    /**
     * arg1
     *
     * @var mixed
     */
    private $arg1;

    /**
     * arg2
     *
     * @var mixed
     */
    private $arg2;

    /**
     * arg3
     *
     * @var mixed
     */
    private $arg3;

    /**
     * arg4
     *
     * @var mixed
     */
    private $arg4;

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
     * get filter
     *
     * @return void
     */
    public function getFilter()
    {
        return $this->filter;
    }

     /**
     * set filter
     *
     * @return void
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
        return $this;
    }

     /**
     * get arg1
     *
     * @return void
     */
    public function getArg1()
    {
        return $this->arg1;
    }

     /**
     * set arg1
     *
     * @return void
     */
    public function setArg1($arg1)
    {
        $this->arg1 = $arg1;
        return $this;
    }

     /**
     * get arg2
     *
     * @return void
     */
    public function getArg2()
    {
        return $this->arg2;
    }

     /**
     * set arg2
     *
     * @return void
     */
    public function setArg2($arg2)
    {
        $this->arg2 = $arg2;
        return $this;
    }

     /**
     * get arg3
     *
     * @return void
     */
    public function getArg3()
    {
        return $this->arg3;
    }

     /**
     * set arg3
     *
     * @return void
     */
    public function setArg3($arg3)
    {
        $this->arg3 = $arg3;
        return $this;
    }

     /**
     * get arg4
     *
     * @return void
     */
    public function getArg4()
    {
        return $this->arg4;
    }

     /**
     * set arg4
     *
     * @return void
     */
    public function setArg4($arg4)
    {
        $this->arg4 = $arg4;
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
            throw new \UnexpectedValueException("FilterImage - The setPorc value should be between 0 and 100");
        }

        //valid filter
        if (!$this->getFilter()) {
            throw new \UnexpectedValueException("FilterImage - setFilter required");
        }
        
        //valid is image
        $image = new \Upload\ValidateImage();
        $image->validImageFormat($container);
    }

    /**
     * Image Filter
     *
     * @param array $file
     * @link imagecreatetruecolor http://php.net/manual/pt_BR/function.imagecreatetruecolor.php
     * @link imagefilter http://php.net/manual/pt_BR/function.imagefilter.php
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

        //image filter
        imagefilter($image, $this->getFilter(), $this->getArg1() ?? null, $this->getArg2() ?? null, $this->getArg3() ?? null, $this->getArg4() ?? null);

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
