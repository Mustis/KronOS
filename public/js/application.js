var state
var wos

(function( $ ) {
	$.fn.pageConstruct = function( initvar ) {

		this.buildPage = function() {
			document.cookie = "session_id=0;expires=0";
			this.loadMenu();
			this.loadContainer();
		}

		this.loadDefaults = function() {
			var self = this;
//			$.getJSON("/backend/logged_in", function(resp) {
//				if (!resp.contents) {
					self.hideMenu();
					self.hideBackground();
					self.setUsername('<em>unauthenticated</em>');
					self.loadLogin();
//				} else {
//					self.loadUsername();
//					self.loadBackground();
//				}
//			});
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
			$('.container-fluid').append('<a class="brand" href="#">KronOS</a>');
			$('.container-fluid').append('<div class="menuitems"></div>');
			$('.container-fluid').append('<p class="navbar-text pull-right">Logged in as <a href="#" class="navbar-link" id="username"><em>unauthenticated</em></a> &bull; <span style="font-family:monospace;"><span id="clock"></span></span></p>');
			$('#clock').jclock({
				format: '%H:%M',
			});
		};

		this.loadContainer = function() {
			$('body').append('<div id="desktop" class="container-fluid"></div>');
			$('desktop').append('<div class="row"></div>');
		};

		this.loadMenuItems = function() {
			$.getJSON("/backend/get_menu", function(resp) {
				if (resp.success) {
					navStr = '<ul class="nav">';
					$.each(resp.contents, function(key, val) {
						openStr = '<li class="dropdown"><a tabindex="-1" class="dropdown-toggle" data-toggle="dropdown" href="#">'+key+' <b class="caret"></b></a><ul class="dropdown-menu">';
						innerStr = '';
						closeStr = '</ul></li>';
						$.each(val, function(ikey, ival) {
							if (typeof ival == "object") {
								innerStr += '<li class="dropdown-submenu"><a tabindex="-1" href="#">'+ikey+'</a><ul class="dropdown-menu">';
								$.each(ival, function(iikey, iival) {
									innerStr += '<li><a tabindex="-1" href=\''+iival+'\'>'+iikey+'</a></li>';
								});
								innerStr += '</ul></li>';
							} else {
								innerStr += '<li><a tabindex="-1" href=\''+ival+'\'>'+ikey+'</a></li>';
							}
						});
						navStr += openStr+innerStr+closeStr;
					});
					navStr += '</ul>';
					$('.menuitems').html(navStr);
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

		this.setUsername = function(name) {
			$("#username").html(name);
		}

		this.submitLogin = function() {
			loginData = {
				'username': $('#inputUsername').val(),
				'password': $('#inputPassword').val()
			};
			self = this;
			$.post('/account/login', loginData, function(resp) {
				if (resp.success) {
					document.cookie = "session_id="+resp.data.sid+";expires=0";
					self.setUsername(resp.data.name);
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
			document.cookie = "session_id=0;expires=0";
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
