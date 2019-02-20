<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%sticking_areas}}".
 *
 * @property int $id
 * @property string $title
 * @property string $translation
 */
class StickingAreas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sticking_areas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'translation'], 'string', 'max' => 255],
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
            'translation' => Yii::t('app', 'Translation'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return StickingAreasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StickingAreasQuery(get_called_class());
    }

    public function getStickingAreas()
    {
        return ArrayHelper::map($this->find()->all(),'id', 'title');
    }
}
