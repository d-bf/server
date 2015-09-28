<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CrackerGen */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cracker Gen'
]) . ' ' . $model->cracker_id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Cracker Gens'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->cracker_id,
    'url' => [
        'view',
        'cracker_id' => $model->cracker_id,
        'gen_id' => $model->gen_id
    ]
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cracker-gen-update">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render('_form', ['model' => $model])?>

</div>
