<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cracker */

$this->title = Yii::t('app', 'Create Cracker');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Crackers'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cracker-create">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render('_form', ['model' => $model])?>

</div>
