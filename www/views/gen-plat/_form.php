<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GenPlat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gen-plat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gen_id')->textInput() ?>

    <?= $form->field($model, 'plat_id')->textInput() ?>

    <?= $form->field($model, 'md5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alt_plat_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
