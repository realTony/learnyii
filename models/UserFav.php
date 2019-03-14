<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user_fav}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $advertisement_id
 */
class UserFav extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_fav}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'advertisement_id'], 'required'],
            [['user_id', 'advertisement_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'advertisement_id' => Yii::t('app', 'Advertisement ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserFavQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserFavQuery(get_called_class());
    }
}
