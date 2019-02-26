<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%adv_type}}".
 *
 * @property int $id
 * @property string $name
 * @property string $translation
 */
class AdvType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%adv_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'translation'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'translation' => Yii::t('app', 'Translation'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AdvTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdvTypeQuery(get_called_class());
    }

    public function getTypes()
    {
        $res = ArrayHelper::map($this->find()->all(), 'id', 'name');
        return $res;
    }
}
