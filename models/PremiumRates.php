<?php

namespace app\models;

use LiqPay;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
 * @property boolean $isTop
 * @property boolean $isUp
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
            [['isTop', 'isUp'], 'boolean'],
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
            'isTop' => \Yii::t('app','Топ'),
            'isUp' => \Yii::t('app','Поднятие'),
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

    public function setAdvertisement($id)
    {
        $this->advertisement = ( new AdvertisementPost())->findOne(['id' => $id]);

        return $this;
    }

    public function getAdvertisement()
    {
        return $this->advertisement;
    }

    public function getLiqForm()
    {
        $settings = (Yii::createObject(Settings::className()));
        $public_key = ($settings->findOne(['name' => 'liqpay_public_key']))->option_value;
        $private_key = ($settings->findOne(['name' => 'liqpay_private_key']))->option_value;;
        $user = Yii::$app->user->id;
        $advertisement = $this->getAdvertisement();

        $currentLang = (Yii::$app->language == 'ru-Ru') ? 'ru' : 'uk';

        $description = $this->rate;

        if( $currentLang == 'uk') {
            $description = $this->rate_ua;
        }

        $liqpay = new CustomPayment($public_key, $private_key);
        $liqpay->advertisementId = $advertisement->id;
        $liqpay->premiumRateId = $this->id;

        $order_id = uniqid(000);
        $settings = [
            'action'         => 'pay',
            'amount'         => floatval($this->price),
            'currency'       => 'UAH',
            'description'    => $description,
            'order_id'       => $order_id,
            'version'        => '3',
            'sandbox'        => 1
        ];
        $liqpay->setData($settings);

        return $liqpay->getPaymentForm($settings);
    }
}
