<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%pages}}".
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string $seo_title
 * @property string $seo_text
 * @property string $options
 * @property string $translation
 * @property string $updated_at
 * @property string $created_at
 */
class Pages extends \yii\db\ActiveRecord
{
    use ImagesTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pages}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seo_text', 'options', 'translation'], 'string'],
            [['updated_at', 'created_at'], 'safe'],
            [['title', 'link', 'seo_title'], 'string', 'max' => 255],
            [['link'], 'unique'],
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
            'link' => Yii::t('app', 'Link'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_text' => Yii::t('app', 'Seo Text'),
            'options' => Yii::t('app', 'Options'),
            'translation' => Yii::t('app', 'Translation'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PagesQuery(get_called_class());
    }

    public function beforeValidate()
    {

        $this->options = (! empty($this->options) ) ? json_encode($this->options): '';
        $this->translation = (! empty($this->translation) ) ? json_encode($this->translation): '';

        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

}
