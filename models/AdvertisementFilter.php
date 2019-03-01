<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 20.02.2019
 * Time: 22:12
 */

namespace app\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;

class AdvertisementFilter extends Model
{
    public $minPrice = 0;
    public $maxPrice = 11000;
    public $minDistance = 0;
    public $maxDistance = 2000;
    public $stickingArea;

    public function rules()
    {
        return [
            [['minDistance', 'minPrice', 'maxDistance', 'maxPrice'], 'integer'],
            ['stickingArea', 'safe'],
        ];
    }

    public function filter($params)
    {
//        $query = AdvertisementPost::find();
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'pagination' => [
//                'pageSize' => 6
//            ],
//            'sort' => [
//                'defaultOrder' => [
//                    'isPremium' => SORT_ASC,
//                    'published_at' => SORT_DESC,
//                ]
//            ],
//        ]);
//
//        $this->load($params);
//
//        if(! $this->validate()) {
//
//            return $dataProvider;
//        }
//
//        $cityId = (new Cities())->find()
//            ->where(['like', 'name', $params['city']])
//            ->orWhere(['name_ua' => $params['city']])->orderBy('name DESC' )->one();
//        $query->leftJoin('{{%advertise_cities_regions}} `cr`','{{%advertisement_post}}.`id` = `cr`.`advertise_id`');
//        $query->andFilterWhere(['like', 'title', $this->textRequest]);
//
//        if(! empty($this->categoryId)) {
//            $query->andFilterWhere(['category_id' => $this->categoryId]);
//        }
//
//        if(! empty($params['city'])) {
//            $query->andFilterWhere(['`cr`.`city_id`' => $cityId['id']]);
//        }
//
//        if(! empty($params['district'])) {
//            $region = (new CityRegions())->find()
//                ->where(['like', 'region', $params['district']])
//                ->orWhere(['region_ua' => $params['district']])->orderBy('region DESC' )->one();
//
//            $query->andFilterWhere(['`cr`.`region_id`' =>  $region['id']]);
//        }
//
//        if(! empty($params['orderBy'])) {
//
//            switch ($params['orderBy']) {
//                case 'price_desc':
//                    $query->orderBy('pricePerMonth DESC');
//                    break;
//                case 'price_asc':
//                    $query->orderBy('pricePerMonth ASC');
//                    break;
//                default:
//                    break;
//            }
//
//        }
//        return $dataProvider;
    }


}