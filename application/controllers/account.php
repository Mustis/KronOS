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

		# Login stuff
		$user = $this->input->post('username');
		$pass = $this->input->post('password');

		if ($user == FALSE || $pass == FALSE) {
			$this->json->error('Username or password was empty');
			return;
		}

		if ($this->user->try_login($user, $pass)) {
			$data = array(
				'uid' => $this->user->uid(),
				'sid' => $this->user->sid(),
				'name' => $this->user->display_name(),
			);
			$this->json->reply('Logged in', $data);
		} else {
			$this->json->error('Incorrect credentials');
		}
	}
}
