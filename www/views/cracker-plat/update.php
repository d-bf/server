<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CrackerPlat */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cracker Plat',
]) . ' ' . $model->cracker_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cracker Plats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cracker_id, 'url' => ['view', 'cracker_id' => $model->cracker_id, 'plat_id' => $model->plat_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cracker-plat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
