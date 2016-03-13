<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cracker}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $config
 * @property integer $input_mode
 *
 * @property CrackInfo[] $crackInfos
 * @property CrackerAlgo[] $crackerAlgos
 * @property Algorithm[] $algos
 * @property CrackerGen[] $crackerGens
 * @property Generator[] $gens
 * @property CrackerPlat[] $crackerPlats
 * @property Platform[] $plats
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
                    'input_mode'
                ],
                'integer'
            ],
            [
                [
                    'name'
                ],
                'string',
                'max' => 50
            ],
            [
                [
                    'config'
                ],
                'string',
                'max' => 500
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
            'config' => Yii::t('app', 'Config'),
            'input_mode' => Yii::t('app', 'Input Mode')
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCrackInfos()
    {
        return $this->hasMany(CrackInfo::className(), [
            'cracker_id' => 'id'
        ]);
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
    public function getAlgos()
    {
        return $this->hasMany(Algorithm::className(), [
            'id' => 'algo_id'
        ])->viaTable('{{%cracker_algo}}', [
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
    public function getGens()
    {
        return $this->hasMany(Generator::className(), [
            'id' => 'gen_id'
        ])->viaTable('{{%cracker_gen}}', [
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
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlats()
    {
        return $this->hasMany(Platform::className(), [
            'id' => 'plat_id'
        ])->viaTable('{{%cracker_plat}}', [
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
