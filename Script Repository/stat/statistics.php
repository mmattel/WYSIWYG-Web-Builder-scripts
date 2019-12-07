<?php
wb_validate_login();
wb_statistics_generate();

function wb_validate_login() {
	require $_SERVER['DOCUMENT_ROOT'] . '/scripts/auth/auth_users.php';

	$allowedLoginUsers = array_keys(wb_get_local_users());
	session_start();

	$errorPage = isset($_SESSION['wb_errorpage']) ? $_SESSION['wb_errorpage'] : '/';

	if(isset($_SESSION['wb_username']) && 
		($_SESSION['wb_username'] == $allowedLoginUsers[0])) {
		return;
	}

#	header('Status: 404', TRUE, 404);
	header('Location:' . $errorPage);
	exit;
}

function wb_statistics_generate() {
	require $_SERVER['DOCUMENT_ROOT'] . '/scripts/stat/statistics_db.php';
	$return = wb_statistics_open();
	$db = $return[0];
	$mysql_page_table = $return[1];
	$db_error_string = $return[3] . "Read: ";
	$page = isset($_GET['page']) ? $_GET['page'] : '';
	$pagelist = isset($_GET['pagelist']) ? $_GET['pagelist'] : '';
	$width = isset($_GET['width']) ? $_GET['width'] : 800;
	$height = isset($_GET['height']) ? $_GET['height'] : 400;
	$days = isset($_GET['days']) ? $_GET['days'] : 0;
	$limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
	if ($page != '') {
		$page = mysqli_real_escape_string($db, $page);
		$sql_where = "WHERE (page='$page'";
		if ($days != 0 && is_numeric($days)) {
			$sql_where .= " AND date >= DATE_SUB(CURDATE(), INTERVAL $days DAY)";
		}
		$sql_where .= ")";
		$sql = "SELECT date, COUNT(*), COUNT(DISTINCT ip_address) FROM $mysql_page_table $sql_where GROUP BY date ORDER BY date";
	} else {
		$sql_where = "";
		if ($days != 0 && is_numeric($days)) {
			$sql_where .= " WHERE date >= DATE_SUB(CURDATE(), INTERVAL $days DAY)";
		}
		$sql = "SELECT page, COUNT(*) as count, COUNT(DISTINCT ip_address) FROM $mysql_page_table $sql_where GROUP BY page ORDER BY count DESC";
		if ($limit != 0 && is_numeric($limit)) {
			$sql .= " LIMIT $limit";
		}
	}

	if ($pagelist != '') {
		$sql = "SELECT DISTINCT page, COUNT(page) AS hits FROM $mysql_page_table GROUP BY page ASC";
	}

	$result = mysqli_query($db, $sql);
	if (!$result) {
		error_log ($db_error_string . mysqli_error($db));
		exit;
	}

	if ($pagelist != '') {
		while ($row = mysqli_fetch_row($result)) {
			$pagenames[] = $row;
		}
		mysqli_free_result($result);
		mysqli_close($db);
		wb_statistics_list_pagenames($pagenames);
	} else {
		$total_hits = array();
		$unique_hits = array();
		while ($row = mysqli_fetch_row($result)) {
			$total_hits[$row[0]] = $row[1];
			$unique_hits[$row[0]] = $row[2];
		}
		mysqli_free_result($result);
		mysqli_close($db);
		wb_statistics_graph($width, $height, $total_hits, $unique_hits);
	}
}

function wb_statistics_list_pagenames($pagenames = []) {
	$e = 'List of Page Names with their total hits:<br><br>';
	$e.= '<table><thead>';
	$e.= '<tr><th>Hits</th><th>Pagename</th></tr>';
	foreach($pagenames as $page) {
		$e.= '<tr>';
		$e.= '<td>'.$page[1].'</td>';
		$e.= '<td>'.$page[0].'</td>';
		$e.= '</tr>';
	}
	$e.= '</tr></table>';
	echo $e;
}

function wb_statistics_graph($width, $height, $total_hits, $unique_hits) {
	require $_SERVER['DOCUMENT_ROOT'] . '/scripts/phpgraphlib/phpgraphlib.php';
	require $_SERVER['DOCUMENT_ROOT'] . '/scripts/phpgraphlib/phpgraphlib_pie.php';
	$graph = new PHPGraphLibPie($width, $height);
	$graph->setTtfFont($_SERVER['DOCUMENT_ROOT'] . '/scripts/phpgraphlib/arial.ttf');
	$graph->setFontSize(10);
	$graph->setLogarithmic(false);
	$graph->addData($unique_hits);
	$graph->setTitle('Site Statistics');
	$graph->setDataValues(true);
	$graph->setXValuesHorizontal(true);
	$graph->setGrid(true);
	$graph->setLegend(true);
	$background_color = '#FFFFFF';
	$bar_color = '#C8C8C8';
	$grid_color = '#DCDCDC';
	$line_color = '#646464';
	$title_color = '#000000';
	$graph->setBackgroundColor($background_color);
	$graph->setLegendColor($background_color);
	$graph->setGridColor($grid_color);
	$graph->setLegendOutlineColor($grid_color);
	$graph->setLineColor($line_color);
	$graph->setXAxisTextColor($line_color);
	$graph->setYAxisTextColor($line_color);
	$graph->setDataValueColor($line_color);
	$graph->setLegendTextColor($line_color);
	$graph->setSwatchOutlineColor($line_color);
	$graph->setTitleColor($title_color);
	$graph->setBarOutlineColor($title_color);
	$graph->setDataPointColor($title_color);
	$graph->setupXAxis('', $title_color);
	$graph->setupYAxis('', $title_color);
	$graph->setGoalLineColor($title_color);
	$graph->setLabelTextColor($bar_color);
	$graph->createGraph();
}
?>
