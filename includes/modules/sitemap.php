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

require_once(DIR_FS_INC . 'vam_count_products_in_category.inc.php');

 //to get category trees
 function get_category_tree($parent_id = '0', $spacing = '', $exclude = '', $category_tree_array = '', $include_itself = false, $cPath = '') {
if ($parent_id == 0){ $cPath = ''; } else { $cPath .= $parent_id . '_'; }
   if (!is_array($category_tree_array)) $category_tree_array = array();
   if ( (sizeof($category_tree_array) < 1) && ($exclude != '0') ) $category_tree_array[] = array('id' => '0', 'text' => TEXT_TOP);

   if ($include_itself) {
     $category_query = "select cd.categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . $_SESSION['languages_id'] . "' and c.categories_status = '1' and cd.categories_id = '" . $parent_id . "'";
     $category_query = vamDBquery($category_query);
     $category = vam_db_fetch_array($category_query,true);
     $category_tree_array[] = array('id' => $parent_id, 'text' => $category['categories_name']);
   }

   $categories_query = "select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . $_SESSION['languages_id'] . "' and c.parent_id = '" . $parent_id . "' and c.categories_status = '1' order by c.sort_order, cd.categories_name";
   $categories_query = vamDBquery($categories_query);
   while ($categories = vam_db_fetch_array($categories_query,true)) {
   
     $SEF_link = vam_href_link(FILENAME_DEFAULT, vam_category_link($categories['categories_id'],$categories['categories_name']));
    
     if ($exclude != $categories['categories_id'])
      $category_tree_array[] = array('id' => $categories['categories_id'],
      				     'text' => $spacing . $categories['categories_name'],
				     'link'  => $SEF_link);
      $category_tree_array = get_category_tree($categories['categories_id'], $spacing . '&nbsp;&nbsp;&nbsp;', $exclude, $category_tree_array, false, $cPath);
   }

   return $category_tree_array;
 }
 
 
 
 
 
 if (GROUP_CHECK == 'true') {
 	$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
 }
 
 $categories_query = "select c.categories_image, c.categories_id, cd.categories_name, cd.categories_description FROM " . TABLE_CATEGORIES . " c left join "
      . TABLE_CATEGORIES_DESCRIPTION ." cd on c.categories_id = cd.categories_id WHERE c.categories_status = '1' and cd.language_id = ".$_SESSION['languages_id']
      ." and c.parent_id = '0' ".$group_check." order by c.sort_order ASC, c.categories_id DESC limit ".MAX_DISPLAY_CATEGORIES_PER_ROW."";

 // db Cache
 $categories_query = vamDBquery($categories_query);
 $module_content = array();
 $categories_image = ''; 
 $categories_image_path = ''; 
 
 while ($categories = vam_db_fetch_array($categories_query,true)) {
   
   $SEF_link = vam_href_link(FILENAME_DEFAULT, vam_category_link($categories['categories_id'],$categories['categories_name']));

   $categories_image = DIR_WS_IMAGES . 'categories/' . $categories['categories_image'];
   $categories_image_path = DIR_FS_CATALOG . DIR_WS_IMAGES . 'categories/' . $categories['categories_image'];
 
	if(file_exists($categories_image_path) && is_file($categories_image_path)) {
		list($width, $height, $type, $attr) = getimagesize($categories_image);
	}
	
   $module_content[]=array('ID'  => $categories['categories_id'],
                           'CATEGORIES_NAME'  => $categories['categories_name'],
                           'CATEGORIES_DESCRIPTION'  => $categories['categories_description'],
                           'CATEGORIES_IMAGE' => $categories_image,
                           'CATEGORIES_IMAGE_WIDTH' => $width,
                           'CATEGORIES_IMAGE_HEIGHT' => $height,
                           'CATEGORIES_LINK'  => $SEF_link
                           
			   //'SCATS'  => get_category_tree($categories['categories_id'], '',0)
			   
			   );
 }

 // if there's sth -> assign it
 if (sizeof($module_content)>=1)
 {
 $module->assign('SITEMAP_LINK', vam_href_link(FILENAME_DEFAULT, 'cat=0'));
 $module->assign('language', $_SESSION['language']);
 $module->assign('module_content',$module_content);
 // set cache ID
 if (!CacheCheck()) {
 $module->caching = 0;
 $module = $module->fetch(CURRENT_TEMPLATE.'/module/sitemap.html');
 } else {
 $module->caching = 1;
 $module->cache_lifetime=CACHE_LIFETIME;
 $module->cache_modified_check=CACHE_CHECK;
 $cache_id = $GET['cPath'].$_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'];
 $module = $module->fetch(CURRENT_TEMPLATE.'/module/sitemap.html',$cache_id);
 }
 	$default->assign('MODULE_sitemap', $module);
 }
?>