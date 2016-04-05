<?php
namespace app\models;

use Yii;
use app\components\AppComp;
use yii\web\UploadedFile;
use app\controllers\SetupController;
use app\components\GenComp;

/**
 * This is the model class for table "{{%crack}}".
 *
 * @property string $id
 * @property integer $gen_id
 * @property integer $algo_id
 * @property string $gen_config
 * @property integer $len_min
 * @property integer $len_max
 * @property string $description
 * @property string $charset_1
 * @property string $charset_2
 * @property string $charset_3
 * @property string $charset_4
 * @property string $mask
 * @property string $target
 * @property integer $has_dep
 * @property string $result
 * @property string $key_total
 * @property string $key_assigned
 * @property string $key_finished
 * @property string $key_error
 * @property string $res_assigned
 * @property integer $status
 * @property integer $ts_create
 * @property integer $ts_last_connect
 *
 * @property Generator $gen
 * @property Algorithm $algo
 * @property CrackInfo[] $crackInfos
 * @property Platform[] $plats
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
                    'gen_config'
                ],
                'string',
                'max' => 64
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
                    'has_dep',
                    'key_total',
                    'key_assigned',
                    'key_finished',
                    'key_error',
                    'res_assigned',
                    'status',
                    'ts_create',
                    'ts_last_connect'
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
            ],
            [
                'mode',
                'safe'
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
            'gen_config' => Yii::t('app', 'Generator Config'),
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
            'has_dep' => Yii::t('app', 'Has Dependency'),
            'result' => Yii::t('app', 'Result'),
            'key_total' => Yii::t('app', 'Total'),
            'key_assigned' => Yii::t('app', 'Assigned'),
            'key_finished' => Yii::t('app', 'Finished'),
            'key_error' => Yii::t('app', 'Error'),
            'res_assigned' => Yii::t('app', 'Res Assigned'),
            'status' => Yii::t('app', 'Status'),
            'ts_last_connect' => Yii::t('app', 'Last Connect'),
            'ts_create' => Yii::t('app', 'Created At'),
            'mode' => Yii::t('app', 'Mode'),
            'charset' => Yii::t('app', 'Charset'),
            'maskChar' => Yii::t('app', 'Mask Char'),
            'maskCharError' => Yii::t('app', 'Mask Char')
        ];
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \yii\db\ActiveRecord::transactions()
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT
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
    public function getCrackInfos()
    {
        return $this->hasMany(CrackInfo::className(), [
            'crack_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlats()
    {
        return $this->hasMany(Platform::className(), [
            'id' => 'plat_id'
        ])->viaTable('{{%crack_info}}', [
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
            '0' => \Yii::t('app', 'Assigning...'),
            '1' => \Yii::t('app', 'Assigned All'),
            '2' => \Yii::t('app', 'Finished')
        ];
        
        if ($status === false) {
            return $statusMap;
        } elseif (isset($statusMap[$status])) {
            return $statusMap[$status];
        } else {
            return \Yii::t('app', 'Unknown');
        }
    }

    public function getDuration()
    {
        $ts_from = $this->ts_create;
        $ts_to = $this->ts_last_connect;
        $diff = $ts_to - $ts_from;
        
        if ($diff < 1) {
            return '-';
        }
        
        // year = 365 * 24 * 60 * 60 = 31536000 seconds
        if ($diff >= 31536000) {
            $y = floor($diff / 31536000);
            $diff = $diff % 31536000;
        } else {
            $y = 0;
        }
        
        // mount = 30 * 24 * 60 * 60 = 2592000 seconds
        if ($diff >= 2592000) {
            $m = floor($diff / 2592000);
            $diff = $diff % 2592000;
        } else {
            $m = 0;
        }
        
        // // week = 7 * 24 * 60 * 60 = 604800 seconds
        // if ($diff >= 604800) {
        // $w = floor($diff / 604800);
        // $diff = $diff % 604800;
        // } else {
        // $w = 0;
        // }
        
        // day = 24 * 60 * 60 = 86400 seconds
        if ($diff >= 86400) {
            $d = floor($diff / 86400);
            $diff = $diff % 86400;
        } else {
            $d = 0;
        }
        
        // hour = 60 * 60 = 3600 seconds
        if ($diff >= 3600) {
            $h = floor($diff / 3600);
            $diff = $diff % 3600;
        } else {
            $h = 0;
        }
        
        // minute = 60 seconds
        if ($diff >= 60) {
            $i = floor($diff / 60);
            $diff = $diff % 60;
        } else {
            $i = 0;
        }
        
        // seconds
        if ($diff > 0) {
            $s = $diff;
        } else {
            $s = 0;
        }
        
        $duration = [];
        
        if ($y > 1)
            $duration[] = "$y years";
        elseif ($y > 0)
            $duration[] = "1 year";
        
        if ($m > 1)
            $duration[] = "$m mounts";
        elseif ($m > 0)
            $duration[] = "1 mount";
        
        if ($d > 1)
            $duration[] = "$d days";
        elseif ($d > 0)
            $duration[] = "1 day";
        
        if ($h > 1)
            $duration[] = "$h hours";
        elseif ($h > 0)
            $duration[] = "1 hour";
        
        if ($i > 1)
            $duration[] = "$i minutes";
        elseif ($i > 0)
            $duration[] = "1 minute";
        
        if ($s > 1)
            $duration[] = "$s seconds";
        elseif ($s > 0)
            $duration[] = "1 second";
        
        return implode(', ', $duration);
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
            $this->ts_create = gmdate('U');
            
            /* Prepare attributes according to crack mode */
            if (empty($this->mode)) { // Simple
                $this->charset_1 = count_chars($this->charset, 3); // Get unique chars only
                $this->charset_2 = '';
                $this->charset_3 = '';
                $this->charset_4 = '';
                
                $this->mask = str_repeat('?1', $this->len_max);
                $this->key_total = GenComp::getKeyTotal($this, true);
            } else { // Mask
                $this->charset_1 = count_chars($this->charset_1, 3); // Get unique chars only
                $this->charset_2 = count_chars($this->charset_2, 3); // Get unique chars only
                $this->charset_3 = count_chars($this->charset_3, 3); // Get unique chars only
                $this->charset_4 = count_chars($this->charset_4, 3); // Get unique chars only
                
                $this->mask = '';
                foreach ($this->maskChar as $mc)
                    $this->mask .= $mc;
                
                $this->key_total = GenComp::getKeyTotal($this, false);
            }
            
            $this->has_dep = 0;
            
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
        /* Save dep file */
        if ($u = UploadedFile::getInstanceByName('gen-dep')) { // There was an upload
            if ($this->gen->name == 'markov') {
                $zip = new \ZipArchive();
                if ($zip->open($u->tempName) === true) {
                    /* Get the first valid file */
                    $i = 0;
                    while (($stat = $zip->statIndex($i))) {
                        if (empty($stat['crc'])) {
                            $zip->deleteIndex($i ++);
                        } else {
                            $zip->renameIndex($i ++, 'dep-gen');
                            break;
                        }
                    }
                    
                    /* Delete all other entities */
                    while ($zip->deleteIndex($i ++));
                    
                    $zip->close();
                    
                    if ($u->saveAs(AppComp::getDepPath() . $this->id)) {
                        $this->updateAttributes([
                            'has_dep' => 1
                        ]);
                    }
                }
            }
        }
        
        /* Fill the crack_info table according to the crack attributes */
        // Select crackers with embedded generator
        $crackInfo = \Yii::$app->db->createCommand("SELECT DISTINCT cp.plat_id AS plat_id, cg.cracker_id AS cracker_id FROM {{%cracker_gen}} cg JOIN {{%cracker_algo}} ca ON (cg.gen_id = :genId AND ca.algo_id = :algoId AND cg.cracker_id = ca.cracker_id) JOIN {{%cracker_plat}} cp ON cp.cracker_id = cg.cracker_id", [
            ':genId' => $this->gen_id,
            ':algoId' => $this->algo_id
        ])->queryAll();
        
        $platforms = array_flip(SetupController::$platforms);
        
        if ($crackInfo) {
            $values = '';
            $params[':i'] = $this->id;
            $params[':g'] = null;
            for ($i = 0; $i < count($crackInfo); $i ++) {
                $values .= ",(:i, :p$i, :g, :c$i)";
                
                $params[":p$i"] = $crackInfo[$i]['plat_id'];
                $params[":c$i"] = $crackInfo[$i]['cracker_id'];
                
                unset($platforms[$crackInfo[$i]['plat_id']]);
            }
            $values = substr($values, 1);
            
            \Yii::$app->db->createCommand("INSERT INTO {{%crack_info}} (crack_id, plat_id, gen_id, cracker_id) VALUES $values", $params)->execute();
        }
        
        // Select crackers without embedded generator
        if (count($platforms) > 0) {
            $platIdes = array_keys($platforms);
            $platIdes = implode(',', $platIdes);
            
            $crackInfo = \Yii::$app->db->createCommand("SELECT DISTINCT gp.plat_id AS plat_id, gp.gen_id AS gen_id, cp.cracker_id AS cracker_id FROM {{%cracker_plat}} cp JOIN {{%cracker}} c ON (cp.plat_id IN ($platIdes) AND ((c.input_mode > 1 AND cp.plat_id < 100) OR (c.input_mode > 0 AND cp.plat_id > 99)) AND cp.cracker_id = c.id) JOIN {{%cracker_algo}} ca ON (ca.algo_id = :algoId AND cp.cracker_id = ca.cracker_id) JOIN {{%gen_plat}} gp ON (gp.gen_id = :genId AND gp.plat_id = cp.plat_id)", [
                ':genId' => $this->gen_id,
                ':algoId' => $this->algo_id
            ])->queryAll();
            
            if ($crackInfo) {
                $values = '';
                unset($params);
                $params[':i'] = $this->id;
                for ($i = 0; $i < count($crackInfo); $i ++) {
                    $values .= ",(:i, :p$i, :g$i, :c$i)";
                    
                    $params[":p$i"] = $crackInfo[$i]['plat_id'];
                    $params[":g$i"] = $crackInfo[$i]['gen_id'];
                    $params[":c$i"] = $crackInfo[$i]['cracker_id'];
                }
                $values = substr($values, 1);
                
                \Yii::$app->db->createCommand("INSERT INTO {{%crack_info}} (crack_id, plat_id, gen_id, cracker_id) VALUES $values", $params)->execute();
            }
        }
        
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \yii\db\BaseActiveRecord::beforeDelete()
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $depFile = AppComp::getDepPath() . $this->id;
            if (file_exists($depFile))
                unlink($depFile);
            
            return true;
        } else {
            return false;
        }
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
