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

class File
{

    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * mime type permitted
     *
     * @var array
     */
    private $mimeTypesPermited = ['image/gif',
                                  'image/jpeg',
                                  'image/png',
                                  'application/msword',
                                  'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                  'application/json',
                                  'application/pdf',
                                  'application/vnd.ms-powerpoint',
                                  'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                  'text/plain',
                                  'application/vnd.ms-excel',
                                  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                  'text/csv'
                                 ];
    
    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * get mime type permitted
     *
     * @return array
     */
    public function getMimeTypesPermited() : array
    {
        return $this->mimeTypesPermited;
    }

    /*-------------------------------------------------------------------------------------
    * Other Methods
    *-------------------------------------------------------------------------------------*/

    /**
     * reorganized file array
     *
     * @param array $file
     * @return void
     */
    public function reorganizedFile(array $file)
    {
        $newArray = [];
        foreach ($file as $key => $all) {
            foreach ($all as $i => $val) {
                $newArray[$i][$key] = $val;
            }
        }
        if (!$newArray) {
            $fileNew[0] = $file;
            return $fileNew;
        }
        return $newArray;
    }

    /**
     * get new name file
     *
     * @return string
     */
    public function newNameFile() : string
    {
        return md5(uniqid(rand(), true));
    }

    /**
     * get name file
     *
     * @param array $file
     * @return string
     */
    public function getNameFile(array $file) : string
    {
        if (!$file['name']) {
            return $file['tmp_name'];
        }
        return $file['name'];
    }

    /**
     * get type file
     *
     * @param array $file
     * @return string
     */
    public function getTypeFile(array $file) : string
    {
        if ($file['type']) {
            $type = $file['type'];
        } else {
            $size = getimagesize($file['tmp_name']);
            $type = $size['mime'] ?? "";
        }
        return $type;
    }

    /**
     * get path file
     *
     * @param array $file
     * @return string
     */
    public function getTmpFile(array $file) : string
    {
        return $file['tmp_name'] ?? "";
    }

    /**
     * get size file
     *
     * @param array $file
     * @return int
     */
    public function getSizeFile(array $file) : int
    {
        if (!$file['size']) {
            $ch = curl_init($this->getTmpFile($file));
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $data = curl_exec($ch);
            curl_close($ch);
            if (preg_match('/Content-Length: (\d+)/', $data, $matches)) {
                return (int) $matches[1] ?? 0;
            }
            return 0;
        }
        return $file['size'];
    }

    /**
     * get extension file
     *
     * @param string $file
     * @return string
     */
    public function getExtFile(string $file) : string
    {
        return pathinfo($file, PATHINFO_EXTENSION) ?? "";
    }

    /**
     * get dimension image
     *
     * @param array $file
     * @return array
     */
    public function getDimensionImage(array $file) : array
    {
        @list($width, $height, $type, $attr) = getimagesize($this->getTmpFile($file));
        if ($width && $height) {
            return [
                'width'  => $width,
                'height' => $height,
                'type'   => $type,
                'attr'   => $attr
            ];
        }
        return [];
    }

    /**
     * get info file exif
     *
     * @param array $file
     * @return array
     */
    public function getInfoFile(array $file) : array
    {
        $exif = exif_read_data($this->getTmpFile($file), 0, true);
        if ($exif) {
            if ($exif['IFD0']['Artist']) {
                $array['Artist'] = explode(';', $exif['IFD0']['Artist']);
            }
            if ($exif['COMPUTED']['Copyright']) {
                $array['Copyright'] = $exif['COMPUTED']['Copyright'];
            }
            if ($exif['FILE']['FileDateTime']) {
                $array['DateTime']  = date('m/d/Y H:m:s', $exif['FILE']['FileDateTime']);
            }
            return $array ?? [];
        }
        return [];
    }

    /**
     * file update
     *
     * @param Core $container
     * @param int $pos
     * @param string $indice
     * @param mixed $newValue
     * @return void
     */
    public function updateFile(Core $container, int $pos, string $indice, $newValue)
    {
        $file = $container->getFile();
        $file[$pos][$indice] = $newValue;
        return $file;
    }

    /**
     * prepare new file
     *
     * @return void
     */
    public function prepareFile(Core $container)
    {
        //if empty file return
        if (!$container->getFile()) {
            return;
        }

        //reorganized file
        $fileNew = $this->reorganizedFile($container->getFile());

        //for file
        for ($i=0; $i < count($fileNew); $i++) {
            //size
            $fileNew[$i]['size'] = $this->getSizeFile($fileNew[$i]);

            //name
            $fileNew[$i]['name'] = $this->getNameFile($fileNew[$i]);

            //mime type
            $fileNew[$i]['type'] = $this->getTypeFile($fileNew[$i]);

            //width, height image dimension
            $isImage = $this->getDimensionImage($fileNew[$i]);
            if ($isImage) {
                $fileNew[$i]['width']  = $isImage['width'];
                $fileNew[$i]['height'] = $isImage['height'];
            }

            //get extension file
            $ext = $this->getExtFile($this->getNameFile($fileNew[$i], PATHINFO_EXTENSION));
            $fileNew[$i]['new_name'] = $this->newNameFile().'.'.$ext;

            //get extension
            $fileNew[$i]['extension'] = $ext;

            //get info exif
            $infoFile = $this->getInfoFile($fileNew[$i]);
            if ($infoFile) {
                $fileNew[$i]['info_exif'] = $infoFile;
            }
        }

        //set new file
        $container->setFile($fileNew);
    }
}
