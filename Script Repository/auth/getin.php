<?php
require $_SERVER['DOCUMENT_ROOT'] . '/scripts/auth/auth_verify.php';
$pages[] = '/target.php';		// target page
$pages[] = '/master.php';		// error/return page

wb_check_login($pages);
?>