<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%categories}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $seo_text
 * @property string $seo_title
 * @property string $link
 * @property int $parent_id
 * @property int $is_blog
 * @property int $is_advertisement
 * @property string $options
 * @property string $modified_at
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'link'], 'required'],
            [['description', 'seo_text', 'options'], 'string'],
            [['parent_id', 'is_blog', 'is_advertisement'], 'integer'],
            [['modified_at'], 'safe'],
            [['title', 'seo_title', 'link'], 'string', 'max' => 255],
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
            'seo_text' => Yii::t('app', 'Seo Text'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'link' => Yii::t('app', 'Link'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'is_blog' => Yii::t('app', 'Is Blog'),
            'is_advertisement' => Yii::t('app', 'Is Advertisement'),
            'options' => Yii::t('app', 'Options'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriesQuery(get_called_class());
    }
}
