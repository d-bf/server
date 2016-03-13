<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%generator}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $config
 *
 * @property Crack[] $cracks
 * @property CrackInfo[] $crackInfos
 * @property CrackerGen[] $crackerGens
 * @property Cracker[] $crackers
 * @property GenPlat[] $genPlats
 * @property Platform[] $plats
 */
class Generator extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%generator}}';
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
            'config' => Yii::t('app', 'Config')
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCracks()
    {
        return $this->hasMany(Crack::className(), [
            'gen_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCrackInfos()
    {
        return $this->hasMany(CrackInfo::className(), [
            'gen_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCrackerGens()
    {
        return $this->hasMany(CrackerGen::className(), [
            'gen_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCrackers()
    {
        return $this->hasMany(Cracker::className(), [
            'id' => 'cracker_id'
        ])->viaTable('{{%cracker_gen}}', [
            'gen_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenPlats()
    {
        return $this->hasMany(GenPlat::className(), [
            'gen_id' => 'id'
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
        ])->viaTable('{{%gen_plat}}', [
            'gen_id' => 'id'
        ]);
    }

    /**
     * @inheritdoc
     *
     * @return GeneratorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneratorQuery(get_called_class());
    }
}
