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
        $task = [];
        
        $reqData = \Yii::$app->request->post();
        if (!empty($reqData['client_info']) && !empty($reqData['client_info']['platform'])) {
            foreach ($reqData['client_info']['platform'] as $platform) {
                $getTaskInfo['platform'] = '';
                $getTaskInfo['benchmark'] = '';
                
                if (!empty($platform['id']))
                    $getTaskInfo['platform'] = $platform['id'];
                
                if (!empty($platform['benchmark']))
                    $getTaskInfo['benchmark'] = $platform['benchmark'];
                
                $newTask = $this->getTask($getTaskInfo);
                if ($newTask) {
                    $newTask['platform'] = $platform['id'];
                    $task[] = $newTask;
                }
            }
        }
        
        return $task;
    }

    /**
     * Get the result of a task and then send a new task
     */
    public function actionResult()
    {
    }

    /**
     * Retrieve a suitable task from database
     * 
     * @param array $info
     */
    protected function getTask($info)
    {
        if (explode('_', $info['platform'])[0] == 'gpu')
            $rateSelector = 'rate_gpu';
        else
            $rateSelector = 'rate_cpu';
        
        $crack = \Yii::$app->db->createCommand("SELECT c.id AS crack_id, c.status AS status, c.key_total AS keyTotal, c.key_assigned AS keyAssigned, a.$rateSelector AS algo_rate FROM {{%crack}} c JOIN {{%crack_plat}} cp ON (cp.plat_name = :platformName AND c.id = cp.crack_id AND (c.status = 0 OR (c.status = 1 AND c.ts_assign < :timestamp))) JOIN {{%algorithm}} a ON a.id = c.algo_id ORDER BY c.res_assigned ASC, c.key_total DESC LIMIT 1", [
            ':platformName' => $info['platform'],
            ':timestamp' => gmdate('U') - 540 // 9 min ago
        ])->queryOne();
        
        // There is no task
        if (!$crack)
            return $crack;
        
        // Calculate speed of current algorithm
        // TODO: Use the client's benchmark of current algorithm if available 
        if ($crack['algo_rate'] === null)
            $rate = 0.5;
        else
            $rate = $crack['algo_rate'];
        $power = $info['benchmark'] * $rate;
        
        // TODO: Assign dynamic amount of work based on remained keys.
        $power *= 188743680; // Assign 3 minute of work: (3 min = 180 sec), (1M = 1048576) => 180 * 1048576 = 188743680
        
        $assign = $crack['keyTotal'] - $crack['keyAssigned'];
        
        if ($assign > $power) { // Task won't be finished by this assignment
            $assign = $power;
            $setStatus = '';
        } else { // All keys will be assigned by this assignment
            $setStatus = ', status = 1';
        }
        
        // Calculate start key
        if ($crack['status'] == 0) {
            $taskStart = $crack['keyAssigned'];
        
            \Yii::$app->db->createCommand("INSERT INTO {{%task}} (crack_id, start, offset, status) VALUES (:crackId, :start, :offset, :status)", [
                ':crackId' => $crack['crack_id'],
                ':start' => $taskStart,
                ':offset' => $assign,
                ':status' => 1
            ])->execute();
        } else {
            // TODO: Calculate start and offset correctly if status is 1
        }
        
        \Yii::$app->db->createCommand("UPDATE {{%crack}} SET key_assigned = key_assigned + :keyAssigned, res_assigned = res_assigned + :resAssigned, ts_assign = :tsAssign $setStatus WHERE id = :crackId", [
            ':keyAssigned' => $assign,
            ':resAssigned' => $info['benchmark'],
            ':tsAssign' => gmdate('U'),
            ':crackId' => $crack['crack_id']
        ])->execute();
        
        unset($crack['status']);
        unset($crack['keyTotal']);
        unset($crack['keyAssigned']);
        unset($crack['algo_rate']);
        
        $crack['start'] = "$taskStart";
        $crack['offset'] = "$assign";
        
        return $crack;
    }

    /**
     * Retrieve average speed of the system
     * 
     * @param mixed $speed current client's speed
     */
    protected function getAvgSpeed($speed)
    {
    }
}
