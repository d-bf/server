<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags()?>
    <title>
<?php
if (empty($this->title))
    echo 'Distributed Brute-Force';
else
    echo 'D-BF: ' . Html::encode($this->title);
?>
    </title>
    <?php $this->head()?>
    <style type="text/css">
        .navbar-brand {
            padding-bottom: 10px;
            padding-top: 10px;
            text-align: center;
        }
        .brand-version {
            display: block;
            font-size: 14px;
            line-height: 15px;
        }
    </style>
</head>
<body>
<?php $this->beginBody()?>

<div class="wrap">
<?php
NavBar::begin([
    'brandLabel' => 'Distributed Brute-Force<span class="brand-version">ver: alpha</span>',
    'brandUrl' => null,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top'
    ]
]);
echo Nav::widget([
    'options' => [
        'class' => 'navbar-nav'
    ],
    'items' => [
        [
            'label' => 'Home',
            'url' => [
                '/site/index'
            ]
        ],
        [
            'label' => 'Cracks',
            'url' => [
                '/crack/index'
            ],
            'options' => [
                'title' => 'List of cracks'
            ]
        ],
        [
            'label' => 'New Crack',
            'url' => [
                '/crack/create'
            ],
            'options' => [
                'title' => 'Create a new crack'
            ]
        ]
    ]
]);
// [
// 'label' => 'About',
// 'url' => [
// '/site/about'
// ]
// ],
// [
// 'label' => 'Contact',
// 'url' => [
// '/site/contact'
// ]
// ],
// Yii::$app->user->isGuest ? [
// 'label' => 'Login',
// 'url' => [
// '/site/login'
// ]
// ] : [
// 'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
// 'url' => [
// '/site/logout'
// ],
// 'linkOptions' => [
// 'data-method' => 'post'
// ]
// ]

NavBar::end();
?>

    <div class="container">
        <?=Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []])?>
        <?= $content?>
    </div>
	</div>

	<footer class="footer">
		<div class="container">
			<p class="pull-left">&copy; D-BF Project <?= date('Y') ?></p>

			<p class="pull-right"><?= Yii::powered() ?></p>
		</div>
	</footer>

<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
