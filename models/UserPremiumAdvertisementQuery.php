<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserPremiumAdvertisement]].
 *
 * @see UserPremiumAdvertisement
 */
class UserPremiumAdvertisementQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserPremiumAdvertisement[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserPremiumAdvertisement|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
