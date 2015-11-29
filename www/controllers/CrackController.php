<?php

namespace app\controllers;

use Yii;
use app\models\Crack;
use app\models\CrackSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CrackController implements the CRUD actions for Crack model.
 */
class CrackController extends Controller
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
     * Lists all Crack models.
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CrackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Crack model.
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
     * Creates a new Crack model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Crack();
        
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
                $model->charset_2 = '';
                $model->charset_3 = '';
                $model->charset_4 = '';
                
                $model->mask = str_repeat('?1', $model->len_max);
                $model->key_total = 0;
                for ($len = $model->len_min; $len <= $model->len_max; $len++)
                    $model->key_total += pow(strlen($model->charset_1), $len);
            }
            $model->save();
            
            $query = 'SELECT DISTINCT p.name FROM {{%gen_plat}} gp JOIN {{%cracker_plat}} cp ON (gp.gen_id = :genId AND cp.plat_id = gp.plat_id) JOIN {{%cracker_algo}} ca ON (ca.algo_id = :algoId AND cp.cracker_id = ca.cracker_id) JOIN {{%platform}} p ON p.id = cp.plat_id UNION ';
            $query .= 'SELECT DISTINCT p.name FROM {{%cracker_algo}} ca JOIN {{%cracker_gen}} cg ON (ca.algo_id = :algoId AND cg.gen_id = :genId AND cg.cracker_id = ca.cracker_id) JOIN {{%cracker_plat}} cp ON cp.cracker_id = cg.cracker_id JOIN {{%platform}} p ON p.id = cp.plat_id';
            $platforms = \Yii::$app->db->createCommand($query, [
                ':genId' => $model->gen_id,
                ':algoId' => $model->algo_id
            ])->queryColumn();
            
            $i = 0;
            $values = '';
            $params[':c'] = $model->id;
            foreach ($platforms as $platform) {
                $values .= ",(:c, :p$i)";
                $params[":p$i"] =  $platform;
                $i++;
            }
            $values = substr($values, 1);
            \Yii::$app->db->createCommand("INSERT INTO {{%crack_plat}} (crack_id, plat_name) VALUES $values", $params)->execute();
            
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
     * Updates an existing Crack model.
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
     * Deletes an existing Crack model.
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
     * Finds the Crack model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param string $id
     * @return Crack the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Crack::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
