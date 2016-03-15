<?php
namespace app\modules\api\controllers;

use app\modules\api\common\controllers\Controller;
use app\modules\api\Api;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        /* Response to client ping */
        if (\Yii::$app->request->post('ping') == 'name') {
            return 'd-bf';
        }
        
        return [
            'default_version' => Api::getDefaultVersion()
        ];
    }
}
