<?php

namespace app\models;

use Imagine\Image\Box;
use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%advertisement_post}}".
 *
 * @property int $id
 * @property string $title
 * @property int $category_id
 * @property int $subCat_id
 * @property string $description
 * @property double $pricePerMonth
 * @property int $contract_term
 * @property double $distancePerMonth
 * @property string $condition
 * @property int $adv_type
 * @property int $sticking_area
 * @property int $authorId
 * @property int $showEmail
 * @property int $isPremium
 * @property int $coverage_type
 * @property string $published_at
 */
class AdvertisementPost extends \yii\db\ActiveRecord
{
    use ImagesTrait;
    use StickingAreasTrait;

    public $city;
    public $city_district;
    public $image_items;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%advertisement_post}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'category_id', 'subCat_id', 'pricePerMonth', 'contract_term', 'distancePerMonth', 'authorId'], 'required'],
            [['category_id', 'subCat_id', 'contract_term', 'adv_type', 'sticking_area', 'authorId', 'showEmail', 'isPremium', 'coverage_type'], 'integer'],
            [['description'], 'string'],
            [['pricePerMonth', 'distancePerMonth'], 'number'],
            [['published_at'], 'safe'],
            [['title', 'condition'], 'string', 'max' => 255],
            [['image_items'], 'image', 'maxFiles' => 5, 'skipOnEmpty' => true, 'extensions' => 'png, jpg']
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
            'category_id' => Yii::t('app', 'Category ID'),
            'subCat_id' => Yii::t('app', 'Sub Cat ID'),
            'description' => Yii::t('app', 'Description'),
            'pricePerMonth' => Yii::t('app', 'Price Per Month'),
            'contract_term' => Yii::t('app', 'Contract Term'),
            'distancePerMonth' => Yii::t('app', 'Distance Per Month'),
            'condition' => Yii::t('app', 'Condition'),
            'adv_type' => Yii::t('app', 'Adv Type'),
            'sticking_area' => Yii::t('app', 'Sticking Area'),
            'authorId' => Yii::t('app', 'Author ID'),
            'showEmail' => Yii::t('app', 'Show Email'),
            'isPremium' => Yii::t('app', 'Is Premium'),
            'coverage_type' => Yii::t('app', 'Coverage Type'),
            'published_at' => Yii::t('app', 'Published At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AdvertisementPostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdvertisementPostQuery(get_called_class());
    }

    public function beforeDelete()
    {
        $images = $this->images;

        if(! empty($images)) {
            foreach ($images as $image) {
                $imgModel = Images::findOne($image->id);
                $uploader = Yii::createObject(ImageUpload::className());
                $uploader->deleteCurrentImage($image->image_name);
                $imgModel->delete();
            }
        }

        return parent::beforeDelete();
    }


    public function beforeValidate()
    {
        $user = \Yii::$app->user->id;
        $this->authorId = $user;

        $this->image_items = UploadedFile::getInstances($this, 'image_items');

        return parent::beforeValidate();
    }

    public function createAdvertisement()
    {
        if(! $this->validate()) {
            return false;
        } else {
            $cities = new Cities();
            $districts = new CityRegions();
            $advCityRegions = new AdvertiseCitiesRegions();


            if($this->save()) {

                $dir = Yii::getAlias('@webroot').'/uploads/'.strtolower($this->formName()).'/';

                if (!file_exists($dir)) {
                    FileHelper::createDirectory($dir);
                }

                foreach ($this->image_items as $file) {
                    $imageModel = Yii::createObject(Images::className());
                    $imageModel->image_name = strtotime('now').'_'.Yii::$app->getSecurity()->generateRandomString(6).'.'.$file->extension;

                    if ($file->saveAs($dir.$imageModel->image_name)) {

                        if (! is_dir($dir.'thumbnails')) {
                            FileHelper::createDirectory($dir.'thumbnails');
                        }


                        Image::getImagine()
                            ->open($dir.$imageModel->image_name)
                            ->thumbnail(new Box(290, 290))->save($dir.'/thumbnails/'.$imageModel->image_name);
                        $thumbModel = Yii::createObject(Images::className());
                        $thumbModel->item_id = $this->id;
                        $thumbModel->module = $this->formName();
                        $thumbModel->alt = $file->name;
                        $thumbModel->image_name = '/uploads/'.strtolower($this->formName()).'/thumbnails/'.$imageModel->image_name;
                        $count = $thumbModel::find()->andWhere(['module'=>$thumbModel->module])->count();
                        $thumbModel->sort =  ($count > 0)? $count++ : 0;
                        $thumbModel->save();
                    }

                    $imageModel->item_id = $this->id;
                    $imageModel->module = $this->formName();
                    $imageModel->alt = $file->name;
                    $imageModel->image_name = '/uploads/'.strtolower($this->formName()).'/'.$imageModel->image_name;
                    $count = $imageModel::find()->andWhere(['module'=>$imageModel->module])->count();
                    $imageModel->sort =  ($count > 0)? $count++ : 0;

                    $imageModel->save();

                }

            } else {
               return false;
            }
        }

    }

    public function getAdvCount()
    {
        return $this->find()->where(['authorId' => Yii::$app->user->id])->count();
    }
}
