<?php
require $_SERVER['DOCUMENT_ROOT'] . '/scripts/auth/auth_logout.php';
$returnPage = '/master.php';		// return page

wb_logout_user($returnPage);
?>