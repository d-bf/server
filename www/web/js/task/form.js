$(function() {
	var chars_l = 'abcdefghijklmnopqrstuvwxyz';
	var chars_u = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var chars_d = '0123456789';
	var chars_s = ' !"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~';
	var chars_a = chars_l + chars_u + chars_d + chars_s;
	
	/* Change mode */
	function applyMode() {
		if ($('#task-mode').val() == 0) { // Simple
			$('.mode-1').hide();
			$('.mode-0').show();
		} else { // Mask
			$('.mode-0').hide();
			$('.mode-1').show();
			applyMaskChars();
		}
	}
	
	applyMode();
	
	$('#task-mode').on('change', function() {
		applyMode();
	});
	
	/* Simple mode: add chars */
	function escapeRegExp(str) {
		return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
	}
	
	function addChars(chars) {
		var charset = $('#task-charset').val();
		for (i = 0; i < chars.length; i++)
			charset = charset.replace(RegExp(escapeRegExp(chars[i]), 'g'), '');
		
		return charset + chars;
	}
	
	$('#charset_l').on('click', function() {
		$('#task-charset').val(addChars(chars_l));
		$('#task-charset').focus();
	});
	
	$('#charset_u').on('click', function() {
		$('#task-charset').val(addChars(chars_u));
		$('#task-charset').focus();
	});
	
	$('#charset_d').on('click', function() {
		$('#task-charset').val(addChars(chars_d));
		$('#task-charset').focus();
	});
	
	$('#charset_s').on('click', function() {
		$('#task-charset').val(addChars(chars_s));
		$('#task-charset').focus();
	});
	
	$('#charset_a').on('click', function() {
		$('#task-charset').val(addChars(chars_a));
		$('#task-charset').focus();
	});
	
	$('#charset_clear').on('click', function() {
		$('#task-charset').val('');
		$('#task-charset').focus();
	});
	
	/* Mask mode: add mask */
	$('.mask-input-group input').popover();
	function applyMaskChars() {
		if ($('#task-mode').val() == 1) {
			max_len = $('#task-len_max').val();
			char = $('#task-maskchars').children('div.input-group:visible').length;
			if (char < max_len) {
				char++;
				for (char; char <= max_len; char++) {
					$('.field-task-maskchar-' + char).show();
					$('.field-task-maskchar-' + char + ' input').prop('disabled', false);
				}
			} else if (char > max_len) {
				for (char; char > max_len; char--) {
					$('.field-task-maskchar-' + char + ' input').prop('disabled', true);
					$('.field-task-maskchar-' + char).hide();
				}
			}
		}
	}
	
	$('#task-len_max').on('change', function() {
		applyMaskChars();
	});
	applyMaskChars();
	
	$(document).on('focus', '.task-mask-btn-group button', function() {
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
//		$('#task-create-form').yiiActiveForm('validateAttribute', 'task-maskcharerror');
		$('#task-create-form').data('yiiActiveForm').submitting = true;
		$('#task-create-form').yiiActiveForm('validate');
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