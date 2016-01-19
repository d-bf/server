<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CrackSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crack-search">

<?php
$form = ActiveForm::begin([
    'action' => [
        'index'
    ],
    'method' => 'get'
]);
?>

    <?= $form->field($model, 'id')?>

    <?= $form->field($model, 'gen_id')?>

    <?= $form->field($model, 'algo_id')?>

    <?= $form->field($model, 'len_min')?>

    <?= $form->field($model, 'len_max')?>

    <?php // echo $form->field($model, 'charset_1') ?>

    <?php // echo $form->field($model, 'charset_2') ?>

    <?php // echo $form->field($model, 'charset_3') ?>

    <?php // echo $form->field($model, 'charset_4') ?>

    <?php // echo $form->field($model, 'mask') ?>

    <?php // echo $form->field($model, 'target') ?>

    <?php // echo $form->field($model, 'result') ?>

    <?php // echo $form->field($model, 'key_total') ?>

    <?php // echo $form->field($model, 'key_assigned') ?>

    <?php // echo $form->field($model, 'key_finished') ?>

    <?php // echo $form->field($model, 'key_error') ?>

    <?php // echo $form->field($model, 'res_assigned') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'ts_assign') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
