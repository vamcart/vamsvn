<?php
/* -----------------------------------------------------------------------------------------
   $Id: categories.php 1302 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (categories.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (categories.php,v 1.10 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
// reset var
$start = microtime();
$box = new vamTemplate;
$box_content = '';
$id = '';

$box->assign('language', $_SESSION['language']);
// set cache ID
if (!CacheCheck()) {
	$cache=false;
	$box->caching = 0;
} else {
	$cache=true;
	$box->caching = 1;
	$box->cache_lifetime = CACHE_LIFETIME;
	$box->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'].$current_category_id;
}

if(!$box->isCached(CURRENT_TEMPLATE.'/boxes/box_categories_left.html', $cache_id) || !$cache){

$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

// include needed functions
require_once (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/inc/vam_show_category.inc.php');
require_once (DIR_FS_INC.'vam_has_category_subcategories.inc.php');
require_once (DIR_FS_INC.'vam_count_products_in_category.inc.php');


$categories_string = '';
if (GROUP_CHECK == 'true') {
	$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 "; 
 } else { $group_check=''; }

$categories_new_query = "select c.categories_id,
                                           cd.categories_name,
                                           c.categories_image,
                                           c.parent_id from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
                                           where c.categories_status = '1'
                                           and c.parent_id = '0'
                                           ".$group_check."
                                           and c.categories_id = cd.categories_id
                                           and cd.language_id='".(int) $_SESSION['languages_id']."'
                                           order by sort_order, cd.categories_name";
$categories_new_query = vamDBquery($categories_new_query);

while ($categories_new = vam_db_fetch_array($categories_new_query, true)) {
	$foo[$categories_new['categories_id']] = array ('id' => $categories_new['categories_id'], 'name' => $categories_new['categories_name'], 'image' => $categories_new['categories_image'], 'parent' => $categories_new['parent_id'], 'level' => 0, 'path' => $categories_new['categories_id'], 'next_id' => false);

	if (isset ($prev_id)) {
		$foo[$prev_id]['next_id'] = $categories_new['categories_id'];
	}

	$prev_id = $categories_new['categories_id'];

	if (!isset ($first_element)) {
		$first_element = $categories_new['categories_id'];
	}
}

//------------------------
if ($cPath) {
	$new_path = '';
	$id = preg_split('/_/', $cPath);
	foreach ($id as $key => $value) {	
		unset ($prev_id);
		unset ($first_id);
		$categories_new_query = "select c.categories_id, c.categories_image, cd.categories_name, c.parent_id from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd where c.categories_status = '1' and c.parent_id = '".$value."' ".$group_check." and c.categories_id = cd.categories_id and cd.language_id='".$_SESSION['languages_id']."' order by sort_order, cd.categories_name";
		$categories_new_query = vamDBquery($categories_new_query);
		$category_check = vam_db_num_rows($categories_new_query, true);
		if ($category_check > 0) {
			$new_path .= $value;
			while ($row = vam_db_fetch_array($categories_new_query, true)) {
				$foo[$row['categories_id']] = array ('id' => $row['categories_id'], 'name' => $row['categories_name'], 'image' => $row['categories_image'], 'parent' => $row['parent_id'], 'level' => $key +1, 'path' => $new_path.'_'.$row['categories_id'], 'next_id' => false);

				if (isset ($prev_id)) {
					$foo[$prev_id]['next_id'] = $row['categories_id'];
				}

				$prev_id = $row['categories_id'];

				if (!isset ($first_id)) {
					$first_id = $row['categories_id'];
				}

				$last_id = $row['categories_id'];
			}
			$foo[$last_id]['next_id'] = $foo[$value]['next_id'];
			$foo[$value]['next_id'] = $first_id;
			$new_path .= '_';
		} else {
			break;
		}
	}
}

vam_show_category($first_element);

$box->assign('BOX_CONTENT', '<ul id="CatNavi">' . $categories_string . '</ul>');

}

// set cache ID
if (!$cache) {
	$box_categories_left = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_categories_left.html');
} else {
	$box_categories_left = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_categories_left.html', $cache_id);
}

$module->assign('box_CATEGORIES_LEFT', $box_categories_left);
?>