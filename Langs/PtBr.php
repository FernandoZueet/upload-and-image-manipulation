<?php

/**
 * This file is part of the Upload Manipulation package.
 *
 * @link http://github.com/fernandozueet/upload-and-image-manipulation
 * @copyright 2018
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Upload\Langs;

use \Upload\Langs\Messages;
use \Upload\Langs\MessagesInterface;

class PtBr extends Messages implements MessagesInterface
{

    private $sizeFileExced       = "O tamanho do arquivo %s excede o permitido de %s";
    private $fileErrorUploadParc = "O upload do arquivo %s foi feito parciamente";
    private $fileTypeError       = "O formato de arquivo %s não é permitido";
    private $imgErrorHeight      = "A imagem %s deve ter %s px de Altura";
    private $imgErrorWidth       = "A imagem %s deve ter %s px de Largura";
    private $imgErrorDimension   = "A imagem %s deve estar nas dimensões: %s px de Largura por %s px de Altura";
    private $imgErrorMinHeight   = "A imagem %s deve ser maior que %s px de Altura";
    private $imgErrorMinWidth    = "A imagem %s deve ser maior que %s px de Largura";
    private $imgErrorMaxHeight   = "A imagem %s deve ser menor que %s px de Altura";
    private $imgErrorMaxWidth    = "A imagem %s deve ser menor que %s px de Largura";
    private $fileErrorMultiple   = "Somente 1 arquivo pode ser enviado por vez";

    public function __get($atrib)
    {
        return $this->$atrib;
    }
}
