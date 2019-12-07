<?php
function wb_statistics_update($pagename='') {
	if (!wb_IsSearchBot()) {
		require $_SERVER['DOCUMENT_ROOT'] . '/scripts/stat/statistics_db.php';

		$return = wb_statistics_open();
		$db = $return[0];
		$mysql_page_table = $return[1];
		$mysql_ua_table = $return[2];
		$db_error_string = $return[3] . 'Write ';
		$sql_page_name = mysqli_real_escape_string($db, $pagename);
		$sql_remote_addr = mysqli_real_escape_string($db, $_SERVER['REMOTE_ADDR']);
		$sql_user_agent_string = mysqli_real_escape_string($db, $_SERVER['HTTP_USER_AGENT']);
		$sql_user_agent_hash = sha1($_SERVER['HTTP_USER_AGENT']);
		$sql_time = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);

		# write tp page table
		$sql = "INSERT INTO $mysql_page_table (id, date, page, ip_address, user_agent_hash) VALUES (NULL, '$sql_time', '$sql_page_name', '$sql_remote_addr', '$sql_user_agent_hash');";
		if (!mysqli_query($db, $sql)) {
			error_log ($db_error_string . 'Page: ' . mysqli_error($db));
		}
		# update user_agents table
		$sql = "INSERT IGNORE INTO $mysql_ua_table (id, user_agent_hash, user_agent_string) VALUES (NULL, '$sql_user_agent_hash', '$sql_user_agent_string')";
		if (!mysqli_query($db, $sql)) {
			error_log ($db_error_string . 'UserAgent: ' . mysqli_error($db));
		}
		mysqli_close($db);
	}
}

function wb_IsSearchBot() {
	$agents = array('bot',
					'crawler',
					'fetcher',
					'indexer',
					'search',
					'slurp',
					'spider',
					'ia_archiver',
					'sogou');
	$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	foreach ($agents as $agent) {
		if (strpos($agent, $user_agent) !== false) {
			return true;
		}
	}
	return false;
}
?>
