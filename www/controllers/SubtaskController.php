<?php

namespace app\controllers;

use Yii;
use app\models\Subtask;
use app\models\SubtaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SubtaskController implements the CRUD actions for Subtask model.
 */
class SubtaskController extends Controller
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
     * Lists all Subtask models.
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubtaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Subtask model.
     * 
     * @param string $id
     * @param string $task_id
     * @return mixed
     */
    public function actionView($id, $task_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $task_id)
        ]);
    }

    /**
     * Creates a new Subtask model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subtask();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'id' => $model->id,
                'task_id' => $model->task_id
            ]);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Subtask model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * 
     * @param string $id
     * @param string $task_id
     * @return mixed
     */
    public function actionUpdate($id, $task_id)
    {
        $model = $this->findModel($id, $task_id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'id' => $model->id,
                'task_id' => $model->task_id
            ]);
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing Subtask model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * 
     * @param string $id
     * @param string $task_id
     * @return mixed
     */
    public function actionDelete($id, $task_id)
    {
        $this->findModel($id, $task_id)->delete();
        
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the Subtask model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param string $id
     * @param string $task_id
     * @return Subtask the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $task_id)
    {
        if (($model = Subtask::findOne([
            'id' => $id,
            'task_id' => $task_id
        ])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
