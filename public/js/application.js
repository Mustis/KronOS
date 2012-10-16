var state

function loadDefaults() {
	jQuery.getJSON("/backend/logged_in", function(resp) {
		if (!resp.contents) {
			loadLoginModal();
		} else {
			loadUsername();
			loadMenu();
			loadBackground();
		}
	});
}

function loadBackground() {
	background = '<style>body { background-image:url(\'/public/img/default-background.jpg\'); background-position: center top; } </style>'
	jQuery('body').append(background);
}

function loadLoginModal() {
	jQuery.ajax({
		url: "/backend/login_modal",
		success: function (data) {
			jQuery('body').append(data);
			jQuery('#loginModal').modal({
				backdrop: 'static',
				keyboard: false,
			});
			jQuery('#loginModal').modal('show');
		},
		dataType: 'html'
	});

}

function loadUsername() {
	jQuery("#username").html(state.name);
}

function loadMenu() {
	jQuery.getJSON("/backend/get_menu", function(resp) {
		if (resp.success) {
			var menuitems = []
			jQuery.each(resp.contents, function(key, val) {
				menuitems.push('<li><a href="' + val + '">' + key + '</li>');
			});
			jQuery('<ul/>', {
				'class': 'nav',
				html: menuitems.join('')
			}).appendTo('.menudiv');
		} else {
			throwError(resp.error, 'error', '#desktop');
		}
	});

}

function submitLogin() {
	loginData = {
		'username': jQuery('#inputUsername').val(),
		'password': jQuery('#inputPassword').val()
	};
	jQuery.post('/account/login', loginData, function(resp) {
		if (resp.success) {
			for (key in resp.data) {
				state[key] = resp.data[key]
			}
			jQuery('#loginModal').modal('hide');
			loadUsername();
			loadMenu();
			loadBackground();
		} else {
			throwError(resp.error, 'error', '.messagebody');
		}
	}, "json");
}

function throwError(e, t, c) {
	var n = jQuery(".alert").length;
	if (n>2) {
		jQuery(".alert").first().remove();
	}

	error = '<div class="alert alert-block alert-' + t + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + e + '</div>'
	jQuery(c).append(error);
}

function logout() {
	state = {}
	loadDefaults();
}

jQuery(function () {
	state = {}

	jQuery.noConflict();
	loadDefaults();
});
