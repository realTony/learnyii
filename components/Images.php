<?php


namespace app\components;


use Yii;

class Images
{
    public static function isThumbnailExists($img)
    {
        return file_exists(realpath(Yii::getAlias('@webroot').$img)) ? $img : '/images/no-photo_item-small.png';
    }

    public static function isImageExists($img)
    {
        return file_exists(realpath(Yii::getAlias('@webroot').$img)) ? $img : '/images/no-photo_big.png';
    }
}