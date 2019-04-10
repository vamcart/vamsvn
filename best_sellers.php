<?php
/* -----------------------------------------------------------------------------------------
   $Id: best_sellers.php 1292 2007-02-06 19:20:03 VaM $

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

$breadcrumb->add(TITLE_BEST_SELLERS_DEFAULT);

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

	$best_sellers_query_raw = "select distinct
	                                        p.*,
	                                        pd.* from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_CATEGORIES." c
	                                        where p.products_status = '1'
	                                        and c.categories_status = '1'
	                                        and p.products_ordered > 0
	                                        and p.products_id = pd.products_id
	                                        and pd.language_id = '".(int) $_SESSION['languages_id']."'
	                                        and p.products_id = p2c.products_id
	                                        ".$group_check."
	                                        ".$fsk_lock."
	                                        and p2c.categories_id = c.categories_id and '".$current_category_id."'
	                                        in (c.categories_id, c.parent_id)
	                                        order by p.products_ordered desc ";
$best_sellers_split = new splitPageResults($best_sellers_query_raw, $_GET['page'], MAX_DISPLAY_SEARCH_RESULTS);

$module_content = array();
$row = 0;
$best_sellers_query = vam_db_query($best_sellers_split->sql_query);
while ($best_sellers = vam_db_fetch_array($best_sellers_query)) {
	$module_content[] = $product->buildDataArray($best_sellers);
}

if (($best_sellers_split->number_of_rows > 0)) {
	$vamTemplate->assign('NAVIGATION_BAR', TEXT_RESULT_PAGE.' '.$best_sellers_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$vamTemplate->assign('NAVIGATION_BAR_PAGES', $best_sellers_split->display_count(TEXT_DISPLAY_NUMBER_OF_BEST_SELLERS));

}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('module_content', $module_content);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/best_sellers.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_BEST_SELLERS.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_BEST_SELLERS.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>