<?php
class Backend extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('core');
	}

	public function index() {
		print "";
	}

	public function get_menu() {
		return $this->core->get_menu();
	}
}
?>
