<?php

namespace app\controllers;

use Yii;
use app\models\GenPlat;
use app\models\GenPlatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GenPlatController implements the CRUD actions for GenPlat model.
 */
class GenPlatController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all GenPlat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GenPlatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GenPlat model.
     * @param integer $gen_id
     * @param integer $plat_id
     * @return mixed
     */
    public function actionView($gen_id, $plat_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($gen_id, $plat_id),
        ]);
    }

    /**
     * Creates a new GenPlat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GenPlat();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'gen_id' => $model->gen_id, 'plat_id' => $model->plat_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GenPlat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $gen_id
     * @param integer $plat_id
     * @return mixed
     */
    public function actionUpdate($gen_id, $plat_id)
    {
        $model = $this->findModel($gen_id, $plat_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'gen_id' => $model->gen_id, 'plat_id' => $model->plat_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GenPlat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $gen_id
     * @param integer $plat_id
     * @return mixed
     */
    public function actionDelete($gen_id, $plat_id)
    {
        $this->findModel($gen_id, $plat_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the GenPlat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $gen_id
     * @param integer $plat_id
     * @return GenPlat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($gen_id, $plat_id)
    {
        if (($model = GenPlat::findOne(['gen_id' => $gen_id, 'plat_id' => $plat_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
