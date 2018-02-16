<?php
/* -----------------------------------------------------------------------------------------
   $Id: specials.php 1292 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(specials.php,v 1.47 2003/05/27); www.oscommerce.com 
   (c) 2003	 nextcommerce (specials.php,v 1.12 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (specials.php,v 1.12 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

require_once (DIR_FS_INC.'vam_get_short_description.inc.php');

$breadcrumb->add(NAVBAR_TITLE_PRODUCTS_NEW);

require (DIR_WS_INCLUDES.'header.php');

//fsk18 lock
$fsk_lock = '';
$days = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}
if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
	//$date_new_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_NEW_PRODUCTS_DAYS, date(Y)));
	//$days = " and p.products_date_added > '".$date_new_products."' ";
}
	$products_new_query_raw = "select distinct
	                                    p.products_id,
	                                    p.label_id,
	                                    p.products_fsk18,
	                                    pd.products_name,
	                                    pd.products_short_description,
	                                    p.products_image,
	                                    p.products_price,
	                                    p.products_model,
	                               	    p.products_vpe,
	                               	    p.products_quantity,
	                               	    p.products_vpe_status,
	                                    p.products_vpe_value,                                                          
	                                    p.products_tax_class_id,
	                                    p.products_date_added,
	                                    m.manufacturers_name
	                                    from " . TABLE_PRODUCTS . " p
	                                    left join " . TABLE_MANUFACTURERS . " m
	                                    on p.manufacturers_id = m.manufacturers_id
	                                    left join " . TABLE_PRODUCTS_DESCRIPTION . " pd
	                                    on p.products_id = pd.products_id,
	                                    " . TABLE_CATEGORIES . " c,
	                                    " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c 
	                                    WHERE pd.language_id = '" . (int) $_SESSION['languages_id'] . "'
	                                    and c.categories_status=1
	                                    and p.products_id = p2c.products_id
	                                    and c.categories_id = p2c.categories_id
	                                    and products_status = '1'
	                                    " . $group_check . "
	                                    " . $fsk_lock . "                                    
	                                    " . $days . "
	                                    order
	                                    by
	                                    p.products_date_added DESC ";
$products_new_split = new splitPageResults($products_new_query_raw, $_GET['page'], MAX_DISPLAY_PRODUCTS_NEW);

$module_content = [];
$row = 0;
$products_new_query = vam_db_query($products_new_split->sql_query);
while ($products_new = vam_db_fetch_array($products_new_query)) {
	$module_content[] = $product->buildDataArray($products_new);
}

if (($products_new_split->number_of_rows > 0)) {
	$vamTemplate->assign('NAVIGATION_BAR', TEXT_RESULT_PAGE.' '.$products_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$vamTemplate->assign('NAVIGATION_BAR_PAGES', $products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW));

}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('module_content', $module_content);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/new_products_overview.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_PRODUCTS_NEW.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_PRODUCTS_NEW.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>