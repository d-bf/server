<?php

namespace app\modules\api\common\controllers;

use app\modules\api\common\controllers;

class CrackController extends Controller
{

	/**
	 * Get crack's information
	 */
    public function actionInfo()
    {
        $reqData = \Yii::$app->request->post();

        if (!empty($reqData['id'])) {
            return \Yii::$app->db->createCommand("SELECT c.id AS id, g.name AS gen_name, a.id AS algo_id, a.name AS algo_name, c.len_min AS lenMin, c.len_max AS lenMax, c.charset_1 AS charset1, c.charset_2 AS charset2, c.charset_3 AS charset3, c.charset_4 AS charset4, c.mask AS mask FROM {{%crack}} c JOIN {{%generator}} g ON (c.id = :crackId AND g.id = c.gen_id) JOIN {{%algorithm}} a ON a.id = c.algo_id", [
                ':crackId' => $reqData['id']
            ])->queryOne();
        } else {
            return [];   
        }
    }
}
