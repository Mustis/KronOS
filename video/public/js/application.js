$(document).ready(function () {
	$.getJSON("/backend/get_menu", function(data) {
		var menuitems = []
		$.each(data, function(key, val) {
			menuitems.push('<li><a href="' + val + '">' + key + '</li>');
		});
		$('<ul/>', {
			'class': 'nav',
			html: menuitems.join('')
		}).appendTo('.menudiv');
	});
});
