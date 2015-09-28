<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cracker_algo}}".
 * 
 * @property integer $cracker_id
 * @property integer $algo_id
 * @property string $algo_switch
 *
 * @property Cracker $cracker
 * @property Algorithm $algo
 */
class CrackerAlgo extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cracker_algo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'cracker_id',
                    'algo_id'
                ],
                'required'
            ],
            [
                [
                    'cracker_id',
                    'algo_id'
                ],
                'integer'
            ],
            [
                [
                    'algo_switch'
                ],
                'string',
                'max' => 40
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cracker_id' => Yii::t('app', 'Cracker ID'),
            'algo_id' => Yii::t('app', 'Algo ID'),
            'algo_switch' => Yii::t('app', 'Algo Switch')
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCracker()
    {
        return $this->hasOne(Cracker::className(), [
            'id' => 'cracker_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlgo()
    {
        return $this->hasOne(Algorithm::className(), [
            'id' => 'algo_id'
        ]);
    }

    /**
     * @inheritdoc
     * 
     * @return CrackerAlgoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CrackerAlgoQuery(get_called_class());
    }
}
