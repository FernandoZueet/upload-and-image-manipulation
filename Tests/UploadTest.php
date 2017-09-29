<?php
namespace Helpers\Upload;

use \Helpers\upload\FactoryUpload;
use \Bootstrap\Bootstrap;
use \site\configs\AppConfigSite;

class UploadTest extends \PHPUnit_Framework_TestCase
{    
    /**
    * @test
    */
    public function TestUploadSimples()
    {
        /**
        * get files $_FILES[]  or array absolute paths
        */
        $filesInput['tmp_name'][0] = 'C:\Users\vogo\Pictures\camera.jpg';
        $filesInput['name'][0] = 'imagem1.jpeg';
        $filesInput['size'][0] = '81123';
        $filesInput['type'][0] = 'image/jpeg';
        


        //---------------------------------------------------------

        /**
        * valid jpg
        *
        * ->setDirectory('/path') - directory (string)
        */
        $validaJpg = new \Upload\Validate\Image\ValidateJpg();

        /**
        * valid png
        *
        * ->setDirectory('/path') - directory (string)
        */
        $validaPng = new \Upload\Validate\Image\ValidatePng();

        //---------------------------------------------------------

        /**
        * upload
        *
        * ->setDirectory('/path') - directory (string)
        */
        $upload = new \Upload\UploadFile();
        $upload->setDirectory('C:\xampp\htdocs\desenv');        

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
        ->validExecute([$upload]);

        //---------------------------------------------------------

        /**
        * get errors upload
        *
        * ->getErrors() (array)
        */
        if ($core->getErrors()) {
            return false ;
        }

        //---------------------------------------------------------        

        /**
        * execute functions
        *
        * ->execute() (bool)
        */
        if (!$core->execute()) {
           return false;
        } else {
            return true;
        }
    }

    /**
    * @test
    */
    public function TestUploadMultiplo()
    {
        /**
        * get files $_FILES[]  or array absolute paths
        */
        $filesInput['tmp_name'][0] = 'C:\Users\vogo\Pictures\camera.jpg';
        $filesInput['tmp_name'][1] = 'C:\Users\vogo\Pictures\sacola.jpg';
        $filesInput['name'][0] = 'imagem1.jpeg';
        $filesInput['name'][1] = 'imagem2.jpeg';
        $filesInput['size'][0] = '81123';
        $filesInput['size'][1] = '45644';
        $filesInput['type'][0] = 'image/jpeg';
        $filesInput['type'][1] = 'image/jpeg';
        


        //---------------------------------------------------------

        /**
        * valid jpg
        *
        * ->setDirectory('/path') - directory (string)
        */
        $validaJpg = new \Upload\Validate\Image\ValidateJpg();

        /**
        * valid png
        *
        * ->setDirectory('/path') - directory (string)
        */
        $validaPng = new \Upload\Validate\Image\ValidatePng();

        //---------------------------------------------------------

        /**
        * upload
        *
        * ->setDirectory('/path') - directory (string)
        */
        $upload = new \Upload\UploadFile();
        $upload->setDirectory('C:\xampp\htdocs\desenv');        

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
        ->validExecute([$upload]);

        //---------------------------------------------------------

        /**
        * get errors upload
        *
        * ->getErrors() (array)
        */
        if ($core->getErrors()) {
            return false ;
        }

        //---------------------------------------------------------        

        /**
        * execute functions
        *
        * ->execute() (bool)
        */
        if (!$core->execute()) {
           return false;
        } else {
            return true;
        }
    }

    /**
    * @test
    */
    public function TestUploadMultiPath()
    {
        /**
        * get files $_FILES[]  or array absolute paths
        */
        $filesInput['tmp_name'][0] = 'C:\Users\vogo\Pictures\camera.jpg';
        $filesInput['tmp_name'][1] = 'C:\Users\vogo\Pictures\sacola.jpg';
        $filesInput['name'][0] = 'imagem1.jpeg';
        $filesInput['name'][1] = 'imagem2.jpeg';
        $filesInput['size'][0] = '81123';
        $filesInput['size'][1] = '45644';
        $filesInput['type'][0] = 'image/jpeg';
        $filesInput['type'][1] = 'image/jpeg';
        


        //---------------------------------------------------------

        /**
        * valid jpg
        *
        * ->setDirectory('/path') - directory (string)
        */
        $validaJpg = new \Upload\Validate\Image\ValidateJpg();

        /**
        * valid png
        *
        * ->setDirectory('/path') - directory (string)
        */
        $validaPng = new \Upload\Validate\Image\ValidatePng();

        //---------------------------------------------------------

        /**
        * upload
        *
        * ->setDirectory('/path') - directory (string)
        */
        $upload = new \Upload\UploadFile();
        $upload->setDirectory('C:\xampp\htdocs\desenv');  
        
        $upload2 = new \Upload\UploadFile();
        $upload2->setDirectory('C:\xampp\htdocs\desenv\app');  

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
            return false ;
        }

        //---------------------------------------------------------        

        /**
        * execute functions
        *
        * ->execute() (bool)
        */
        if (!$core->execute()) {
           return false;
        } else {
            return true;
        }
    }

    /**
    * @test
    */
    public function TestUploadSimplesPath()
    {
        /**
        * get files $_FILES[]  or array absolute paths
        */
        $filesInput['tmp_name'][0] = 'C:\Users\vogo\Pictures\camera.jpg';
        $filesInput['name'][0] = 'imagem1.jpeg';
        $filesInput['size'][0] = '81123';
        $filesInput['type'][0] = 'image/jpeg';        

        //---------------------------------------------------------

        /**
        * valid jpg
        *
        * ->setDirectory('/path') - directory (string)
        */
        $validaJpg = new \Upload\Validate\Image\ValidateJpg();

        /**
        * valid png
        *
        * ->setDirectory('/path') - directory (string)
        */
        $validaPng = new \Upload\Validate\Image\ValidatePng();

        //---------------------------------------------------------

        /**
        * upload
        *
        * ->setDirectory('/path') - directory (string)
        */
        $upload = new \Upload\UploadFile();
        $upload->setDirectory('C:\xampp\htdocs\desenv');  
        
        $upload2 = new \Upload\UploadFile();
        $upload2->setDirectory('C:\xampp\htdocs\desenv\app');  

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
            return false ;
        }

        //---------------------------------------------------------        

        /**
        * execute functions
        *
        * ->execute() (bool)
        */
        if (!$core->execute()) {
           return false;
        } else {
            return true;
        }
    }

    /**
    * @test
    */
    public function TestUploadMultiploFilter()
    {
        /**
        * get files $_FILES[]  or array absolute paths
        */
        $filesInput['tmp_name'][0] = 'C:\Users\vogo\Pictures\camera.jpg';
        $filesInput['tmp_name'][1] = 'C:\Users\vogo\Pictures\sacola.jpg';
        $filesInput['name'][0] = 'imagem1.jpeg';
        $filesInput['name'][1] = 'imagem2.jpeg';
        $filesInput['size'][0] = '81123';
        $filesInput['size'][1] = '45644';
        $filesInput['type'][0] = 'image/jpeg';
        $filesInput['type'][1] = 'image/jpeg';
        


        //---------------------------------------------------------

        /**
        * valid jpg
        *
        * ->setDirectory('/path') - directory (string)
        */
        $validaJpg = new \Upload\Validate\Image\ValidateJpg();

        /**
        * valid png
        *
        * ->setDirectory('/path') - directory (string)
        */
        $validaPng = new \Upload\Validate\Image\ValidatePng();

        //---------------------------------------------------------        
        
        /**
        * resize image
        *
        * ->setPorc(100) - quality image (int - 0 a 100)
        * ->setWidth(50) - width (int)
        * ->setHeight(100) - height (int)
        */
        $resize = new \Upload\ResizeImage();
        $resize->setDirectory('C:\xampp\htdocs\desenv')->setPorc(100)->setWidth(50)->setHeight(100);

        /**
        * rotate image
        *
        * ->setDirectory('/path') - directory (string)
        * ->setPorc(100) - quality image (int - 0 a 100)
        * ->setRotate(90) - rotate image (int - 0 a 360)
        */
        $rotate = new \Upload\RotateImage();
        $rotate->setDirectory('C:\xampp\htdocs\desenv')->setPorc(100)->setRotate(90);

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
        ->validExecute([$resize, $rotate]);

        //---------------------------------------------------------

        /**
        * get errors upload
        *
        * ->getErrors() (array)
        */
        if ($core->getErrors()) {
            return false ;
        }

        //---------------------------------------------------------        

        /**
        * execute functions
        *
        * ->execute() (bool)
        */
        if (!$core->execute()) {
           return false;
        } else {
            return true;
        }
    }
}