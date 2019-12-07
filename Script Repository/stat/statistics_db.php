<?php
# Note regarding ports/sockets:
# How the connection is made to the Database is determined by the host parameter.
# eg: 'localhost'			('localhost')  assumes port 3306
# eg: 'localhost:port'		('localhost:3306')
# eg: 'localhost:socket'	(':/var/run/mysqld/mysqld.sock')

function wb_statistics_open() {
	$mysql_host = 'localhost';
	$mysql_user = 'your user';
	$mysql_password = 'your password';
	$mysql_database = 'your database';
	$mysql_page_table = 'www_site_stat';
	$mysql_ua_table = 'useragents';
	$db_error_string = 'WB Page Statistics DB Error ';

	$db = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);

	if (!$db) {
                error_log ($db_error_string ."Open: ". mysqli_connect_error());
		exit;
	}
	if (!mysqli_set_charset($db, "utf8")) {
		error_log ($db_error_string . mysqli_error($db));
		exit;
	}

	$return[] = $db;
	$return[] = $mysql_page_table;
	$return[] = $mysql_ua_table;
	$return[] = $db_error_string;

	return $return;
}
?>
