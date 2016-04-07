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
	D-BF config file (dbf-data/config/dbf.json). After activating a
	platform, the client will look for corresponding vendor file on each
	start and will download it form server if it doesn't exist. But it is
	strongly recommended that you download large vendor files yourself and
	extract it into vendor directory of D-BF client (dbf-data/vendor/). <br>The
	client also performs benchmark of active platforms on each start and
	stores the results in the config file. If the benchmark result is
	greater than 0, it means the activated platform works correctly on your
	system. <br> The current supporting GPUs are AMD and Nvidia for both
	Linux and Windows operating system. <br>
	As noted in 
<?php
echo Html::a('http://hashcat.net/oclhashcat', 'http://hashcat.net/oclhashcat');
?>
	GPU driver requirement is:
	<br> Nvidia users require ForceWare 346.59 or later <br> AMD users
	require Catalyst 15.7 or later
</p>