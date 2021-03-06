<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Crack;

/**
 * CrackSearch represents the model behind the search form about `app\models\Crack`.
 */
class CrackSearch extends Crack
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
                    'len_max',
                    'has_dep',
                    'key_total',
                    'key_assigned',
                    'key_finished',
                    'key_error',
                    'res_assigned',
                    'status',
                    'ts_create',
                    'ts_last_connect'
                ],
                'integer'
            ],
            [
                [
                    'genName',
                    'algoName',
                    'gen_config',
                    'description',
                    'charset_1',
                    'charset_2',
                    'charset_3',
                    'charset_4',
                    'mask',
                    'target',
                    'result'
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
        $query = Crack::find();
        
        $query->joinWith([
            'gen',
            'algo'
        ], false);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'ts_last_connect' => SORT_DESC
                ]
            ]
        ]);
        
        $dataProvider->sort->attributes['genName'] = [
            'asc' => [
                '{{%generator}}.name' => SORT_ASC
            ],
            'desc' => [
                '{{%generator}}.name' => SORT_DESC
            ]
        ];
        
        $dataProvider->sort->attributes['algoName'] = [
            'asc' => [
                '{{%algorithm}}.name' => SORT_ASC
            ],
            'desc' => [
                '{{%algorithm}}.name' => SORT_DESC
            ]
        ];
        
        $this->load($params);
        
        if (! $this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'gen_id' => $this->gen_id,
            'algo_id' => $this->algo_id,
            'len_min' => $this->len_min,
            'len_max' => $this->len_max,
            'has_dep' => $this->has_dep,
            'key_total' => $this->key_total,
            'key_assigned' => $this->key_assigned,
            'key_finished' => $this->key_finished,
            'key_error' => $this->key_error,
            'res_assigned' => $this->res_assigned,
            'status' => $this->status,
            'ts_create' => $this->ts_create,
            'ts_last_connect' => $this->ts_last_connect
        ]);
        
        $query->andFilterWhere([
            'like',
            '{{%generator}}.name',
            $this->genName
        ])
            ->andFilterWhere([
            'like',
            '{{%algorithm}}.name',
            $this->algoName
        ])
            ->andFilterWhere([
            'like',
            'gen_config',
            $this->gen_config
        ])
            ->andFilterWhere([
            'like',
            'description',
            $this->description
        ])
            ->andFilterWhere([
            'like',
            'charset_1',
            $this->charset_1
        ])
            ->andFilterWhere([
            'like',
            'charset_2',
            $this->charset_2
        ])
            ->andFilterWhere([
            'like',
            'charset_3',
            $this->charset_3
        ])
            ->andFilterWhere([
            'like',
            'charset_4',
            $this->charset_4
        ])
            ->andFilterWhere([
            'like',
            'mask',
            $this->mask
        ])
            ->andFilterWhere([
            'like',
            'target',
            $this->target
        ])
            ->andFilterWhere([
            'like',
            'result',
            $this->result
        ]);
        
        return $dataProvider;
    }
}
