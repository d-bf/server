<style type="text/css">
.markov-mode-label {
	font-weight: normal;
}
</style>

<?php
use kartik\touchspin\TouchSpin;
?>

<div class="col-sm-12">
	<label>Markov Mode: </label>
	&nbsp;
	<label class="markov-mode-label">
		<input type="radio" value="0" name="markov-mode" checked="checked"> Pre-Position
	</label>
	&nbsp;
	<label class="markov-mode-label">
		<input type="radio" value="1" name="markov-mode"> Classic
	</label>
</div>

<div class="col-sm-3">
<?php
echo TouchSpin::widget([
    'name' => 'markov-threshold',
    'pluginOptions' => [
        'prefix' => 'Threshold',
        'verticalbuttons' => true,
        'min' => 1,
        'max' => 95
    ]
]);
?>
</div>
<div class="help-block col-sm-9">
Maximum number of chars to use
</div>