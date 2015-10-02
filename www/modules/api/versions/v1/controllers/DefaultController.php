<?php

namespace app\modules\api\versions\v1\controllers;

use yii\web\Controller;
use yii\helpers\Url;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}
