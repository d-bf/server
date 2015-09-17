<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GenPlat */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Gen Plat',
]) . ' ' . $model->gen_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gen Plats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gen_id, 'url' => ['view', 'gen_id' => $model->gen_id, 'plat_id' => $model->plat_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="gen-plat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
