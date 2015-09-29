<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CrackerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Crackers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cracker-index">

	<h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Cracker'), ['create'], ['class' => 'btn btn-success'])?>
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
            'name',
            'gen_type',
            [
                'class' => 'yii\grid\ActionColumn'
            ]
        ]
    ]);
    ?>

</div>
