<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%crack}}".
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
 * @property string $target
 * @property string $key_total
 * @property string $key_assigned
 * @property string $key_finished
 * @property string $key_error
 *
 * @property Generator $gen
 * @property Algorithm $algo
 * @property CrackPlat[] $crackPlats
 * @property Platform[] $platNames
 * @property Task[] $tasks
 */
class Crack extends \yii\db\ActiveRecord
{

    public $mode, $charset, $maskChar, $maskCharError, $_LEN_MAX = 55;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%crack}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'gen_id',
                    'algo_id',
                    'len_min',
                    'len_max',
                    'mode'
                ],
                'required'
            ],
            [
                'charset',
                'match',
                'pattern' => '/^.+$/',
                'skipOnEmpty' => false,
                'message' => '{attribute} cannot be blank.',
                'when' => function ($model) {
                    return $model->mode == 0;
                },
                'whenClient' => "function() {
					return $('#crack-mode').val() == '0';
				}"
            ],
            [
                [
                    'charset_1',
                    'charset_2',
                    'charset_3',
                    'charset_4'
                ],
                'match',
                'pattern' => '/^.+$/',
                'skipOnEmpty' => false,
                'message' => '{attribute} cannot be blank.',
                'when' => function ($model, $attribute) {
                    if ($model->mode == 1) {
                        foreach ($model->maskChar as $mc)
                            if ($mc == '?' . explode('_', $attribute)[1])
                                return true;
                    }
                    return false;
                },
                'whenClient' => "function(attribute) {
					var ret = false;
					if ($('#crack-mode').val() == '1') {
						$('#crack-maskchars input:enabled').each(function(index, element) {
							if ($(element).val() == '?' + attribute.name.split('_')[1]) {
								ret = true;
								return false; // Break loop
							}
						});
					}
					return ret;
				}"
            ],
            [
                'maskChar',
                'each',
                'rule' => [
                    'match',
                    'pattern' => '/^\?{0,1}.{1}$/',
                    'skipOnEmpty' => false,
                    'message' => '{attribute} cannot be blank.'
                ],
                'when' => function ($model) {
                    return $model->mode == 1;
                },
                'enableClientValidation' => false
            ],
            [
                'maskChar',
                'match',
                'pattern' => '/^\?{0,1}.{1}$/',
                'skipOnEmpty' => false,
                'message' => '{attribute} cannot be blank.',
                'when' => function () {
                    return false;
                },
                'whenClient' => "function(attribute) {
					return (($('#crack-mode').val() == '1') && (! $(attribute.input).prop('disabled')));
				}"
            ],
            [
                'maskCharError',
                'required',
                'when' => function ($model) {
                    if ($model->mode == 1) {
                        foreach ($model->maskChar as $mc)
                            if (empty($mc))
                                return true;
                    }
                    return false;
                },
                'whenClient' => "function(attribute) {
					var ret = false;
					if ($('#crack-mode').val() == '1') {
						$('#crack-maskchars input:visible:enabled').each(function(index, element) {
							if ($(element).val().length == 0) {
								ret = true;
								return false; // Break loop
							}
						});
					}
					return ret;
				}"
            ],
            [
                [
                    'gen_id',
                    'algo_id',
                    'len_min',
                    'len_max',
                    'key_total',
                    'key_assigned',
                    'key_finished',
                    'key_error'
                ],
                'integer'
            ],
            [
                'len_max',
                'compare',
                'compareAttribute' => 'len_min',
                'operator' => '>='
            ],
            [
                [
                    'charset_1',
                    'charset_2',
                    'charset_3',
                    'charset_4',
                    'mask'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'target'
                ],
                'string',
                'max' => 60000
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
            'gen_id' => Yii::t('app', 'Gen ID'),
            'algo_id' => Yii::t('app', 'Algo ID'),
            'len_min' => Yii::t('app', 'Min'),
            'len_max' => Yii::t('app', 'Max'),
            'charset_1' => Yii::t('app', 'Custom Charset 1'),
            'charset_2' => Yii::t('app', 'Custom Charset 2'),
            'charset_3' => Yii::t('app', 'Custom Charset 3'),
            'charset_4' => Yii::t('app', 'Custom Charset 4'),
            'mask' => Yii::t('app', 'Mask'),
            'mask' => Yii::t('app', 'Target'),
            'key_total' => Yii::t('app', 'Total'),
            'key_assigned' => Yii::t('app', 'Assigned'),
            'key_finished' => Yii::t('app', 'Finished'),
            'key_error' => Yii::t('app', 'Error'),
            'mode' => Yii::t('app', 'Mode'),
            'charset' => Yii::t('app', 'Charset'),
            'maskChar' => Yii::t('app', 'Mask Char'),
            'maskCharError' => Yii::t('app', 'Mask Char')
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGen()
    {
        return $this->hasOne(Generator::className(), [
            'id' => 'gen_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlgo()
    {
        return $this->hasOne(Algorithm::className(), [
            'id' => 'algo_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCrackPlats()
    {
        return $this->hasMany(CrackPlat::className(), [
            'crack_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlatNames()
    {
        return $this->hasMany(Platform::className(), [
            'name' => 'plat_name'
        ])->viaTable('{{%crack_plat}}', [
            'crack_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), [
            'crack_id' => 'id'
        ]);
    }

    /**
     * @inheritdoc
     * 
     * @return CrackQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CrackQuery(get_called_class());
    }
}
