<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* TODO: error handling */

class Control extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user');
		$this->load->model('msession');
	}

	public function index() {
	}

	public function open($aid) {
		if ($this->user->is_logged_in()) {
			$instance = $this->msession->openApp($aid);

			$repl = array('id' => $instance->iid(), 'name' => $instance->appName(), 'title' => $instance->windowTitle(), 'interior' => $instance->windowContents());
			$this->json->reply($repl);
		} else {
			$this->json->error('Not logged in.');
		}
	}

	public function act($iid, $action) {
//		return $this->msession->getAppInst($iid)->act($action);
	}

	public function close($iid) {
		$this->msession->closeApp($iid);
	}
}
?>
