<?php
namespace app\modules\api\common\controllers;

use app\modules\api\common\controllers;

class GetController extends Controller
{

    /**
     * Get algorithm-cracker map
     */
    public function actionAlgoCracker()
    {
        $reqData = \Yii::$app->request->post();
        
        if (! empty($reqData['platform'])) {
            return \Yii::$app->db->createCommand("SELECT pac.algo_id, c.name AS cracker FROM {{%plat_algo_cracker}} pac JOIN {{%platform}} p ON (p.name = :platName AND pac.plat_id = p.id) JOIN {{%cracker}} c ON c.id = pac.cracker_id", [
                ':platName' => $reqData['platform']
            ])->queryAll();
        } else {
            return [];
        }
    }
}
