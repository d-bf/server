<?php

namespace app\controllers;

use Yii;
use app\models\CrackerGen;
use app\models\CrackerGenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CrackerGenController implements the CRUD actions for CrackerGen model.
 */
class CrackerGenController extends Controller
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
     * Lists all CrackerGen models.
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CrackerGenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single CrackerGen model.
     * 
     * @param integer $cracker_id
     * @param integer $gen_id
     * @return mixed
     */
    public function actionView($cracker_id, $gen_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cracker_id, $gen_id)
        ]);
    }

    /**
     * Creates a new CrackerGen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CrackerGen();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'cracker_id' => $model->cracker_id,
                'gen_id' => $model->gen_id
            ]);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing CrackerGen model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * 
     * @param integer $cracker_id
     * @param integer $gen_id
     * @return mixed
     */
    public function actionUpdate($cracker_id, $gen_id)
    {
        $model = $this->findModel($cracker_id, $gen_id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'cracker_id' => $model->cracker_id,
                'gen_id' => $model->gen_id
            ]);
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing CrackerGen model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * 
     * @param integer $cracker_id
     * @param integer $gen_id
     * @return mixed
     */
    public function actionDelete($cracker_id, $gen_id)
    {
        $this->findModel($cracker_id, $gen_id)->delete();
        
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the CrackerGen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param integer $cracker_id
     * @param integer $gen_id
     * @return CrackerGen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cracker_id, $gen_id)
    {
        if (($model = CrackerGen::findOne([
            'cracker_id' => $cracker_id,
            'gen_id' => $gen_id
        ])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
