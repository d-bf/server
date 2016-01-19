<?php
namespace app\controllers;

use Yii;
use app\models\CrackerPlat;
use app\models\CrackerPlatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CrackerPlatController implements the CRUD actions for CrackerPlat model.
 */
class CrackerPlatController extends Controller
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
     * Lists all CrackerPlat models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CrackerPlatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single CrackerPlat model.
     *
     * @param integer $cracker_id            
     * @param integer $plat_id            
     * @return mixed
     */
    public function actionView($cracker_id, $plat_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cracker_id, $plat_id)
        ]);
    }

    /**
     * Creates a new CrackerPlat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CrackerPlat();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'cracker_id' => $model->cracker_id,
                'plat_id' => $model->plat_id
            ]);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing CrackerPlat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $cracker_id            
     * @param integer $plat_id            
     * @return mixed
     */
    public function actionUpdate($cracker_id, $plat_id)
    {
        $model = $this->findModel($cracker_id, $plat_id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'cracker_id' => $model->cracker_id,
                'plat_id' => $model->plat_id
            ]);
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing CrackerPlat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $cracker_id            
     * @param integer $plat_id            
     * @return mixed
     */
    public function actionDelete($cracker_id, $plat_id)
    {
        $this->findModel($cracker_id, $plat_id)->delete();
        
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the CrackerPlat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $cracker_id            
     * @param integer $plat_id            
     * @return CrackerPlat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cracker_id, $plat_id)
    {
        if (($model = CrackerPlat::findOne([
            'cracker_id' => $cracker_id,
            'plat_id' => $plat_id
        ])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
