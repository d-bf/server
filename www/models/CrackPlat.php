<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%crack_plat}}".
 *
 * @property string $crack_id
 * @property string $plat_name
 *
 * @property Crack $crack
 * @property Platform $platName
 */
class CrackPlat extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%crack_plat}}';
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
                    'plat_name'
                ],
                'required'
            ],
            [
                [
                    'crack_id'
                ],
                'integer'
            ],
            [
                [
                    'plat_name'
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
            'crack_id' => Yii::t('app', 'Crack ID'),
            'plat_name' => Yii::t('app', 'Plat Name')
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
    public function getPlatName()
    {
        return $this->hasOne(Platform::className(), [
            'name' => 'plat_name'
        ]);
    }

    /**
     * @inheritdoc
     *
     * @return CrackPlatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CrackPlatQuery(get_called_class());
    }
}
