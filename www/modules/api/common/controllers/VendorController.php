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
     * "object_type" : "",
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
        if (isset($reqData['object_type']) && isset($reqData['vendor_type']) && isset($reqData['name']) && isset($reqData['platform_id'])) {
            if ($reqData['object_type'] == 'file') { // File
                $filePath = ApiComp::getVendorPath() . $reqData['vendor_type'] . DIRECTORY_SEPARATOR . $reqData['name'] . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . $reqData['platform_id'];
                if (file_exists($filePath)) {
                    return AppComp::sendFile(md5_file($filePath), $filePath);
                }
            } elseif ($reqData['object_type'] == 'info') { // Information
                if ($reqData['vendor_type'] == 'cracker') { // Cracker's information
                    $crackerInfo = \Yii::$app->db->createCommand("SELECT c.id AS id, c.config AS config FROM {{%cracker}} c WHERE c.name = :crackerName", [
                        ':crackerName' => $reqData['name']
                    ])->queryOne();
                    
                    if (! $crackerInfo)
                        return 0;
                    
                    $info['name'] = $reqData['name'];
                    $info['config'] = unserialize($crackerInfo['config']) ?  : '';
                    
                    $crackerGeneratorsInfo = \Yii::$app->db->createCommand("SELECT g.name AS name, cg.config AS config FROM {{%cracker_gen}} cg JOIN {{%generator}} g ON (cg.cracker_id = :crackerId AND g.id = cg.gen_id)", [
                        ':crackerId' => $crackerInfo['id']
                    ])->queryAll();
                    
                    $info['generator'] = [];
                    foreach ($crackerGeneratorsInfo as $crackerGeneratorInfo) {
                        array_push($info['generator'], [
                            'name' => $crackerGeneratorInfo['name'],
                            'config' => unserialize($crackerGeneratorInfo['config']) ?  : ''
                        ]);
                    }
                    
                    return $info;
                } elseif ($reqData['vendor_type'] == 'generator') { // Generator's information
                    $generatorInfo = \Yii::$app->db->createCommand("SELECT config FROM {{%generator}} WHERE name = :name", [
                        ':name' => $reqData['name']
                    ])->queryOne();
                    
                    if (! $generatorInfo)
                        return 0;
                    
                    $info['name'] = $reqData['name'];
                    $info['config'] = unserialize($generatorInfo['config']) ?  : '';
                    
                    return $info;
                }
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
