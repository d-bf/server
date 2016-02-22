$(function() {
	var chars_l = 'abcdefghijklmnopqrstuvwxyz';
	var chars_u = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var chars_d = '0123456789';
	var chars_s = ' !"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~';
	var chars_a = chars_l + chars_u + chars_d + chars_s;
	
	/* Show/hide generator's config */
	$('#crack-gen_id').on('select2:select', function() {
		var genId = $(this).val();
		if ($('#gen_config_' + genId).length) { // Has config, so show it
			if ($('#gen_config').is( ":hidden" )) { // No current config
				$('#gen_config_' + genId).show(0, function() {
					$('#gen_config').show(400);
				});
			} else { // Previous config is visible
				$('.config-container').hide(400);
				$('#gen_config').show(0, function() {
					$('#gen_config_' + genId).show(400);
				});
			}
		} else { // Does not have config, so hide it
			$('#gen_config').hide(400, function() {
				$('.config-container').hide(0);
			});
		}
	});
	$('#crack-gen_id').trigger('select2:select'); // Initialize
	
	/* Change mode */
	function applyMode() {
		if ($('#crack-mode').is(':checked')) { // Mask
			$('.mode-0').hide();
			$('.mode-1').show();
			applyMaskChars();
		} else { // Simple
			$('.mode-1').hide();
			$('.mode-0').show();
		}
	}
	
	applyMode();
	
	$('#crack-mode').on('switchChange.bootstrapSwitch', function() {
		applyMode();
	});
	
	/* Simple mode: add chars */
	function escapeRegExp(str) {
		return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
	}
	
	function addChars(chars) {
		var charset = $('#crack-charset').val();
		for (i = 0; i < chars.length; i++)
			charset = charset.replace(RegExp(escapeRegExp(chars[i]), 'g'), '');
		
		return charset + chars;
	}
	
	$('#charset_l').on('click', function() {
		$('#crack-charset').val(addChars(chars_l));
		$('#crack-charset').focus();
	});
	
	$('#charset_u').on('click', function() {
		$('#crack-charset').val(addChars(chars_u));
		$('#crack-charset').focus();
	});
	
	$('#charset_d').on('click', function() {
		$('#crack-charset').val(addChars(chars_d));
		$('#crack-charset').focus();
	});
	
	$('#charset_s').on('click', function() {
		$('#crack-charset').val(addChars(chars_s));
		$('#crack-charset').focus();
	});
	
	$('#charset_a').on('click', function() {
		$('#crack-charset').val(addChars(chars_a));
		$('#crack-charset').focus();
	});
	
	$('#charset_clear').on('click', function() {
		$('#crack-charset').val('');
		$('#crack-charset').focus();
	});
	
	/* Mask mode: add mask */
	$('.mask-input-group input').popover();
	function applyMaskChars() {
		if ($('#crack-mode').is(":checked")) {
			max_len = $('#crack-len_max').val();
			char = $('#crack-maskchars').children('div.input-group:visible').length;
			if (char < max_len) {
				char++;
				for (char; char <= max_len; char++) {
					$('.field-crack-maskchar-' + char).show();
					$('.field-crack-maskchar-' + char + ' input').prop('disabled', false);
					if ($('#crack-create-form').yiiActiveForm('find', 'crack-maskcharerror').status > 0) // Form has been validated before
						$('#crack-create-form').yiiActiveForm('validateAttribute', 'crack-maskchar-' + char); // Validate the newly added field again
				}
			} else if (char > max_len) {
				for (char; char > max_len; char--) {
					$('.field-crack-maskchar-' + char + ' input').prop('disabled', true);
					$('.field-crack-maskchar-' + char).hide();
				}
			}
			if ($('#crack-create-form').yiiActiveForm('find', 'crack-maskcharerror').status > 0) // Form has been validated before
				$('#crack-create-form').yiiActiveForm('validateAttribute', 'crack-maskcharerror'); // Validate crack-maskcharerror
		}
	}
	
	$('#crack-len_max').on('change', function() {
		applyMaskChars();
	});
	applyMaskChars();
	
	$(document).on('focus', '.crack-mask-btn-group button', function() {
		if (this.id == 'mask_l')
			maskChar = '?l';
		else if (this.id == 'mask_u')
			maskChar = '?u';
		else if (this.id == 'mask_d')
			maskChar = '?d';
		else if (this.id == 'mask_s')
			maskChar = '?s';
		else if (this.id == 'mask_a')
			maskChar = '?a';
		else if (this.id == 'mask_1')
			maskChar = '?1';
		else if (this.id == 'mask_2')
			maskChar = '?2';
		else if (this.id == 'mask_3')
			maskChar = '?3';
		else if (this.id == 'mask_4')
			maskChar = '?4';
		
		$('#' + $(this).attr('data-mask-id') + ' input').val(maskChar).trigger('change');
		
		$('#crack-create-form').yiiActiveForm('validateAttribute', 'crack-charset_1');
		$('#crack-create-form').yiiActiveForm('validateAttribute', 'crack-charset_2');
		$('#crack-create-form').yiiActiveForm('validateAttribute', 'crack-charset_3');
		$('#crack-create-form').yiiActiveForm('validateAttribute', 'crack-charset_4');
		if ($('#crack-create-form').yiiActiveForm('find', 'crack-maskcharerror').status > 0)
			$('#crack-create-form').yiiActiveForm('validateAttribute', 'crack-maskcharerror');
	});
	
	var temp_mask_char;
	$(document).on('focus', '.mask-input', function() {
		temp_mask_char = $(this).val(); 
		$(this).val('');
	});
	$(document).on('blur', '.mask-input', function(e) {
		if ($(this).val() == '')
			$(this).val(temp_mask_char);
	});
});