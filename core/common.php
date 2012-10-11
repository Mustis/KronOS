<?php
if (!defined('WEBOS')) exit('Invalid access.');

require_once('../config.php');

function make_reply($contents, $data=NULL) {
	$resp = array(
		'success' => TRUE,
		'time' => time(),
		'contents' => $contents,
		'data' => $data,
	);
	echo json_encode($resp);
	exit(0);
}
function make_error($reason, $errcode) {
	$resp = array(
		'success' => FALSE,
		'time' => time(),
		'error' => array(
			'code' => $errcode,
			'reason' => $reason,
		),
	);
	echo json_encode($resp);
	exit(0);
}
