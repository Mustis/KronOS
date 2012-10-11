<?php
class Core extends CI_Model {
	public function get_menu() {
		$menu = array(
			'#1'	=> 'Desktop',
			'#2'	=> 'Apps',
			'#3'	=> 'Test'
		);
		print json_encode($menu);
	}
}
?>
