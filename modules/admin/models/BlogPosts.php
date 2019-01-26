<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%blog_posts}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $link
 * @property int $category_id
 * @property string $post_thumbnail
 * @property string $post_image
 * @property int $author_id
 * @property string $seo_title
 * @property string $seo_text
 * @property string $created_at
 * @property string $modified_at
 */
class BlogPosts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%blog_posts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'seo_text'], 'string'],
            [['category_id', 'author_id'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['title', 'link', 'post_thumbnail', 'post_image', 'seo_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'link' => Yii::t('app', 'Link'),
            'category_id' => Yii::t('app', 'Category ID'),
            'post_thumbnail' => Yii::t('app', 'Post Thumbnail'),
            'post_image' => Yii::t('app', 'Post Image'),
            'author_id' => Yii::t('app', 'Author ID'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_text' => Yii::t('app', 'Seo Text'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BlogPostsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogPostsQuery(get_called_class());
    }
}
