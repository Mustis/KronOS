<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Mustis WebOS</title>
		<meta name="description" content="">
		<meta name="author" content="">

		<link href="/public/css/bootstrap.min.css" rel="stylesheet">
		<!--<link rel="stylesheet/less" type="text/css" href="/public/less/bootstrap.less">-->
		<script src="/public/js/jquery.min.js"></script>

		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<script type="text/javascript">
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
		</script>

	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="brand" href="#">WebOS Dev</a>
					<div class="nav-collapse collapse menudiv">
						<p class="navbar-text pull-right">
							Logged in as <a href="#" class="navbar-link">Username</a>
						</p>
					</div>
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row">

			</div>
		</div>

		<script src="/public/js/bootstrap.min.js"></script>
		<script src="/public/js/less-1.3.0.min.js"></script>
	</body>
</html>
