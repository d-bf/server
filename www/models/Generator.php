<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%generator}}".
 *
 * @property integer $id
 * @property string $name
 *
 * @property CrackerGen[] $crackerGens
 * @property GenPlat[] $genPlats
 * @property Crack[] $cracks
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
                'max' => 80
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
    public function getCracks()
    {
        return $this->hasMany(Crack::className(), [
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
