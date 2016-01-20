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
        
        $platforms = [
            [0, 'cpu_linux_64'],
            [1, 'cpu_linux_32'],
            [2, 'cpu_win_64'],
            [3, 'cpu_win_32'],
            [4, 'cpu_mac_64'],
            [5, 'cpu_mac_32'],
            [6, 'gpu_linux_64_amd'],
            [7, 'gpu_linux_64_nv'],
            [8, 'gpu_linux_32_amd'],
            [9, 'gpu_linux_32_nv'],
            [10, 'gpu_win_64_amd'],
            [11, 'gpu_win_64_nv'],
            [12, 'gpu_win_32_amd'],
            [13, 'gpu_win_32_nv'],
            [14, 'gpu_mac_64_amd'],
            [15, 'gpu_mac_64_nv'],
            [16, 'gpu_mac_32_amd'],
            [17, 'gpu_mac_32_nv']
        ];
        
        $values = '';
        $params = [];
        $i = 0;
        foreach ($platforms as $platform) {
            $values .= ",(:i$i,:n$i)";
            $params[":i$i"] = $platform[0];
            $params[":n$i"] = $platform[1];
            $i++;
        }
        $values = substr($values, 1);
        
        \Yii::$app->db->createCommand("INSERT IGNORE INTO {{%platform}} (id, name) VALUES $values", $params)->execute();
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_generator()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_gen_plat()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_cracker()
    {
        $this->initStartMsg(__FUNCTION__);
        
        $this->initEndMsg(__FUNCTION__);
    }

    private function initTable_cracker_plat()
    {}

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
