<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 13.04.2019
 * Time: 19:18
 */

namespace app\components;


use app\models\AdvertisementPost;
use app\models\PremiumRates;
use app\models\UserPremiumAdvertisement;
use yii\base\Component;

class Premium extends Component
{
    public static function checkPrem($id) : bool
    {
        $timestamp = date('Y-m-d H:i:s');
        $premAdvertisements = ( new UserPremiumAdvertisement())
            ->find()
            ->where(['<', 'confirmation_timestamp', $timestamp])
            ->andWhere(['>', 'expiration_timestamp', $timestamp])
            ->andWhere(['advertisement_id' => $id])
            ->one();

        if(! empty($premAdvertisements->advertisement_id)) {
            $rates = (new PremiumRates())
                ->findOne(['id' => $premAdvertisements->premium_type_id]);
            $adv = (new AdvertisementPost())
                ->find()
                ->where(['in', 'id', $premAdvertisements->advertisement_id])
                ->one();

            if( $rates->isTop == 1 && $adv->isPremium == 1) {
                return true;
            }
        }

        return false;
    }
}