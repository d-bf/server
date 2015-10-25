<?php

namespace app\modules\api\common\controllers;

use app\modules\api\common\controllers;
use app\modules\api\common\components\ApiComp;
use app\components\AppComp;

class VendorController extends Controller
{

    /**
     * Send vendor file to client
     * request data:
     * [
     * {
     * "type" : "",
     * "name" : "",
     * "platform_id" : ""
     * }
     * ]
     */
    public function actionGet()
    {
        $reqData = \Yii::$app->request->post();
        if (isset($reqData['type']) && isset($reqData['name']) && isset($reqData['platform_id'])) {
            $filePath = ApiComp::getVendorPath() . $reqData['type'] . DIRECTORY_SEPARATOR . $reqData['name'] . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . $reqData['platform_id'];
            if (file_exists($filePath)) {
                return AppComp::sendFile(md5_file($filePath), $filePath);
            }
        }
        
        return "";
    }

    /**
     * Check vendor file for update and send new file if needed
     */
    public function actionUpdate()
    {
    }
}
