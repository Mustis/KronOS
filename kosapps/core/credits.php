<?php

require_once('kosapps/common.php');

class Credits extends KOS_App {
	protected $iid;
	protected $aid;

	public function appName() {
		return "credits";
	}
	public function windowTitle() {
		return "About KronOS";
	}
	public function windowContents() {
		return <<<EOF
<h4>Committers</h4>
<ul>
	<li>BiohZn</li>
	<li>DimeCadmium</li>
	<li>Oscar</li>
	<li>hyster</li>
	<li>DarkDevil</li>
</ul>
EOF;
	}
}

?>
