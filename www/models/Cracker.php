<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cracker}}".
 * 
 * @property integer $id
 * @property string $name
 * @property integer $gen_type
 * @property string $switch_min_max
 *
 * @property CrackerAlgo[] $crackerAlgos
 * @property CrackerGen[] $crackerGens
 * @property CrackerPlat[] $crackerPlats
 */
class Cracker extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cracker}}';
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
                    'id',
                    'gen_type'
                ],
                'integer'
            ],
            [
                [
                    'name'
                ],
                'string',
                'max' => 80
            ],
            [
                [
                    'switch_min_max'
                ],
                'string',
                'max' => 40
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
            'name' => Yii::t('app', 'Name'),
            'gen_type' => Yii::t('app', 'Gen Type'),
            'switch_min_max' => Yii::t('app', 'Switch Min Max')
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCrackerAlgos()
    {
        return $this->hasMany(CrackerAlgo::className(), [
            'cracker_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCrackerGens()
    {
        return $this->hasMany(CrackerGen::className(), [
            'cracker_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCrackerPlats()
    {
        return $this->hasMany(CrackerPlat::className(), [
            'cracker_id' => 'id'
        ]);
    }

    /**
     * @inheritdoc
     * 
     * @return CrackerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CrackerQuery(get_called_class());
    }
}
