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

$breadcrumb->add(NAVBAR_TITLE_SPECIALS, vam_href_link(FILENAME_SPECIALS));

require (DIR_WS_INCLUDES.'header.php');

//fsk18 lock
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}
$specials_query_raw = "select p.products_id,
                                p.label_id,
                                pd.products_name,
                                pd.products_short_description,
                                pd.products_description,
                                p.products_price,
                                p.products_tax_class_id,p.products_shippingtime,
                                p.products_image,p.products_vpe_status,p.products_vpe_value,p.products_vpe,p.products_fsk18,
                                s.specials_new_products_price from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_SPECIALS." s
                                where p.products_status = '1'
                                and s.products_id = p.products_id
                                and p.products_id = pd.products_id
                                ".$group_check."
                                ".$fsk_lock."
                                and pd.language_id = '".(int) $_SESSION['languages_id']."'
                                and s.status = '1' order by s.specials_date_added DESC";
$specials_split = new splitPageResults($specials_query_raw, $_GET['page'], MAX_DISPLAY_SPECIAL_PRODUCTS);

$module_content = '';
$row = 0;
$specials_query = vam_db_query($specials_split->sql_query);
while ($specials = vam_db_fetch_array($specials_query)) {
	$module_content[] = $product->buildDataArray($specials);
}

if (($specials_split->number_of_rows > 0)) {
	$vamTemplate->assign('NAVBAR', TEXT_RESULT_PAGE.' '.$specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$vamTemplate->assign('NAVBAR_PAGES', $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS));

}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('module_content', $module_content);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/specials.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_SPECIALS.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_SPECIALS.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>