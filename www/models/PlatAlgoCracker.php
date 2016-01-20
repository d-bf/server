<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%plat_algo_cracker}}".
 *
 * @property integer $plat_id
 * @property integer $algo_id
 * @property integer $cracker_id
 *
 * @property Platform $plat
 * @property Algorithm $algo
 * @property Cracker $cracker
 */
class PlatAlgoCracker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%plat_algo_cracker}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plat_id', 'algo_id', 'cracker_id'], 'required'],
            [['plat_id', 'algo_id', 'cracker_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plat_id' => Yii::t('app', 'Plat ID'),
            'algo_id' => Yii::t('app', 'Algo ID'),
            'cracker_id' => Yii::t('app', 'Cracker ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlat()
    {
        return $this->hasOne(Platform::className(), ['id' => 'plat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlgo()
    {
        return $this->hasOne(Algorithm::className(), ['id' => 'algo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCracker()
    {
        return $this->hasOne(Cracker::className(), ['id' => 'cracker_id']);
    }

    /**
     * @inheritdoc
     * @return PlatAlgoCrackerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlatAlgoCrackerQuery(get_called_class());
    }
}
