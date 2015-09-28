<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CrackerPlatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cracker-plat-search">

    <?php
    
    $form = ActiveForm::begin([
        'action' => [
            'index'
        ],
        'method' => 'get'
    ]);
    ?>

    <?= $form->field($model, 'cracker_id')?>

    <?= $form->field($model, 'plat_id')?>

    <?= $form->field($model, 'md5')?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
