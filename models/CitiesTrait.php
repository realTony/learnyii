<?php

namespace app\models;


use yii\helpers\ArrayHelper;

trait CitiesTrait
{
    public function getCities()
    {
        return $this->hasMany(AdvertiseCitiesRegions::className(), ['advertise_id' => 'id'])->orderBy('id');
    }


    public function getCityNames()
    {
        $ids = ArrayHelper::getColumn($this->cities, 'city_id');
        $cities = Cities::find()->where(['in', 'id', $ids])->all();

        return ArrayHelper::getColumn($cities, 'name');
    }

    public function getDistrictNames()
    {
        $ids = ArrayHelper::getColumn($this->cities, 'region_id');
        $districts = CityRegions::find()->where(['in', 'id', $ids])->all();

        return ArrayHelper::getColumn($districts, 'region');
    }
}

