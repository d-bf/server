<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Crack */

$this->title = 'Crack #' . $model->id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Cracks'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crack-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
        <?=Html::a(Yii::t('app', 'Delete'), ['delete','id' => $model->id], ['class' => 'btn btn-danger','data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),'method' => 'post']])?>
    </p>

<?php
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'description',
        [
            'attribute' => 'status',
            'value' => $model->getStatusMap($model->status)
        ],
        [
            'attribute' => 'ts_create',
            'format' => [
                'datetime',
                'php:Y-m-d H:i:s'
            ]
        ],
        [
            'attribute' => 'ts_last_connect',
            'format' => [
                'datetime',
                'php:Y-m-d H:i:s'
            ]
        ],
        [
            'label' => 'Duration',
            'value' => $model->getDuration()
        ],
        'algoName',
        'target:ntext',
        'result:ntext',
        'genName',
        [
            'attribute' => 'has_dep',
            'value' => empty($model->has_dep) ? 'No' : 'Yes'
        ],
        [
            'attribute' => 'len_min',
            'label' => 'Minimum Length'
        ],
        [
            'attribute' => 'len_max',
            'label' => 'Maximum Length'
        ],
        'charset_1',
        'charset_2',
        'charset_3',
        'charset_4',
        'mask',
        'key_total',
        'key_assigned',
        'key_finished',
        'key_error'
    ]
]);
?>

</div>
