<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GenPlat */

$this->title = Yii::t('app', 'Create Gen Plat');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Gen Plats'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gen-plat-create">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render('_form', ['model' => $model])?>

</div>
