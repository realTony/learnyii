<?php

namespace app\models;

use Yii;
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

    public function searchAll($params)
    {
        $query = AdvertisementPost::find();
        $query->leftJoin('{{%user}}', '{{%user}}.`id` = {{%advertisement_post}}.authorId');
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
//            'category_id' => $this->category_id,
//            'subCat_id' => $this->subCat_id,
//            'pricePerMonth' => $this->pricePerMonth,
//            'contract_term' => $this->contract_term,
//            'distancePerMonth' => $this->distancePerMonth,
            'adv_type' => $this->adv_type,
            'sticking_area' => $this->sticking_area,
            'showEmail' => $this->showEmail,
            'isPremium' => $this->isPremium,
            'coverage_type' => $this->coverage_type,
            'published_at' => $this->published_at,
            'is_approved' => $this->is_approved,
            'is_archived' => 0,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'condition', $this->condition])
        ->orderBy('published_at DESC');

        return $dataProvider;
    }

    public function searchCat($params)
    {
        $query = AdvertisementPost::find();
        $params['page'] = (! empty($params['page'])) ? $params['page']: 1;
        $query->leftJoin('{{%user_premium_advertisement}} `upa`', '{{%advertisement_post}}.`id` = `upa`.`advertisement_id`');
        $query->leftJoin('{{%premium_rates}} `pr`', '`upa`.`premium_type_id` = `pr`.`id`');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
                'pageSizeLimit' => Yii::$app->params['pageSize'],
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
//        $query->leftJoin('{{%advertisement_cat_filters}} `filter`','{{%advertisement_post}}.`id` = `cr`.`advertise_id`');
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

        if(! empty($params['extraFilter'])) {
            $query->andFilterWhere(['in', 'filter_id', $params['extraFilter']]);
        }
        if(! empty($params['subCategory'])) {
            $query->andFilterWhere(['in', 'subCat_id', $params['subCategory']]);
        }
        $query
            ->andWhere(['is_approved' => 1])
            ->andWhere(['is_banned' => 0])
            ->andWhere(['is_archived' => 0]);
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'condition', $this->condition]);

        if(! empty($params['orderBy'])) {

            switch ($params['orderBy']) {
                case 'price_desc':

                    $query->orderBy('`pr`.`isUp` DESC, `pr`.`isTop` DESC, pricePerMonth DESC');
                    break;
                case 'price_asc':
                    $query->orderBy('`pr`.`isUp` DESC, `pr`.`isTop` DESC, pricePerMonth ASC');
                    break;
                case 'popular':
                    $query->orderBy('`pr`.`isUp` DESC, `pr`.`isTop` DESC, {{%advertisement_post}}.views DESC');
                    break;
                default:
                    $query->orderBy('`pr`.`isUp` DESC, `pr`.`isTop` DESC, {{%advertisement_post}}.`published_at` DESC');
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
                'pageSize' => 29,
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