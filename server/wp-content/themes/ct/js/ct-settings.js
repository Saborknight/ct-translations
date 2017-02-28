jQuery(document).ready(function($) {
	if($('.settings_page_ct_settings_page')) {
		// Shift the number field up to it's neighbouring country_code field
		$('input.company_number').each( function() {
			var ungratefulParent = $( this ).parent().parent();
			var item = $( this ).prop('id');

			item = item.replace('company_phone_', '');
			item = item.replace('_number', '');

			console.log(item, 'moving!');
			$('#company_phone_' + item + '_country_code').after($( this ));

			console.log('Trying to remove', ungratefulParent);
			ungratefulParent.hide();
		});
	}
});
