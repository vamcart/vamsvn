<?php

  $report = isset($_GET['report']) ? $_GET['report'] : null;
  $report_type = isset($_GET['report_type']) ? $_GET['report_type'] : null;

  require_once(DIR_WS_CLASSES . 'currencies.php');
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
    $tick_interval = 'hour';
  } else if ($report == 2) {
    $report_desc = REPORT_TYPE_DAILY;
    $tick_interval = 'day';
  } else if ($report == 3) {
    $report_desc = REPORT_TYPE_WEEKLY;
    $tick_interval = 'week';
  } else if ($report == 4) {
    $report_desc = REPORT_TYPE_MONTHLY;
    $tick_interval = 'month';
  } else if ($report == 5) {
    $report_desc = REPORT_TYPE_YEARLY;
    $tick_interval = 'year';
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

  require_once(DIR_WS_CLASSES . 'sales_report2.php');
  $report = new sales_report($sales_report_view, $startDate, $endDate, $sales_report_filter);

  if (strlen($sales_report_filter) == 0) {
    $sales_report_filter = $report->filter;
    $sales_report_filter_link = "";
  }

$data_count = array();
$data_avg = array();
$data_sum = array();
$data_total = array();
$data_number = array();
for ($i = 0; $i < $report->size; $i++) { 

$data_count[] = $report->info[$i]['count'];
//$data_avg[] = $report->info[$i]['avg'];
$data_sum[] = number_format($report->info[$i]['sum'],0,'','');
$data_total[] = '["'.$report->info[$i]['text']. '",'.number_format($report->info[$i]['sum'],0,'','').']';
$data_number[] = '["'.$report->info[$i]['text']. '",'.number_format($report->info[$i]['count'],0,'','').']';
}

$data_date = array();
for ($i = 0; $i < $report->size; $i++) { 

$data_date[] = $report->info[$i]['text'];
									
}

// /Статистика заказов по периодам

?>