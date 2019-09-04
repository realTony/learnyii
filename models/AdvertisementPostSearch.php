<?php

namespace app\models;

use app\models\AdvertisementPost;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * AdvertisementPostSearch represents the model behind the search form of `app\models\AdvertisementPost`.
 *
 * What I need to filter/sort here?
 * - By Cities
 * - By Price range (min-max)
 * - By districts
 * - By Categories
 * - By Sub Category
 * - By Distance (range)
 *
 * Also I need to check if:
 *  - Is it archived
 *  - Is it premium
 *  - Is it active/deleted
 *
 * What is premium here?
 *  - Post has a premium flag
 *  - This post is exists at {user_premium_advertisement} table
 *  - It's not out of date
 *  - It's confirmed (we've got a payment)
 *
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
    public $perPage;

    public $filters = [
        'city' => '',
        'district' => '',
        'subCat_id' => '',
        'minPrice' => '',
        'maxPrice' => '',
        'minDistance' => '',
        'maxDistance' => '',
        'stickingArea' => '',
        'extraFilter' => '',
        'subCategory' => '',
//        'is_approved' => ['type'=>'boolean', 'value'=>0],
        'isPremium' => ['type'=>'boolean', 'value'=>0],
        'is_banned' => ['type'=>'boolean', 'value'=>0],
        'is_archived' => ['type'=>'boolean', 'value'=>0],
    ];

    public $ordering = [
        'default' => '`pr`.`isUp` DESC, `pr`.`isTop` DESC, {{%advertisement_post}}.`published_at` DESC',
        'price_asc' => '`pr`.`isUp` DESC, `pr`.`isTop` DESC, pricePerMonth ASC',
        'price_desc' => '`pr`.`isUp` DESC, `pr`.`isTop` DESC, pricePerMonth DESC',
        'popular' => '`pr`.`isUp` DESC, `pr`.`isTop` DESC, {{%advertisement_post}}.views DESC',
    ];

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
            'is_archived' => 0,
            'is_banned' => 0,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'condition', $this->condition]);

        return $dataProvider;
    }

    public function searchArchive($params)
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
            'is_archived' => true
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
        $params['page'] = (! empty($params['page'])) ? $params['page']: 1;
        $this->load($params);
        $query = $this->getAdvertisementPosts();
        $query = $this->setAdditionalTables($query);

        /**
         * I need here to join:
         * {user_premium_advertisement} ?
         * {premium_rates} ?
         * {advertise_cities_regions}
         * {advertisement_cat_filters}
         *
         * I don't need here any kind of premium posts
         *
         */
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
                'pageSizeLimit' => Yii::$app->params['pageSize'],
            ],
            'sort' => [
                'defaultOrder' => [
                  'published_at' => SORT_DESC,
                ],
          ],
        ]);
        $this->setFilters($params);

        $query = $this->setQueryFilters($query, $params);

        $params['orderBy'] = (! empty($params['orderBy'])) ? $params['orderBy'] : 'default';
        $query->orderBy($this->ordering[$params['orderBy']]);

        return $dataProvider;
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function searchPremCat($params)
    {
        //Prepare general posts
        //Maybe I can make some prefiltering here
        $query = $this->getAdvertisementPosts();

        $query = $this->setAdditionalTables($query);

        $this->filters['isPremium']['value'] = true;
//        $this->filters['is_approved']['value'] = true;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
            'sort' => [
                'defaultOrder' => [
                '`upa`.`id`' => SORT_DESC,
                'published_at' => SORT_DESC,
                ],
                'attributes' => ['`upa`.`id`','published_at',]
            ],
        ]);
        $this->load($params);

        $this->setFilters($params);

        // grid filtering conditions
        $query = $this->setQueryFilters($query, $params);
        $query->andWhere(['not', ['`upa`.`id`' => null]]);

        $params['orderBy'] = (! empty($params['orderBy'])) ? $params['orderBy'] : 'default';
        $query->orderBy($this->ordering[$params['orderBy']]);


        $query->orderBy('RAND()');

        return $dataProvider;
    }

    public function searchUser($params)
    {
        $params['page'] = (! empty($params['page'])) ? $params['page']: 1;
        $this->load($params);
        $query = $this->getAdvertisementPosts();
        $query = $this->setAdditionalTables($query);
        // add conditions that should always apply here

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

        $this->setFilters($params);
        $query = $this->setQueryFilters($query, $params);

        // grid filtering conditions

        $query->andFilterWhere([
            'authorId' => $params['user_id']
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'condition', $this->condition]);

        $params['orderBy'] = (! empty($params['orderBy'])) ? $params['orderBy'] : 'default';
        $query->orderBy($this->ordering[$params['orderBy']]);



        return $dataProvider;
    }

    /**
     *
     *
     * @return AdvertisementPostQuery
     */
    private function getAdvertisementPosts() : AdvertisementPostQuery
    {
        $query = AdvertisementPost::find();

        return $query;
    }

    private function setFilters(array $params)
    {
        if(! empty($params)) {
            foreach ($params as $param =>$val) {
                $this->filters[$param] = $val;
            }
        }

        return $this;
    }

    /**
     * @param AdvertisementPostQuery $query
     *
     * @return AdvertisementPostQuery
     */
    private function setQueryFilters(AdvertisementPostQuery $query, $params) : AdvertisementPostQuery
    {
        $cityId = '';

        foreach ( $this->filters as $filter=> $val) {
            if(is_array($val) && isset($val['value'])) {
                $query->andWhere([$filter => $val['value']]);
            }
        }

        if (! empty($params['city'])) {
            $cityId = (new Cities())->find()
                                    ->where(['like', 'name', $params['city']])
                                    ->orWhere(['name_ua' => $params['city']])->orderBy('name DESC' )->one();
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

        if( ! empty($params['category_id'])) {
            $query->andFilterWhere([
                '{{%advertisement_post}}.category_id' => $params['category_id'],
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

        return $query;
    }

    private function setAdditionalTables(AdvertisementPostQuery $query) : AdvertisementPostQuery
    {
        $query->leftJoin('{{%advertise_cities_regions}} `cr`',
            '{{%advertisement_post}}.`id` = `cr`.`advertise_id`');
        $query->leftJoin('{{%user_premium_advertisement}} `upa`', '{{%advertisement_post}}.`id` = `upa`.`advertisement_id`');
        $query->leftJoin('{{%premium_rates}} `pr`', '`upa`.`premium_type_id` = `pr`.`id`');
        $query->leftJoin('{{%advertisement_cat_filters}} `filter`','{{%advertisement_post}}.`filter_id` = `filter`.`id`');

        return  $query;
    }

    public function setPerPage($quantity)
    {
        $this->perPage = ($quantity > 1) ? $quantity :Yii::$app->params['pageSize'];

        return $this;
    }
}