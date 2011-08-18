<?php
/* -----------------------------------------------------------------------------------------
   $Id: product_listing.php 1286 2007-02-06 20:41:56 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_listing.php,v 1.42 2003/05/27); www.oscommerce.com
   (c) 2003	 nextcommerce (product_listing.php,v 1.19 2003/08/1); www.nextcommerce.org
   (c) 2004	 xt:Commerce (product_listing.php,v 1.19 2003/08/1); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$result = true;
// include needed functions
require_once (DIR_FS_INC.'vam_get_all_get_params.inc.php');
require_once (DIR_FS_INC.'vam_get_vpe_name.inc.php');
require_once (DIR_WS_FUNCTIONS.'params_filters.php');
if (isset($_GET['on_page']) && is_numeric($_GET['on_page'])) {
 $num_page =  $_GET['on_page'];
 } else {
 $num_page =  MAX_DISPLAY_SEARCH_RESULTS;
 }

/* all products list */
$current_manufacturers_id = 0;
$where_manufacturers = "";
if(isset($_GET["filter_id"]))
{
    $current_manufacturers_id = intval($_GET["filter_id"]);
}
if($current_manufacturers_id != 0){
    $where_manufacturers = " and p.manufacturers_id = '" . $current_manufacturers_id . "' ";
}

if($current_manufacturers_id != 0){

    $product_list_rs = vamDBquery("select p.products_model,
                                    p.products_ean,
                                    pd.products_name,
                                    p.products_id

                                from ".TABLE_PRODUCTS_DESCRIPTION." pd,
                                    ".TABLE_PRODUCTS_TO_CATEGORIES." p2c,
                                    ".TABLE_PRODUCTS." p

                                where p.products_status = '1'
                                    " . $where_manufacturers . "
                                    and p.products_id = p2c.products_id
                                    and pd.products_id = p2c.products_id
                                    and pd.language_id = '1'
                                    and p2c.categories_id = '" . $current_category_id . "'
                                ORDER BY pd.products_name ");

    $product_list = array();
    while($product_row = vam_db_fetch_array($product_list_rs,true))
    {
        $product_list[] = $product_row;
    }
    $product_list_info = "TEST";
    $module->assign('product_list', $product_list);

} elseif (!empty($search_by_params_ids)) {
    $product_list_rs = vamDBquery("select p.products_model,
                                    p.products_ean,
                                    pd.products_name,
                                    p.products_id

                                from ".TABLE_PRODUCTS_DESCRIPTION." pd,
                                    ".TABLE_PRODUCTS_TO_CATEGORIES." p2c,
                                    ".TABLE_PRODUCTS." p

                                where p.products_status = '1' and
                                    " . $search_by_params_ids . "
                                    p.products_id = p2c.products_id
                                    and pd.products_id = p2c.products_id
                                    and pd.language_id = '1'
                                    and p2c.categories_id = '" . $current_category_id . "'
                                ORDER BY pd.products_name ");
    $product_list = array();
    while($product_row = vam_db_fetch_array($product_list_rs,true))
    {
        $product_list[] = $product_row;
    }
    $module->assign('product_list', $product_list);

} else {

}
/* */

$module->assign('LINK_PAGE',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','on_page','sort', 'direction', 'info','x','y')) . 'on_page='));

$listing_sql = str_replace("where p.products_status = '1'", "where $search_by_params_ids p.products_status = '1'", $listing_sql);

if (isset($_GET['status']))
{

    if ('all' === $_GET['status'])
    {
        $listing_sql = str_replace("p.products_status = '1'", "1", $listing_sql);
    }
    else
    {
        $_GET['status'] = intval($_GET['status']);
        $listing_sql = str_replace("p.products_status = '1'", "p.products_status = '".$_GET['status']."'", $listing_sql);
    }
}
$listing_sql = get_params_listing_sql($listing_sql, intval($current_category_id), $selectedGroups);

//print "[".$listing_sql."]";
//exit;
$listing_split = new splitPageResults($listing_sql, (int)$_GET['page'], $num_page, 'p.products_id');
$module_content = array ();
if ($listing_split->number_of_rows > 0) {



	$navigation = TEXT_RESULT_PAGE.' '.$listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y')));
	$navigation_pages = $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS);
	if (GROUP_CHECK == 'true') {
		$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
	}
	$category_query = vamDBquery("select
		                                    cd.categories_description,
		                                    cd.categories_name,
						    cd.categories_heading_title,
		                                    c.listing_template,
		                                    c.categories_image from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
		                                    where c.categories_id = '".$current_category_id."'
		                                    and cd.categories_id = '".$current_category_id."'
		                                    ".$group_check."
		                                    and cd.language_id = '".$_SESSION['languages_id']."'");

	$category = vam_db_fetch_array($category_query,true);
	$image = '';
	if ($category['categories_image'] != '')
		$image = DIR_WS_IMAGES.'categories/'.$category['categories_image'];
	$module->assign('CATEGORIES_NAME', $category['categories_name']);
	$module->assign('CATEGORIES_HEADING_TITLE', $category['categories_heading_title']);

	$module->assign('CATEGORIES_IMAGE', $image);
	$module->assign('CATEGORIES_DESCRIPTION', $category['categories_description']);

	$rows = 0;

	$listing_query = vamDBquery($listing_split->sql_query);
    $ids = array();
    while ($listing = vam_db_fetch_array($listing_query, true)) {
        $rows ++;

        $module_content[] =  $product->buildDataArray($listing);
		
        $ids[] = $module_content[sizeof($module_content) - 1]['PRODUCTS_ID'];
   }

// Parameters start

    if (is_array($ids) && sizeof($ids) > 0)
    {
        //$cats = vam_db_query("SELECT products_id, categories_id FROM ".TABLE_PRODUCTS_TO_CATEGORIES." WHERE products_id IN (".implode(", ", $ids).")");
        //$temp = array();
	    //while ($c = vam_db_fetch_array($cats, true))
	    //{
	        //if ($temp[$c['products_id']] < 1) $temp[$c['products_id']] =  $c['categories_id'];
	    //}

        $p_list = array();
        $params_r = vamDBquery("SELECT products_id, categories_id, products_parameters_title, products_parameters2products_value, products_parameters_titlesuff FROM ".TABLE_PRODUCTS_PARAMETERS2PRODUCTS." LEFT JOIN ".TABLE_PRODUCTS_PARAMETERS." USING(products_parameters_id) WHERE products_id IN (".implode(", ", $ids).") AND products_parameters_useinsdesc = 1 ORDER BY products_parameters_order ASC");
        while($p = vam_db_fetch_array($params_r,true))
        {
            //if ($temp[$p['products_id']] == $p['categories_id'])
            	$p_list[$p['products_id']][] = array('name' => $p['products_parameters_title'], 'value' => $p['products_parameters2products_value'], 'suff' => $p['products_parameters_titlesuff']);
        }
        foreach($module_content as $k => $m)
        {
            $module_content[$k]['params'] = $p_list[$m['PRODUCTS_ID']];
        }
    }

	$module->assign('BUTTON_COMPARE', vam_image_submit('button_compare.gif', TEXT_PRODUCT_COMPARE));

// Parameters end

} else {

	// no product found
	$result = false;

}
// get default template
if ($category['listing_template'] == '' or $category['listing_template'] == 'default') {
	$files = array ();
	if ($dir = opendir(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/product_listing/')) {
		while (($file = readdir($dir)) !== false) {
			if (is_file(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/product_listing/'.$file) and ($file != "index.html") and (substr($file, 0, 1) !=".")) {
				$files[] = array ('id' => $file, 'text' => $file);
			} //if
		} // while
		closedir($dir);
	}
	$category['listing_template'] = $files[0]['id'];
}

if ($result != false) {

	$module->assign('MANUFACTURER_DROPDOWN', $manufacturer_dropdown);
	$module->assign('MANUFACTURER_SORT', $manufacturer_sort);
	
	$query = "SELECT manufacturers_description FROM ".TABLE_MANUFACTURERS_INFO." where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and languages_id = '".$_SESSION['languages_id']."'";

		$open_query = vamDBquery($query);
		$open_data = vam_db_fetch_array($open_query, true);
		$manufacturers_description = $open_data["manufacturers_description"]; 
		$module->assign('MANUFACTURERS_DESCRIPTION', $manufacturers_description);

	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $module_content);

 	$module->assign('LINK_sort_name_asc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=name&direction=asc'));
	$module->assign('LINK_sort_name_desc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=name&direction=desc'));
	$module->assign('LINK_sort_price_asc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=price&direction=asc'));
	$module->assign('LINK_sort_price_desc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=price&direction=desc'));

	$module->assign('NAVIGATION', $navigation);
	$module->assign('NAVIGATION_PAGES', $navigation_pages);
	
  include (DIR_WS_MODULES.FILENAME_PRODUCTS_FILTERS);	
	
	// set cache ID
	 if (!CacheCheck()) {
		$module->caching = 0;
		$module = $module->fetch(CURRENT_TEMPLATE.'/module/product_listing/'.$category['listing_template']);
	} else {
		$module->caching = 1;
		$module->cache_lifetime = CACHE_LIFETIME;
		$module->cache_modified_check = CACHE_CHECK;
		$cache_id = $current_category_id.'_'.$_SESSION['language'].'_'.$_SESSION['customers_status']['customers_status_name'].'_'.$_SESSION['currency'].'_'.$_GET['manufacturers_id'].'_'.$_GET['filter_id'].'__'.$_GET['q'].'_'.$_GET['price_min'].'_'.$_GET['price_max'].'_'.$_GET['on_page'].'_'.$_GET['page'].'__'.$_GET['sort'].'_'.$_GET['direction'].'_'.$_GET['keywords'].'_'.$_GET['categories_id'].'_'.$_GET['pfrom'].'_'.$_GET['pto'].'_'.$_GET['x'].'_'.$_GET['y'];
		$module = $module->fetch(CURRENT_TEMPLATE.'/module/product_listing/'.$category['listing_template'], $cache_id);
	}
	$vamTemplate->assign('main_content', $module);
} else {

	$error = TEXT_PRODUCT_NOT_FOUND;
	include (DIR_WS_MODULES.FILENAME_ERROR_HANDLER);
}
?>