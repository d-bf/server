<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CrackerGen */

$this->title = Yii::t('app', 'Create Cracker Gen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cracker Gens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cracker-gen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
