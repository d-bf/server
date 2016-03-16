<?php
use yii\web\View;
?>
<style type="text/css">
.markov-mode-label {
	font-weight: normal;
}
</style>

<?php
Yii::$app->view->registerJs(<<<eoJs
    $(function() {
        $('form').submit(function(event) {
            if ($('#crack-gen_id').select2('data')[0].text == 'markov') {
                if ($('#gen-dep').parents('.file-input').hasClass('has-error')) {
                    event.preventDefault();
                    
                    return false;
                }
                
                var config = new Array();
                
                if ($('#markov-mode').is(':checked'))
                    config.push('--markov-classic');
                
                var markovThreshold = $('#markov-threshold').val();
                if (markovThreshold && markovThreshold.length > 0)
                    config.push('--markov-threshold=' + markovThreshold);
                else
                    config.push('--markov-threshold=0');
                
                $('#crack-gen_config').val(JSON.stringify(config));
            }
            
            return true;
        });
    });
eoJs
, View::POS_READY)?>

<?php
use kartik\touchspin\TouchSpin;
use kartik\file\FileInput;
use kartik\switchinput\SwitchInput;
?>

<fieldset>
	<legend>Markov</legend>
	<div class="form-group">
		<label class="control-label col-sm-2">Mode</label>
		<div class="col-sm-10">
        	<?php
        echo SwitchInput::widget([
            'name' => 'markov-mode',
            'id' => 'markov-mode',
            'containerOptions' => [
                'class' => ''
            ],
            'pluginOptions' => [
                'offText' => 'Pre-position',
                'onText' => '&nbsp;Classic&nbsp;',
                'offColor' => 'default',
                'onColor' => 'default'
            ]
        ]);
        ?>
        </div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2">Threshold</label>
		<div class="col-sm-2">
            <?php
            echo TouchSpin::widget([
                'name' => 'markov-threshold',
                'id' => 'markov-threshold',
                'pluginOptions' => [
                    'verticalbuttons' => true,
                    'initval' => 0,
                    'min' => 0,
                    'max' => 256,
                    'boostat' => 5
                ]
            ]);
            ?>
        </div>
		<div class="col-sm-8 help-block">Maximum number of characters to
			choose, set to 0 to disable</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2">Stat File (zip)</label>
		<div class="col-sm-5">
        	<?php
        echo FileInput::widget([
            'name' => 'gen-dep',
            'id' => 'gen-dep',
            'pluginOptions' => [
                'allowedFileExtensions' => [
                    'zip'
                ],
                'msgInvalidFileExtension' => 'Not a zip file!',
                'showPreview' => false,
                'showUpload' => false,
                'removeLabel' => '',
                'browseLabel' => ''
            ]
        ]);
        ?>
        </div>
		<div class="col-sm-5 help-block">Compress as zip file, Leave empty to
			use default stat file</div>
	</div>
</fieldset>