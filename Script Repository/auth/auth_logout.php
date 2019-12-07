<?php
function wb_logout_user($returnPage = '/') {

	session_start();
	session_unset();
	session_destroy();

	header('Location:' . $returnPage);
}
?>