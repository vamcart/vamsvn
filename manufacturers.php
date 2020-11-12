<?php
/* -----------------------------------------------------------------------------------------
   $Id: manufacturers.php 1292 2007-02-06 19:20:03 VaM $

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

$breadcrumb->add(TITLE_MANUFACTURERS_DEFAULT);

require (DIR_WS_INCLUDES.'header.php');

	$manufacturers_query_raw = "SELECT m.*, mi.* FROM ".TABLE_MANUFACTURERS." as m 
                         left join ".TABLE_MANUFACTURERS_INFO." as mi 
                         on mi.manufacturers_id = m.manufacturers_id 
                         where mi.languages_id = '".$_SESSION['languages_id']."' and m.manufacturers_status = 1 
                         order by m.sort_order, m.manufacturers_name asc";
$manufacturers_split = new splitPageResults($manufacturers_query_raw, $_GET['page'], MAX_DISPLAY_SEARCH_RESULTS);

$module_content = array();
$row = 0;
$manufacturers_query = vam_db_query($manufacturers_split->sql_query);
while ($manufacturers = vam_db_fetch_array($manufacturers_query)) {
	
   $manufacturers_image = DIR_FS_CATALOG . DIR_WS_IMAGES . $manufacturers['manufacturers_image'];
 
	if(file_exists($manufacturers_image) && is_file($manufacturers_image)) {
		list($width, $height, $type, $attr) = getimagesize($manufacturers_image);
	}
	
   $module_content[]=array('PRODUCTS_ID'  => $manufacturers['manufacturers_id'],
                           'PRODUCTS_NAME'  => $manufacturers['manufacturers_name'],
                           'PRODUCTS_SHORT_DESCRIPTION'  => $manufacturers['manufacturers_description'],
                           'PRODUCTS_IMAGE' => DIR_WS_IMAGES . $manufacturers['manufacturers_image'],
                           'PRODUCTS_IMAGE_WIDTH' => $width,
                           'PRODUCTS_IMAGE_HEIGHT' => $height,
                           'PRODUCTS_LINK'  => vam_href_link(FILENAME_DEFAULT, 'manufacturers_id='.$manufacturers['manufacturers_id'])
   );
}

if (($manufacturers_split->number_of_rows > 0)) {
	$vamTemplate->assign('NAVIGATION_BAR', TEXT_RESULT_PAGE.' '.$manufacturers_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$vamTemplate->assign('NAVIGATION_BAR_PAGES', $manufacturers_split->display_count(TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS));

}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('module_content', $module_content);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/manufacturers.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_MANUFACTURERS.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_MANUFACTURERS.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>