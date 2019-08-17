<?php

namespace app\models;

use app\components\L10nTrait;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use app\modules\admin\models\Categories;

/**
 * This is the model class for table "{{%pages}}".
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string $seo_title
 * @property string $seo_text
 * @property array $options
 * @property array $translation
 * @property string $updated_at
 * @property string $created_at
 */
class Pages extends \yii\db\ActiveRecord
{
    use ImagesTrait;
    use L10nTrait;
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

    public function getCategories()
    {
        return Yii::createObject(Categories::className())
            ->find()
            ->andWhere(['is_blog' => 1, 'parent_id' => null])
            ->orderBy('id')
            ->all();
    }

    public function getAdverts()
    {
        return Yii::createObject(Categories::className())
            ->find()
            ->andWhere(['is_blog' => 0, 'parent_id' => null])
            ->orderBy('id')
            ->all();
    }

    public function getAdvertList()
    {
        $arr = ArrayHelper::toArray($this->adverts, [Images::className() => [
            'name' => 'title',
            'key' => 'id'
        ]]);

        $arr = ArrayHelper::map($arr, 'id', 'title');
        $arr = ArrayHelper::merge(['' => 'Выберите категорию'], $arr);

        return $arr;
    }

    public function getCatList(){

        $arr = ArrayHelper::toArray($this->categories, [Images::className() => [
            'name' => 'title',
            'key' => 'id'
        ]]);

        $arr = ArrayHelper::map($arr, 'id', 'title');
        $arr = ArrayHelper::merge(['' => 'Выберите категорию'], $arr);
        return $arr;
    }

    public function afterFind()
    {
        $options = json_decode($this->options, true);
        $this->translation = json_decode($this->translation, true);
        $options['title'] = $this->title;
        $options['seo_title'] = $this->seo_title;
        $options['seo_text'] = $this->seo_text;

        $this->options = $options;

        parent::afterFind(); // TODO: Change the autogenerated stub
    }

}
