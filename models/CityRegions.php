<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%city_regions}}".
 *
 * @property int $id
 * @property int $city_id
 * @property string $region
 * @property string $region_ua
 * @property string $district_approved_flag
 */
class CityRegions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%city_regions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'region'], 'required'],
            [['city_id', 'district_approved_flag'], 'integer'],
            [['region', 'region_ua'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'region' => Yii::t('app', 'Region'),
            'region_ua' => Yii::t('app', 'Region Ua'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CityRegionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityRegionsQuery(get_called_class());
    }
}
