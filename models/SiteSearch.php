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

class SiteSearch extends Model
{
    public $textRequest;
    public $categoryId;
    public $city;
    public $district;
    public $orderBy;

    public function rules()
    {
        return [
            [['textRequest', 'city', 'orderBy'], 'string'],
            ['categoryId', 'integer'],
            [['textRequest', 'city'], 'trim']
        ];
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        return parent::validate($attributeNames, $clearErrors); // TODO: Change the autogenerated stub
    }

    public function search($params)
    {
        $query = AdvertisementPost::find();


        $this->load($params);

        if(! $this->validate()) {

            return false;
        }

        $query->leftJoin('{{%advertise_cities_regions}} `cr`','{{%advertisement_post}}.`id` = `cr`.`advertise_id`');
        $query->leftJoin('{{%cities}} `c`','`cr`.`city_id` = `c`.`id`');

        if(! empty($params['textRequest'])) {
            $query->andFilterWhere(['like', 'title', $params['textRequest']]);
        }
        if(! empty($this->categoryId)) {
            $query->andFilterWhere(['category_id' => $this->categoryId]);
        }

        if(! empty($params['city'])) {
            $query->andFilterWhere(['`c`.`name`' => $params['city']])
            ->orFilterWhere(['`c`.`name_ua`' => $params['city']]);
        }

        if(! empty($params['district'])) {
            $region = (new CityRegions())->find()
                ->where(['like', 'region', $params['district']])
                ->orWhere(['region_ua' => $params['district']])->orderBy('region DESC' )->one();

            $query->andFilterWhere(['`cr`.`region_id`' =>  $region['id']]);
        }

        if(! empty($params['orderBy'])) {

            switch ($params['orderBy']) {
                case 'price_desc':
                    $query->orderBy('isPremium DESC, pricePerMonth DESC');
                    break;
                case 'price_asc':
                    $query->orderBy('isPremium DESC, pricePerMonth ASC');
                    break;
                default:
                    break;
            }

        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6
            ],
            'sort' => [
                'defaultOrder' => [
                    'isPremium' => SORT_DESC,
                    'published_at' => SORT_DESC,
                ]
            ],
        ]);

        return $dataProvider;
    }


}