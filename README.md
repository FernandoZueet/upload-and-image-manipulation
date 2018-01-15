# PHP Upload and Image Manipulation

Package with functions created to facilitate the upload and manipulation of images to the server.

## Safety Notices

To ensure the security of uploads on the server it is highly recommended that the files be uploaded outside the site's public folder. 
Force the file types accepted in .htacess

```bash
ForceType application/octet-stream
<FilesMatch "(?i).jpge?g$">
    ForceType image/jpeg
</FilesMatch>
```

## Requirements

This will install PHP Upload and Image Manipulation and all required dependencies. PHP Upload and Image Manipulation requires PHP 7.0.0 or newer.
To create derived images [GD](https://secure.php.net/manual/pt_BR/ref.image.php) should be installed on your server. 

## Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install Slim.

```bash
$ composer require fernandozueet/upload-image-manipulation
```

## Supported languages Classes

```php
new \Upload\Langs\PtBr()
new \Upload\Langs\Eng()

```

## Supported Image File Formats Classes

```php
new \Upload\Validate\Image\ValidateGif()
new \Upload\Validate\Image\ValidateJpg()
new \Upload\Validate\Image\ValidatePng()
new \Upload\Validate\Image\ValidateWebp()
```

Examples:

```php
/**
* valid png
*
* ->setWidth(100) - width (int)
*/
$validaPng = new \Upload\Validate\Image\ValidatePng();
$validaPng->setWidth(100);

/**
* valid png
*
* ->setWidth(100) - width (int)
* ->setHeight(150) - height (int)
*/
$validaPng = new \Upload\Validate\Image\ValidatePng();
$validaPng->setWidth(100)->setHeight(150);

/**
* valid png
*
* ->setMinWidth(100) - min width (int)
* ->setMinHeight(100) - min height (int)
*/
$validaPng = new \Upload\Validate\Image\ValidatePng();
$validaPng->setMinWidth(100)->setMinHeight(100);

/**
* valid png
*
* ->setMaxWidth(900) - max width (int)
* ->setMaxHeight(600) - max height (int)
*/
$validaPng = new \Upload\Validate\Image\ValidatePng();
$validaPng->setMaxWidth(900)->setMaxHeight(600);

/**
* valid png
*
* ->setMaxSizeByte(1000000) - max bytes files (int)
*/
$validaPng = new \Upload\Validate\Image\ValidatePng();
$validaPng->setMaxSizeByte(1000000);

/**
* valid png
*
* ->setMinWidth(100) - min width (int)
* ->setMinHeight(100) - min height (int)
* ->setMaxWidth(900) - max width (int)
* ->setMaxHeight(600) - max height (int)
* ->setMaxSizeByte(1000000) - max bytes files (int)
*/
$validaPng = new \Upload\Validate\Image\ValidatePng();
$validaPng->setMinWidth(100)->setMinHeight(100)->setMaxWidth(900)->setMaxHeight(600)
          ->setMaxSizeByte(1000000);
```

## Supported Docs File Formats Classes

```php
new \Upload\Validate\Doc\ValidateCsv()
new \Upload\Validate\Doc\ValidateDoc()
new \Upload\Validate\Doc\ValidateDocx()
new \Upload\Validate\Doc\ValidateJson()
new \Upload\Validate\Doc\ValidatePdf()
new \Upload\Validate\Doc\ValidatePpt()
new \Upload\Validate\Doc\ValidatePptx()
new \Upload\Validate\Doc\ValidateTxt()
new \Upload\Validate\Doc\ValidateXls()
new \Upload\Validate\Doc\ValidateXlsx()
```

Examples:

```php
/**
* valid csv
*
* ->setMaxSizeByte(1000000) - max bytes files (int)
*/
$validaPng = new \Upload\Validate\Doc\ValidateCsv();
$validaPng->setMaxSizeByte(1000000);
```

## Upload Function

```php
/**
* upload
*
* ->setDirectory('/path') - directory (string)
*/
$upload = new \Upload\UploadFile();
$upload->setDirectory('/path');
```

## Resize Image Function

```php
/**
* resize image
*
* ->setDirectory('/path') - directory (string)
* ->setSaveAs('jpg') - string - optional ( jpg | png | gif | webp )
* ->setPorc(100) - quality image (int - 0 a 100)
* ->setWidth(50) - width (int)
* ->setHeight(100) - height (int)
*/
$resize = new \Upload\ResizeImage();
$resize->setDirectory('/path')->setSaveAs('jpg')
       ->setPorc(100)->setWidth(50)->setHeight(100);
```

## Crop Image Function

```php
/**
* crop image
*
* ->setDirectory('/path') - directory (string)
* ->setSaveAs('jpg') - string - optional ( jpg | png | gif | webp )
* ->setPorc(100) - quality image (int - 0 a 100)
* ->setX(10) - x (int)
* ->setY(10) - y (int)
* ->setWidth(100) - width (int)
* ->setHeight(100) - height (int)
*/
$crop = new \Upload\CropImage();
$crop->setDirectory('/path')->setSaveAs('jpg')
     ->setPorc(100)->setX(10)->setY(10)->setWidth(100)->setHeight(100);
```

## Rotate Image Function

```php
/**
* rotate image
*
* ->setDirectory('/path') - directory (string)
* ->setSaveAs('jpg') - string - optional ( jpg | png | gif | webp )
* ->setPorc(100) - quality image (int - 0 a 100)
* ->setRotate(90) - rotate image (int - 0 a 360)
*/
$rotate = new \Upload\RotateImage();
$rotate->setDirectory('/path')->setSaveAs('jpg')
       ->setPorc(100)->setRotate(90);
```

## Filter Image Function

```php
/**
* filter image
*
* ->setDirectory('/path') - directory (string)
* ->setSaveAs('jpg') - string - optional ( jpg | png | gif | webp )
* ->setPorc(100) - quality image (int - 0 a 100)
* ->setFilter(IMG_FILTER_COLORIZE) - constant (IMG_FILTER_NEGATE, IMG_FILTER_GRAYSCALE, IMG_FILTER_BRIGHTNESS, IMG_FILTER_CONTRAST, 
* IMG_FILTER_COLORIZE, IMG_FILTER_EDGEDETECT, IMG_FILTER_EMBOSS, IMG_FILTER_GAUSSIAN_BLUR, IMG_FILTER_SELECTIVE_BLUR, IMG_FILTER_MEAN_REMOVAL,
* IMG_FILTER_SMOOTH, IMG_FILTER_PIXELATE)
* ->setArg1() ->setArg2() ->setArg3() ->setArg4() 
* docs complete http://us2.php.net/manual/en/function.imagefilter.php
*/
$filter = new \Upload\FilterImage();
$filter->setDirectory('/path')->setSaveAs('jpg')
       ->setPorc(100)->setFilter(IMG_FILTER_COLORIZE)->setArg1(0)->setArg2(255)->setArg3(0)/*-setArg4(0)*/;
```

## Gama Correction Image Function

```php
/**
* gama correction image
*
* ->setDirectory('/path') - directory (string)
* ->setSaveAs('jpg') - string - optional ( jpg | png | gif | webp )
* ->setPorc(100) - quality image (int - 0 a 100)
* ->setInputgamma(300) - input gamma (float)
* ->setOutputgamma(90) - output gamma (float)
*/
$gamacorrect = new \Upload\GamaCorrectImage();
$gamacorrect->setDirectory('/path')->setSaveAs('jpg')
            ->setPorc(100)->setInputgamma(300)->setOutputgamma(90);
```

## Flip Image Function

```php
/**
* flip image
*
* ->setDirectory('/path') - directory (string)
* ->setSaveAs('jpg') - string - optional ( jpg | png | gif | webp )
* ->setPorc(100) - quality image (int - 0 a 100)
* ->setMode(IMG_FLIP_HORIZONTAL) - constant (IMG_FLIP_HORIZONTAL, IMG_FLIP_VERTICAL and IMG_FLIP_BOTH)
*/
$flip = new \Upload\FlipImage();
$flip->setDirectory('/path')->setSaveAs('jpg')
     ->setPorc(100)->setMode(IMG_FLIP_HORIZONTAL); 
```

## Text Image Function

```php
/**
* text image
*
* ->setDirectory('/path') - directory (string)
* ->setSaveAs('jpg') - string - optional ( jpg | png | gif | webp )
* ->setPorc(100) - quality image (int - 0 a 100)
* ->setSize(20) - size font (int)
* ->setAngle(0) - angle text (int)
* ->setX(50) - x (int)
* ->setY(50) - y (int)
* ->setFontFile('/path/arial.ttf') - font text (string)
* ->setRgbColor([0,1,255]) - rgb color (string)
* ->setText('Example') - text image (string)
*/
$textimg = new \Upload\TextImage();
$textimg->setDirectory('/path')->setSaveAs('jpg')
        ->setPorc(100)->setSize(20)->setAngle(0)->setX(50)->setY(50)->setFontFile('/path/arial.ttf') 
        ->setRgbColor([0,1,255])->setText('Example');
```

## Watermarks Image Function

```php
/**
* watemarks image
*
* ->setDirectory('/path') - directory (string)
* ->setSaveAs('jpg') - string - optional ( jpg | png | gif | webp )
* ->setPorc(100) - quality image (int - 0 a 100)
* ->setImageLogo($_FILES['logo']) - image logo (array|string - $_FILES[] or path absolute image)
* ->setRight(90) - right position (int)
* ->setBottom(50) - bottom position (int)
*/
$watermarks = new \Upload\WatermarksImage();
$watermarks->setDirectory('/path')->setSaveAs('jpg')
           ->setPorc(100)->setImageLogo($_FILES['logo'])->setRight(90)->setBottom(50);
```

## Example Complete 1 - Simple upload

Error message ptbr, upload multiple, format file permitted .jpg, .png and function execute upload two folders diferents.

```php
/**
* get files $_FILES[]  or array absolute paths
*/
$filesInput['tmp_name'][0] = 'http://example.com.br/image.jpg';
$filesInput['tmp_name'][1] = 'http://example.com.br/image2.jpg';
$filesInput = $_FILES['example'];

//---------------------------------------------------------

/**
* valid jpg
*
* ->setDirectory('/path') - directory (string)
* ->setWidth(100) - width (int)
* ->setHeight(150) - height (int)
*/
$validaJpg = new \Upload\Validate\Image\ValidateJpg();
$validaJpg->setWidth(100)->setHeight(150);

/**
* valid png
*
* ->setDirectory('/path') - directory (string)
* ->setMinWidth(100) - min width (int)
* ->setMinHeight(100) - min height (int)
*/
$validaPng = new \Upload\Validate\Image\ValidatePng();
$validaPng->setMinWidth(100)->setMinHeight(100);

//---------------------------------------------------------

/**
* upload
*
* ->setDirectory('/path') - directory (string)
*/
$upload = new \Upload\UploadFile();
$upload->setDirectory('/path');

/**
* upload
*
* ->setDirectory('/path2') - directory (string)
*/
$upload2 = new \Upload\UploadFile();
$upload2->setDirectory('/path2');

//---------------------------------------------------------

/**
* configs
* 
* ->setMessage(new \Upload\Langs\PtBr()) - Language class
* ->setFile($filesInput) - array file
* ->setUploadMultiple(true) - status upload (bool - default false)
* ->setObjValids([$validaPng,$validaJpg,$validaGif]) - array classes valid types
* ->validExecute([$upload2, $upload]) - array classes execute functions
*/
$core = new \Upload\Core();
$core->setMessage(new \Upload\Langs\PtBr())->setFile($filesInput ?? [])->setUploadMultiple(true) 
     ->setObjValids([$validaJpg,$validaPng])
     ->validExecute([$upload, $upload2]);

//---------------------------------------------------------

/**
* get errors upload
*
* ->getErrors() (array)
*/
if ($core->getErrors()) {
    var_dump($core->getErrors());
    exit;
}

//---------------------------------------------------------

/**
* get files upload
*
* ->getFile() (array)
*/
var_dump($core->getFile());

//---------------------------------------------------------

/**
* execute functions 
*
* ->execute() (bool)
*/
if (!$core->execute()) {
    echo 'error';
    exit;
}
```

## Example Complete 2 - Merge various functions

Error message ptbr, upload unique, format file permitted .jpg, .png and function execute resize and rotate function. 
Multiple upload is not supported in this case

```php
/**
* get files $_FILES[]  or array absolute paths
*/
$filesInput['tmp_name'][0] = 'http://example.com.br/image.jpg';
$filesInput = $_FILES['example'];

//---------------------------------------------------------

/**
* valid jpg
*
* ->setDirectory('/path') - directory (string)
* ->setWidth(100) - width (int)
* ->setHeight(150) - height (int)
*/
$validaJpg = new \Upload\Validate\Image\ValidateJpg();
$validaJpg->setWidth(100)->setHeight(150);

/**
* valid png
*
* ->setDirectory('/path') - directory (string)
* ->setMinWidth(100) - min width (int)
* ->setMinHeight(100) - min height (int)
*/
$validaPng = new \Upload\Validate\Image\ValidatePng();
$validaPng->setMinWidth(100)->setMinHeight(100);

//---------------------------------------------------------

/**
* resize image
*
* ->setDirectory('/path') - directory (string)
* ->setPorc(100) - quality image (int - 0 a 100)
* ->setWidth(50) - width (int)
* ->setHeight(100) - height (int)
*/
$resize = new \Upload\ResizeImage();
$resize->setDirectory('/path')
       ->setPorc(100)->setWidth(50)->setHeight(100);

/**
* rotate image
*
* ->setDirectory('/path') - directory (string)
* ->setPorc(100) - quality image (int - 0 a 100)
* ->setRotate(90) - rotate image (int - 0 a 360)
*/
$rotate = new \Upload\RotateImage();
$rotate->setDirectory('/path')
       ->setPorc(100)->setRotate(90);

//---------------------------------------------------------

/**
* configs
* 
* ->setMessage(new \Upload\Langs\PtBr()) - Language class
* ->setFile($filesInput) - array file
* ->setUploadMultiple(true) - status upload (bool - default false)
* ->setObjValids([$validaPng,$validaJpg,$validaGif]) - array classes valid types
* ->validExecute([$upload2, $upload]) - array classes execute functions
*/
$core = new \Upload\Core();
$core->setMessage(new \Upload\Langs\PtBr())->setFile($filesInput ?? [])->setUploadMultiple(false) 
     ->setObjValids([$validaJpg,$validaPng])
     ->validExecute([$resize, $rotate]);

//---------------------------------------------------------

/**
* get errors upload
*
* ->getErrors() (array)
*/
if ($core->getErrors()) {
    var_dump($core->getErrors());
    exit;
}

//---------------------------------------------------------

/**
* get files upload
*
* ->getFile() (array)
*/
var_dump($core->getFile());

//---------------------------------------------------------

/**
* execute functions 
*
* ->execute() (bool)
*/
if (!$core->execute()) {
    echo 'error';
    exit;
}
```

## Contributing

Please see [CONTRIBUTING](https://github.com/FernandoZueet/upload-and-image-manipulation/graphs/contributors) for details.

## Security

If you discover security related issues, please email fernandozueet@hotmail.com instead of using the issue tracker.

## Credits

- [Fernando Zueet](https://github.com/FernandoZueet)

## License

The PHP Upload and Image Manipulation is licensed under the MIT license. See [License File](LICENSE.md) for more information.
