<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct() {
		# Required
	        parent::__construct();
		$this->load->model('user');
	}

	public function index(){
	}

	public function login() {
		if ($this->user->logged_in)
			redirect('account/');

		# Login stuff
		if (count($this->input->post()) == 2) {
			$user = $this->input->post('username');
			$pass = $this->input->post('password');

			if ($user == 'test' && $pass == 'test') {
				$this->user->logged_in = True;
				$response = array(
					'loggedIn' => True,
				);
				print json_encode($response);
			}
		}
	}
}
