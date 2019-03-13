<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdvertisementPost;

/**
 * AdvertisementPostSearch represents the model behind the search form of `app\models\AdvertisementPost`.
 */
class AdvertisementPostSearch extends AdvertisementPost
{
    /**
     * {@inheritdoc}
     */
    public $city;
    public $district;
    public $orderBy;
    public $user_id;

    public function rules()
    {
        return [
            [['id', 'category_id', 'subCat_id', 'contract_term', 'adv_type', 'sticking_area', 'authorId', 'showEmail', 'isPremium', 'coverage_type'], 'integer'],
            [['title', 'description', 'condition', 'published_at'], 'safe'],
            [['pricePerMonth', 'distancePerMonth'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AdvertisementPost::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'subCat_id' => $this->subCat_id,
            'pricePerMonth' => $this->pricePerMonth,
            'contract_term' => $this->contract_term,
            'distancePerMonth' => $this->distancePerMonth,
            'adv_type' => $this->adv_type,
            'sticking_area' => $this->sticking_area,
            'authorId' => $this->authorId,
            'showEmail' => $this->showEmail,
            'isPremium' => $this->isPremium,
            'coverage_type' => $this->coverage_type,
            'published_at' => $this->published_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'condition', $this->condition]);

        return $dataProvider;
    }

    public function searchCat($params)
    {
        $query = AdvertisementPost::find();


        $params['page'] = (! empty($params['page'])) ? $params['page']: 1;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
                'pageSizeLimit' => 8,
            ],
            'sort' => [
                'defaultOrder' => [
                    'isPremium' => SORT_DESC,
                    'published_at' => SORT_DESC,
                ]
            ],
        ]);

        if (! empty($params['city'])) {
            $this->city = $params['city'];
        }

        if (! empty($params['district'])) {
            $this->district = $params['district'];
        }


        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }




        if (! empty($params['city'])) {
            $cityId = (new Cities())->find()
                ->where(['like', 'name', $params['city']])
                ->orWhere(['name_ua' => $params['city']])->orderBy('name DESC' )->one();
        }

        $query->leftJoin('{{%advertise_cities_regions}} `cr`','{{%advertisement_post}}.`id` = `cr`.`advertise_id`');
        // grid filtering conditions
        if( ! empty($params['category_id'])) {
            $query->andFilterWhere([
                'category_id' => $params['category_id'],
            ]);
        }
        if( !empty($params['subCat_id'])) {
            $query->andFilterWhere([
                'subCat_id' => $params['subCat_id'],
            ]);
        }

        if(! empty($params['city'])) {
            $query->andFilterWhere(['`cr`.`city_id`' => $cityId['id']]);
        }

        if(! empty($params['district'])) {
            $region = (new CityRegions())->find()
                ->where(['like', 'region', $params['district']])
                ->orWhere(['region_ua' => $params['district']])->orderBy('region DESC' )->one();

            $query->andFilterWhere(['`cr`.`region_id`' =>  $region['id']]);
        }

        if(! empty($params['minPrice'])) {
            $query->andFilterWhere(['>', 'pricePerMonth', $params['minPrice']]);
        }

        if(! empty($params['maxPrice'])) {
            $query->andFilterWhere(['<', 'pricePerMonth', $params['maxPrice']]);
        }

        if(! empty($params['minDistance'])) {
            $query->andFilterWhere(['>', 'distancePerMonth', $params['minDistance']]);
        }

        if(! empty($params['maxDistance'])) {
            $query->andFilterWhere(['<', 'distancePerMonth', $params['maxDistance']]);
        }

        if(! empty($params['stickingArea'])) {
            $query->andFilterWhere(['in', 'sticking_area', $params['stickingArea']]);
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'condition', $this->condition]);

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


        return $dataProvider;
    }

    public function searchUser($params)
    {
        $query = AdvertisementPost::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
            ],
            'sort' => [
                'defaultOrder' => [
                    'isPremium' => SORT_DESC,
                    'published_at' => SORT_DESC,
                ]
            ],
        ]);

        if (! empty($params['city'])) {
            $this->city = $params['city'];
        }

        if (! empty($params['district'])) {
            $this->district = $params['district'];
        }


        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }




        if (! empty($params['city'])) {
            $cityId = (new Cities())->find()
                ->where(['like', 'name', $params['city']])
                ->orWhere(['name_ua' => $params['city']])->orderBy('name DESC' )->one();
        }

        $query->leftJoin('{{%advertise_cities_regions}} `cr`','{{%advertisement_post}}.`id` = `cr`.`advertise_id`');
        // grid filtering conditions
        if(! empty($params['category_id'])) {
            $query->andFilterWhere([
                'category_id' => $params['category_id'],
            ]);
        }

        if(! empty($params['subCat_id'])) {
            $query->andFilterWhere([
                'subCat_id' => $this->subCat_id,
            ]);
        }

        $query->andFilterWhere([
            'authorId' => $params['user_id']
        ]);

        if(! empty($params['city'])) {
            $query->andFilterWhere(['`cr`.`city_id`' => $cityId['id']]);
        }

        if(! empty($params['district'])) {
            $region = (new CityRegions())->find()
                ->where(['like', 'region', $params['district']])
                ->orWhere(['region_ua' => $params['district']])->orderBy('region DESC' )->one();

            $query->andFilterWhere(['`cr`.`region_id`' =>  $region['id']]);
        }

        if(! empty($params['minPrice'])) {
            $query->andFilterWhere(['>', 'pricePerMonth', $params['minPrice']]);
        }

        if(! empty($params['maxPrice'])) {
            $query->andFilterWhere(['<', 'pricePerMonth', $params['maxPrice']]);
        }

        if(! empty($params['minDistance'])) {
            $query->andFilterWhere(['>', 'distancePerMonth', $params['minDistance']]);
        }

        if(! empty($params['maxDistance'])) {
            $query->andFilterWhere(['<', 'distancePerMonth', $params['maxDistance']]);
        }

        if(! empty($params['stickingArea'])) {
            $query->andFilterWhere(['in', 'sticking_area', $params['stickingArea']]);
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'condition', $this->condition]);

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


        return $dataProvider;
    }
}