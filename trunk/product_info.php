<?php
/* -----------------------------------------------------------------------------------------
   $Id: product_info.php 1320 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_info.php,v 1.94 2003/05/04); www.oscommerce.com 
   (c) 2003      nextcommerce (product_info.php,v 1.46 2003/08/25); www.nextcommerce.org
   (c) 2004      xt:Commerce (product_info.php,v 1.46 2003/08/25); xt-commerce.com

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
   New Attribute Manager v4b                            Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com   
   Cross-Sell (X-Sell) Admin 1                          Autor: Joshua Dechant (dreamscape)
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create template elements
$vamTemplate = new vamTemplate;

// include boxes

if ($_GET['products_id']) {
	$cat = vam_db_query("SELECT categories_id FROM ".TABLE_PRODUCTS_TO_CATEGORIES." WHERE products_id='".(int) $_GET['products_id']."'");
	$catData = vam_db_fetch_array($cat);
	require_once (DIR_FS_INC.'vam_get_path.inc.php');
	if ($catData['categories_id'])
		$cPath = vam_input_validation(vam_get_path($catData['categories_id']), 'cPath', '');

}

require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC.'vam_get_download.inc.php');
require_once (DIR_FS_INC.'vam_delete_file.inc.php');
require_once (DIR_FS_INC.'vam_get_all_get_params.inc.php');
require_once (DIR_FS_INC.'vam_date_long.inc.php');
require_once (DIR_FS_INC.'vam_draw_hidden_field.inc.php');
require_once (DIR_FS_INC.'vam_image_button.inc.php');
require_once (DIR_FS_INC.'vam_draw_form.inc.php');
require_once (DIR_FS_INC.'vam_draw_input_field.inc.php');
require_once (DIR_FS_INC.'vam_image_submit.inc.php');

if ($_GET['action'] == 'get_download') {
	vam_get_download($_GET['cID']);
}

include (DIR_WS_MODULES.'product_info.php');

require (DIR_WS_INCLUDES.'header.php');
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
if ((file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_INFO.'_'.$actual_products_id.'.html'))) {
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_INFO.'_'.$actual_products_id.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_INFO.'_'.$actual_products_id.'.html' : CURRENT_TEMPLATE.'/index.html');
} else {
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_INFO.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_INFO.'.html' : CURRENT_TEMPLATE.'/index.html');
}
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>