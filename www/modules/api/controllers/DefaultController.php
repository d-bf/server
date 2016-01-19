<?php
namespace app\modules\api\controllers;

use app\modules\api\common\controllers\Controller;
use app\modules\api\Api;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        return [
            'default_version' => Api::getDefaultVersion()
        ];
    }
}
