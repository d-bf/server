<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cracker_plat}}".
 *
 * @property integer $cracker_id
 * @property integer $plat_id
 * @property string $config
 * @property string $md5
 *
 * @property Cracker $cracker
 * @property Platform $plat
 */
class CrackerPlat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cracker_plat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cracker_id', 'plat_id'], 'required'],
            [['cracker_id', 'plat_id'], 'integer'],
            [['config'], 'string', 'max' => 500],
            [['md5'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cracker_id' => Yii::t('app', 'Cracker ID'),
            'plat_id' => Yii::t('app', 'Plat ID'),
            'config' => Yii::t('app', 'Config'),
            'md5' => Yii::t('app', 'Md5'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCracker()
    {
        return $this->hasOne(Cracker::className(), ['id' => 'cracker_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlat()
    {
        return $this->hasOne(Platform::className(), ['id' => 'plat_id']);
    }

    /**
     * @inheritdoc
     * @return CrackerPlatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CrackerPlatQuery(get_called_class());
    }
}
