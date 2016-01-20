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
 * @property string $description
 * @property string $charset_1
 * @property string $charset_2
 * @property string $charset_3
 * @property string $charset_4
 * @property string $mask
 * @property string $target
 * @property string $result
 * @property string $key_total
 * @property string $key_assigned
 * @property string $key_finished
 * @property string $key_error
 * @property string $res_assigned
 * @property integer $ts_assign
 * @property integer $status
 *
 * @property Generator $gen
 * @property Algorithm $algo
 * @property CrackPlat[] $crackPlats
 * @property Platform[] $platNames
 * @property Task[] $tasks
 */
class Crack extends \yii\db\ActiveRecord
{

    public $mode, $charset, $maskChar, $maskCharError, $_LEN_MAX = 55, $genName, $algoName;

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
                    'target'
                ],
                'required'
            ],
            [
                [
                    'description'
                ],
                'string',
                'max' => 50
            ],
            [
                'charset',
                'match',
                'pattern' => '/^.+$/',
                'skipOnEmpty' => false,
                'message' => '{attribute} cannot be blank.',
                'when' => function ($model) {
                    return empty($model->mode);
                },
                'whenClient' => "function() {
					return (! $('#crack-mode').is(':checked'));
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
                    if (! empty($model->mode)) {
                        foreach ($model->maskChar as $mc)
                            if ($mc == '?' . explode('_', $attribute)[1])
                                return true;
                    }
                    return false;
                },
                'whenClient' => "function(attribute) {
					var ret = false;
					if ($('#crack-mode').is(':checked')) {
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
                    return (! empty($model->mode));
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
					return ($('#crack-mode').is(':checked') && (! $(attribute.input).prop('disabled')));
				}"
            ],
            [
                'maskCharError',
                'required',
                'when' => function ($model) {
                    if (! empty($model->mode)) {
                        foreach ($model->maskChar as $mc)
                            if (empty($mc))
                                return true;
                    }
                    return false;
                },
                'whenClient' => "function(attribute) {
					var ret = false;
					if ($('#crack-mode').is(':checked')) {
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
                    'key_error',
                    'res_assigned',
                    'status',
                    'ts_assign'
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
                'max' => 5120
            ],
            [
                [
                    'result'
                ],
                'string',
                'max' => 10240
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
            'gen_id' => Yii::t('app', 'Word Generator'),
            'genName' => Yii::t('app', 'Word Generator'),
            'algo_id' => Yii::t('app', 'Algorithm'),
            'algoName' => Yii::t('app', 'Algorithm'),
            'len_min' => Yii::t('app', 'Min'),
            'len_max' => Yii::t('app', 'Max'),
            'description' => Yii::t('app', 'Description'),
            'charset_1' => Yii::t('app', 'Custom Charset 1'),
            'charset_2' => Yii::t('app', 'Custom Charset 2'),
            'charset_3' => Yii::t('app', 'Custom Charset 3'),
            'charset_4' => Yii::t('app', 'Custom Charset 4'),
            'mask' => Yii::t('app', 'Mask'),
            'target' => Yii::t('app', 'Target Hashes'),
            'result' => Yii::t('app', 'Result'),
            'key_total' => Yii::t('app', 'Total'),
            'key_assigned' => Yii::t('app', 'Assigned'),
            'key_finished' => Yii::t('app', 'Finished'),
            'key_error' => Yii::t('app', 'Error'),
            'res_assigned' => Yii::t('app', 'Res Assigned'),
            'ts_assign' => Yii::t('app', 'Last Assignment'),
            'status' => Yii::t('app', 'Status'),
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

    public function getStatusMap($status = false)
    {
        $statusMap = [
            '0' => 'Not assigned all',
            '1' => 'Assigned all',
            '2' => 'Finished'
        ];
        
        if ($status === false) {
            return $statusMap;
        } elseif (isset($statusMap[$status])) {
            return $statusMap[$status];
        } else {
            return \Yii::t('app', 'Unknown');
        }
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

    /**
     *
     * {@inheritDoc}
     *
     * @see \yii\db\BaseActiveRecord::beforeSave($insert)
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            /* Prepare attributes according to crack mode */
            if (empty($this->mode)) { // Simple
                $this->charset_1 = count_chars($this->charset, 3); // Get unique chars only
                $this->charset_2 = '';
                $this->charset_3 = '';
                $this->charset_4 = '';
                
                $this->mask = str_repeat('?1', $this->len_max);
                $this->key_total = 0;
                for ($len = $this->len_min; $len <= $this->len_max; $len ++)
                    $this->key_total += pow(strlen($this->charset_1), $len);
            } else { // Mask
                $this->charset_1 = count_chars($this->charset_1, 3); // Get unique chars only
                $this->charset_2 = count_chars($this->charset_2, 3); // Get unique chars only
                $this->charset_3 = count_chars($this->charset_3, 3); // Get unique chars only
                $this->charset_4 = count_chars($this->charset_4, 3); // Get unique chars only
                
                $charLenMap = [
                    '?l' => 26,
                    '?u' => 26,
                    '?d' => 10,
                    '?s' => 33,
                    '?a' => 95,
                    '?1' => strlen($this->charset_1),
                    '?2' => strlen($this->charset_2),
                    '?3' => strlen($this->charset_3),
                    '?4' => strlen($this->charset_4)
                ];
                
                $this->mask = '';
                foreach ($this->maskChar as $mc)
                    $this->mask .= $mc;
                
                $this->key_total = 0;
                for ($len = $this->len_min; $len <= $this->len_max; $len ++) {
                    $charLen = 1;
                    for ($l = 1; $l <= $len; $l ++)
                        $charLen *= isset($charLenMap[$this->maskChar[$l]]) ? $charLenMap[$this->maskChar[$l]] : 1;
                    $this->key_total += $charLen;
                }
            }
            
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \yii\db\BaseActiveRecord::afterSave($insert, $changedAttributes)
     */
    public function afterSave($insert, $changedAttributes)
    {
        /* Fill the crack_plat table according to the crack attributes */
        $query = 'SELECT DISTINCT p.name FROM {{%gen_plat}} gp JOIN {{%cracker_plat}} cp ON (gp.gen_id = :genId AND cp.plat_id = gp.plat_id) JOIN {{%cracker_algo}} ca ON (ca.algo_id = :algoId AND cp.cracker_id = ca.cracker_id) JOIN {{%platform}} p ON p.id = cp.plat_id UNION ';
        $query .= 'SELECT DISTINCT p.name FROM {{%cracker_algo}} ca JOIN {{%cracker_gen}} cg ON (ca.algo_id = :algoId AND cg.gen_id = :genId AND cg.cracker_id = ca.cracker_id) JOIN {{%cracker_plat}} cp ON cp.cracker_id = cg.cracker_id JOIN {{%platform}} p ON p.id = cp.plat_id';
        $platforms = \Yii::$app->db->createCommand($query, [
            ':genId' => $this->gen_id,
            ':algoId' => $this->algo_id
        ])->queryColumn();
        
        $i = 0;
        $values = '';
        $params = [];
        foreach ($platforms as $platform) {
            $values .= ",(:c, :p$i)";
            $params[":p$i"] = $platform;
            $i ++;
        }
        if (count($params) > 0) {
            $values = substr($values, 1);
            $params[':c'] = $this->id;
            \Yii::$app->db->createCommand("INSERT INTO {{%crack_plat}} (crack_id, plat_name) VALUES $values", $params)->execute();
        }
        
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \yii\db\BaseActiveRecord::afterFind()
     */
    public function afterFind()
    {
        $this->genName = $this->gen->name;
        $this->algoName = $this->algo->name;
        
        parent::afterFind();
    }
}
