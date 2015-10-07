<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Crack */

$this->title = Yii::t('app', 'New Crack');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Cracks'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crack-create">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render('_form', ['model' => $model])?>

</div>
