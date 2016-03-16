<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DownloadSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="download-search">

    <?php
    
    $form = ActiveForm::begin([
        'action' => [
            'index'
        ],
        'method' => 'get'
    ]);
    ?>

    <?= $form->field($model, 'sort')?>

    <?= $form->field($model, 'file_type')?>

    <?= $form->field($model, 'name')?>

    <?= $form->field($model, 'os')?>

    <?= $form->field($model, 'arch')?>

    <?php // echo $form->field($model, 'processor') ?>

    <?php // echo $form->field($model, 'brand') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'md5') ?>

    <?php // echo $form->field($model, 'path') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
