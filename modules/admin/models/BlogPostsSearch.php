<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\BlogPosts;

/**
 * BlogPostsSearch represents the model behind the search form of `app\modules\admin\models\BlogPosts`.
 */
class BlogPostsSearch extends BlogPosts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'author_id'], 'integer'],
            [['title', 'description', 'link', 'post_thumbnail', 'post_image', 'seo_title', 'seo_text', 'options', 'translation', 'updated_at', 'created_at'], 'safe'],
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
        $query = BlogPosts::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('updated_at DESC'),
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
//            'author_id' => $this->author_id,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'post_thumbnail', $this->post_thumbnail])
            ->andFilterWhere(['like', 'post_image', $this->post_image])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_text', $this->seo_text])
            ->andFilterWhere(['like', 'options', $this->options])
            ->andFilterWhere(['like', 'translation', $this->translation]);

        return $dataProvider;
    }
}
