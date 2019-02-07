<?php

namespace app\models;

use yii\helpers\ArrayHelper;

trait ImagesTrait
{
    public function getImages()
    {
        $name = \yii\helpers\StringHelper::basename(get_class($this));
        return $this->hasMany(Images::className(), ['item_id' => 'id'])
            ->andWhere(['module' => $name])->orderBy('sort');
    }

    public function getImagesLinks()
    {
        return ArrayHelper::getColumn($this->images, 'imageUrl');
    }

    public function getImagesLinksData()
    {
        $arr = ArrayHelper::toArray($this->images, [Images::className() => [
            'caption' => 'image_name',
            'key' => 'id'
        ]]);

        return $arr;
    }
}