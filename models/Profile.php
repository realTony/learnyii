<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property int $user_id
 * @property string $public_email
 * @property string $location
 * @property string $website
 * @property string $last_name
 * @property string $phone
 * @property string $viber
 * @property string $telegram
 * @property string $whatsapp
 * @property string $profile_image
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['public_email', 'location', 'website', 'last_name', 'phone', 'viber', 'telegram', 'whatsapp'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'public_email' => Yii::t('app', 'Public Email'),
            'location' => Yii::t('app', 'Location'),
            'website' => Yii::t('app', 'Website'),
            'last_name' => Yii::t('app', 'Last Name'),
            'phone' => Yii::t('app', 'Phone'),
            'viber' => Yii::t('app', 'Viber'),
            'telegram' => Yii::t('app', 'Telegram'),
            'whatsapp' => Yii::t('app', 'Whatsapp'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileQuery(get_called_class());
    }

    public static function getImage()
    {
        return (self::getAttribute('profile_image')) ? self::getAttribute('profile_image') : '/images/empty_user.jpg';
    }
}
