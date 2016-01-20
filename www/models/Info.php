<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%info}}".
 *
 * @property string $info_name
 * @property string $info_type
 * @property string $info_value
 */
class Info extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['info_name'], 'required'],
            [['info_name', 'info_type'], 'string', 'max' => 32],
            [['info_value'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'info_name' => Yii::t('app', 'Info Name'),
            'info_type' => Yii::t('app', 'Info Type'),
            'info_value' => Yii::t('app', 'Info Value'),
        ];
    }

    /**
     * @inheritdoc
     * @return InfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InfoQuery(get_called_class());
    }
}
