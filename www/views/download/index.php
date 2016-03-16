<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\commands\FilesController;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DownloadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Downloads');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="download-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [
            [
                'attribute' => 'name',
                'group' => true
            ],
            [
                'attribute' => 'os',
                'filter' => FilesController::$os,
                'group' => true
            ],
            [
                'attribute' => 'arch',
                'filter' => FilesController::$arch
            ],
            [
                'attribute' => 'processor',
                'filter' => FilesController::$processor
            ],
            'brand',
            'size:shortsize',
            'md5',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>

</div>
