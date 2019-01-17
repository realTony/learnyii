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

    public function rules()
    {
        return [
            [
                ['imageFile'],
                'image',
                'skipOnEmpty' => false,
                'extensions' => 'png,jpg',
                'minWidth' => 210,
                'minHeight' => 210,
                'maxSize' => 512000,
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
            $this->deleteCurrentImage($currentImage);

            return $this->getUploadFolder().$this->saveImage();
        }else{
            return false;
        }
    }

    /**
     * @return string
     */
    public function getUploadFolder()
    {
        return $this->makeFolder();
    }

    /**
     * @return string fileName
     */
    private function generateFilename()
    {
        return strtolower(md5(uniqid($this->imageFile->baseName))).'.'.($this->imageFile->extension);
    }

    public function deleteCurrentImage($currentImage)
    {
        //Remove image file if it's already exists
        if ($this->fileExists($currentImage)){
            unlink(Yii::getAlias('@web') . $currentImage);
        }
    }

    /**
     * @param $currentImage
     * @return bool
     */
    public function fileExists($currentImage)
    {
        $path = Yii::$app->basePath . '/web/' . $currentImage;
        if(!empty($currentImage) && $currentImage != null )
        {
            return file_exists($path);
        }
    }

    private function saveImage()
    {
        $filename = $this->generateFilename();

        $this->imageFile->saveAs($this->getUploadFolder().$filename);


        return $filename;
    }

    public function getImage()
    {
        return ($this->imageFile) ? $this->getUploadFolder(). $this->imageFile : '/images/empty_user.jpg';
    }

    private function makeFolder()
    {
        $date = date('Y-m');
        $path = Yii::getAlias('@web') . 'uploads/'.$date.'/';
        if( !is_dir($path ) )
        {
            FileHelper::createDirectory($path, '0775' );
            return $path;
        }
        return $path;
    }
}