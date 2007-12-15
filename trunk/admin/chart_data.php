<?php

  $report = $_GET['report'];

  require('includes/application_top.php');

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
    $summary1 = AVERAGE_HOURLY_TOTAL;
    $summary2 = TODAY_TO_DATE;
    $report_desc = REPORT_TYPE_HOURLY;
  } else if ($report == 2) {
    $summary1 = AVERAGE_DAILY_TOTAL;
    $summary2 = WEEK_TO_DATE;
    $report_desc = REPORT_TYPE_DAILY;
  } else if ($report == 3) {
    $summary1 = AVERAGE_WEEKLY_TOTAL;
    $summary2 = MONTH_TO_DATE;
    $report_desc = REPORT_TYPE_WEEKLY;
  } else if ($report == 4) {
    $summary1 = AVERAGE_MONTHLY_TOTAL;
    $summary2 = YEAR_TO_DATE;
    $report_desc = REPORT_TYPE_MONTHLY;
  } else if ($report == 5) {
    $summary1 = AVERAGE_YEARLY_TOTAL;
    $summary2 = YEARLY_TOTAL;
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

// generate some random data:

srand((double)microtime()*1000000);

$data = array();
for ($i = 0; $i < $report->size; $i++) { 

$data[] = $report->info[$i]['count'];
									
}

$data_date = array();
for ($i = 0; $i < $report->size; $i++) { 

$data_date[] = $report->info[$i]['text'];
									
}

// use the chart class to build the chart:
include_once(DIR_WS_CLASSES . 'ofc-library/open-flash-chart.php');
$g = new graph();

// Spoon sales, March 2007
$g->title( $report_desc . TEXT_STATS_SALES, '{font-size: 26px;}' );

$g->set_data( $data );
$g->line_hollow( 2, 4, '0x80a033', TEXT_NUMBER_OF_ORDERS, 10 );

// label each point with its value
$g->set_x_labels( $data_date );

// set the Y max
$g->set_y_max( (max($data) / 10) + max($data) );
// label every 20 (0,20,40,60)
$g->y_label_steps( 6 );

// display the data
echo $g->render();

?>