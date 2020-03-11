<?php
function wb_validate_login($userID) {
	require $_SERVER['DOCUMENT_ROOT'] . '/scripts/auth/auth_users.php';

	$allowedLoginUsers = array_keys(wb_get_local_users());
	session_start();

	$errorPage = isset($_SESSION['wb_errorpage']) ? $_SESSION['wb_errorpage'] : '/';

	if(isset($_SESSION['wb_username']) && 
		($_SESSION['wb_username'] == $allowedLoginUsers[$userID])) {
		return true;
	}

#	header('Status: 404', TRUE, 404);
	header('Location:' . $errorPage);
	exit;
}
?>