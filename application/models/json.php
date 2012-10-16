<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json extends CI_Model {

	public function __construct() {
		# Required
		parent::__construct();
	}

	public function index() {
	}

	public function success($contents, $data=NULL) {
		$resp = array(
			'success' => TRUE,
			'time' => time(),
			'contents' => $contents,
			'data' => $data,
		);
		return json_encode($resp);
	}

	public function error($reason) {
		$resp = array(
			'success' => False,
			'time' => time(),
			'error' => array(
				'reason' => $reason,
			),
		);
		return json_encode($resp);
	}
}
