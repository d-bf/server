<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Download */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Downloads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="download-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'file_type' => $model->file_type, 'name' => $model->name, 'os' => $model->os, 'arch' => $model->arch, 'processor' => $model->processor, 'brand' => $model->brand], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'file_type' => $model->file_type, 'name' => $model->name, 'os' => $model->os, 'arch' => $model->arch, 'processor' => $model->processor, 'brand' => $model->brand], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sort',
            'file_type',
            'name',
            'os',
            'arch',
            'size',
            'md5',
            'processor',
            'brand',
        ],
    ]) ?>

</div>
