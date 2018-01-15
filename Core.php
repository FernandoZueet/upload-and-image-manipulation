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

use \Upload\Langs\MessagesInterface;
use \Upload\Validate\Validate;
use \Upload\File;

class Core
{

    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * Array class validates
     *
     * @var array
     */
    private $objValids = [];

    /**
     * Class Validate
     *
     * @var Validate
     */
    private $validate;

    /**
     * Class Messages
     *
     * @var class
     */
    private $message;

    /**
     * Status upload multiple
     *
     * @var boolean
     */
    private $uploadMultiple = false;

    /**
     * Class file
     *
     * @var File
     */
    private $fileClass;

    /**
     * Array de files
     *
     * @var array
     */
    private $file = [];

    /**
     * File active
     *
     * @var array
     */
    private $fileActive = [];

    /**
     * Status validate
     *
     * @var boolean
     */
    private $statusValidate = false;

    /**
     * Array class executes
     *
     * @var array
     */
    private $classExecutes = [];

    /**
     * Union executes
     *
     * @var boolean
     */
    private $unionExecutes = false;
    
    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/
    
    /**
     * Get array class validates
     *
     * @return array
     */
    public function getObjValids() : array
    {
        return $this->objValids;
    }

    /**
     * Set array class validates
     *
     * @param array $objValids
     * @return void
     */
    public function setObjValids(array $objValids)
    {
        $this->init();
        if (!$objValids) {
            throw new \UnexpectedValueException("SetObjValids is required");
        }
        $this->objValids = $objValids;
        $this->validate();
        return $this;
    }

    /**
     * Get class Validate
     *
     * @return Validate
     */
    public function getValidate() : Validate
    {
        return $this->validate;
    }

     /**
     * Set class Validate
     *
     * @return Validate
     */
    public function setValidate(Validate $validate)
    {
        $this->validate = $validate;
        return $this;
    }

    /**
     * Get class Messages
     *
     * @return void
     */
    public function getMessage() : MessagesInterface
    {
        return $this->message ?? new \Upload\Langs\PtBr();
    }

    /**
     * Set class Messages
     *
     * @param class $message
     * @return void
     */
    public function setMessage(MessagesInterface $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get status upload multiple
     *
     * @return bool
     */
    public function getUploadMultiple() : bool
    {
        return $this->uploadMultiple;
    }

    /**
     * Set status upload multiple
     *
     * @param bool $uploadMultiple
     * @return void
     */
    public function setUploadMultiple(bool $uploadMultiple)
    {
        $this->uploadMultiple = $uploadMultiple;
        return $this;
    }

    /**
     * Get class File
     *
     * @return File
     */
    public function getFileClass() : File
    {
        return $this->fileClass;
    }

    /**
     * Set class File
     *
     * @param File $fileClass
     * @return void
     */
    public function setFileClass(File $fileClass)
    {
        $this->fileClass = $fileClass;
        return $this;
    }

    /**
     * Get file array
     *
     * @return array
     */
    public function getFile() : array
    {
        return $this->file;
    }

    /**
     * Set file array
     *
     * @param array $file
     * @return void
     */
    public function setFile(array $file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Get file active
     *
     * @return array
     */
    public function getFileActive() : array
    {
        return $this->fileActive;
    }
    
    /**
     * Set file active
     *
     * @param array $fileActive
     * @return void
     */
    public function setFileActive(array $fileActive)
    {
        $this->fileActive = $fileActive;
        return $this;
    }

    /**
     * Get status validate
     *
     * @return bool
     */
    public function getStatusValidate() : bool
    {
        return $this->statusValidate;
    }

    /**
     * Set status validate
     *
     * @param bool $statusValidate
     * @return void
     */
    public function setStatusValidate(bool $statusValidate)
    {
        $this->statusValidate = $statusValidate;
        return $this;
    }

    /**
     * Get class executes
     *
     * @return array
     */
    public function getClassExecutes() : array
    {
        return $this->classExecutes;
    }

    /**
     * Set class executes
     *
     * @param array $classExecutes
     * @return void
     */
    public function setClassExecutes(array $classExecutes)
    {
        if (!$classExecutes) {
            throw new \UnexpectedValueException("setClassExecute is required");
        }
        $this->classExecutes = $classExecutes;
        return $this;
    }

    /**
     * Get union executes
     *
     * @return bool
     */
    public function getUnionExecutes() : bool
    {
        return $this->unionExecutes;
    }

    /**
     * Set union executes
     *
     * @param bool $unionExecutes
     * @return void
     */
    public function setUnionExecutes(bool $unionExecutes)
    {
        $this->unionExecutes = $unionExecutes;
        return $this;
    }

    /*-------------------------------------------------------------------------------------
    * Other Methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Initial settings and set data in the application container
     *
     * @return void
     */
    public function init()
    {
        $file = new \Upload\File();
        $file->prepareFile($this);
        $this->setFileClass($file);
        $this->setValidate(new \Upload\Validate\Validate());
    }

    /**
     * Get errors upload
     *
     * @return array
     */
    public function getErrors() : array
    {
        if (!method_exists($this->getMessage(), 'getError')) {
            return [];
        }
        return $this->getMessage()->getError();
    }

    /**
     * Validate functions files
     *
     * @return void
     */
    public function validate()
    {
        //get file
        $fileNew = $this->getFile();

        //is upload multiple
        if (!$this->getUploadMultiple() && count($fileNew) > 1) {
            $this->getMessage()->setFile(['name' => 'error'])->setError('fileErrorMultiple');
            return;
        }

        //get mime type files
        $typesInput = [];
        foreach ($this->getObjValids() as $vld) {
            $typesInput[] = $vld->getMimeTypeFile();
        }

        //valid type file
        foreach ($fileNew as $ifile) {
            $this->setFileActive($ifile);
            if (!$this->getValidate()->validTypeFile($this)) {
                $this->getMessage()->setFile($ifile)->setError('fileTypeError', [$ifile['type']]);
                return;
            }
            if (!$this->getValidate()->validTypeFile($this, $typesInput)) {
                $this->getMessage()->setFile($ifile)->setError('fileTypeError', [$ifile['type']]);
                return;
            }
        }

        //execute functions valid
        foreach ($fileNew as $ifile) {
            foreach ($this->getObjValids() as $vld) {
                $this->setFileActive($ifile);
                if ($vld->getMimeTypeFile() == $ifile['type']) {
                    $vld->execute($this);
                }
            }
        }

        //if validation errors
        if (!$this->getErrors()) {
            $this->setStatusValidate(true);
        } else {
            $this->setStatusValidate(false);
        }
    }

    /**
     * Validate functions upload
     *
     * @param array $arrayExecutes
     * @return void
     */
    public function validExecute(array $arrayExecutes)
    {
        //if validation errors
        if (!$this->getStatusValidate()) {
            return false;
        }

        //execute functions validates
        $this->setClassExecutes($arrayExecutes);
        $countArray = [];
        foreach ($this->getFile() as $ifile) {
            foreach ($this->getClassExecutes() as $vld) {
                if (array_key_exists($vld->getDirectory(), $countArray)) { //Equal directory count
                    $countArray[$vld->getDirectory()]++;
                } else {
                    $countArray[$vld->getDirectory()] = 1;
                }
                $this->setFileActive($ifile); //set file active container
                $vld->valid($this); //valid class executes
            }
        }

        //if equal directory
        if (count($countArray) == 1) {
            $this->setUnionExecutes(true);
        }
        
        //if validation errors
        if (!$this->getErrors()) {
            $this->setStatusValidate(true);
        } else {
            $this->setStatusValidate(false);
        }
    }

    /**
     * Upload functions execute
     *
     * @return bool
     */
    public function execute() : bool
    {
        //if validation errors
        if (!$this->getStatusValidate()) {
            return false;
        }

        //execute functions
        $return    = 0;
        $contFile  = -1;
        $contClass = -1;
        foreach ($this->getFile() as $ifile) {
            $contFile++; //count file
            $contClass = -1;
            foreach ($this->getClassExecutes() as $vld) {
                $contClass++; //count class
                if ($contClass >= 1 && $this->getUnionExecutes()) { //union executes functions
                    $ifile = $this->getFileClass()->updateFile($this, $contFile, 'tmp_name', $vld->getDirectory().'/'.$ifile['new_name'])[$contFile];
                }
                $this->setFileActive($ifile); //set file active container
                if ($vld->execute($this)) { //execute functions
                    $return++; //count success
                };
            }
        }

        //if errors execute
        if ($return != count($this->getClassExecutes()) * count($this->getFile())) {
            $this->deleteFiles();
            return false;
        }

        return true;
    }

    /**
     * Delete files error upload function
     *
     * @return void
     */
    public function deleteFiles()
    {
        foreach ($this->getFile() as $ifile) {
            foreach ($this->getClassExecutes() as $vld) {
                @unlink($vld->getDirectory().'/'.$ifile['new_name']);
            }
        }
    }
}
