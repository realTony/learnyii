<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user_premium_advertisement}}".
 *
 * @property int $id
 * @property int $author_id
 * @property int $advertisement_id
 * @property int $premium_type_id
 * @property string $confirmation_timestamp
 * @property string $expiration_timestamp
 * @property string $order_id
 * @property int $is_notification_sent
 *
 * @property AdvertisementPost $advertisement
 * @property User $author
 * @property PremiumRates $premiumType
 */
class UserPremiumAdvertisement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_premium_advertisement}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'advertisement_id', 'premium_type_id'], 'required'],
            [['author_id', 'advertisement_id', 'premium_type_id', 'is_notification_sent'], 'integer'],
            [['confirmation_timestamp', 'expiration_timestamp'], 'safe'],
            [['order_id'], 'string'],
            [['advertisement_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisementPost::className(), 'targetAttribute' => ['advertisement_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['premium_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PremiumRates::className(), 'targetAttribute' => ['premium_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'author_id' => Yii::t('app', 'Author ID'),
            'advertisement_id' => Yii::t('app', 'Advertisement ID'),
            'premium_type_id' => Yii::t('app', 'Premium Type ID'),
            'confirmation_timestamp' => Yii::t('app', 'Confirmation Timestamp'),
            'expiration_timestamp' => Yii::t('app', 'Expiration Timestamp'),
            'is_notification_sent' => Yii::t('app', 'Is Notification Sent'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisement()
    {
        return $this->hasOne(AdvertisementPost::className(), ['id' => 'advertisement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPremiumType()
    {
        return $this->hasOne(PremiumRates::className(), ['id' => 'premium_type_id']);
    }

    /**
     * {@inheritdoc}
     * @return UserPremiumAdvertisementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserPremiumAdvertisementQuery(get_called_class());
    }
}
