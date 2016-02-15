<?php
namespace app\modules\api\common\controllers;

use app\modules\api\common\controllers;
use app\modules\api\common\components\ApiComp;
use yii\helpers\Json;

class VendorController extends Controller
{

    /**
     * Send vendor file to client
     * request data:
     * {
     * "vendor_type" : "",
     * "name" : "",
     * "platform_id" : ""
     * }
     * vendor_type: cracker | generator
     */
    public function actionGet()
    {
        $reqData = \Yii::$app->request->post();
        
        if (isset($reqData['vendor_type']) && isset($reqData['name']) && isset($reqData['platform_id'])) {
            $filePath = ApiComp::getVendorPath() . strtolower($reqData['vendor_type']) . DIRECTORY_SEPARATOR . strtolower($reqData['name']) . DIRECTORY_SEPARATOR . strtolower($reqData['platform_id']);
            if (file_exists($filePath)) {
                return \Yii::$app->getResponse()->sendFile($filePath, md5_file($filePath));
            }
        }
        
        return 0;
    }

    /**
     * Send vendor inforamtion to client
     * request data:
     * {
     * "vendor_type" : "",
     * "name" : "",
     * "platform_id" : ""
     * }
     * vendor_type: cracker | generator
     */
    public function actionGetinfo()
    {
        $reqData = \Yii::$app->request->post();
        
        $info = '';
        
        if (isset($reqData['vendor_type']) && isset($reqData['name']) && isset($reqData['platform_id'])) {
            if ($reqData['vendor_type'] == 'cracker') { // Cracker's information
                $crackerInfo = \Yii::$app->db->createCommand("SELECT c.id AS id, c.config AS config FROM {{%cracker}} c WHERE c.name = :crackerName", [
                    ':crackerName' => $reqData['name']
                ])->queryOne();
                
                if ($crackerInfo) {
                    $info = Json::decode($crackerInfo['config'], true);
                    
                    $info['generator'] = [];
                    $crackerGeneratorsInfo = \Yii::$app->db->createCommand("SELECT g.name AS name, cg.config AS config FROM {{%cracker_gen}} cg JOIN {{%generator}} g ON (cg.cracker_id = :crackerId AND g.id = cg.gen_id)", [
                        ':crackerId' => $crackerInfo['id']
                    ])->queryAll();
                    if ($crackerGeneratorsInfo) {
                        foreach ($crackerGeneratorsInfo as $crackerGeneratorInfo) {
                            array_push($info['generator'], [
                                'name' => $crackerGeneratorInfo['name'],
                                'config' => Json::decode($crackerGeneratorInfo['config'], true)
                            ]);
                        }
                    }
                }
            } elseif ($reqData['vendor_type'] == 'generator') { // Generator's information
                $info = \Yii::$app->db->createCommand("SELECT config FROM {{%generator}} WHERE name = :name", [
                    ':name' => $reqData['name']
                ])->queryScalar();
                
                if ($info === false)
                    $info = '';
                else
                    $info = Json::decode($info);
            }
        }
        
        return $info;
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
