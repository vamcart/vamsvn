<?php
/* -----------------------------------------------------------------------------------------
   $Id: products_media.php 1259 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (products_media.php,v 1.8 2003/08/25); www.nextcommerce.org
   (c) 2004	 xt:Commerce (products_media.php,v 1.8 2003/08/25); xt-commerce.com
   
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$module_content = array ();
$filename = '';

// check if allowed to see
require_once (DIR_FS_INC.'vam_in_array.inc.php');
$check_query = vamDBquery("SELECT DISTINCT
				products_id
				FROM ".TABLE_PRODUCTS_CONTENT."
				WHERE languages_id='".(int) $_SESSION['languages_id']."'");


$check_data = array ();
$i = '0';
while ($content_data = vam_db_fetch_array($check_query,true)) {
	$check_data[$i] = $content_data['products_id'];
	$i ++;
}
if (vam_in_array($product->data['products_id'], $check_data)) {
	// get content data

	require_once (DIR_FS_INC.'vam_filesize.inc.php');

	if (GROUP_CHECK == 'true')
		$group_check = "group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%' AND";

	//get download
	$content_query = vamDBquery("SELECT
					content_id,
					content_name,
					content_link,
					content_file,
					content_read,
					file_comment
					FROM ".TABLE_PRODUCTS_CONTENT."
					WHERE
					products_id='".$product->data['products_id']."' AND
	                ".$group_check."
					languages_id='".(int) $_SESSION['languages_id']."'");

	while ($content_data = vam_db_fetch_array($content_query,true)) {
		$filename = '';
		if ($content_data['content_link'] != '') {

			$icon = vam_image(DIR_WS_CATALOG.'admin/images/icons/icon_link.gif');
		} else {
			$icon = vam_image(DIR_WS_CATALOG.'admin/images/icons/icon_'.str_replace('.', '', strstr($content_data['content_file'], '.')).'.gif');
		}

		if ($content_data['content_link'] != '')
			$filename = '<a href="'.$content_data['content_link'].'" target="new">';
		$filename .= $content_data['content_name'];
		if ($content_data['content_link'] != '')
			$filename .= '</a>';
		$button = '';
		if ($content_data['content_link'] == '') {
			if (preg_match('/.html/i', $content_data['content_file']) or preg_match('/.htm/i', $content_data['content_file']) or preg_match('/.txt/i', $content_data['content_file']) or preg_match('/.bmp/i', $content_data['content_file']) or preg_match('/.jpg/i', $content_data['content_file']) or preg_match('/.gif/i', $content_data['content_file']) or preg_match('/.png/i', $content_data['content_file']) or preg_match('/.tif/i', $content_data['content_file'])) {

				$button = '<a style="cursor:hand" onclick="javascript:window.open(\''.vam_href_link(FILENAME_MEDIA_CONTENT, 'coID='.$content_data['content_id']).'\', \'popup\', \'toolbar=0, width=640, height=600\')">'.vam_image_button('button_view.gif', TEXT_VIEW).'</a>';

			} else {

				$button = '<a href="'.vam_href_link('media/products/'.$content_data['content_file']).'">'.vam_image_button('button_download.gif', TEXT_DOWNLOAD).'</a>';

			}
		}
		$module_content[] = array ('ICON' => $icon, 'FILENAME' => $filename, 'DESCRIPTION' => $content_data['file_comment'], 'FILESIZE' => vam_filesize($content_data['content_file']), 'BUTTON' => $button, 'HITS' => $content_data['content_read']);
	}

	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $module_content);
	
	$module->assign('download_permission', false);

// Get last order id for checkout_success
    $orders_query_raw = "SELECT orders_id FROM " . TABLE_ORDERS . " WHERE customers_id = '" . (int)$_SESSION['customer_id'] . "' ORDER BY orders_id DESC LIMIT 1";
    $orders_query = vam_db_query($orders_query_raw);
    $orders_values = vam_db_fetch_array($orders_query);
    $last_order = $orders_values['orders_id'];

// Now get all downloadable products in that order
  $downloads_query_raw = "SELECT DATE_FORMAT(date_purchased, '%Y-%m-%d') as date_purchased_day, opd.download_maxdays, op.products_name, opd.orders_products_download_id, opd.orders_products_filename, opd.download_count, opd.download_maxdays
                          FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " opd
                          WHERE customers_id = '" . (int)$_SESSION['customer_id'] . "'
                          AND o.orders_id = '" . (int)$last_order . "'
                          AND o.orders_status >= " . DOWNLOAD_MIN_ORDERS_STATUS . "
                          AND op.orders_id = '" . (int)$last_order . "'
                          AND opd.orders_products_id=op.orders_products_id
                          AND opd.orders_products_filename<>'' limit 1";
  $downloads_query = vam_db_query($downloads_query_raw);

// Don't display if there is no downloadable product
  if (vam_db_num_rows($downloads_query) > 0) {

    $downloads_values = vam_db_fetch_array($downloads_query);

// MySQL 3.22 does not have INTERVAL
    	list($dt_year, $dt_month, $dt_day) = explode('-', $downloads_values['date_purchased_day']);
    	$download_timestamp = mktime(23, 59, 59, $dt_month, $dt_day + $downloads_values['download_maxdays'], $dt_year);
  	    $download_expiry = date('Y-m-d H:i:s', $download_timestamp);

// The link will appear only if:
// - Download remaining count is > 0, AND
// - The file is present in the DOWNLOAD directory, AND EITHER
// - No expiry date is enforced (maxdays == 0), OR
// - The expiry date is not reached
      if (($downloads_values['download_count'] > 0) &&
          (file_exists(DIR_FS_DOWNLOAD . $downloads_values['orders_products_filename'])) &&
          (($downloads_values['download_maxdays'] == 0) ||
           ($download_timestamp > time()))) {
           	
	$module->assign('download_permission', true);
  	
  	}
	
	}
	
	// set cache ID

		$module->caching = 0;
		$module = $module->fetch(CURRENT_TEMPLATE.'/module/products_media.html');

	$info->assign('MODULE_products_media', $module);
}
?>