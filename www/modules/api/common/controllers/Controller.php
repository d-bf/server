<?php

namespace app\modules\api\common\controllers;

class Controller extends \yii\web\Controller
{

    public function beforeAction($action)
    {
        \Yii::$app->controller->enableCsrfValidation = false;
        
        return parent::beforeAction($action);
    }
}