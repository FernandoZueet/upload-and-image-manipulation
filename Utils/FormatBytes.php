<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2017
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload\Utils;

class FormatBytes
{

    /**
     * format bytes
     *
     * @param int $size
     * @param int $decimals
     * @param string $extensao
     * @return void
     */
    function formatBytes($size, $decimals = 0, string $extensao = null)
    {
        $unit = array(
        '0' => 'Byte',
        '1' => 'KB',
        '2' => 'MB',
        '3' => 'GB',
        '4' => 'TB',
        '5' => 'PB',
        '6' => 'EB',
        '7' => 'ZB',
        '8' => 'YB'
        );
        for ($i = 0; $size >= 1024 && $i <= count($unit); $i++) {
            $size = $size/1024;
        }
        if (!empty($extensao)) {
            return round($size, $decimals).' '.$unit[$i];
        } else {
            return round($size, $decimals);
        }
    }
}
