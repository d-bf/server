<?php
namespace app\modules\api\common\controllers;

use app\modules\api\common\controllers;
use app\controllers\SetupController;

class TaskController extends Controller
{

    /**
     * Send task to client
     * request data:
     * {
     * "client_info" : {
     * "platform" : [
     * {
     * "id" : "",
     * "benchmark"
     * }
     * ]
     * }
     */
    public function actionGet()
    {
        $reqData = \Yii::$app->request->post();
        
        $task = [];
        if (empty($reqData['client_info']) || empty($reqData['client_info']['platform']))
            return $task;
        
        foreach ($reqData['client_info']['platform'] as $platform) {
            if (empty($platform['id']) || empty($platform['benchmark']))
                continue;
            
            $getTaskInfo['platform'] = $platform['id'];
            $getTaskInfo['benchmark'] = $platform['benchmark'];
            
            $newTask = $this->getTask($getTaskInfo);
            if ($newTask) {
                $newTask['platform'] = $platform['id'];
                $task[] = $newTask;
            }
        }
        
        return $task;
    }

    /**
     * Get the result of a task and then send a new task
     */
    public function actionResult()
    {
        $reqData = \Yii::$app->request->post();
        foreach ($reqData as $taskInfo) { // taskInfo: {"crack_id":"","start":"","offset":"","result":"","status":""}
            $task = \Yii::$app->db->createCommand("SELECT crack_id FROM {{%task}} WHERE crack_id = :crackId AND start = :start AND offset = :offset", [
                ':crackId' => $taskInfo['crack_id'],
                ':start' => $taskInfo['start'],
                ':offset' => $taskInfo['offset']
            ])->queryScalar();
            
            if ($task) { // Task is valid
                if (isset($taskInfo['status'])) {
                    $status = $taskInfo['status'];
                    if (($status === 0) || ($status === '0')) {
                        $status = 0;
                    } else {
                        $status = intval($status);
                        if ($status == 0) // intval() failed
                            $status = - 3;
                    }
                } else {
                    $status = - 3;
                }
                
                if (($status === 0) && ! empty($taskInfo['result'])) { // Result exists and is valid
                    $result = explode("\n", $taskInfo['result']);
                    
                    $transaction = \Yii::$app->db->beginTransaction();
                    
                    $crack = \Yii::$app->db->createCommand("SELECT result, target, status FROM {{%crack}} WHERE id = :id", [
                        ':id' => $taskInfo['crack_id']
                    ])->queryOne(\PDO::FETCH_ASSOC);
                    
                    // Should update ts_last_connect
                    if ($crack['status'] < 2) { // It's not a finished crack
                        $setTsLastConnect = ', ts_last_connect = ' . gmdate('U');
                    } else {
                        $setTsLastConnect = '';
                    }
                    
                    // Remove duplicate results
                    if (! empty($crack['result'])) {
                        $crackResult = explode("\n", $crack['result']);
                        $result = array_unique(array_merge($crackResult, $result));
                    }
                    
                    // Check if crack is finished now
                    if (count(explode("\n", $crack['target'])) <= count($result)) {
                        $setStatus = ', status = 2'; // Crack is finished
                    } else {
                        $setStatus = '';
                    }
                    
                    \Yii::$app->db->createCommand("UPDATE {{%crack}} SET result = :result $setTsLastConnect $setStatus WHERE id = :id", [
                        ':result' => implode("\n", $result),
                        ':id' => $taskInfo['crack_id']
                    ])->execute();
                    
                    $transaction->commit();
                }
                
                // Update task status
                \Yii::$app->db->createCommand("UPDATE {{%task}} SET status = :status, ts_save = :tsSave WHERE crack_id = :crackId AND start = :start AND offset = :offset", [
                    ':status' => $status,
                    ':tsSave' => gmdate('U'),
                    ':crackId' => $taskInfo['crack_id'],
                    ':start' => $taskInfo['start'],
                    ':offset' => $taskInfo['offset']
                ])->execute();
            }
        }
    }

    /**
     * Retrieve a suitable task from database
     *
     * @param array $info            
     */
    protected function getTask(&$info)
    {
        if (explode('_', $info['platform'])[0] == 'gpu')
            $rateSelector = 'rate_gpu';
        else
            $rateSelector = 'rate_cpu';
        
        $timeout = gmdate('U') - 540; /* 9 min ago */
        
        $crack = \Yii::$app->db->createCommand("SELECT c.id AS crack_id, c.status AS status, c.key_total AS keyTotal, c.key_assigned AS keyAssigned, a.$rateSelector AS algo_rate FROM {{%crack}} c JOIN {{%crack_plat}} cp ON (cp.plat_id = :platformId AND c.id = cp.crack_id AND (c.status = 0 OR (c.status = 1 AND c.ts_last_connect < :timeout))) JOIN {{%algorithm}} a ON a.id = c.algo_id ORDER BY c.res_assigned ASC, c.key_total DESC LIMIT 1", [
            ':platformName' => SetupController::getPlatId($info['platform']),
            ':timeout' => $timeout
        ])->queryOne(\PDO::FETCH_ASSOC);
        
        // There is no task
        if (! $crack)
            return false;
            
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
            
            \Yii::$app->db->createCommand("INSERT INTO {{%task}} (crack_id, start, offset, status, ts_save) VALUES (:crackId, :start, :offset, :status, :tsSave)", [
                ':crackId' => $crack['crack_id'],
                ':start' => $taskStart,
                ':offset' => $assign,
                ':status' => null,
                ':tsSave' => gmdate('U')
            ])->execute();
        } else {
            // TODO: Handle situations where task is bigger or is too small
            $task = \Yii::$app->db->createCommand("SELECT start, offset, ts_save FROM {{%task}} WHERE crack_id = :crackId AND (status IS NULL OR status <> 0) AND ts_save < :timeout AND offset <= :assign ORDER BY retry ASC, ts_save ASC", [
                ':crackId' => $crack['crack_id'],
                ':timeout' => $timeout,
                ':assign' => $assign
            ])->queryOne(\PDO::FETCH_ASSOC);
            
            if ($task) {
                $taskStart = $task['start'];
                $assign = $task['offset'];
                
                \Yii::$app->db->createCommand("UPDATE {{%task}} SET retry = retry + 1, ts_save =:updateTsSave WHERE crack_id = :crackId AND start = :start AND offset = :offset AND ts_save = :tsSave", [
                    ':updateTsSave' => gmdate('U'),
                    ':crackId' => $crack['crack_id'],
                    ':start' => $task['start'],
                    ':offset' => $task['offset'],
                    ':tsSave' => $task['ts_save']
                ])->execute();
            } else {
                return false;
            }
            
            $updateRetry = ', retry = retry + 1';
        }
        
        if ($assign < $power) // Less resource is assigned to this crack
            $info['benchmark'] *= ($assign / $power);
        
        \Yii::$app->db->createCommand("UPDATE {{%crack}} SET key_assigned = key_assigned + :keyAssigned, res_assigned = res_assigned + :resAssigned, ts_last_connect = :tsLastConnect $setStatus WHERE id = :crackId", [
            ':keyAssigned' => $assign,
            ':resAssigned' => $info['benchmark'],
            ':tsLastConnect' => gmdate('U'),
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
}
