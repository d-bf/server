<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Download;

/**
 * DownloadSearch represents the model behind the search form about `app\models\Download`.
 */
class DownloadSearch extends Download
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'sort',
                    'size'
                ],
                'integer'
            ],
            [
                [
                    'file_type',
                    'name',
                    'os',
                    'arch',
                    'processor',
                    'brand',
                    'md5',
                    'path'
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
        $query = Download::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        
        $this->load($params);
        
        if (! $this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'sort' => $this->sort,
            'size' => $this->size
        ]);
        
        $query->andFilterWhere([
            'like',
            'file_type',
            $this->file_type
        ])
            ->andFilterWhere([
            'like',
            'name',
            $this->name
        ])
            ->andFilterWhere([
            'like',
            'os',
            $this->os
        ])
            ->andFilterWhere([
            'like',
            'arch',
            $this->arch
        ])
            ->andFilterWhere([
            'like',
            'processor',
            $this->processor
        ])
            ->andFilterWhere([
            'like',
            'brand',
            $this->brand
        ])
            ->andFilterWhere([
            'like',
            'md5',
            $this->md5
        ])
            ->andFilterWhere([
            'like',
            'path',
            $this->path
        ]);
        
        return $dataProvider;
    }
}
