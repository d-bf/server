<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Download */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Download',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Downloads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'file_type' => $model->file_type, 'name' => $model->name, 'os' => $model->os, 'arch' => $model->arch, 'processor' => $model->processor, 'brand' => $model->brand]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="download-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
