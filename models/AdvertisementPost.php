<?php

namespace app\models;

use Imagine\Image\Box;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\UploadedFile;
use app\modules\admin\models\Categories;
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
 * @property int $views
 * @property int $coverage_type
 * @property string $published_at
 * @property int $filter_id
 * @property int $is_banned
 * @property int $is_approved
 */
class AdvertisementPost extends \yii\db\ActiveRecord
{
    use ImagesTrait;
    use StickingAreasTrait;
    use CitiesTrait;

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
            [['title', 'category_id', 'subCat_id', 'pricePerMonth', 'contract_term', 'distancePerMonth', 'authorId', 'city'], 'required'],
            [['category_id', 'subCat_id', 'views', 'contract_term', 'adv_type', 'sticking_area', 'authorId', 'showEmail', 'isPremium', 'coverage_type', 'filter_id'], 'integer'],
            [['description'], 'string'],
            [['pricePerMonth', 'distancePerMonth'], 'number'],
            [['published_at'], 'safe'],
            [['title', 'condition'], 'string', 'max' => 60],
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
            'city' => Yii::t('app', 'Город')
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
        if( empty($this->authorId) ) {
            $user = \Yii::$app->user->id;
            $this->authorId = $user;
        }

        if( empty($this->contract_term)) {
            $this->contract_term = 0;
        }

        if( empty($this->distancePerMonth)) {
            $this->distancePerMonth = 0;
        }

        $this->image_items = UploadedFile::getInstances($this, 'image_items');
        return parent::beforeValidate();
    }

    public function createAdvertisement()
    {
        if(! $this->validate()) {
            return false;
        }

        $filterID = null;

        if(! empty($this->sticking_area) ) {
            $filterID = $this->sticking_area;
        } elseif (! empty($this->adv_type)) {
            $filterID = $this->adv_type;
        }
        $this->filter_id = $filterID;

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
                        ->thumbnail(new Box(580, 580))->save($dir.'/thumbnails/'.$imageModel->image_name);
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

            $i = 0;

            if(! empty($this->city)) {
                foreach ($this->city as $city) {
                    $cities = new Cities();
                    $districts = new CityRegions();

                    $cityId = $cities->find()->where(['like', 'name', $city])->one();
                    $districtId = 0;

                    if(! empty($this->city_district[$i])) {
                        $districtId = $districts->find()->where(['like', 'region', $this->city_district[$i]])->one();
                    }

                    $advCityRegions = new AdvertiseCitiesRegions();

                    if(empty($advCityRegions->find()->where(['advertise_id' => $this->id])->all())) {
                        $advCityRegions->city_id = $cityId['id'];
                        $advCityRegions->advertise_id = $this->id;
                        $advCityRegions->region_id = $districtId;
                        $advCityRegions->save();
                    } else {
                        if($districtId == 0) {
                            $advCityRegions = $advCityRegions->find()
                                ->where(['advertise_id' => $this->id, 'city_id' => $cityId['id'] ])
                                ->all();
                        }
                    }

                    $i++;
                }
            }

        } else {
           return false;
        }

        return $this->id;
    }

    public function updateAdvertisement()
    {
        if(! $this->validate()) {
            return false;
        }

        $filterID = null;

        if(! empty($this->sticking_area) ) {
            $filterID = $this->sticking_area;
        } elseif (! empty($this->adv_type)) {
            $filterID = $this->adv_type;
        }
        $this->filter_id = $filterID;
        $images = $this->images;

        foreach ($images as $image ) {
            if( strpos($image->image_name,'thumbnails')) {
                continue;
            }
        }

        return true;
    }
    public function getAdvCount()
    {
        return $this->find()->where(['authorId' => Yii::$app->user->id])->count();
    }

    public static function advCount()
    {
        return self::find()->where(['authorId' => Yii::$app->user->id])->count();
    }

    public function setCities($cities)
    {
        $this->city = $cities;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setDistrict($district)
    {
        $this->city_district = $district;
    }

    public function getDistrict()
    {
        return $this->city_district;
    }

    public function updateViews($pageId) : void
    {
        $page = $this->findOne($pageId);
        $views = $page->views;
        $views++;
        $page->authorId = $page->authorId;
        $page->views = $views;

       if(!$page->save()) {
           $page->errors;
       }
    }

    public function getInteresting()
    {
        $posts = $this->find()->orderBy('isPremium DESC, views DESC')->limit(30)->asArray()->all();
        $ruList = [];
        $list = '';

        foreach ($posts as $item) {
            $ruList[] = '<a href="'.Url::to(['/advertisement/page/'.$item['id']]).'">'.$item['title'].'</a>';
        }

        return implode(', ', $ruList);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'authorId']);
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    public function getSubCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'subCat_id']);
    }

    public function getIsTop()
    {
        $userPrem = (new UserPremiumAdvertisement())
            ->findOne(['advertisement_id' => $this->id]);

        $premiumRates = new PremiumRates();

        if(! empty($userPrem)) {
            $premiumRates =
            (new PremiumRates())
                ->findOne(['id' =>  $userPrem->premium_type_id ]);
        }
        return (! empty($premiumRates->isTop) && $premiumRates->isTop == 1) ? true : false;
    }
}
