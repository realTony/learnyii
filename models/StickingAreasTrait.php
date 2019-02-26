<?php

namespace app\models;

trait StickingAreasTrait
{

    public function getArea()
    {
        return $this->hasOne(StickingAreas::className(), ['id' => 'sticking_area']);
    }

    public function getAreaName()
    {
        return $this->area['title'];
    }
}