<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AdvertisementCatFilters]].
 *
 * @see AdvertisementCatFilters
 */
class AdvertisementCatFiltersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AdvertisementCatFilters[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AdvertisementCatFilters|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
