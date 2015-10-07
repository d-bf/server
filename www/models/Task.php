<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task}}".
 * 
 * @property string $id
 * @property string $crack_id
 * @property string $start
 * @property string $offset
 * @property integer $status
 *
 * @property Crack $crack
 */
class Task extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
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
                    'crack_id',
                    'start'
                ],
                'required'
            ],
            [
                [
                    'id',
                    'crack_id',
                    'start',
                    'offset',
                    'status'
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
            'id' => Yii::t('app', 'ID'),
            'crack_id' => Yii::t('app', 'Crack ID'),
            'start' => Yii::t('app', 'Start'),
            'offset' => Yii::t('app', 'Offset'),
            'status' => Yii::t('app', 'Status')
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
     * @inheritdoc
     * 
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }
}
