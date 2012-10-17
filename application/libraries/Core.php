<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core {
	public function get_menu() {
		$menu = array(
			'Desktop'	=> '#',
			'App'		=> '#',
			'Logout'	=> 'javascript:wos.logout();void(0);',
			'GitHub'	=> 'https://github.com/mustis/WebOsProject'
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
							<input type="text" id="inputUsername" placeholder="Username">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputPassword">Password</label>
						<div class="controls">
							<input type="password" id="inputPassword" placeholder="Password">
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<label class="checkbox">
								<input type="checkbox"> Remember me
							</label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Login</button>
				</div>
			</form>
		</div>';
		return $login_modal;
	}
}
?>
