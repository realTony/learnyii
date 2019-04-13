<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property int $id
 * @property string $name
 * @property string $option_value
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['option_value'], 'required'],
            [['option_value'], 'string'],
            [['name'], 'string', 'max' => 191],
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
            'option_value' => Yii::t('app', 'Option Value'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SettingsQuery(get_called_class());
    }

    public function getSiteEmail()
    {
        return $this->findOne(['name' => 'site_email']);
    }

    public function getEmailNotification()
    {
        return $this->findOne(['name' => 'premium_alert_message']);
    }
}
