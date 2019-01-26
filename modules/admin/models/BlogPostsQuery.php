<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[BlogPosts]].
 *
 * @see BlogPosts
 */
class BlogPostsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BlogPosts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BlogPosts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
