<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cracker */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Crackers'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cracker-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])?>
        <?=Html::a(Yii::t('app', 'Delete'), ['delete','id' => $model->id], ['class' => 'btn btn-danger','data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),'method' => 'post']])?>
    </p>

    <?php
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'gen_type'
        ]
    ])?>

</div>
