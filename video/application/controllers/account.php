<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct() {
		# Required
        parent::__construct();
		
		$this->load->model('user');
	}

	public function index(){
		$test = array(
			"This" => "Account"
		);
		print json_encode($test);
	}
	
	public function login() {
		if ($this->user->logged_in)
			redirect('account/');
			
		echo "Login";
	}
}