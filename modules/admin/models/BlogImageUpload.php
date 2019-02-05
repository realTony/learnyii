<?php

namespace app\modules\admin\models;

use app\models\ImageUpload;
use Yii;
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
            $this->deleteCurrentImage($currentImage);

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
        $this->isUploadExists();
        $this->post_image->saveAs(Yii::getAlias('@webroot').$uploadFolder.$filename);
        return $this->getUploadFolder().$filename;
    }
}