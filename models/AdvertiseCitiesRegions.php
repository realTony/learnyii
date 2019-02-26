<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%advertise_cities_regions}}".
 *
 * @property int $id
 * @property int $advertise_id
 * @property int $city_id
 * @property int $region_id
 */
class AdvertiseCitiesRegions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%advertise_cities_regions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['advertise_id', 'city_id'], 'required'],
            [['advertise_id', 'city_id', 'region_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'advertise_id' => Yii::t('app', 'Advertise ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'region_id' => Yii::t('app', 'Region ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AdvertiseCitiesRegionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdvertiseCitiesRegionsQuery(get_called_class());
    }
}
