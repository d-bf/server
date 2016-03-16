<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use app\commands\FilesController;
use kartik\growl\Growl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DownloadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Download') . ' ' . $file_type;
$this->params['breadcrumbs'][] = 'Download';
$this->params['breadcrumbs'][] = $file_type;
?>

<?php
$msg = Yii::$app->getSession()->getFlash('download');
if (! empty($msg)) {
    echo Growl::widget([
        'type' => Growl::TYPE_DANGER,
        'title' => (isset($msg['title']) ? $msg['title'] : 'Error'),
        'icon' => 'glyphicon glyphicon-ok-sign',
        'body' => (isset($msg['body']) ? $msg['body'] : 'Unknown!'),
        'showSeparator' => true,
        'delay' => 0,
        'pluginOptions' => [
            'delay' => 5000,
            'showProgressbar' => false,
            'placement' => [
                'from' => 'top',
                'align' => 'center'
            ]
        ]
    ]);
}
?>

<div class="download-index">

	<h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?php
$infoFile = 'info_' . strtolower($file_type);
if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $infoFile . '.php')) {
    echo $this->render($infoFile);
}
?>

	<br>

    <?php
    echo GridView::widget([
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
                'template' => '{download}',
                'buttons' => [
                    'download' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', [
                            'get',
                            'file' => $model->path,
                            'md5' => $model->md5
                        ], [
                            'title' => Yii::t('yii', 'Download'),
                            'aria-label' => Yii::t('yii', 'Download'),
                            'data-pjax' => '0'
                        ]);
                    }
                ]
            ]
        ]
    ]);
    ?>

</div>
