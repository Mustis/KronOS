<?php
define('WEBOS', TRUE);
require_once('common.php');

if (empty($_GET['app'])) {
	make_error('No app specified to display.');
}
if ($_GET['app'] == 'core') {
	if (empty($_GET['part']))
		make_error('No part of core specified to display.');

	if (strpos($_GET['part'], '/') !== FALSE) // there WAS a '/' in it
		make_error('No such part of core.');

	$fn = 'pages/'.$_GET['part'].'.html';
	if (!is_file($fn)) // file doesn't exist or is not 'regular file'
		make_error('No such part of core.');

	$data = file_get_contents($fn);
	make_reply($data);
} else { // $_GET['app'] != 'core'
	make_error('Not implemented.');
}
