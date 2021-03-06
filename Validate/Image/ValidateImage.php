<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2018
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload\Validate\Image;

use \Upload\Core;

class ValidateImage
{

    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * Extension save as permitted
     *
     * @var array
     */
    private $extensionSaveAsPermitted = ['jpg', 'png', 'gif', 'webp'];

    /**
     * Width image
     *
     * @var int
     */
    private $width = 0;

    /**
     * Height image
     *
     * @var int
     */
    private $height = 0;

    /**
     * Min width image
     *
     * @var int
     */
    private $minWidth = 0;

    /**
     * Min height image
     *
     * @var int
     */
    private $minHeight = 0;

    /**
     * Max width image
     *
     * @var int
     */
    private $maxWidth = 0;

    /**
     * Max height image
     *
     * @var int
     */
    private $maxHeight = 0;

    /**
     * Max size byte file
     *
     * @var int
     */
    private $maxSizeByte = 2000000;


    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Get width image
     *
     * @return int
     */
    public function getWidth() : int
    {
        return $this->width;
    }

    /**
     * Set width image
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
     * Get height image
     *
     * @return int
     */
    public function getHeight() : int
    {
        return $this->height;
    }

    /**
     * Set height image
     *
     * @param int $height
     * @return void
     */
    public function setHeight(int $height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Get min width image
     *
     * @return int
     */
    public function getMinWidth() : int
    {
        return $this->minWidth;
    }

    /**
     * Set min width image
     *
     * @param int $minWidth
     * @return void
     */
    public function setMinWidth(int $minWidth)
    {
        $this->minWidth = $minWidth;
        return $this;
    }

    /**
     * Get min height image
     *
     * @return int
     */
    public function getMinHeight() : int
    {
        return $this->minHeight;
    }

    /**
     * Set min height image
     *
     * @param int $minHeight
     * @return void
     */
    public function setMinHeight(int $minHeight)
    {
        $this->minHeight = $minHeight;
        return $this;
    }

    /**
     * Get max width image
     *
     * @return int
     */
    public function getMaxWidth() : int
    {
        return $this->maxWidth;
    }

    /**
     * Set max width image
     *
     * @param int $maxWidth
     * @return void
     */
    public function setMaxWidth(int $maxWidth)
    {
        $this->maxWidth = $maxWidth;
        return $this;
    }

    /**
     * Get max height image
     *
     * @return int
     */
    public function getMaxHeight() : int
    {
        return $this->maxHeight;
    }

    /**
     * Set max height image
     *
     * @param int $maxHeight
     * @return void
     */
    public function setMaxHeight(int $maxHeight)
    {
        $this->maxHeight = $maxHeight;
        return $this;
    }

    /**
     * Get max size byte permitted file
     *
     * @return int
     */
    public function getMaxSizeByte() : int
    {
        return $this->maxSizeByte;
    }

    /**
     * Set max size byte permitted file
     *
     * @param int $maxSizeByte
     * @return void
     */
    public function setMaxSizeByte(int $maxSizeByte)
    {
        $this->maxSizeByte = $maxSizeByte;
        return $this;
    }

    /*-------------------------------------------------------------------------------------
    * Other Methods
    *-------------------------------------------------------------------------------------*/
   
    /**
     * Valid dimensions
     *
     * @param Core $container
     * @return void
     */
    public function validDimension(Core $container)
    {
        
        //is image
        $this->validImageFormat($container);

        //file active
        $file = $container->getFileActive();

        //validate
        if (($this->getWidth() || $this->getHeight()) && ($this->getMaxWidth() || $this->getMaxHeight() || $this->getMinHeight() || $this->getMinWidth())) {
            throw new \UnexpectedValueException("Incorrect data formatting. When entering a maximum and minimum width and height value, remove the value of setWidth and setHeight");
        }

        //width
        if (($this->getWidth() > 0) && ($file['width'] != $this->getWidth())) {
            $container->getMessage()->setFile($file)->setError('imgErrorWidth', [ $file['name'], $this->getWidth() ]);
        }
        
        //height
        if (($this->getHeight() > 0) && ($file['height'] != $this->getHeight())) {
            $container->getMessage()->setFile($file)->setError('imgErrorHeight', [ $file['name'], $this->getHeight() ]);
        }

        //min width
        if (($this->getMinWidth() > 0) && ($file['width'] < $this->getMinWidth())) {
            $container->getMessage()->setFile($file)->setError('imgErrorMinWidth', [ $file['name'], $this->getMinWidth() ]);
        }
        
        //min height
        if (($this->getMinHeight() > 0) && ($file['height'] < $this->getMinHeight())) {
            $container->getMessage()->setFile($file)->setError('imgErrorMinHeight', [ $file['name'], $this->getMinHeight() ]);
        }
        
        //max width
        if (($this->getMaxWidth() > 0) && ($this->getMaxWidth() < $file['width'])) {
            $container->getMessage()->setFile($file)->setError('imgErrorMaxWidth', [ $file['name'], $this->getMaxWidth() ]);
        }
        
        //max width
        if (($this->getMaxHeight() > 0) && ($this->getMaxHeight() < $file['height'])) {
            $container->getMessage()->setFile($file)->setError('imgErrorMaxHeight', [ $file['name'], $this->getMaxHeight() ]);
        }
    }

    /**
     * Image valid format
     *
     * @param Core $container
     * @return void
     */
    public function validImageFormat(Core $container)
    {
        //file active
        $file = $container->getFileActive();

        //is image
        if (!$file['width'] && !$file['height']) {
            $container->getMessage()->setFile($file)->setError('fileTypeError', [$file['type']]);
        }
    }

    /**
     * Valid image save as
     *
     * @param string $extension ( jpg | png | gif | webp )
     * @return void
     */
    public function validIsImageSaveAs(string $extension) 
    {
        if (!in_array($extension, $this->extensionSaveAsPermitted)) {
            throw new \UnexpectedValueException("SetSaveImageAs function only allows values ​​(jpg, png, gif and png)");
        }
    }
}
