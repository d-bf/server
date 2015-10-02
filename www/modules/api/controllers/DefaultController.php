<?php

namespace app\modules\api\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\modules\api\Api;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        $this->redirect(Url::to('/api/' . Api::getDefaultVersion()));
    }
}
