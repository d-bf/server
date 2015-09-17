<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gen_id')->textInput() ?>

    <?= $form->field($model, 'algo_id')->textInput() ?>

    <?= $form->field($model, 'len_min')->textInput() ?>

    <?= $form->field($model, 'len_max')->textInput() ?>

    <?= $form->field($model, 'charset_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'charset_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'charset_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'charset_4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mask')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
