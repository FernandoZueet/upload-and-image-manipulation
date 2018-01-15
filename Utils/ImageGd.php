<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2018
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload\Utils;

class ImageGd
{

    /**
     * Execute image create functions
     *
     * @param array $file
     * @param string $pathImage
     * @link imagecreatefromjpeg http://php.net/manual/pt_BR/function.imagecreatefromjpeg.php
     * @link imagecreatefrompng https://secure.php.net/manual/pt_BR/function.imagecreatefrompng.php
     * @link imagecreatefromgif http://php.net/manual/pt_BR/function.imagecreatefromgif.php
     * @return void
     */
    public function imgCreateFrom(array $file, string $pathImage)
    {
        if ($file['type'] == "image/jpeg") {
            return imagecreatefromjpeg($pathImage);
        }
        if ($file['type'] == "image/png") {
            return imagecreatefrompng($pathImage);
        }
        if ($file['type'] == "image/gif") {
            return imagecreatefromgif($pathImage);
        }
        if ($file['type'] == "image/webp") {
            return imagecreatefromwebp($pathImage);
        }
    }

    /**
     * Image generate
     *
     * @param img resource $thumb
     * @param array $file
     * @param string $fileDest
     * @param int $porc
     * @param string $saveImageAs ( jpg | png | gif | webp )
     * @link imagejpeg http://php.net/manual/pt_BR/function.imagejpeg.php
     * @link imagepng http://php.net/manual/pt_BR/function.imagepng.php
     * @link imagegif http://php.net/manual/pt_BR/function.imagegif.php
     * @return void
     */
    public function imgGenerate($thumb, array $file, string $fileDest, int $porc, string $saveImageAs = '')
    {
        if ($saveImageAs == 'jpg' || $file['type'] == "image/jpeg") {
            return imagejpeg($thumb, $fileDest, $porc);
        }
        if ($saveImageAs == 'png' || $file['type'] == "image/png") {
            return imagepng($thumb, $fileDest);
        }
        if ($saveImageAs == 'gif' || $file['type'] == "image/gif") {
            return imagegif($thumb, $fileDest);
        }
        if ($saveImageAs == 'webp' || $file['type'] == "image/webp") {
            return imagewebp($thumb, $fileDest);
        }
    }

    /**
     * Set transparency image
     *
     * @param img resource $thumb
     * @link imagealphablending http://php.net/manual/pt_BR/function.imagealphablending.php
     * @link imagecolorallocatealpha http://php.net/manual/pt_BR/function.imagecolorallocatealpha.php
     * @link imagefill http://php.net/manual/pt_BR/function.imagefill.php
     * @link imagesavealpha http://php.net/manual/pt_BR/function.imagesavealpha.php
     * @return void
     */
    public function setTransparency($thumb)
    {
        imagealphablending($thumb, false);
        $colorTransparent = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
        imagefill($thumb, 0, 0, $colorTransparent);
        imagesavealpha($thumb, true);
    }
}
