<?php

namespace app\modules\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Article;

/**
 * SearchArticle represents the model behind the search form of `app\models\Article`.
 */
class SearchArticle extends Article
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'created_at', 'updated_at'], 'integer'],
            [['seourl', 'title', 'announcement', 'content', 'image', 'ext_id'], 'safe'],
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
        $query = Article::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'seourl', $this->seourl])
            ->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'announcement', $this->announcement])
            ->andFilterWhere(['ilike', 'content', $this->content])
            ->andFilterWhere(['ilike', 'image', $this->image])
            ->andFilterWhere(['ilike', 'ext_id', $this->ext_id]);

        return $dataProvider;
    }
}
