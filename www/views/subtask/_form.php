<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Subtask */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subtask-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'task_id')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'start')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'offset')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'status')->textInput()?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
