<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%gen_plat}}".
 * 
 * @property integer $gen_id
 * @property integer $plat_id
 * @property string $md5
 * @property integer $alt_plat_id
 *
 * @property Generator $gen
 * @property Platform $plat
 * @property Platform $altPlat
 */
class GenPlat extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gen_plat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'gen_id',
                    'plat_id'
                ],
                'required'
            ],
            [
                [
                    'gen_id',
                    'plat_id',
                    'alt_plat_id'
                ],
                'integer'
            ],
            [
                [
                    'md5'
                ],
                'string',
                'max' => 32
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gen_id' => Yii::t('app', 'Gen ID'),
            'plat_id' => Yii::t('app', 'Plat ID'),
            'md5' => Yii::t('app', 'Md5'),
            'alt_plat_id' => Yii::t('app', 'Alt Plat ID')
        ];
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
    public function getAltPlat()
    {
        return $this->hasOne(Platform::className(), [
            'id' => 'alt_plat_id'
        ]);
    }

    /**
     * @inheritdoc
     * 
     * @return GenPlatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GenPlatQuery(get_called_class());
    }
}
