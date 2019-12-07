<?php
# Example for phpgraphlib pie-chart

	require __DIR__.'/phpgraphlib/phpgraphlib.php';
	require __DIR__.'/phpgraphlib/phpgraphlib_pie.php';
	$graph = new PHPGraphLibPie($width, $height);
    $graph->setTtfFont(__DIR__.'/phpgraphlib/arial.ttf');
    $graph->setFontSize(10);
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
?>