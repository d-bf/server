<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%subtask}}".
 * 
 * @property string $id
 * @property string $task_id
 * @property string $start
 * @property string $offset
 * @property integer $status
 *
 * @property Task $task
 */
class Subtask extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subtask}}';
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
                    'task_id',
                    'start'
                ],
                'required'
            ],
            [
                [
                    'id',
                    'task_id',
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
            'task_id' => Yii::t('app', 'Task ID'),
            'start' => Yii::t('app', 'Start'),
            'offset' => Yii::t('app', 'Offset'),
            'status' => Yii::t('app', 'Status')
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), [
            'id' => 'task_id'
        ]);
    }

    /**
     * @inheritdoc
     * 
     * @return SubtaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubtaskQuery(get_called_class());
    }
}
