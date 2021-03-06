<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%platform}}".
 *
 * @property integer $id
 * @property string $name
 *
 * @property CrackInfo[] $crackInfos
 * @property Crack[] $cracks
 * @property CrackerPlat[] $crackerPlats
 * @property Cracker[] $crackers
 * @property GenPlat[] $genPlats
 * @property GenPlat[] $genPlats0
 * @property Generator[] $gens
 */
class Platform extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%platform}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'name'
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
                'max' => 32
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
    public function getCrackInfos()
    {
        return $this->hasMany(CrackInfo::className(), [
            'plat_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCracks()
    {
        return $this->hasMany(Crack::className(), [
            'id' => 'crack_id'
        ])->viaTable('{{%crack_info}}', [
            'plat_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCrackerPlats()
    {
        return $this->hasMany(CrackerPlat::className(), [
            'plat_id' => 'id'
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
        ])->viaTable('{{%cracker_plat}}', [
            'plat_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenPlats()
    {
        return $this->hasMany(GenPlat::className(), [
            'plat_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenPlats0()
    {
        return $this->hasMany(GenPlat::className(), [
            'alt_plat_id' => 'id'
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
        ])->viaTable('{{%gen_plat}}', [
            'plat_id' => 'id'
        ]);
    }

    /**
     * @inheritdoc
     *
     * @return PlatformQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlatformQuery(get_called_class());
    }
}
