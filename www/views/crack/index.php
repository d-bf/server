<?php
use yii\bootstrap\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CrackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cracks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crack-index">

	<h1>List of cracks</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=Html::a(Yii::t('app', 'New Crack'), ['create'], ['class' => 'btn btn-success','title' => 'Create a new crack'])?>
    </p>

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'No crack found.',
    'columns' => [
        'id',
        'description',
        // 'gen_id',
        'algoName',
        [
            'attribute' => 'result',
            'format' => 'html',
            'value' => function ($model) {
                return Html::tag('span', nl2br(htmlentities($model->result)), [
                    'style' => 'white-space: nowrap;'
                ]);
            }
        ],
        [
            'attribute' => 'status',
            'filter' => $searchModel->getStatusMap(),
            'value' => function ($model) {
                return $model->getStatusMap($model->status);
            }
        ],
        // 'len_min',
        // 'len_max',
        // 'charset_1',
        // 'charset_2',
        // 'charset_3',
        // 'charset_4',
        // 'mask',
        // 'target:ntext',
        'key_total',
        'key_assigned',
        // 'key_finished',
        // 'key_error',
        // 'res_assigned',
        // 'ts_create',
        [
            'attribute' => 'ts_last_connect',
            'filter' => false,
            'format' => [
                'datetime',
                'php:Y-m-d H:i:s'
            ]
        ],
        
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {delete}'
        ]
    ]
]);
?>

</div>
