<?php
namespace app\controllers;

use Yii;
use app\models\Download;
use app\models\DownloadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\AppComp;

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
                    'delete' => [
                        'post'
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Download models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DownloadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Finds the Download model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
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
        if (($model = Download::findOne([
            'file_type' => $file_type,
            'name' => $name,
            'os' => $os,
            'arch' => $arch,
            'processor' => $processor,
            'brand' => $brand
        ])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Send download file
     *
     * @param string $file            
     * @param string $md5            
     */
    public function actionGet($file, $md5)
    {
        $filePath = AppComp::getPublicPath() . 'last' . DIRECTORY_SEPARATOR . $file;
        
        if (file_exists($filePath)) {
            if (strcasecmp(md5_file($filePath), $md5) == 0) {
                return \Yii::$app->response->sendFile($filePath);
            } else {
                $msg['title'] = 'MD5 mismatch!';
            }
        } else {
            $msg['title'] = 'File does not exist!';
        }
        
        if (! empty($msg)) {
            $msg['body'] = 'Please try again later or contact administrator.';
            
            \Yii::$app->getSession()->setFlash('download', $msg);
        }
        
        $this->redirect('index');
    }
}
