<?php

require_once (DIR_FS_INC.'vam_date_short.inc.php');

// include the needed functions
if (!function_exists('vam_date_long')) {
	require_once (DIR_FS_INC.'vam_date_long.inc.php');
}

// reset var
$box = new vamTemplate;
$box_content='';
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

// /downloads

  if (!strstr($_SERVER['SCRIPT_NAME'], FILENAME_ACCOUNT_HISTORY_INFO)) {
  if (isset($_SESSION['customer_id'])) {
  	
  if (!strstr($_SERVER['SCRIPT_NAME'], FILENAME_ACCOUNT_HISTORY_INFO)) {
// Get last order id for checkout_success
    $orders_query_raw = "SELECT orders_id FROM " . TABLE_ORDERS . " WHERE customers_id = '" . $_SESSION['customer_id'] . "' ORDER BY orders_id DESC LIMIT 1";
    $orders_query = vam_db_query($orders_query_raw);
    $orders_values = vam_db_fetch_array($orders_query);
    $last_order = $orders_values['orders_id'];
  } else {
    $last_order = $_GET['order_id'];
  }

// Now get all downloadable products in that order
  $downloads_query_raw = "SELECT DATE_FORMAT(date_purchased, '%Y-%m-%d') as date_purchased_day, o.orders_status, op.products_name, opd.orders_products_download_id, opd.orders_products_filename, opd.download_count, opd.download_maxdays, opd.download_pin_code,opd.download_is_pin
                          FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " opd
                          WHERE customers_id = '" . (int)$_SESSION['customer_id'] . "'
                          AND o.orders_id = '" . (int)$last_order . "'
                          AND o.orders_status >= " . DOWNLOAD_MIN_ORDERS_STATUS . "
                          AND op.orders_id = '" . $last_order . "'
                          AND opd.orders_products_id=op.orders_products_id
                          AND (opd.orders_products_filename != '' or opd.download_is_pin='1')";
  $downloads_query = vam_db_query($downloads_query_raw);

// Don't display if there is no downloadable product
if (vam_db_num_rows($downloads_query) > 0) {
	$jj = 0;
	//<!-- list of products -->
	while ($downloads = vam_db_fetch_array($downloads_query)) {
		// MySQL 3.22 does not have INTERVAL
		list ($dt_year, $dt_month, $dt_day) = explode('-', $downloads['date_purchased_day']);
		$download_timestamp = mktime(23, 59, 59, $dt_month, $dt_day + $downloads['download_maxdays'], $dt_year);
		$download_expiry = date('Y-m-d H:i:s', $download_timestamp);

//PIN add

if ($downloads['download_is_pin']==1) { //PIN processing

	$pinstring=$downloads['download_pin_code'];
	
if ($downloads['orders_status'] < DOWNLOAD_MIN_ORDERS_STATUS) {
			$dl[$jj]['download_link'] .= '';
} else {
			$dl[$jj]['download_link'] .= $downloads['products_name'] . ': ' . $pinstring . ' ';
}
				
} else { //usual stuff


		//<!-- left box -->
		// The link will appear only if:
		// - Download remaining count is > 0, AND
		// - The file is present in the DOWNLOAD directory, AND EITHER
		// - No expiry date is enforced (maxdays == 0), OR
		// - The expiry date is not reached
		if (($downloads['download_count'] > 0) && (file_exists(DIR_FS_DOWNLOAD.$downloads['orders_products_filename'])) && (($downloads['download_maxdays'] == 0) || ($download_timestamp > time())) && ($downloads['orders_status'] >= DOWNLOAD_MIN_ORDERS_STATUS)) {
			$dl[$jj]['download_link'] .= '<a href="'.vam_href_link(FILENAME_DOWNLOAD, 'order='.$last_order.'&id='.$downloads['orders_products_download_id']).'">'.$downloads['products_name'].'</a>';
			$dl[$jj]['pic_link'] .= vam_href_link(FILENAME_DOWNLOAD, 'order='.$last_order.'&id='.$downloads['orders_products_download_id']);
		} else {
			$dl[$jj]['download_link'] .= $downloads['products_name'];
		}
		//<!-- right box -->
		$dl[$jj]['date'] .= vam_date_long($download_expiry);
		$dl[$jj]['count'] .= $downloads['download_count'];
		$jj ++;
	}
  }

$box->assign('dl', $dl);

$box->caching = 0;
$box->assign('language', $_SESSION['language']);
$box_download= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_download.html');
$vamTemplate->assign('box_DOWNLOADS',$box_download);

}

}
}

// /downloads

?>