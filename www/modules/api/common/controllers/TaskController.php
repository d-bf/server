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
                $getTaskInfo['pu'] = '';
                $getTaskInfo['benchmark'] = '';
                // os_arch_pu_brand
                if (!empty($platform['id'])) {
                    $platformInfo = explode('_', $platform['id']); // $platformInfo indexes are: 0: os, 1: arch, 2: pu (processing uint), 3: brand
                    if (!empty($platformInfo[2]))
                        $getTaskInfo['pu'] = $platformInfo[2];
                }
                
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
     * 
     * @param array $info
     */
    protected function getTask($info)
    {
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
