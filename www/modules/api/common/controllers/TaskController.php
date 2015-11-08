<?php

namespace app\modules\api\common\controllers;

use app\modules\api\common\controllers;

class TaskController extends Controller
{

    /**
     * Send task to client
     * request data:
     * {
     * "client_info" : {
     * "platform" : {
     * "id" : "",
     * "benchmark"
     * }
     * }
     */
    public function actionGet()
    {
        $reqData = \Yii::$app->request->post();
        if (!empty($reqData['client_info']) && !empty($reqData['client_info']['platform'])) {
            $task = [];
            foreach ($reqData['client_info']['platform'] as $platform) {
                $getTaskInfo['platform'] = '';
                $getTaskInfo['benchmark'] = '';
                
                if (!empty($platform['id']))
                    $getTaskInfo['platform'] = $platform['id'];
                
                if (!empty($platform['benchmark']))
                    $getTaskInfo['benchmark'] = $platform['benchmark'];
                
                $task = $this->getTask($getTaskInfo);
            }
        }
    }

    /**
     * Get the result of a task and then send a new task
     */
    public function actionResult()
    {
    }

    /**
     * Retrieve a suitable task from database
     * @param array $info
     */
    protected function getTask($info)
    {
        if (explode('_', $info['platform'])[2] == 'gpu')
            $rateSelector = 'rate_gpu';
        else
            $rateSelector = 'rate_cpu';
        
        $task = \Yii::$app->db->createCommand("SELECT c.id AS id, g.name AS gen_name, a.id AS algo_id, a.name AS algo_name, a.$rateSelector AS algo_rate, c.len_min AS lenMin, c.len_max AS lenMax, c.charset_1 AS charset1, c.charset_2 AS charset2, c.charset_3 AS charset3, c.charset_4 AS charset4, c.mask AS mask, c.key_total AS keyTotal, c.key_assigned AS keyAssigned, c.res_assigned AS resAssigned FROM {{%crack}} c JOIN {{%generator}} g ON (c.id = :crackId AND g.id = c.gen_id) JOIN {{%algorithm}} a ON a.id = c.algo_id", [
            ':crackId' => \Yii::$app->db->createCommand("SELECT c.id FROM {{%crack}} c JOIN {{%crack_platform}} cp ON (cp.platform_name = :platformName AND c.id = cp.crack_id) ORDER BY c.res_assigned ASC, c.key_total DESC, c.key_assigned ASC LIMIT 1", [
                ':platformName' => $info['platform']
            ])->queryScalar()
        ])->queryOne();
        
        // Calculate speed of current algorithm
        // TODO: Use the client's benchmark of current algorithm if available 
        if ($task['algo_rate'] === null)
            $rate = 0.5;
        else
            $rate = $task['algo_rate'];
        $power = $info['benchmark'] * rate;
        
        // TODO: Assign dynamic amount of work based on remained keys.
        // Assign 3 minute of work (3 min = 10800 sec)
        $power *= 10800;
        
        $canAssign = $task['keyTotal'] - $task['keyAssigned'];
        
        if ($canAssign > $power) { // Task won't be finished by this assignment
            $canAssign = $power;
        }
        
        \Yii::$app->db->createCommand("UPDATE {{%crack}} SET key_assigned = key_assigned + :keyAssigned WHERE id = :crackId", [
            ':keyAssigned' => $canAssign,
            ':crackId' => $task['id']
        ])->execute();
    }

    /**
     * Retrieve average speed of the system
     * @param mixed $speed current client's speed
     */
    protected function getAvgSpeed($speed)
    {
    }
}
