<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%algorithm}}".
 *
 * @property integer $id
 * @property string $name
 * @property double $rate_cpu
 * @property double $rate_gpu
 *
 * @property Crack[] $cracks
 * @property CrackerAlgo[] $crackerAlgos
 * @property Cracker[] $crackers
 * @property PlatAlgoCracker[] $platAlgoCrackers
 * @property Platform[] $plats
 */
class Algorithm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%algorithm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['rate_cpu', 'rate_gpu'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique']
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
            'rate_cpu' => Yii::t('app', 'Rate Cpu'),
            'rate_gpu' => Yii::t('app', 'Rate Gpu'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCracks()
    {
        return $this->hasMany(Crack::className(), ['algo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrackerAlgos()
    {
        return $this->hasMany(CrackerAlgo::className(), ['algo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrackers()
    {
        return $this->hasMany(Cracker::className(), ['id' => 'cracker_id'])->viaTable('{{%cracker_algo}}', ['algo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatAlgoCrackers()
    {
        return $this->hasMany(PlatAlgoCracker::className(), ['algo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlats()
    {
        return $this->hasMany(Platform::className(), ['id' => 'plat_id'])->viaTable('{{%plat_algo_cracker}}', ['algo_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AlgorithmQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlgorithmQuery(get_called_class());
    }
}
