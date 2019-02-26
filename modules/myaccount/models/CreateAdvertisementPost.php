<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 19.02.2019
 * Time: 14:16
 */

namespace app\modules\myaccount\models;


use app\models\AdvertiseCitiesRegions;
use app\models\AdvertisementPost;
use app\models\Cities;
use app\models\CityRegions;
use app\models\Images;
use Imagine\Image\Box;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

class CreateAdvertisementPost extends Model
{
    public $title;
    public $category_id;
    public $subCat_id;
    public $description;
    public $pricePerMonth;
    public $distancePerMonth;
    public $authorId;
    public $advertise_type;
    public $sticking_area;
    public $contract_term;
    public $city;
    public $city_district;
    public $coverage;
    public $show_email;
    public $published_at;
    public $images;

    public function rules()
    {
        return [
            [['title', 'authorId', 'category_id', 'subCat_id', 'pricePerMonth', 'contract_term', 'published_at', 'show_email', 'advertise_type', 'sticking_area'], 'required'],
            [['title', 'description'], 'string'],
            [['distancePerMonth', 'pricePerMonth', 'contract_term', 'sticking_area', 'category_id', 'subCat_id'], 'number'],
            [['show_email', 'coverage'], 'boolean'],
            [['show_email', 'coverage'], 'default', 'value' => 0],
            [['images'], 'image', 'maxFiles' => 5, 'skipOnEmpty' => true, 'extensions' => 'png, jpg']
        ];
    }

    public function beforeValidate()
    {
        $user = \Yii::$app->user->id;
        $this->authorId = $user;
        $this->published_at = time();
        $this->images = UploadedFile::getInstances($this, 'images');

        return parent::beforeValidate();
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        return parent::validate($attributeNames, $clearErrors); // TODO: Change the autogenerated stub
    }

    /**
     *
     * @return bool
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function createAdvertisement()
    {
        if(! $this->validate()) {
            return false;
        } else {
            $advertisement = new AdvertisementPost();
            $cities = new Cities();
            $districts = new CityRegions();
            $advCityRegions = new AdvertiseCitiesRegions();

            $advertisement->title = $this->title;
            $advertisement->category_id = $this->category_id;
            $advertisement->subCat_id = $this->subCat_id;
            $advertisement->description = $this->description;
            $advertisement->pricePerMonth = $this->pricePerMonth;
            $advertisement->distancePerMonth = $this->distancePerMonth;
            $advertisement->showEmail = $this->show_email;
            $advertisement->authorId = $this->authorId;
            $advertisement->contract_term = $this->contract_term;
            $advertisement->adv_type = $this->advertise_type;
            $advertisement->sticking_area = $this->sticking_area;
            $advertisement->coverage_type = $this->coverage;

            if($advertisement->save()) {

                $dir = Yii::getAlias('@webroot').'/uploads/'.strtolower($this->formName()).'/';

                if (!file_exists($dir)) {
                    FileHelper::createDirectory($dir);
                }

                foreach ($this->images as $file) {
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
                        $thumbModel->item_id = $advertisement->id;
                        $thumbModel->module = $advertisement->formName();
                        $thumbModel->alt = $file->name;
                        $thumbModel->image_name = '/uploads/'.strtolower($this->formName()).'/thumbnails/'.$imageModel->image_name;
                        $count = $thumbModel::find()->andWhere(['module'=>$thumbModel->module])->count();
                        $thumbModel->sort =  ($count > 0)? $count++ : 0;
                        $thumbModel->save();
                    }

                    $imageModel->item_id = $advertisement->id;
                    $imageModel->module = $advertisement->formName();
                    $imageModel->alt = $file->name;
                    $imageModel->image_name = '/uploads/'.strtolower($this->formName()).'/'.$imageModel->image_name;
                    $count = $imageModel::find()->andWhere(['module'=>$imageModel->module])->count();
                    $imageModel->sort =  ($count > 0)? $count++ : 0;

                    $imageModel->save();

                }

            } else {
                echo "<pre>";
                print_r( $advertisement->errors);
                echo "</pre>";
            }

//            if(! empty($this->city)) {
//                $advCityRegions->
//            }
        }

    }



}