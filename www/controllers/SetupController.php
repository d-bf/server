<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * SetupController performs the initial setup and initialization of database.
 */
class SetupController extends Controller
{

    public function actionInit()
    {
        $this->initTable_platform();
        $this->initTable_generator();
        $this->initTable_gen_plat();
        $this->initTable_cracker();
        // $this->initTable_cracker_plat();
        // $this->initTable_cracker_gen();
        // $this->initTable_algorithm();
        // $this->initTable_cracker_algo();
        // $this->initTable_plat_algo_cracker();
    }

    private function initStartMsg($function)
    {
        $tableName = substr($function, 10);
        echo "Initializing \"$tableName\" table...<br>";
    }

    private function initEndMsg($function)
    {
        $tableName = substr($function, 10);
        echo "\"$tableName\" table Initialized.<br><br>";
    }

    private function initTable_platform()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $data = [
            [0,     'cpu_linux_64'],
            [1,     'cpu_linux_32'],
            [2,     'cpu_win_64'],
            [3,     'cpu_win_32'],
            [4,     'cpu_mac_64'],
            [5,     'cpu_mac_32'],
            [6,     'gpu_linux_64_amd'],
            [7,     'gpu_linux_64_nv'],
            [8,     'gpu_linux_32_amd'],
            [9,     'gpu_linux_32_nv'],
            [10,    'gpu_win_64_amd'],
            [11,    'gpu_win_64_nv'],
            [12,    'gpu_win_32_amd'],
            [13,    'gpu_win_32_nv'],
            [14,    'gpu_mac_64_amd'],
            [15,    'gpu_mac_64_nv'],
            [16,    'gpu_mac_32_amd'],
            [17,    'gpu_mac_32_nv']
        ];
        
        $fields = 2;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT IGNORE INTO {{%platform}} (id, name) VALUES $values", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_generator()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $data = [
            [0, 'general',  ''],
//             [1, 'markov', ''],
        ];
        
        $fields = 3;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT IGNORE INTO {{%generator}} (id, name, config) VALUES $values", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_gen_plat()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $data = [
            /* general */
            [0, 0,  null,    null],
            [0, 1,  null,    null],
            [0, 2,  null,    null],
            [0, 3,  null,    null],
            [0, 4,  null,    null],
            [0, 5,  null,    null],
            [0, 6,  0,       null],
            [0, 7,  0,       null],
            [0, 8,  1,       null],
            [0, 9,  1,       null],
            [0, 10, 2,       null],
            [0, 11, 2,       null],
            [0, 12, 3,       null],
            [0, 13, 3,       null],
            [0, 14, 4,       null],
            [0, 15, 4,       null],
            [0, 16, 5,       null],
            [0, 17, 5,       null],
            
//             /* markov */
//             [1, 0,  null,    null],
//             [1, 1,  null,    null],
//             [1, 2,  null,    null],
//             [1, 3,  null,    null],
//             [1, 4,  null,    null],
//             [1, 5,  null,    null],
//             [1, 6,  0,       null],
//             [1, 7,  0,       null],
//             [1, 8,  1,       null],
//             [1, 9,  1,       null],
//             [1, 10, 2,       null],
//             [1, 11, 2,       null],
//             [1, 12, 3,       null],
//             [1, 13, 3,       null],
//             [1, 14, 4,       null],
//             [1, 15, 4,       null],
//             [1, 16, 5,       null],
//             [1, 17, 5,       null]
        ];
        
        $fields = 4;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT IGNORE INTO {{%gen_plat}} (gen_id, plat_id, alt_plat_id, md5) VALUES $values", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_cracker()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $data = [
            [0, 'hashcat'],
            [1, 'oclHashcat'],
        ];
        
        $fields = 2;
        $values = '';
        $params = [];
        $i = 0;
        foreach ($data as $dataItem) {
            $vals = '';
            for ($f = 0; $f < $fields; $f ++) {
                $vals .= ",:f$f$i";
                $params[":f$f$i"] = $dataItem[$f];
            }
            $values .= ',(' . substr($vals, 1) . ')';
            $i ++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT IGNORE INTO {{%cracker}} (id, name) VALUES $values", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_cracker_plat()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_cracker_gen()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_algorithm()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_cracker_algo()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_plat_algo_cracker()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $this->initEndMsg(__FUNCTION__);
    }
}
