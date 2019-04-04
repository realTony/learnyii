<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%advertisement_cat_filters}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int $type_id
 * @property string $filter_name
 * @property string $filter_translation
 *
 * @property Categories $category
 * @property AdvType $type
 * @property AdvertisementPost[] $advertisementPosts
 */
class AdvertisementCatFilters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%advertisement_cat_filters}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'type_id', 'filter_name', 'filter_translation'], 'required'],
            [['category_id', 'type_id'], 'integer'],
            [['filter_name', 'filter_translation'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'type_id' => Yii::t('app', 'Type ID'),
            'filter_name' => Yii::t('app', 'Filter Name'),
            'filter_translation' => Yii::t('app', 'Filter Translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(AdvType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisementPosts()
    {
        return $this->hasMany(AdvertisementPost::className(), ['filter_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AdvertisementCatFiltersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdvertisementCatFiltersQuery(get_called_class());
    }
}
