<?php
/* -----------------------------------------------------------------------------------------
   $Id: downloads.php 896 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(downloads.php,v 1.2 2003/02/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (downloads.php,v 1.6 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (downloads.php,v 1.6 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

// ibclude the needed functions
if (!function_exists('vam_date_long')) {
	require_once (DIR_FS_INC.'vam_date_long.inc.php');
}

$module = new vamTemplate;

if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
	// Get last order id for checkout_success
	$orders_query = vam_db_query("select orders_id, orders_status from ".TABLE_ORDERS." where customers_id = '".$_SESSION['customer_id']."' order by orders_id desc limit 1");
	$orders = vam_db_fetch_array($orders_query);
	$last_order = $orders['orders_id'];
	$order_status = $orders['orders_status'];
} else {
	$last_order = (int)$_GET['order_id'];
	$orders_query = vam_db_query("SELECT orders_status FROM ".TABLE_ORDERS." WHERE orders_id = '".$last_order."'");
	$orders = vam_db_fetch_array($orders_query);
	$order_status = $orders['orders_status'];
}
if ($order_status < DOWNLOAD_MIN_ORDERS_STATUS) {
	$module->assign('dl_prevented', 'true');
}
// Now get all downloadable products in that order
$downloads_query = vam_db_query("select date_format(o.date_purchased, '%Y-%m-%d') as date_purchased_day, opd.download_maxdays, op.products_name, opd.orders_products_download_id, opd.orders_products_filename, opd.download_count, opd.download_maxdays, opd.download_pin_code,opd.download_is_pin from ".TABLE_ORDERS." o, ".TABLE_ORDERS_PRODUCTS." op, ".TABLE_ORDERS_PRODUCTS_DOWNLOAD." opd where o.customers_id = '".$_SESSION['customer_id']."' and o.orders_id = '".$last_order."' and o.orders_id = op.orders_id and op.orders_products_id = opd.orders_products_id and (opd.orders_products_filename != '' or opd.download_is_pin='1')");
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
	
if ($order_status < DOWNLOAD_MIN_ORDERS_STATUS) {
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
		if (($downloads['download_count'] > 0) && (file_exists(DIR_FS_DOWNLOAD.$downloads['orders_products_filename'])) && (($downloads['download_maxdays'] == 0) || ($download_timestamp > time())) && ($order_status >= DOWNLOAD_MIN_ORDERS_STATUS)) {
			$dl[$jj]['download_link'] = '<a href="'.vam_href_link(FILENAME_DOWNLOAD, 'order='.$last_order.'&id='.$downloads['orders_products_download_id']).'">'.$downloads['products_name'].'</a>';
			$dl[$jj]['pic_link'] = vam_href_link(FILENAME_DOWNLOAD, 'order='.$last_order.'&id='.$downloads['orders_products_download_id']);
		} else {
			$dl[$jj]['download_link'] = $downloads['products_name'];
		}
		//<!-- right box -->
		$dl[$jj]['date'] = vam_date_long($download_expiry);
		$dl[$jj]['count'] = $downloads['download_count'];
		$jj ++;
	}
  }
}
$module->assign('dl', $dl);
$module->assign('language', $_SESSION['language']);
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$module->caching = 0;
$module = $module->fetch(CURRENT_TEMPLATE.'/module/downloads.html');
$vamTemplate->assign('downloads_content', $module);
?>