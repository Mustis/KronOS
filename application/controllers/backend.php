<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('user');
	}

	public function index() {
	}

	public function logged_in() {
		$this->json->reply($this->user->is_logged_in());
	}

	public function login_modal() {
		print $this->core->get_login();
	}

	public function get_menu() {
		$this->json->reply($this->core->get_menu());
	}
}
?>
