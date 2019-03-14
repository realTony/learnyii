<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    private static $uploadFolder;

    /**
     * @return array
     */
    public function rules() : array
    {
        return [
            [
                ['imageFile'],
                'image',
                'skipOnEmpty' => false,
                'extensions' => 'png,jpg',
                'minWidth' => 210,
                'minHeight' => 210,
//                'maxSize' => 512000,
                'maxFiles' => 1
                ]
        ];
    }

    /**
     * @param UploadedFile $file
     * @param $currentImage
     * @return bool|string
     */
    public function uploadImage(UploadedFile $file, $currentImage )
    {
        $this->imageFile = $file;

        if($this->validate())
        {
            //Save image
            $this->isUploadExists();
            $this->deleteCurrentImage($currentImage);

            return $this->saveImage();
        }else{
            return false;
        }
    }

    /**
     * @return string
     */
    public function getUploadFolder()
    {
        return self::$uploadFolder;
    }

    /**
     * @return string fileName
     */
    protected function generateFilename()
    {
        return strtolower(md5(uniqid($this->imageFile->baseName))).'.'.($this->imageFile->extension);
    }

    public function deleteCurrentImage($currentImage)
    {
        //Remove image file if it's already exists
        if ($this->fileExists($currentImage)){
            if( is_file(Yii::$app->basePath . '/web'  . $currentImage )) {
                unlink(Yii::$app->basePath . '/web'  . $currentImage);
            }
        }
    }

    /**
     * @param $currentImage
     * @return bool
     */
    public function fileExists($currentImage)
    {
        $path = Yii::$app->basePath . '/web' . $currentImage;

        if(!empty($currentImage) && $currentImage != null )
        {
            return file_exists($path);
        }
    }

    protected function isUploadExists() {
        $date = date('Y-m');
        $path = Yii::getAlias('@web') . '/uploads/'.$date.'/';

        if(! is_dir(self::$uploadFolder)) {
            $path = $this->makeUploadFolder($path);
            $this->setUploadPath($path);
        }

        return $this;
    }

    private function setUploadPath($path) {
        self::$uploadFolder = $path;

        return $this;
    }

    protected function saveImage()
    {
        $filename = $this->generateFilename();

        $this->isUploadExists();
        $this->imageFile->saveAs(Yii::getAlias('@webroot').self::$uploadFolder.$filename);
        return $this->getUploadFolder().$filename;
    }

    public function getImage()
    {
        return ($this->imageFile) ? $this->getUploadFolder(). $this->imageFile : '/images/empty_user.jpg';
    }

    private function makeUploadFolder($path)
    {
        if( !is_dir($path ) )
        {
            $realpath = Yii::getAlias('@webroot').$path;
            FileHelper::createDirectory($realpath, '0775' );
            return $path;
        }

        return $path;
    }
}