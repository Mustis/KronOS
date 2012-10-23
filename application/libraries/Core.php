<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core {
	protected $CI;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('user');
	}

	public function get_menu() {
		/*$menu = array(
			'Desktop'	=> '#',
			'App'		=> '#',
			'Logout'	=> 'javascript:wos.logout();void(0);',
			'GitHub'	=> 'https://github.com/mustis/KronOS'
		);*/
		$menu = array(
			'Apps'		=> array(),
			'System'	=> array(),
		);

		$ulev = $this->CI->user->level();
		if ($ulev == 'operator') $chklevel = "a.access = 'user' OR a.access = 'operator'";
		elseif ($ulev == 'manager') $chklevel = "1"; // full access -> always true
		else $chklevel = "a.access = 'user'"; // fallback

		$sql = 'SELECT c.catname AS category, a.appname AS appname, a.aid AS appid FROM categories AS c, apps AS a WHERE c.cid = a.parent AND ('.$chklevel.')';
		$q = $this->CI->db->query($sql);
		foreach ($q->result() as $row) {
			$menu['Apps'][$row->category][$row->appname] = 'javascript:wos.openApp('.$row->appid.');void(0);';
		}

		ksort($menu['Apps']);
		foreach ($menu['Apps'] as $key => &$cat) {
			if (is_array($cat)) {
				ksort($cat);
			}
		}

		$menu['System'] = array(
			'About KronOS'  => 'javascript:wos.openCoreApp("credits");void(0);',
			'Preferences'   => 'javascript:wos.openCoreApp("account");void(0);',
			'Logout'        => 'javascript:wos.logout();void(0);',
		);

		return $menu;
	}
	public function get_login() {
		$login_modal = '
		<div id="loginModal" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<h3 id="myModalLabel">Login</h3>
			</div>
			<form class="form-horizontal" method="post" action="javascript:wos.submitLogin();void(0);">
				<div class="modal-body">
					<div class="messagebody">
					</div>
					<div class="control-group">
						<label class="control-label" for="inputUsername">Username</label>
						<div class="controls">
							<input type="text" id="inputUsername" placeholder="Username" tabindex="1">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputPassword">Password</label>
						<div class="controls">
							<input type="password" id="inputPassword" placeholder="Password" tabindex="2">
						</div>
					</div>
<!--
					<div class="control-group">
						<div class="controls">
							<label class="checkbox">
								<input type="checkbox"> Remember me
							</label>
						</div>
					</div>
-->
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" tabindex="3">Login</button>
				</div>
			</form>
		</div>';
		return $login_modal;
	}
}
?>
