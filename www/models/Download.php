<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%download}}".
 *
 * @property integer $sort
 * @property string $file_type
 * @property string $name
 * @property string $os
 * @property string $arch
 * @property string $processor
 * @property string $brand
 * @property integer $size
 * @property string $md5
 * @property string $path
 */
class Download extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%download}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'size'], 'integer'],
            [['file_type', 'name', 'os', 'arch', 'processor', 'brand'], 'required'],
            [['file_type'], 'string', 'max' => 30],
            [['name'], 'string', 'max' => 100],
            [['os'], 'string', 'max' => 15],
            [['arch'], 'string', 'max' => 5],
            [['processor'], 'string', 'max' => 3],
            [['brand'], 'string', 'max' => 25],
            [['md5'], 'string', 'max' => 32],
            [['path'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sort' => Yii::t('app', 'Sort'),
            'file_type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'os' => Yii::t('app', 'OS'),
            'arch' => Yii::t('app', 'Arch'),
            'processor' => Yii::t('app', 'Processor'),
            'brand' => Yii::t('app', 'Brand'),
            'size' => Yii::t('app', 'Size'),
            'md5' => Yii::t('app', 'MD5'),
            'path' => Yii::t('app', 'Path'),
        ];
    }

    /**
     * @inheritdoc
     * @return DownloadQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DownloadQuery(get_called_class());
    }
}
