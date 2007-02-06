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

$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$module_content = array ();
$filename = '';

// check if allowed to see
require_once (DIR_FS_INC.'xtc_in_array.inc.php');
$check_query = xtDBquery("SELECT DISTINCT
				products_id
				FROM ".TABLE_PRODUCTS_CONTENT."
				WHERE languages_id='".(int) $_SESSION['languages_id']."'");


$check_data = array ();
$i = '0';
while ($content_data = xtc_db_fetch_array($check_query,true)) {
	$check_data[$i] = $content_data['products_id'];
	$i ++;
}
if (xtc_in_array($product->data['products_id'], $check_data)) {
	// get content data

	require_once (DIR_FS_INC.'xtc_filesize.inc.php');

	if (GROUP_CHECK == 'true')
		$group_check = "group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%' AND";

	//get download
	$content_query = xtDBquery("SELECT
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

	while ($content_data = xtc_db_fetch_array($content_query,true)) {
		$filename = '';
		if ($content_data['content_link'] != '') {

			$icon = xtc_image(DIR_WS_CATALOG.'admin/images/icons/icon_link.gif');
		} else {
			$icon = xtc_image(DIR_WS_CATALOG.'admin/images/icons/icon_'.str_replace('.', '', strstr($content_data['content_file'], '.')).'.gif');
		}

		if ($content_data['content_link'] != '')
			$filename = '<a href="'.$content_data['content_link'].'" target="new">';
		$filename .= $content_data['content_name'];
		if ($content_data['content_link'] != '')
			$filename .= '</a>';
		$button = '';
		if ($content_data['content_link'] == '') {
			if (eregi('.html', $content_data['content_file']) or eregi('.htm', $content_data['content_file']) or eregi('.txt', $content_data['content_file']) or eregi('.bmp', $content_data['content_file']) or eregi('.jpg', $content_data['content_file']) or eregi('.gif', $content_data['content_file']) or eregi('.png', $content_data['content_file']) or eregi('.tif', $content_data['content_file'])) {

				$button = '<a style="cursor:hand" onclick="javascript:window.open(\''.xtc_href_link(FILENAME_MEDIA_CONTENT, 'coID='.$content_data['content_id']).'\', \'popup\', \'toolbar=0, width=640, height=600\')">'.xtc_image_button('button_view.gif', TEXT_VIEW).'</a>';

			} else {

				$button = '<a href="'.xtc_href_link('media/products/'.$content_data['content_file']).'">'.xtc_image_button('button_download.gif', TEXT_DOWNLOAD).'</a>';

			}
		}
		$module_content[] = array ('ICON' => $icon, 'FILENAME' => $filename, 'DESCRIPTION' => $content_data['file_comment'], 'FILESIZE' => xtc_filesize($content_data['content_file']), 'BUTTON' => $button, 'HITS' => $content_data['content_read']);
	}

	$module_smarty->assign('language', $_SESSION['language']);
	$module_smarty->assign('module_content', $module_content);
	// set cache ID

		$module_smarty->caching = 0;
		$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/products_media.html');

	$info_smarty->assign('MODULE_products_media', $module);
}
?>