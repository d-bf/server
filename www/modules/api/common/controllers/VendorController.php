<?php
namespace app\modules\api\common\controllers;

use app\modules\api\common\controllers;
use app\modules\api\common\components\ApiComp;
use app\components\AppComp;

class VendorController extends Controller
{

    /**
     * Send vendor file or inforamtion to client
     * request data:
     * {
     * "vendor_type" : "",
     * "name" : "",
     * "platform_id" : ""
     * }
     * object_type: file | info
     * vendor_type: cracker | generator
     */
    public function actionGet()
    {
        $reqData = \Yii::$app->request->post();
        
        if (isset($reqData['vendor_type']) && isset($reqData['name']) && isset($reqData['platform_id'])) {
            $filePath = ApiComp::getVendorPath() . strtolower($reqData['vendor_type']) . DIRECTORY_SEPARATOR . strtolower($reqData['name']) . DIRECTORY_SEPARATOR . strtolower($reqData['platform_id']);
            if (file_exists($filePath)) {
                return AppComp::sendFile(md5_file($filePath), $filePath);
            }
        }
        
        return 0;
    }

    /**
     * update vendor file or information
     * request data:
     * {
     * "object_type" : "",
     * "vendor_type" : "",
     * "name" : "",
     * "platform_id" : "",
     * "version" : ""
     * }
     * object_type: file | info
     * vendor_type: cracker | generator
     */
    public function actionUpdate()
    {}
}
