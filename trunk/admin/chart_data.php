<?php

  $report = isset($_GET['report']) ? $_GET['report'] : null;
  $report_type = isset($_GET['report_type']) ? $_GET['report_type'] : null;

  require('includes/application_top.php');

				switch ($report_type) {

// Количество заказов по статусам

					case 'orders' :

  require(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/'.FILENAME_STATS_SALES_REPORT2);

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  // default view (daily)
  $sales_report_default_view = 2;
  // report views (1: hourly 2: daily 3: weekly 4: monthly 5: yearly)
  $sales_report_view = $sales_report_default_view;
  if ( ($_GET['report']) && (vam_not_null($_GET['report'])) ) {
    $sales_report_view = $_GET['report'];
  }
  if ($sales_report_view > 5) {
    $sales_report_view = $sales_report_default_view;
  }

  if ($sales_report_view == 2) {
    $report = 2;
  }

    $report_desc = REPORT_TYPE_MONTHLY;

  require(DIR_WS_CLASSES . 'sales_report2.php');
  $report = new sales_report(4, $startDate, $endDate, $sales_report_filter);

// use the chart class to build the chart:
include_once(DIR_WS_CLASSES . 'ofc-library/open-flash-chart.php');

$data_count = array();
$data_sum = array();
for ($i = 0; $i < $report->size; $i++) { 

$data_count[] = $report->info[$i]['count'];
$data_sum[] = number_format($report->info[$i]['sum'],0,'','');
									
}

$data_date = array();
for ($i = 0; $i < $report->size; $i++) { 

$data_date[] = $report->info[$i]['text'];
									
}

$g = new graph();
$g->bg_colour = '0xFFFFFF';
$g->x_grid_colour = '0xd8d8d8';
$g->y_grid_colour = '0xd8d8d8';

$g->title( HEADING_TITLE . ': ' . $report_desc, '{font-size: 18px;}' );

$g->set_data( $data_sum );
$g->bar( 60, '#ff9900', TEXT_TOTAL_SUMM, 12 );

$g->set_data( $data_count );
$g->line_hollow( 3, 4, '#0077cc', TEXT_NUMBER_OF_ORDERS, 12 );

$g->attach_to_y_right_axis(2);

$g->set_x_labels( $data_date );
$g->set_x_label_style( 10, '0x000000', 0, 2 );
$g->set_y_max( (max($data_sum) / 10) + max($data_sum) );
$g->set_y_right_max( (max($data_count) / 10) + max($data_count) );
$g->y_label_steps( 4 );
echo $g->render();

						break;

// /Количество заказов по статусам

// Статистика заказов по периодам

					default :

  require(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/'.FILENAME_STATS_SALES_REPORT2);

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  // default view (daily)
  $sales_report_default_view = 2;
  // report views (1: hourly 2: daily 3: weekly 4: monthly 5: yearly)
  $sales_report_view = $sales_report_default_view;
  if ( ($_GET['report']) && (vam_not_null($_GET['report'])) ) {
    $sales_report_view = $_GET['report'];
  }
  if ($sales_report_view > 5) {
    $sales_report_view = $sales_report_default_view;
  }

  if ($sales_report_view == 2) {
    $report = 2;
  }

  if ($report == 1) {
    $report_desc = REPORT_TYPE_HOURLY;
  } else if ($report == 2) {
    $report_desc = REPORT_TYPE_DAILY;
  } else if ($report == 3) {
    $report_desc = REPORT_TYPE_WEEKLY;
  } else if ($report == 4) {
    $report_desc = REPORT_TYPE_MONTHLY;
  } else if ($report == 5) {
    $report_desc = REPORT_TYPE_YEARLY;
  }

  // check start and end Date
  $startDate = "";
  if ( ($_GET['startDate']) && (vam_not_null($_GET['startDate'])) ) {
    $startDate = $_GET['startDate'];
  }
  $endDate = "";
  if ( ($_GET['endDate']) && (vam_not_null($_GET['endDate'])) ) {
    $endDate = $_GET['endDate'];
  }

  // check filters
  if (($_GET['filter']) && (vam_not_null($_GET['filter']))) {
    $sales_report_filter = $_GET['filter'];
    $sales_report_filter_link = "&filter=$sales_report_filter";
  }

  require(DIR_WS_CLASSES . 'sales_report2.php');
  $report = new sales_report($sales_report_view, $startDate, $endDate, $sales_report_filter);

  if (strlen($sales_report_filter) == 0) {
    $sales_report_filter = $report->filter;
    $sales_report_filter_link = "";
  }

$data_count = array();
$data_avg = array();
$data_sum = array();
for ($i = 0; $i < $report->size; $i++) { 

$data_count[] = $report->info[$i]['count'];
//$data_avg[] = $report->info[$i]['avg'];
$data_sum[] = number_format($report->info[$i]['sum'],0,'','');
									
}

$data_date = array();
for ($i = 0; $i < $report->size; $i++) { 

$data_date[] = $report->info[$i]['text'];
									
}

// use the chart class to build the chart:
include_once(DIR_WS_CLASSES . 'ofc-library/open-flash-chart.php');
$g = new graph();
$g->bg_colour = '0xFFFFFF';
$g->x_grid_colour = '0xd8d8d8';
$g->y_grid_colour = '0xd8d8d8';

$g->title( HEADING_TITLE . ': ' . $report_desc, '{font-size: 18px;}' );

$g->set_data( $data_count );
$g->line_hollow( 3, 4, '0x0077cc', TEXT_NUMBER_OF_ORDERS, 12 );

$g->set_data( $data_sum );
$g->line_dot( 3, 4, '0xff9900', TEXT_TOTAL_SUMM, 12 );

//
// Attach the second data line (Free Ram) to the right axis:
//
$g->attach_to_y_right_axis(2);
//

// label each point with its value
$g->set_x_labels( $data_date );
$g->set_x_label_style( 10, '0x000000', 0, 2 );

// set the Y max
$g->set_y_max( (max($data_count) / 10) + max($data_count) );
$g->set_y_right_max( (max($data_sum) / 10) + max($data_sum) );
// label every 20 (0,20,40,60)
$g->y_label_steps( 4 );

// display the data
echo $g->render();

						break;

// /Статистика заказов по периодам

}

?>