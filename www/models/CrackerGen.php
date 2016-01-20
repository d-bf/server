<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cracker_gen}}".
 *
 * @property integer $cracker_id
 * @property integer $gen_id
 * @property string $config
 *
 * @property Cracker $cracker
 * @property Generator $gen
 */
class CrackerGen extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cracker_gen}}';
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
                    'gen_id'
                ],
                'required'
            ],
            [
                [
                    'cracker_id',
                    'gen_id'
                ],
                'integer'
            ],
            [
                [
                    'config'
                ],
                'string',
                'max' => 500
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
            'gen_id' => Yii::t('app', 'Gen ID'),
            'config' => Yii::t('app', 'Config')
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
    public function getGen()
    {
        return $this->hasOne(Generator::className(), [
            'id' => 'gen_id'
        ]);
    }

    /**
     * @inheritdoc
     *
     * @return CrackerGenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CrackerGenQuery(get_called_class());
    }
}
