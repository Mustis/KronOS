<?php
class Core extends CI_Model {
	public function get_menu() {
		$menu = array(
			'Desktop'	=> '#',
			'App'		=> '#',
			'Test'		=> '#',
			'GitHub'	=> 'https://github.com/mustis/WebOsProject'
		);
		print json_encode($menu);
	}
}
?>
