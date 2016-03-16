<?php
use app\commands\FilesController;
use yii\bootstrap\Html;
?>

<p>
	Vendor files may be required by
<?php
echo Html::a('D-BF', [
    '/download/index',
    'type' => FilesController::TYPE_CLIENT
], [
    'title' => 'List client downloads'
]);
?>
	client.
	They are compressed as 7zip archive. After download they should be extracted into vendor directory of D-BF client (dbf-data/vendor/).
	<br> These files are mostly crackers for CPU or GPU processors. <br>
	CPU cracking is enabled by default in the D-BF client. If you need to
	enable GPU cracking, you should activate the proper platform in the
	D-BF config file (dbf-data/config/dbf.json). The current supporting
	GPUs are AMD and Nvidia for both Linux and Windows operating system. <br>
	As noted in 
<?php
echo Html::a('http://hashcat.net/oclhashcat', 'http://hashcat.net/oclhashcat');
?>
	GPU driver requirement is:
	<br> Nvidia users require ForceWare 346.59 or later <br> AMD users
	require Catalyst 15.7 or later
</p>