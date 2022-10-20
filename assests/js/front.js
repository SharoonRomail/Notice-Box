jQuery(document).ready(function($) {
	jQuery( ".close_cross" ).click(function() {
		jQuery(this).parent(".notice_box").slideUp("slow");
	});
});