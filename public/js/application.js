var state
var wos

(function( $ ) {
	$.fn.pageConstruct = function( initvar ) {

		this.buildPage = function() {
			state = {}
			this.loadMenu();
			this.loadContainer();
		}

		this.loadDefaults = function() {
			var self = this;
			$.getJSON("/backend/logged_in", function(resp) {
				if (!resp.contents) {
					self.hideMenu();
					self.hideBackground();
					self.loadLogin();
				} else {
					self.loadUsername();
					self.loadBackground();
				}
			});
		}

		this.showError = function(e, t, c) {
			var n = $(".alert").length;
			if (n>2) {
				$(".alert").first().remove();
			}
			error = '<div class="alert alert-block alert-' + t + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + e + '</div>'
			$(c).append(error);
		}

		this.loadMenu = function() {
			$('body').append('<div class="navbar navbar-inverse navbar-fixed-top"></div>');
			$('.navbar').append('<div class="navbar-inner"><div class="container-fluid"></div></div>');
			$('.container-fluid').append('<a class="brand" href="#">WebOS Dev</a>');
			$('.container-fluid').append('<div class="nav-collapse collapse menudiv"></div>');
			$('.menudiv').append('<div class="menuitems"></div>');
			$('.menudiv').append('<p class="navbar-text pull-right">Logged in as <a href="#" class="navbar-link" id="username"><em>unauthenticated</em></a></p>');
		};

		this.loadContainer = function() {
			$('body').append('<div id="desktop" class="container-fluid"></div>');
			$('desktop').append('<div class="row"></div>');
		};

		this.loadMenuItems = function() {
			$.getJSON("/backend/get_menu", function(resp) {
				if (resp.success) {
					var menuitems = []
					$.each(resp.contents, function(key, val) {
						menuitems.push('<li><a href="' + val + '">' + key + '</li>');
					});
					$('<ul/>', {
						'class': 'nav',
						html: menuitems.join('')
					}).appendTo('.menuitems');
				} else {
					throwError(resp.error, 'error', '#desktop');
				}
			});
		};

		this.hideMenu = function() {
			$('.menuitems').empty();
		}

		this.loadLogin = function() {
			$.ajax({
				url: "/backend/login_modal",
				success: function (data) {
					$('body').append(data);
					$('#loginModal').modal({
						backdrop: 'static',
						keyboard: false,
					});
					$('#loginModal').modal('show');
				},
				dataType: 'html'
			});
		}

		this.loadBackground = function() {
			background = '<style>body { background-image:url(\'/public/img/default-background.jpg\'); background-position: center top; } </style>'
			$('body').append(background);
		};

		this.hideBackground = function() {
			$('style').remove();
		}

		this.loadUsername = function() {
			$("#username").html(state.name);
		}

		this.submitLogin = function() {
			loginData = {
				'username': $('#inputUsername').val(),
				'password': $('#inputPassword').val()
			};
			self = this;
			$.post('/account/login', loginData, function(resp) {
				if (resp.success) {
					for (key in resp.data) {
						state[key] = resp.data[key]
					}
					self.loadUsername();
					self.loadMenuItems();
					self.loadBackground();

					$('#loginModal').modal('hide');
					$('#inputUsername').val("")
					$(".alert").remove();
				} else {
					self.showError(resp.error, 'error', '.messagebody');
				}

				$('#inputPassword').val("")
			}, "json");
		}

		this.logout = function() {
			state = {}
			this.loadDefaults();
		}

 		return this;
	};
})( jQuery );

$(function () {
	wos = $('document.body').pageConstruct();

	wos.buildPage();
	wos.loadDefaults();
});
