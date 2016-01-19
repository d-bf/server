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
        <?= Html::a(Yii::t('app', 'New Crack'), ['create'], [
            'class' => 'btn btn-success',
            'title' => 'Create a new crack'
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'emptyText' => 'No cracks found.',
        'columns' => [
            'id',
            // 'gen_id',
            'algo_id',
            // 'len_min',
            // 'len_max',
            // 'charset_1',
            // 'charset_2',
            // 'charset_3',
            // 'charset_4',
            // 'mask',
            // 'target',
            'key_total',
            'key_assigned',
            // 'key_finished',
            // 'key_error',
            // 'res_assigned',
            // 'status',
            // 'ts_assign',
        	'result',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
