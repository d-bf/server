<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Generator */

$this->title = Yii::t('app', 'Create Generator');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Generators'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="generator-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
