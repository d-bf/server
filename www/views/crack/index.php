<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CrackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cracks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crack-index">

	<h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Crack'), ['create'], ['class' => 'btn btn-success'])?>
    </p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            'id',
            'gen_id',
            'algo_id',
            'len_min',
            'len_max',
            // 'charset_1',
            // 'charset_2',
            // 'charset_3',
            // 'charset_4',
            // 'mask',
            // 'key_total',
            // 'key_assigned',
            // 'key_finished',
            // 'key_error',
            [
                'class' => 'yii\grid\ActionColumn'
            ]
        ]
    ]);
    ?>

</div>