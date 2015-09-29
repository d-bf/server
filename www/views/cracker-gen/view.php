<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CrackerGen */

$this->title = $model->cracker_id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Cracker Gens'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cracker-gen-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'cracker_id' => $model->cracker_id, 'gen_id' => $model->gen_id], ['class' => 'btn btn-primary'])?>
        <?=Html::a(Yii::t('app', 'Delete'), ['delete','cracker_id' => $model->cracker_id,'gen_id' => $model->gen_id], ['class' => 'btn btn-danger','data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),'method' => 'post']])?>
    </p>

    <?php
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cracker_id',
            'gen_id'
        ]
    ])?>

</div>
