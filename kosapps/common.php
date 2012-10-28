<?php

abstract class KOS_App {
	function __construct($iid) {
		$this->iid = $iid;
	}
	public function iid() {
		return $this->iid;
	}

	abstract public function appName();
	abstract public function windowTitle();
	abstract public function windowContents();

	public function opening() { return; }
	public function closing() { return; }

	abstract public function act($action);
}

?>
