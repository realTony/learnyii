<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%premium_rates}}".
 *
 * @property int $id
 * @property string $rate
 * @property string $rate_ua
 * @property double $price
 * @property int $duration
 * @property string $description
 * @property string $description_ua
 * @property string $rate_icon
 *
 * @property UserPremiumAdvertisement[] $userPremiumAdvertisements
 */
class PremiumRates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%premium_rates}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['duration'], 'integer'],
            [['description', 'description_ua'], 'string'],
            [['rate', 'rate_ua', 'rate_icon'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'rate' => \Yii::t('app','Название услуги'),
            'rate_ua' => \Yii::t('app','Название услуги Укр'),
            'price' => \Yii::t('app','Стоимость'),
            'duration' => \Yii::t('app','Длительность'),
            'description' => \Yii::t('app','Описание'),
            'description_ua' => \Yii::t('app','Описание Укр'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPremiumAdvertisements()
    {
        return $this->hasMany(UserPremiumAdvertisement::className(), ['premium_type_id' => 'id']);
    }

    public function create() : bool
    {
        if(! $this->validate()) {
            return false;
        }

        $this->duration = (! empty( $this->duration)) ? $this->duration*24 : 24;

        if(!$this->save()) {
            return false;
        }

        return true;
    }

    public function getRates() : array
    {
        $rates = $this->find()->all();
        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';
        $ratesArr = ArrayHelper::map($rates, 'id', 'rate');

        if( $currentLang == 'uk') {
            $ratesArr = ArrayHelper::map($rates, 'id', 'rate_ua');
        }

        return $ratesArr;
    }
}
