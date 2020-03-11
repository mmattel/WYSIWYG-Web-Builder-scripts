<?php
require $_SERVER['DOCUMENT_ROOT'] . '/scripts/auth/auth_verify.php';
$pages[] = '/' . basename($_SERVER['HTTP_REFERER']);	// referrer page
$pages[] = '/scripts/stat/statistics.php';				// target page
$pages[] = '/index.php';								// error/return page

wb_check_login($pages);
?>
