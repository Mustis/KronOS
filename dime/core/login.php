<?php
define('WEBOS', TRUE);
require_once('common.php');

if (empty($_POST['user']) || empty($_POST['pass'])) {
	make_error('Username or password empty.');
}
$sth = $db->prepare('SELECT uid, displayname FROM users WHERE username = ? AND password = ?');
$sth->bind_param('ss', $_POST['user'], sha1(PWSALT.$_POST['pass']));
$sth->execute();
$sth->bind_result($uid, $dispname);
if (!$sth->fetch()) { // no row returned
	make_error('Username or password incorrect.');
}

// row returned, user/pw good
$sth->close();
$sth = $db->prepare('INSERT INTO sessions(sid, uid, started, last, active) VALUES (NULL, ?, NOW(), NOW(), 1)');
$sth->bind_param('i', $uid);
$sth->execute();
$sid = $sth->insert_id;


$data = <<<EOF
<script>
$(document).ready(function () {
	$("div#body").html("");
	poster("display.php?app=core&part=desktop", {});
});
</script>
EOF;
make_reply($data, array('uid' => $uid, 'sid' => $sid, 'name' => $dispname));
