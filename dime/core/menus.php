<?php
define('WEBOS', TRUE);
require_once('common.php');

if ($_GET['m'] == 'app') {
	$data = //...
<<<EOF
<li><a href="#">Accessories</a><ul>
	<li id="edit"><a href="#">Text Editor</a></li>
</ul></li>
<li><a href="#">Internet</a><ul>
	<li id="web"><a href="#">Web Browser</a></li>
	<li id="irc"><a href="#">IRC Client</a></li>
</ul></li>
EOF;
	make_reply($data);
} elseif ($_GET['m'] == 'system') {
	$data = //...
<<<EOF
<li id="about"><a href="#">About WebOS</a></li>
<li id="logout"><a href="#">End Session</a></li>
EOF;
	make_reply($data);
} else {
	make_error('No such menu.');
}
