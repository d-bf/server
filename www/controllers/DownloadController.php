<?php

namespace app\controllers;

use Yii;
use app\models\Download;
use app\models\DownloadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DownloadController implements the CRUD actions for Download model.
 */
class DownloadController extends Controller
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
     * Lists all Download models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DownloadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Download model.
     * @param string $file_type
     * @param string $name
     * @param string $os
     * @param string $arch
     * @param string $processor
     * @param string $brand
     * @return mixed
     */
    public function actionView($file_type, $name, $os, $arch, $processor, $brand)
    {
        return $this->render('view', [
            'model' => $this->findModel($file_type, $name, $os, $arch, $processor, $brand),
        ]);
    }

    /**
     * Creates a new Download model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Download();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'file_type' => $model->file_type, 'name' => $model->name, 'os' => $model->os, 'arch' => $model->arch, 'processor' => $model->processor, 'brand' => $model->brand]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Download model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $file_type
     * @param string $name
     * @param string $os
     * @param string $arch
     * @param string $processor
     * @param string $brand
     * @return mixed
     */
    public function actionUpdate($file_type, $name, $os, $arch, $processor, $brand)
    {
        $model = $this->findModel($file_type, $name, $os, $arch, $processor, $brand);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'file_type' => $model->file_type, 'name' => $model->name, 'os' => $model->os, 'arch' => $model->arch, 'processor' => $model->processor, 'brand' => $model->brand]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Download model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $file_type
     * @param string $name
     * @param string $os
     * @param string $arch
     * @param string $processor
     * @param string $brand
     * @return mixed
     */
    public function actionDelete($file_type, $name, $os, $arch, $processor, $brand)
    {
        $this->findModel($file_type, $name, $os, $arch, $processor, $brand)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Download model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $file_type
     * @param string $name
     * @param string $os
     * @param string $arch
     * @param string $processor
     * @param string $brand
     * @return Download the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($file_type, $name, $os, $arch, $processor, $brand)
    {
        if (($model = Download::findOne(['file_type' => $file_type, 'name' => $name, 'os' => $os, 'arch' => $arch, 'processor' => $processor, 'brand' => $brand])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
