<?php
class Core extends CI_Model {
	public function get_menu() {
		$menu = array(
			'Desktop'	=> '#',
			'App'		=> '#',
			'Test'		=> '#',
			'GitHub'	=> 'https://github.com/mustis/WebOsProject'
		);
		return $menu;
	}
	public function get_login() {
		$login_modal = '
		<div id="loginModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<h3 id="myModalLabel">Login</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" action="javascript:submitLogin();void(0);">
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
				</form>
			</div>
			<div class="modal-footer">
				<button onClick="submitLogin()" class="btn btn-primary">Login</button>
			</div>
		</div>';
		return $login_modal;
	}
}
?>
