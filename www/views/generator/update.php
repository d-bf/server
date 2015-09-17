<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Generator */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Generator',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Generators'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="generator-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
