<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%algorithm}}".
 * 
 * @property integer $id
 * @property string $name
 *
 * @property CrackerAlgo[] $crackerAlgos
 * @property Crack[] $cracks
 */
class Algorithm extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%algorithm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id'
                ],
                'required'
            ],
            [
                [
                    'id'
                ],
                'integer'
            ],
            [
                [
                    'name'
                ],
                'string',
                'max' => 100
            ],
            [
                [
                    'name'
                ],
                'unique'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name')
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCrackerAlgos()
    {
        return $this->hasMany(CrackerAlgo::className(), [
            'algo_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCracks()
    {
        return $this->hasMany(Crack::className(), [
            'algo_id' => 'id'
        ]);
    }

    /**
     * @inheritdoc
     * 
     * @return AlgorithmQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlgorithmQuery(get_called_class());
    }
}
