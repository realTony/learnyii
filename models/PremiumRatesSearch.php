<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PremiumRatesSearch represents the model behind the search form of `\app\models\PremiumRates`.
 */
class PremiumRatesSearch extends PremiumRates
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['duration'], 'integer'],
            [['description', 'description_ua'], 'string'],
            [['rate', 'rate_ua', 'rate_icon'], 'string', 'max' => 255],
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
        $query = PremiumRates::find();

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
            'price' => $this->price,
            'duration' => $this->duration,
        ]);

        $query->andFilterWhere(['like', 'rate', $this->rate])
            ->andFilterWhere(['like', 'rate_ua', $this->rate_ua]);

        return $dataProvider;
    }
}
