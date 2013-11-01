<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* TODO: error handling */
/* TODO: check that requesting user == app-session user */

class Control extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user');
		$this->load->model('msession');
	}

	public function index() {
	}

	public function open($aid, $core=NULL) {
		if ($this->user->is_logged_in()) {
			if ($aid == -1) {
				// core app!
				$instance = $this->msession->openCoreApp($core);
				$repl = array('id' => $instance->iid(), 'name' => $instance->appName(), 'title' => $instance->windowTitle(), 'interior' => $instance->windowContents());
				$this->json->reply($repl);
			} else {
				$instance = $this->msession->openApp($aid);
				$repl = array('id' => $instance->iid(), 'name' => $instance->appName(), 'title' => $instance->windowTitle(), 'interior' => $instance->windowContents());
				$this->json->reply($repl);
			}
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
