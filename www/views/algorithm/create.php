<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Algorithm */

$this->title = Yii::t('app', 'Create Algorithm');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Algorithms'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="algorithm-create">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render('_form', ['model' => $model])?>

</div>
