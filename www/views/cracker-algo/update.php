<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CrackerAlgo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cracker Algo',
]) . ' ' . $model->cracker_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cracker Algos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cracker_id, 'url' => ['view', 'cracker_id' => $model->cracker_id, 'algo_id' => $model->algo_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cracker-algo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
