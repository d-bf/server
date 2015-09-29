<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => [
                        'post'
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Task models.
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Task model.
     * 
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->mode == 1) { // Mask
                $model->charset_1 = count_chars($model->charset_1, 3); // Get unique chars only
                $model->charset_2 = count_chars($model->charset_2, 3); // Get unique chars only
                $model->charset_3 = count_chars($model->charset_3, 3); // Get unique chars only
                $model->charset_4 = count_chars($model->charset_4, 3); // Get unique chars only
                
                $charLenMap = [
                    '?l' => 26,
                    '?u' => 26,
                    '?d' => 10,
                    '?s' => 33,
                    '?a' => 95,
                    '?1' => strlen($model->charset_1),
                    '?2' => strlen($model->charset_2),
                    '?3' => strlen($model->charset_3),
                    '?4' => strlen($model->charset_4)
                ];
                
                $model->mask = '';
                foreach ($model->maskChar as $mc)
                    $model->mask .= $mc;
                
                $model->key_total = 0;
                for ($len = $model->len_min; $len <= $model->len_max; $len++) {
                    $charLen = 1;
                    for ($l = 1; $l <= $len; $l++)
                        $charLen *= isset($charLenMap[$model->maskChar[$l]]) ? $charLenMap[$model->maskChar[$l]] : 1;
                    $model->key_total += $charLen;
                }
            } else { // Simple
                $model->charset_1 = count_chars($model->charset, 3); // Get unique chars only
                $model->charset_2 = null;
                $model->charset_3 = null;
                $model->charset_4 = null;
                
                $model->mask = str_repeat('?1', $model->len_max);
                $model->key_total = 0;
                for ($len = $model->len_min; $len <= $model->len_max; $len++)
                    $model->key_total += pow(strlen($model->charset_1), $len);
            }
            $model->save();
            
            return $this->redirect([
                'view',
                'id' => $model->id
            ]);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * 
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'id' => $model->id
            ]);
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * 
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param string $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
