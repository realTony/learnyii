<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StickingAreas]].
 *
 * @see StickingAreas
 */
class StickingAreasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StickingAreas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StickingAreas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
