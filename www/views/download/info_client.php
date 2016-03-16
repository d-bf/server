<?php
use app\commands\FilesController;
use yii\bootstrap\Html;
?>

<p>
	D-BF is the main executable client.<br>
	After execution, the client will download the required files (vendor files) from server.
	You can also download the vendor files separately and place it in the correct location,
	for more information click 
<?php
echo Html::a('here', [
    '/download/index',
    'type' => FilesController::TYPE_VENDOR
], [
    'title' => 'List vendor downloads'
]);
?>.
	<br> <b>It is strongly recommended that you download large vendor files separately from the 
<?php
echo Html::a('server', [
    '/download/index',
    'type' => FilesController::TYPE_VENDOR
], [
    'title' => 'List vendor downloads'
]);
?>.
	</b> <br> <br> The files are compressed as 7zip archive, they should be
	decompress after download.
</p>