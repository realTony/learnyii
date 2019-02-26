<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AdvertiseCitiesRegions]].
 *
 * @see AdvertiseCitiesRegions
 */
class AdvertiseCitiesRegionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AdvertiseCitiesRegions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AdvertiseCitiesRegions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
