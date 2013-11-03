<?php

abstract class KOS_App {
	function __construct($iid, $aid) {
		$this->iid = $iid;
		$this->aid = $aid;
	}
	public function iid() { return $this->iid; }
	public function aid() { return $this->aid; }

	abstract public function appName();
	abstract public function windowTitle();
	abstract public function windowContents();

	public function opening() { return; } // default
	public function closing() { return; } // default

	public static function scripts($aid) { return 'wos.appscripts['.$aid.'] = {load: function(t){this.target = t}};'; } // default
	public function act($action) { return $action; } // default, but will only work for static ("content") apps.
}

?>
