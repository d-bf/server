<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Algorithm;
use yii\helpers\ArrayHelper;
use app\models\Generator;
use kartik\touchspin\TouchSpin;
use app\assets\crack\FormAsset;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Crack */
/* @var $form yii\widgets\ActiveForm */

FormAsset::register($this);
?>

<style type="text/css">
.inline-buttons button {
	margin-top: 5px;
}

.mask-input-group {
	margin: 4px;
}

.mask-input {
	width: 3em !important;
	padding: 6px 0px;
	text-align: center;
}
</style>

<div class="crack-form">

	<?php
$form = ActiveForm::begin([
    'id' => 'crack-create-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'offset' => 'col-sm-offset-2',
            'label' => 'col-sm-2',
            'wrapper' => 'col-sm-8',
            'error' => '',
            'hint' => 'col-sm-2'
        ]
    ],
    'options' => [
        'enctype' => 'multipart/form-data',
        'data-toggle' => 'validator'
    ]
]);
?>

<?php
if (empty($model->gen_id))
    $model->gen_id = 0;

echo $form->field($model, 'gen_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Generator::find()->orderBy([
        'name' => SORT_ASC
    ])
        ->all(), 'id', 'name'),
    'options' => [
        'placeholder' => 'Select...'
    ]
]);
?>

		<?php
echo $form->field($model, 'algo_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Algorithm::find()->orderBy([
        'name' => SORT_ASC
    ])
        ->all(), 'id', 'name'),
    'options' => [
        'placeholder' => 'Select...'
    ]
]);
?>

		<?php echo $form->field($model, 'target')->textarea(['maxlength' => true])->hint('One hash per line'); ?>

		<hr>

	<fieldset>

		<legend style="font-size: medium;">
					<?php
    if (empty($model->mode))
        $model->mode = 0;
    
    echo $form->field($model, 'mode', [
        'horizontalCssClasses' => [
            'label' => 'col-sm-1'
        ]
    ])->widget(SwitchInput::classname(), [
        'pluginOptions' => [
            'offText' => 'Simple',
            'onText' => '&nbsp;Mask&nbsp;'
        ]
    ]); // Add space to match it's length to offText to be displayed correctly!
    
    ?>
			</legend>

			<?php echo Html::activeHiddenInput($model, 'mask', ['id' => 'crack-mask']); ?>

			<div class="mode-1">
				<?php echo $form->field($model, 'charset_1')->textInput(['id'=>'crack-charset_1']); ?>

				<?php echo $form->field($model, 'charset_2')->textInput(['id'=>'crack-charset_2']); ?>

				<?php echo $form->field($model, 'charset_3')->textInput(['id'=>'crack-charset_3']); ?>

				<?php echo $form->field($model, 'charset_4')->textInput(['id'=>'crack-charset_4']); ?>
			</div>

		<div class="mode-0">
<?php
$templateCharset = '{label}<div class="col-sm-8">{input}{hint}<div class="inline-buttons">';
$templateCharset .= Html::button('Lower Case', [
    'id' => 'charset_l',
    'class' => 'btn btn-primary'
]) . "&nbsp";
$templateCharset .= Html::button('Upper Case', [
    'id' => 'charset_u',
    'class' => 'btn btn-primary'
]) . "&nbsp";
$templateCharset .= Html::button('Digits', [
    'id' => 'charset_d',
    'class' => 'btn btn-primary'
]) . "&nbsp";
$templateCharset .= Html::button('Special Chars', [
    'id' => 'charset_s',
    'class' => 'btn btn-primary'
]) . "&nbsp";
$templateCharset .= Html::button('All', [
    'id' => 'charset_a',
    'class' => 'btn btn-primary'
]) . "&nbsp";
$templateCharset .= Html::button('Clear', [
    'id' => 'charset_clear',
    'class' => 'btn btn-primary'
]) . "&nbsp";
$templateCharset .= '</div>{error}</div>';

echo $form->field($model, 'charset', [
    'template' => $templateCharset
])->textInput([
    'id' => 'crack-charset'
]);
?>
			</div>

		<div class="form-group form-inline">
			<label class="control-label col-sm-2">Length</label>
			<div class="col-sm-4">
					<?php echo $form->field($model, 'len_min', ['selectors' => ['input' => '#crack-len_min'],'horizontalCssClasses' => ['wrapper' => 'col-sm-6','error' => '','hint' => 'col-sm-2']])->textInput(['id' => 'crack-len_min'])->label(false)->widget(TouchSpin::className(), ['pluginOptions' => ['prefix' => $model->getAttributeLabel('len_min'),'verticalbuttons' => true,'min' => 1,'max' => $model->_LEN_MAX]]); ?>
				</div>
			<div class="col-sm-4">
					<?php echo $form->field($model, 'len_max', ['selectors' => ['input' => '#crack-len_max'],'horizontalCssClasses' => ['wrapper' => 'col-sm-6','error' => '','hint' => 'col-sm-2']])->textInput(['id' => 'crack-len_max'])->label(false)->widget(TouchSpin::className(), ['pluginOptions' => ['prefix' => $model->getAttributeLabel('len_max'),'verticalbuttons' => true,'min' => 1,'max' => $model->_LEN_MAX]]); ?>
				</div>
		</div>

		<div class="mode-1">
			<div class="form-group form-inline">
				<label class="control-label col-sm-2">Mask</label>
				<div id="crack-maskchars" class="col-sm-10">
						<?php
    for ($char = 1; $char <= $model->_LEN_MAX; $char ++) :
        
        /* Start popover content */
        ob_start();
        ?>
						<div class="crack-mask-btn-group text-center">
						<div class="btn-group" role="group">
							<button id="mask_l" class="btn btn-default"
								data-mask-id="field-crack-maskchar-<?= $char ?>"
								title="Lower Case">l</button>
							<button id="mask_u" class="btn btn-default"
								data-mask-id="field-crack-maskchar-<?= $char ?>"
								title="Upper Case">u</button>
							<button id="mask_d" class="btn btn-default"
								data-mask-id="field-crack-maskchar-<?= $char ?>" title="Digits">d</button>
							<button id="mask_s" class="btn btn-default"
								data-mask-id="field-crack-maskchar-<?= $char ?>"
								title="Special Chars">s</button>
							<button id="mask_a" class="btn btn-default"
								data-mask-id="field-crack-maskchar-<?= $char ?>"
								title="All Chars">a</button>
						</div>
						<div class="btn-group" role="group">
							<button id="mask_1" class="btn btn-default"
								data-mask-id="field-crack-maskchar-<?= $char ?>"
								title="Custom Charset 1">1</button>
							<button id="mask_2" class="btn btn-default"
								data-mask-id="field-crack-maskchar-<?= $char ?>"
								title="Custom Charset 2">2</button>
							<button id="mask_3" class="btn btn-default"
								data-mask-id="field-crack-maskchar-<?= $char ?>"
								title="Custom Charset 3">3</button>
							<button id="mask_4" class="btn btn-default"
								data-mask-id="field-crack-maskchar-<?= $char ?>"
								title="Custom Charset 4">4</button>
						</div>
					</div>
						<?php
        /* Get popover content */
        $popoverContent = ob_get_clean();
        
        // Render mask field
        echo $form->field($model, "maskChar[$char]", [
            'options' => [
                'id' => "field-crack-maskchar-$char",
                'class' => "input-group mask-input-group"
            ],
            'template' => '<span class="input-group-addon">' . sprintf('%02d', $char) . '</span>{input}'
        ])->textInput([
            'id' => "crack-maskchar-$char",
            'class' => 'form-control mask-input',
            'maxlength' => '1',
            'data-toggle' => 'popover',
            'data-container' => 'body',
            'data-content' => $popoverContent,
            'data-html' => 'true',
            'data-placement' => 'top',
            'data-trigger' => 'focus'
        ]);
    endfor
    ;
    
    echo $form->field($model, 'maskCharError', [
        'options' => [
            'class' => 'col-sm-12 form-group field-crack-maskcharerror required'
        ],
        'template' => '{input}{error}'
    ])->textInput([
        'id' => 'crack-maskcharerror',
        'style' => 'display: none'
    ]);
    ?>
					</div>
				<div class="col-sm-10 col-sm-offset-2 help-block help-block-error">
					<div>
						<b>Mask help:</b>
					</div>
					<div>Each mask char can be a signle character or any of the
						following:</div>
					<div>?l : Lower case = abcdefghijklmnopqrstuvwxyz</div>
					<div>?u : Upper case = ABCDEFGHIJKLMNOPQRSTUVWXYZ</div>
					<div>?d : Digits = 0123456789</div>
					<div>?s : Special chars = ! "#$%&amp;'()*+,-./:;&lt;=>?@[\]^_`{|}~</div>
					<div>?a : All chars = ?l?u?d?s</div>
					<div>?1 : Custom Charset 1</div>
					<div>?2 : Custom Charset 2</div>
					<div>?3 : Custom Charset 3</div>
					<div>?4 : Custom Charset 4</div>
				</div>
			</div>
		</div>

	</fieldset>

	<div class="form-group">
			<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>