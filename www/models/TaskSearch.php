<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;

/**
 * TaskSearch represents the model behind the search form about `app\models\Task`.
 */
class TaskSearch extends Task
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'gen_id',
                    'algo_id',
                    'len_min',
                    'len_max'
                ],
                'integer'
            ],
            [
                [
                    'charset_1',
                    'charset_2',
                    'charset_3',
                    'charset_4',
                    'mask'
                ],
                'safe'
            ]
        ];
    }

    /**
     * @inheritdoc
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
        $query = Task::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        
        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'gen_id' => $this->gen_id,
            'algo_id' => $this->algo_id,
            'len_min' => $this->len_min,
            'len_max' => $this->len_max
        ]);
        
        $query->andFilterWhere([
            'like',
            'charset_1',
            $this->charset_1
        ])->andFilterWhere([
            'like',
            'charset_2',
            $this->charset_2
        ])->andFilterWhere([
            'like',
            'charset_3',
            $this->charset_3
        ])->andFilterWhere([
            'like',
            'charset_4',
            $this->charset_4
        ])->andFilterWhere([
            'like',
            'mask',
            $this->mask
        ]);
        
        return $dataProvider;
    }
}
