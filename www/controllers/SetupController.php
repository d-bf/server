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
