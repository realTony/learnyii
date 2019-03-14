<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserFav]].
 *
 * @see UserFav
 */
class UserFavQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserFav[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserFav|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
