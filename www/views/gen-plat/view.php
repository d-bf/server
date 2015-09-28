<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GenPlat */

$this->title = $model->gen_id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Gen Plats'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gen-plat-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'gen_id' => $model->gen_id, 'plat_id' => $model->plat_id], ['class' => 'btn btn-primary'])?>
        <?=Html::a(Yii::t('app', 'Delete'), ['delete','gen_id' => $model->gen_id,'plat_id' => $model->plat_id], ['class' => 'btn btn-danger','data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),'method' => 'post']])?>
    </p>

    <?=DetailView::widget(['model' => $model,'attributes' => ['gen_id','plat_id','md5','alt_plat_id']])?>

</div>
