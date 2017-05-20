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

use \Upload\Langs\MessagesInterface;
use \Upload\Validate\Validate;
use \Upload\File;

class Core
{

    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * array class validates
     *
     * @var array
     */
    private $objValids = [];

    /**
     * class Validate
     *
     * @var Validate
     */
    private $validate;

    /**
     * class Messages
     *
     * @var class
     */
    private $message;

    /**
     * status upload multiple
     *
     * @var boolean
     */
    private $uploadMultiple = false;

    /**
     * class file
     *
     * @var File
     */
    private $fileClass;

    /**
     * array de files
     *
     * @var array
     */
    private $file = [];

    /**
     * file active
     *
     * @var array
     */
    private $fileActive = [];

    /**
     * status validate
     *
     * @var boolean
     */
    private $statusValidate = false;

    /**
     * array class executes
     *
     * @var array
     */
    private $classExecutes = [];

    /**
     * union executes
     *
     * @var boolean
     */
    private $unionExecutes = false;
    
    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/
    
    /**
     * get array class validates
     *
     * @return array
     */
    public function getObjValids() : array
    {
        return $this->objValids;
    }

    /**
     * set array class validates
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
     * get class Validate
     *
     * @return Validate
     */
    public function getValidate() : Validate
    {
        return $this->validate;
    }

     /**
     * set class Validate
     *
     * @return Validate
     */
    public function setValidate(Validate $validate)
    {
        $this->validate = $validate;
        return $this;
    }

    /**
     * get class Messages
     *
     * @return void
     */
    public function getMessage() : MessagesInterface
    {
        return $this->message ?? new \Upload\Langs\PtBr();
    }

    /**
     * set class Messages
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
     * get status upload multiple
     *
     * @return bool
     */
    public function getUploadMultiple() : bool
    {
        return $this->uploadMultiple;
    }

    /**
     * set status upload multiple
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
     * get class File
     *
     * @return File
     */
    public function getFileClass() : File
    {
        return $this->fileClass;
    }

    /**
     * set class File
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
     * get file array
     *
     * @return array
     */
    public function getFile() : array
    {
        return $this->file;
    }

    /**
     * set file array
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
     * get file active
     *
     * @return array
     */
    public function getFileActive() : array
    {
        return $this->fileActive;
    }
    
    /**
     * set file active
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
     * get status validate
     *
     * @return bool
     */
    public function getStatusValidate() : bool
    {
        return $this->statusValidate;
    }

    /**
     * set status validate
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
     * get class executes
     *
     * @return array
     */
    public function getClassExecutes() : array
    {
        return $this->classExecutes;
    }

    /**
     * set class executes
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
     * get union executes
     *
     * @return bool
     */
    public function getUnionExecutes() : bool
    {
        return $this->unionExecutes;
    }

    /**
     * set union executes
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
     * initial settings and set data in the application container
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
     * get errors upload
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
     * validate functions files
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
     * validate functions upload
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
     * upload functions execute
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
     * delete files error upload function
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
