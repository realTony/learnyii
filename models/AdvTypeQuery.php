<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AdvType]].
 *
 * @see AdvType
 */
class AdvTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AdvType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AdvType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
