<?php
function wb_check_login($pages = []) {
	require $_SERVER['DOCUMENT_ROOT'] . '/scripts/auth/auth_users.php';
	
	$targetPage = isset($pages[0]) ? $pages[0] : '/';
	$errorPage = isset($pages[1]) ? $pages[1] : '/';

	$allowedLoginUsers = wb_get_local_users();

	$user[] = isset($_POST['username']) ? $_POST['username'] : '';
	$pwd[] = isset($_POST['password']) ? $_POST['password'] : '';

	$httpData = array_combine($user, $pwd);

	$match = array_intersect_assoc($allowedLoginUsers, $httpData);
	if (empty($match)) {
#		header('Status: 401', TRUE, 401);
		header('Location:' . $errorPage);
		exit;
	} else {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
			$_SESSION['wb_username'] = $_POST['username'];
			$_SESSION['wb_errorpage'] = $errorPage;
			header('Location:' . $targetPage);
		}
	}
}
?>