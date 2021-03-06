<?php
namespace app\modules\api\common\controllers;

use app\modules\api\common\controllers;
use app\modules\api\common\components\ApiComp;
use yii\helpers\Json;

class CrackController extends Controller
{

    /**
     * Get crack's information
     */
    public function actionInfo()
    {
        $reqData = \Yii::$app->request->post();
        
        if (empty($reqData['id']) || empty($reqData['platform'])) {
            return [];
        } else {
            $crack = \Yii::$app->db->createCommand("SELECT c.id AS id, g.name AS generator, c.gen_config AS gen_config, c.algo_id AS algo_id, a.name AS algo_name, c.len_min AS len_min, c.len_max AS len_max, c.charset_1 AS charset1, c.charset_2 AS charset2, c.charset_3 AS charset3, c.charset_4 AS charset4, c.mask AS mask, c.target AS target, c.has_dep AS has_dep FROM {{%crack}} c JOIN {{%generator}} g ON (c.id = :crackId AND g.id = c.gen_id) JOIN {{%algorithm}} a ON (a.id = c.algo_id)", [
                ':crackId' => $reqData['id']
            ])->queryOne(\PDO::FETCH_ASSOC);
            
            if ($crack) {
                $crack['gen_config'] = Json::decode($crack['gen_config'], true); // Should be array
                $crack['has_dep'] = (! empty($crack['has_dep'])); // Should be boolean
                
                $crackInfos = \Yii::$app->db->createCommand("SELECT p.name AS plat_name, ci.gen_id AS gen_id, c.name AS cracker_name FROM {{%crack_info}} ci JOIN {{%platform}} p ON (ci.crack_id = :crackId AND p.id = ci.plat_id) JOIN {{cracker}} c ON (c.id = ci.cracker_id)", [
                    ':crackId' => $crack['id']
                ])->queryAll();
                
                $crack['info'] = [];
                foreach ($crackInfos as $crackInfo) {
                    $crack['info'][] = [
                        'platform' => $crackInfo['plat_name'],
                        'cracker' => $crackInfo['cracker_name'],
                        'internal_gen' => ($crackInfo['gen_id'] == null)
                    ];
                }
                
                return $crack;
            } else {
                return [];
            }
        }
    }

    public function actionDep()
    {
        $reqData = \Yii::$app->request->post();
        
        if (! empty($reqData['id'])) {
            $filePath = ApiComp::getDepPath() . $reqData['id'];
            if (file_exists($filePath)) {
                return \Yii::$app->getResponse()->sendFile($filePath, md5_file($filePath));
            }
        }
        
        return '';
    }
}