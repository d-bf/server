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
 * @property integer $size
 * @property string $md5
 * @property string $processor
 * @property string $brand
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
            [['md5'], 'string', 'max' => 32],
            [['processor'], 'string', 'max' => 3],
            [['brand'], 'string', 'max' => 25],
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
            'file_type' => Yii::t('app', 'File Type'),
            'name' => Yii::t('app', 'Name'),
            'os' => Yii::t('app', 'Os'),
            'arch' => Yii::t('app', 'Arch'),
            'size' => Yii::t('app', 'Size'),
            'md5' => Yii::t('app', 'Md5'),
            'processor' => Yii::t('app', 'Processor'),
            'brand' => Yii::t('app', 'Brand'),
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
