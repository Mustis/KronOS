<?php
define('WEBOS', TRUE);
require_once('common.php');

if (empty($_GET['app'])) {
	make_error('No app specified to display.', -1);
}
if ($_GET['app'] == 'core') {
	if (empty($_GET['part'])) {
		make_error('No part of core specified to display.', -2);
	}
	switch ($_GET['part']) {
		case 'logo':
			make_reply('DimeTest');
		case 'login':
			$data = '<form action=\'javascript:poster("login.php", {user:$("#user").val(), pass:$("#pass").val()});void(0);\'>';
			$data .= '<label for="user">Username: </label><input id="user" name="user" type="text" /><br />';
			$data .= '<label for="pass">Password: </label><input id="pass" name="pass" type="password" /><br />';
			$data .= '<input value="Login" type="submit" />';
			$data .= '</form>';
			make_reply($data);
			break;
		default:
			make_error('No such part of core.', -3);
	}
} else { // $_GET['app'] != 'core'
	make_error('Not implemented.', 0);
}
