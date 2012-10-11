jQuery.noConflict();
jQuery(document).ready(function () {
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
});
