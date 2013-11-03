<?php

/*
DOCS:
	<script>wos.applib.loadscripts(<?php echo $this->aid() ?>);</script>
can be used to trigger load JS from: public function scripts()

scripts should return valid javascript code including at least:
	wos.apps[<?php echo $this->aid() ?>].load = function(target){ appName.ctr = target; }
or etc. Don't include script tags, it's loaded a la <script src="...">
*/

require_once('kosapps/common.php');

class User_Manager extends KOS_App {
	protected $iid;

	public function appName() {
		return "usermanager";
	}
	public function windowTitle() {
		return "User Manager";
	}
	public function windowContents() {
		return <<<EOF
<em>User Manager!</em>
EOF;
	}

}

?>
