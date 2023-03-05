<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kindergartens;

/**
 * KindergartensSerch represents the model behind the search form of `app\models\Kindergartens`.
 */
class KindergartensSerch extends Kindergartens
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kindergarten_id', 'capacity'], 'integer'],
            [['name'], 'safe'],
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
        $query = Kindergartens::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        // grid filtering conditions
        $query->andFilterWhere([
            'capacity' => $this->capacity,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
