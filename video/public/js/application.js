jQuery.noConflict();

jQuery(document).ready(function () {
	jQuery.getJSON("/backend/logged_in", function(data) {
		if (!data) {
			jQuery.ajax({
				url: "/backend/login_modal",
				success: function (data) { jQuery('body').append(data); },
				dataType: 'html'
			}).done(function() {
				jQuery('#loginModal').modal({
					backdrop: 'static',
					keyboard: false
				});
				jQuery('#loginModal').modal('show');
			});
		} else {
			jQuery.getJSON("/backend/get_menu", function(data) {
				var menuitems = []
				jQuery.each(data, function(key, val) {
					menuitems.push('<li><a href="' + val + '">' + key + '</li>');
				});
				jQuery('<ul/>', {
					'class': 'nav',
					html: menuitems.join('')
				}).appendTo('.menudiv');
			});
		}
	});
});
