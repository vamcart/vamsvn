<?php
/* -----------------------------------------------------------------------------------------
   $Id: featured.php 1292 2007-02-06 19:20:03 VaM $

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
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

require_once (DIR_FS_INC.'xtc_get_short_description.inc.php');

$breadcrumb->add(NAVBAR_TITLE_FEATURED, xtc_href_link(FILENAME_FEATURED));

require (DIR_WS_INCLUDES.'header.php');

//fsk18 lock
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}
$featured_query_raw = "select p.products_id,
                                pd.products_name,
                                p.products_price,
                                p.products_tax_class_id,p.products_shippingtime,
                                p.products_image,p.products_vpe_status,p.products_vpe_value,p.products_vpe,p.products_fsk18 from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_FEATURED." f
                                where p.products_status = '1'
                                and f.products_id = p.products_id
                                and p.products_id = pd.products_id
                                ".$group_check."
                                ".$fsk_lock."
                                and pd.language_id = '".(int) $_SESSION['languages_id']."'
                                and f.status = '1' order by f.featured_date_added DESC";
$featured_split = new splitPageResults($featured_query_raw, $_GET['page'], MAX_DISPLAY_FEATURED_PRODUCTS);

$module_content = '';
$row = 0;
$featured_query = xtc_db_query($featured_split->sql_query);
while ($featured = xtc_db_fetch_array($featured_query)) {
	$module_content[] = $product->buildDataArray($featured);
}

if (($featured_split->number_of_rows > 0)) {
	$smarty->assign('NAVBAR', '<span class="right">'.TEXT_RESULT_PAGE.' '.$featured_split->display_links(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array ('page', 'info', 'x', 'y'))) . '</span>' . $featured_split->display_count(TEXT_DISPLAY_NUMBER_OF_FEATURED));

}

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('module_content', $module_content);
$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/featured.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>