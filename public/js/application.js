(function( $ ) {
	$.fn.pageConstruct = function() {

		this.buildPage = function() {
			document.cookie = "session_id=0;expires=0";
			this.loadMenu();
			this.loadContainer();
		}

		this.loadDefaults = function() {
			var self = this;
//			$.getJSON("backend/logged_in", function(resp) {
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
			$('.navbar').append('<div class="navbar-inner"><div id="menu" class="container-fluid"></div></div>');
			$('#menu').append('<a class="brand dropdown-toggle" href="#" tabindex="-1" data-toggle="dropdown">KronOS <b class="caret"></b></a><ul id="coreapps" class="dropdown-menu"></ul>');
			$('#menu').append('<div class="menuitems"></div>');
			$('#menu').append('<p class="navbar-text pull-right">Logged in as <a href="#" class="navbar-link" id="username"><em>unauthenticated</em></a> &bull; <span style="font-family:monospace;"><span id="clock"></span></span></p>');
			$('#clock').jclock({
				format: '%H:%M',
			});

			$('#coreapps').append('<li><a tabindex="-1" href="javascript:wos.openCoreApp(\'credits\');void(0);">Credits</a></li>');
		};

		this.loadContainer = function() {
			$('body').append('<div id="desktop" class="container-fluid"></div>');
			$('desktop').append('<div class="row"></div>');
		};

		this.loadMenuItems = function() {
			$.getJSON("backend/get_menu", function(resp) {
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
				url: "backend/login_modal",
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
			$.post('account/login', loginData, function(resp) {
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

		this.credits = function() {
			$('body').append('<div id="credits" class="modal hide fade"></div>');
			
			$('#credits').append('<div class="modal-header">');
			$('#credits').append('<div class="modal-body">');
			$('#credits').append('<div class="modal-footer">');

			$('').append('');
			$('#credits>.modal-header').append('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
			$('#credits>.modal-header').append('<h3 id="creditsLabel">About KronOS</h3>');

			$('#credits>.modal-body').append('<h4>Committers</h4>');
			$('#credits>.modal-body').append('<ul><li>BiohZn</li><li>DimeCadmium</li><li>Oscar</li><li>hyster</li><li>DarkDeviL</li></ul>');

			$('#credits>.modal-footer').append('<button class="btn" aria-hidden="true" onClick="wos.hideCredits();">Close</button>');

			$('#credits').modal({
				backdrop: false
			});
			$('#credits').modal('show');
		}

		this.hideCredits = function() {
			$('#credits').modal('hide');
			$('#credits').remove();
		}

		this.logout = function() {
			document.cookie = "session_id=0;expires=0";
			this.loadDefaults();
		}

		this.openApp = function(appid) {
			$.getJSON("control/open/"+appid, function(resp) {
				if (resp.success) {
					var repl = resp.contents
					var target = 'div#'+repl.name+repl.id;

					wos.apps[repl.id] = {aid: appid, instance: repl.id, title: repl.title, target: target};

					$.getScript('control/scripts/'+appid, function() {
						wos.appscripts[appid].load(target);
					});

					$('body').append('<div id="'+repl.name+repl.id+'" class="app modal hide fade"></div>');

					$(target).append('<div class="modal-header"></div>');
					$(target).append('<div class="modal-body"></div>');
					$(target).append('<div class="modal-footer"></div>');

					$(target+'>.modal-header').append('<button type="button" class="close" aria-hidden="true" data-dismiss="modal" onClick="wos.closeApp(\'#'+repl.name+repl.id+'\');void(0);">&times;</button>');
					$(target+'>.modal-header').append('<h3 class="appLabel">'+repl.title+'</h3>');

					$(target+'>.modal-body').append(repl.interior);

					$(target).modal({ backdrop: false });
					$(target).modal('show');
				} else {
					throwError(resp.error, 'error', '#desktop');
				}
			});
		}

		this.openCoreApp = function(appname) {
			this.openApp("-1/"+appname);
		}

		this.closeApp = function(target) {
			$(target).modal('hide');
			$(target).remove();
		}

		this.apps = {};
		this.appscripts = {}

		return this;
	};
})( jQuery );

$(function () {
	wos = $('document.body').pageConstruct();

	wos.buildPage();
	wos.loadDefaults();
});
