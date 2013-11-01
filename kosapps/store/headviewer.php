<?php

require_once('kosapps/common.php');

class Headviewer extends KOS_App {
	protected $iid;

	public function appName() {
		return "headviewer";
	}
	public function windowTitle() {
		return "HTTP Headers Tool";
	}
	public function jscode($target) {
		return <<<EOF
jQuery($target+' .httpheaders-urlbar').submit(function(ev){
	'get headers for "$target .httpheaders-urlbar > input" from app.'

	ev.preventDefault();
});
EOF;
	}
	public function windowContents() {
		return <<<EOF
<div><form class="httpheaders-urlbar">http://google.com/</form></div>
<div class="httpheaders-headers"></div>
EOF;
	}

	public function act($action) {
		return $action;
	}
}

?>
