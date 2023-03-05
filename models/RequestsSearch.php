<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Requests;

/**
 * RequestsSearch represents the model behind the search form of `app\models\Requests`.
 */
class RequestsSearch extends Requests
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kindergarten_id', 'user_id', 'status'], 'integer'],
            [['child_name', 'birth_date', 'reason', 'created_at'], 'safe'],
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
        $query = Requests::find();

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
            'kindergarten_id' => $this->kindergarten_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'child_name', $this->child_name])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'birth_date', $this->birth_date]);

        return $dataProvider;
    }
}
