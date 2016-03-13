<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%crack_info}}".
 *
 * @property string $crack_id
 * @property integer $plat_id
 * @property integer $gen_id
 * @property integer $cracker_id
 *
 * @property Crack $crack
 * @property Platform $plat
 * @property Generator $gen
 * @property Cracker $cracker
 */
class CrackInfo extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%crack_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'crack_id',
                    'plat_id'
                ],
                'required'
            ],
            [
                [
                    'crack_id',
                    'plat_id',
                    'gen_id',
                    'cracker_id'
                ],
                'integer'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'crack_id' => Yii::t('app', 'Crack ID'),
            'plat_id' => Yii::t('app', 'Plat ID'),
            'gen_id' => Yii::t('app', 'Gen ID'),
            'cracker_id' => Yii::t('app', 'Cracker ID')
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCrack()
    {
        return $this->hasOne(Crack::className(), [
            'id' => 'crack_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlat()
    {
        return $this->hasOne(Platform::className(), [
            'id' => 'plat_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGen()
    {
        return $this->hasOne(Generator::className(), [
            'id' => 'gen_id'
        ]);
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
     * @inheritdoc
     *
     * @return CrackInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CrackInfoQuery(get_called_class());
    }
}
