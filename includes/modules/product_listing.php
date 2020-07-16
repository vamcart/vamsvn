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


// Start product/catalog variables set fot template
$module->assign( 'product_name_tpl', $product_name_tpl );
$module->assign( 'products_category_tpl', $products_category_tpl_arr );
$module->assign( 'category_path_tpl', $category_path_tpl_arr );
// End product/catalog variables set fot template


// include needed functions
require_once (DIR_FS_INC.'vam_get_all_get_params.inc.php');
require_once (DIR_FS_INC.'vam_get_vpe_name.inc.php');
if (isset($_GET['on_page']) && is_numeric($_GET['on_page'])) {
if ($_GET['on_page'] <=100 ) { 
$num_page =  $_GET['on_page'];
} else { 
$num_page = 100;
}
} else {
$num_page =  MAX_DISPLAY_SEARCH_RESULTS;
}

$module->assign('LINK_PAGE',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','cPath','on_page','sort', 'direction', 'info','x','y')) . 'on_page='));

$listing_split = new splitPageResults($listing_sql, (int)$_GET['page'], $num_page, 'p.products_id');
$module_content = array ();
if ($listing_split->number_of_rows > 0) {



	$navigation = TEXT_RESULT_PAGE.' '.$listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'cPath', 'info', 'x', 'y')));
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

  if (strstr($PHP_SELF, FILENAME_PRODUCTS_FILTERS)) {
	global $filter,$filter_description;
	$module->assign('FILTER', $filter);
	$module->assign('FILTER_DESCRIPTION', $filter_description);
	
	}

	(!$_GET['manufacturers_id'] && $_GET['filter_id'] > 0) ? $_GET['manufacturers_id'] = $_GET['filter_id'] : false;
		
	$query = "SELECT m.*, mi.* FROM ".TABLE_MANUFACTURERS." as m left join ".TABLE_MANUFACTURERS_INFO." as mi on mi.manufacturers_id = m.manufacturers_id where m.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and mi.languages_id = '".$_SESSION['languages_id']."'";

		$open_query = vamDBquery($query);
		$open_data = vam_db_fetch_array($open_query, true);
		$manufacturers_description = $open_data["manufacturers_description"]; 
		$module->assign('MANUFACTURERS_DESCRIPTION', $manufacturers_description);
		$module->assign('MANUFACTURERS_NAME', $open_data["manufacturers_name"]);
		
	$rows = 0;
	$listing_query = vamDBquery($listing_split->sql_query);
	while ($listing = vam_db_fetch_array($listing_query, true)) {
		$rows ++;
		$module_content[] =  $product->buildDataArray($listing);		
	}
	

if (PRODUCT_LISTING_ATTRIBUTES == 'true') {
		
// Attributes start
foreach($module_content as $k => $m)
{
$pID = $module_content[$k]['PRODUCTS_ID'];
if (vam_has_product_attributes($pID)) {
$products_options_name_query = vamDBquery("select distinct popt.products_options_id, popt.products_options_name,popt.products_options_type,popt.products_options_length,popt.products_options_rows,popt.products_options_size from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".$pID."' and patrib.options_id = popt.products_options_id and popt.language_id = '".(int) $_SESSION['languages_id']."' order by popt.sortorder");
	$row = 0;
	$col = 0;
	$products_options_data = array ();
	while ($products_options_name = vam_db_fetch_array($products_options_name_query,true)) {
		$selected = 0;
		$products_options_array = array ();

		$products_options_data[$row] = array (
		
		'NAME' => $products_options_name['products_options_name'],
		'TYPE'=>$products_options_name['products_options_type'],
		'ROWS'=>$products_options_name['products_options_rows'],
		'LENGTH'=>$products_options_name['products_options_length'],
		'SIZE'=>$products_options_name['products_options_size'], 
		'ID' => $products_options_name['products_options_id'], 
		//'DATA' => ''
		
		);

		$products_options_query = vamDBquery("select pov.products_options_values_id,
		                                                 pov.products_options_values_name,
		                                                 pov.products_options_values_description,
		                                                 pov.products_options_values_text,
		                                                 pov.products_options_values_image,
		                                                 pov.products_options_values_link,
		                                                 pa.attributes_model,
		                                                 pa.options_values_price,
		                                                 pa.price_prefix,
		                                                 pa.attributes_stock,
		                                                 pa.attributes_model
		                                                 from ".TABLE_PRODUCTS_ATTRIBUTES." pa,
		                                                 ".TABLE_PRODUCTS_OPTIONS_VALUES." pov
		                                                 where pa.products_id = '".$pID."'
		                                                 and pa.options_id = '".$products_options_name['products_options_id']."'
		                                                 and pa.options_values_id = pov.products_options_values_id
		                                                 and pov.language_id = '".(int) $_SESSION['languages_id']."'
		                                                 order by pa.sortorder");
		$col = 0;
        // added by mosq
        $checked = 'checked="checked"';
		while ($products_options = vam_db_fetch_array($products_options_query,true)) {
			$price = '';
			if ($_SESSION['customers_status']['customers_status_show_price'] == '0') {
				//$products_options_data[$row]['DATA'] = array();
				$products_options_data[$row]['DATA'][$col] = array (
				
				'ID' => $products_options['products_options_values_id'], 
				'TEXT' => $products_options['products_options_values_name'],
				'DESCRIPTION' => $products_options['products_options_values_description'], 
				'SHORT_DESCRIPTION' => $products_options['products_options_values_text'], 
				'IMAGE' => $products_options['products_options_values_image'], 
				'LINK' => $products_options['products_options_values_link'], 
				'MODEL' => $products_options['attributes_model'], 
				'STOCK' => $products_options['attributes_stock'], 
				'PRICE' => '', 
				'FULL_PRICE' => '', 
				'PREFIX' => $products_options['price_prefix'],
				// added by mosq
                'CHECKED' => $checked,
				);
			
				$price = '';
				$full_price = '';
			} else {
				if ($products_options['options_values_price'] != '0.00') {
//					$price = $vamPrice->Format($products_options['options_values_price'], false, $module_content[$k]['PRODUCTS_TAX_INFO']);
					$price = $vamPrice->GetOptionPrice($pID, $products_options_name['products_options_id'], $products_options['products_options_values_id']);
					$price = $price['price'];
				}
				$products_price = $vamPrice->GetPrice($pID, $format = false, 1, $module_content[$k]['PRODUCTS_TAX_INFO'], $module_content[$k]['PRODUCTS_PRICE']);
				if ($_SESSION['customers_status']['customers_status_discount_attributes'] == 1 && $products_options['price_prefix'] == '+')
					$price -= $price / 100 * $discount;				
					$attr_price=$price;
					//if ($products_options['price_prefix']=="-") { $attr_price=$price*(-1); $price=$attr_price; }
					$full_price = $products_price + $attr_price;
					$price_plain = $vamPrice->Format($price, false);
					$price = $vamPrice->Format($price, true);
					$full_price = $vamPrice->Format($full_price, true);
			}
			
			//$products_options_data[$row]['DATA'] = array();
			$products_options_data[$row]['DATA'][$col] = array (
			
			'ID' => $products_options['products_options_values_id'], 
			'TEXT' => $products_options['products_options_values_name'],
			'DESCRIPTION' => $products_options['products_options_values_description'], 
			'SHORT_DESCRIPTION' => $products_options['products_options_values_text'], 
			'IMAGE' => $products_options['products_options_values_image'], 
			'LINK' => $products_options['products_options_values_link'], 
			'MODEL' => $products_options['attributes_model'], 
			'STOCK' => $products_options['attributes_stock'], 
			'PRICE' => $price, 
			'PRICE_PLAIN' => $price_plain, 
			'FULL_PRICE' => $full_price, 'PREFIX' => $products_options['price_prefix'],
			// added by mosq
            'CHECKED' => $checked,
			);
			
			$checked = '';
			$col ++;
		}
		$row ++;
	}
$module_content[$k]['attrib'] = $products_options_data;
}
}
// Attributes end

}
	
	$module->assign('BUTTON_COMPARE', vam_image_submit('view.png', TEXT_PRODUCT_COMPARE));
	$module->assign('PRODUCTS_COUNT', $listing_split->number_of_rows);
		
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
	
	(!$_GET['manufacturers_id'] && $_GET['filter_id'] > 0) ? $_GET['manufacturers_id'] = $_GET['filter_id'] : false;
	
	$query = "SELECT m.*, mi.* FROM ".TABLE_MANUFACTURERS." as m left join ".TABLE_MANUFACTURERS_INFO." as mi on mi.manufacturers_id = m.manufacturers_id where m.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and mi.languages_id = '".$_SESSION['languages_id']."'";

		$open_query = vamDBquery($query);
		$open_data = vam_db_fetch_array($open_query, true);
		$manufacturers_description = $open_data["manufacturers_description"]; 
		$module->assign('MANUFACTURERS_DESCRIPTION', $manufacturers_description);
		$module->assign('MANUFACTURERS_NAME', $open_data["manufacturers_name"]);

	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $module_content);

 	$module->assign('LINK_sort_name_asc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=name&direction=asc'));
	$module->assign('LINK_sort_name_desc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=name&direction=desc'));
	$module->assign('LINK_sort_price_asc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=price&direction=asc'));
	$module->assign('LINK_sort_price_desc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=price&direction=desc'));
	$module->assign('LINK_sort_quantity_asc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=quantity&direction=asc'));
	$module->assign('LINK_sort_quantity_desc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=quantity&direction=desc'));
	$module->assign('LINK_sort_viewed_asc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=viewed&direction=asc'));
	$module->assign('LINK_sort_viewed_desc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=viewed&direction=desc'));
	$module->assign('LINK_sort_ordered_asc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=ordered&direction=asc'));
	$module->assign('LINK_sort_ordered_desc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=ordered&direction=desc'));
	$module->assign('LINK_sort_id_asc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=id&direction=asc'));
	$module->assign('LINK_sort_id_desc',vam_href_link(basename($PHP_SELF),vam_get_all_get_params(array ('page','sort', 'direction', 'info','x','y')) . 'sort=id&direction=desc'));

	$module->assign('NAVIGATION', $navigation);
	$module->assign('NAVIGATION_PAGES', $navigation_pages);
	
  //include (DIR_WS_MODULES.FILENAME_PRODUCTS_FILTERS);	

  $news_category_id = $current_category_id;
  include (DIR_WS_MODULES.'news_product_listing.php');

  $faq_category_id = $current_category_id;
  include (DIR_WS_MODULES.'faq_product_listing.php');

  $articles_category_id = $current_category_id;
  include (DIR_WS_MODULES.'articles_product_listing.php');
  	
	// set cache ID
	 if (!CacheCheck()) {
		$module->caching = 0;
		$module = $module->fetch(CURRENT_TEMPLATE.'/module/product_listing/'.$category['listing_template']);
	} else {
		$module->caching = 0;
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