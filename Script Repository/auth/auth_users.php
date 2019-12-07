<?php
function wb_get_local_users() {

	$usernames = array('user1','user2');
	$passwords = array('pwd1','pwd2');

	return array_combine($usernames, $passwords);
}
?>