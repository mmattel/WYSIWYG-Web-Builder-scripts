<?php
function wb_check_login($pages = []) {
	require $_SERVER['DOCUMENT_ROOT'] . '/scripts/auth/auth_users.php';
	
	$refererPage = isset($pages[0]) ? $pages[0] : '/';
	$targetPage = isset($pages[1]) ? $pages[1] : '/';
	$errorPage = isset($pages[2]) ? $pages[2] : '/';

	$allowedLoginUsers = wb_get_local_users();

	$user[] = isset($_POST['username']) ? $_POST['username'] : '';
	$pwd[] = isset($_POST['password']) ? $_POST['password'] : '';

	$httpData = array_combine($user, $pwd);

	$match = array_intersect_assoc($allowedLoginUsers, $httpData);
	if (empty($match)) {
		error_log("Unsuccessful Login: $refererPage User: $user[0] Password: $pwd[0]");
#		header('Status: 401', TRUE, 401);
		header('Location:' . $errorPage);
		exit;
	} else {
		if (session_status() === PHP_SESSION_NONE) {
			error_log("Successful Login: $refererPage User: $user[0] Password: xxx");
			session_start();
			$_SESSION['wb_username'] = $_POST['username'];
			$_SESSION['wb_errorpage'] = $errorPage;
			$_SESSION['wb_piecharttype'] = isset($_POST['piecharttype']) ? $_POST['piecharttype'] : 'pieunique';
			header('Location:' . $targetPage);
		}
	}
}
?>