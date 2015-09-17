<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CrackerGen;

/**
 * CrackerGenSearch represents the model behind the search form about `app\models\CrackerGen`.
 */
class CrackerGenSearch extends CrackerGen
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cracker_id', 'gen_id'], 'integer'],
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
        $query = CrackerGen::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'cracker_id' => $this->cracker_id,
            'gen_id' => $this->gen_id,
        ]);

        return $dataProvider;
    }
}
