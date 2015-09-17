<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CrackerAlgo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cracker-algo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cracker_id')->textInput() ?>

    <?= $form->field($model, 'algo_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
