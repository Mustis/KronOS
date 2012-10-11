<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

	var $logged_in = False;

	public function __construct() {
		# Required
        parent::__construct();
	}

	public function check_login() {
		if (!$this->logged_in)
			redirect('account/login/');
	}
}
