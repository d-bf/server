<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property string $id
 * @property integer $gen_id
 * @property integer $algo_id
 * @property integer $len_min
 * @property integer $len_max
 * @property string $charset_1
 * @property string $charset_2
 * @property string $charset_3
 * @property string $charset_4
 * @property string $mask
 *
 * @property Subtask[] $subtasks
 * @property Generator $gen
 * @property Algorithm $algo
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
            [['gen_id', 'algo_id', 'len_min', 'len_max', 'mask'], 'required'],
            [['gen_id', 'algo_id', 'len_min', 'len_max'], 'integer'],
            [['charset_1', 'charset_2', 'charset_3', 'charset_4', 'mask'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gen_id' => Yii::t('app', 'Gen ID'),
            'algo_id' => Yii::t('app', 'Algo ID'),
            'len_min' => Yii::t('app', 'Len Min'),
            'len_max' => Yii::t('app', 'Len Max'),
            'charset_1' => Yii::t('app', 'Charset 1'),
            'charset_2' => Yii::t('app', 'Charset 2'),
            'charset_3' => Yii::t('app', 'Charset 3'),
            'charset_4' => Yii::t('app', 'Charset 4'),
            'mask' => Yii::t('app', 'Mask'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubtasks()
    {
        return $this->hasMany(Subtask::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGen()
    {
        return $this->hasOne(Generator::className(), ['id' => 'gen_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlgo()
    {
        return $this->hasOne(Algorithm::className(), ['id' => 'algo_id']);
    }

    /**
     * @inheritdoc
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }
}
