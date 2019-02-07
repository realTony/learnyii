<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 07.02.2019
 * Time: 2:18
 */

namespace app\models;


use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

class ImageWidgetModel extends Model
{
    protected $dirName = '';
    protected $files;
    protected $generatedName = '';
    protected $options = [
        'crop' => false,
        'height' => 210,
        'width' => 210,
    ];

    public function setOptions($options = [])
    {
        return $this;
    }

    public function uploadImage()
    {
        return $this->files->saveAs($this->getDir().$this->generatedName);
    }

    public function getDir()
    {
        $dir = Yii::getAlias('@webroot').'/uploads/'.$this->dirName.'/';

        if (!file_exists($dir)) {
            FileHelper::createDirectory($dir);
        }

        return $dir;
    }

    public function setDirName($name)
    {
        $this->dirName = strtolower($name);
        return $this;
    }

    public function setImages($files)
    {
        $this->files = $files;
        $this->generatedName = $this->generateImageName();
        return $this;
    }

    public function getImageName()
    {
        return $this->generatedName;
    }

    protected function generateImageName(){
        return strtotime('now').'_'.Yii::$app->getSecurity()->generateRandomString(6).'.'.$this->files->extension;
    }

    public function getDirName(){
        return Yii::getAlias('@web').'uploads/'.$this->dirName;
    }

}