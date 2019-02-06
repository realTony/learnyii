<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "stick_images".
 *
 * @property int $id
 * @property string $image_name
 * @property string $module
 * @property int $item_id
 * @property string $alt
 * @property int $sort
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $attachment;

    public static function tableName()
    {
        return 'stick_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_name', 'module', 'alt', 'sort'], 'required'],
            [['item_id', 'sort'], 'integer'],
            [['sort'], 'default', 'value' => function($model){
                $count = Images::find()->andWhere(['module' => $model->module ])->count();
                return ($count > 0)? $count++ : 0;
            }],
            [['image_name', 'module', 'alt'], 'string', 'max' => 255],
            [['attachment'], 'image']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'image_name' => Yii::t('app', 'Image Name'),
            'module' => Yii::t('app', 'Module'),
            'item_id' => Yii::t('app', 'Item ID'),
            'alt' => Yii::t('app', 'Alt'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ImagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImagesQuery(get_called_class());
    }

    public function getImageUrl()
    {
        $path = '';

        if ($this->image_name) {
            $path = Url::home(true).$this->image_name;
        }

        return $path;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            Images::updateAllCounters(['sort' => -1], ['and', ['module' => 'pages', 'item_id' => $this->item_id], ['>', 'sort', $this->sort]]);

            return true;
        } else {
            return false;
        }
    }
}
