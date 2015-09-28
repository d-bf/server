<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CrackerAlgo */

$this->title = Yii::t('app', 'Create Cracker Algo');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Cracker Algos'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cracker-algo-create">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render('_form', ['model' => $model])?>

</div>
