<?php
include('config.php');

function make_reply($data, $errcode=NULL) {
	if ($errcode === NULL) {
		$resp = array(
			'success' => TRUE,
			'time' => time(),
			'contents' => $data,
		);
		echo json_encode($resp);
	} else {
		$resp = array(
			'success' => FALSE,
			'time' => time(),
			'error' => array(
				'code' => $errcode,
				'reason' => $data,
			),
		);
		echo json_encode($resp);
	}
	exit(0);
}
