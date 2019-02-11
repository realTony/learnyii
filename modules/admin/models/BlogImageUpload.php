<?php

namespace app\modules\admin\models;

use app\models\ImageUpload;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class BlogImageUpload extends ImageUpload
{
    public $post_image;

    public function rules()
    {
        return [
            [
                ['post_image'],
                'image',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg',
                'minWidth' => 210,
                'minHeight' => 210,
                'maxFiles' => 1
            ]
        ];
    }

    public function uploadImage(UploadedFile $file, $currentImage )
    {
        $this->post_image = $file;
        if($this->validate())
        {
            //Save image
            $this->isUploadExists();
            return $this->saveImage();
        }else{
            return false;
        }
    }

    protected function generateFilename()
    {
        return strtolower(md5(uniqid($this->post_image->baseName))).'.'.($this->post_image->extension);
    }

    protected function saveImage()
    {
        $filename = $this->generateFilename();
        $uploadFolder = parent::__get('uploadFolder');
        $dir = Yii::getAlias('@webroot').$uploadFolder;
        $this->isUploadExists();
        if ($this->post_image->saveAs($dir.$filename)) {
            $thumbnail = Yii::$app->image->load($dir. $filename);

            $thumbnail->background('#FFF', 0);
            if (! is_dir($dir.'thumbnails')) {
                FileHelper::createDirectory($dir.'thumbnails');
            }
            $thumbnail->resize(290, null, \yii\image\drivers\Image::PRECISE)->save($dir.'/thumbnails/'.$filename, 85);
        }
        return ['image' => $this->getUploadFolder().$filename, 'thumbnails' => $this->getUploadFolder().'thumbnails/'.$filename ];
    }
}