<?php

namespace app\modules\api\common\controllers;

use yii\web\Response;

class Controller extends \yii\web\Controller
{

    public function beforeAction($action)
    {
        \Yii::$app->controller->enableCsrfValidation = false;
        
        return parent::beforeAction($action);
    }
}