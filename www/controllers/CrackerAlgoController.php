<?php

namespace app\controllers;

use Yii;
use app\models\CrackerAlgo;
use app\models\CrackerAlgoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CrackerAlgoController implements the CRUD actions for CrackerAlgo model.
 */
class CrackerAlgoController extends Controller
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
     * Lists all CrackerAlgo models.
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CrackerAlgoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single CrackerAlgo model.
     * 
     * @param integer $cracker_id
     * @param integer $algo_id
     * @return mixed
     */
    public function actionView($cracker_id, $algo_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cracker_id, $algo_id)
        ]);
    }

    /**
     * Creates a new CrackerAlgo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CrackerAlgo();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'cracker_id' => $model->cracker_id,
                'algo_id' => $model->algo_id
            ]);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing CrackerAlgo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * 
     * @param integer $cracker_id
     * @param integer $algo_id
     * @return mixed
     */
    public function actionUpdate($cracker_id, $algo_id)
    {
        $model = $this->findModel($cracker_id, $algo_id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'cracker_id' => $model->cracker_id,
                'algo_id' => $model->algo_id
            ]);
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing CrackerAlgo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * 
     * @param integer $cracker_id
     * @param integer $algo_id
     * @return mixed
     */
    public function actionDelete($cracker_id, $algo_id)
    {
        $this->findModel($cracker_id, $algo_id)->delete();
        
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the CrackerAlgo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param integer $cracker_id
     * @param integer $algo_id
     * @return CrackerAlgo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cracker_id, $algo_id)
    {
        if (($model = CrackerAlgo::findOne([
            'cracker_id' => $cracker_id,
            'algo_id' => $algo_id
        ])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
