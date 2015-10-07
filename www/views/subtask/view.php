<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Subtask */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Subtasks'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subtask-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id, 'crack_id' => $model->crack_id], ['class' => 'btn btn-primary'])?>
        <?=Html::a(Yii::t('app', 'Delete'), ['delete','id' => $model->id,'crack_id' => $model->crack_id], ['class' => 'btn btn-danger','data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),'method' => 'post']])?>
    </p>

    <?php
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'crack_id',
            'start',
            'offset',
            'status'
        ]
    ])?>

</div>