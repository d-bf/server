<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Download */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Downloads'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="download-view">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=DetailView::widget(['model' => $model,'attributes' => ['file_type','name','os','arch','processor','brand','size:shortsize','md5']])?>

</div>
