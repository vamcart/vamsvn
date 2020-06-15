<?php
/* -----------------------------------------------------------------------------------------
   $Id: sitemap.php 782 2007-02-13 10:23:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce; www.oscommerce.com
   (c) 2003	 nextcommerce; www.nextcommerce.org
   (c) 2004 xt:Commerce (sitemap.php,v 1.19 2004/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$module = new vamTemplate;
$module->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

 $manufacturers_query = "SELECT m.*, mi.* FROM ".TABLE_MANUFACTURERS." as m 
                         left join ".TABLE_MANUFACTURERS_INFO." as mi 
                         on mi.manufacturers_id = m.manufacturers_id 
                         where mi.languages_id = '".$_SESSION['languages_id']."' 
                         and m.manufacturers_status = 1 order by m.sort_order, m.manufacturers_name asc limit ".MAX_DISPLAY_SEARCH_RESULTS."
                         ";

 // db Cache
 $manufacturers_query = vamDBquery($manufacturers_query);
 $module_content = array();
 while ($manufacturers = vam_db_fetch_array($manufacturers_query,true)) {

   $manufacturers_image = DIR_WS_IMAGES . 'manufacturers/' . $manufacturers['manufacturers_image'];
	if(file_exists($manufacturers_image) && is_file($manufacturers_image)) {
   $manufacturers_image = DIR_WS_IMAGES . 'manufacturers/' . $manufacturers['manufacturers_image'];
   } else {
   $manufacturers_image = DIR_WS_IMAGES . 'product_images/noimage.gif';
   }
 
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

 // if there's sth -> assign it
 if (sizeof($module_content)>=1)
 {
 $module->assign('MANUFACTURERS_LINK', vam_href_link(FILENAME_MANUFACTURERS));
 $module->assign('language', $_SESSION['language']);
 $module->assign('module_content',$module_content);
 // set cache ID
 if (!CacheCheck()) {
 $module->caching = 0;
 $module = $module->fetch(CURRENT_TEMPLATE.'/module/manufacturers_default.html');
 } else {
 $module->caching = 1;
 $module->cache_lifetime=CACHE_LIFETIME;
 $module->cache_modified_check=CACHE_CHECK;
 $cache_id = $current_category_id.$_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'];
 $module = $module->fetch(CURRENT_TEMPLATE.'/module/manufacturers_default.html',$cache_id);
 }
 	$default->assign('MODULE_manufacturers_default', $module);
 }
?>