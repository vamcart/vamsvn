<?php
/* -----------------------------------------------------------------------------------------
   $Id: new_products.php 1292 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_products.php,v 1.33 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (new_products.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (new_products.php,v 1.9 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

//fsk18 lock
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0')
	$fsk_lock = ' and p.products_fsk18!=1';

if ((!isset ($new_products_category_id)) || ($new_products_category_id == '0')) {
	if (GROUP_CHECK == 'true')
		$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";

	if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
		$date_new_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_NEW_PRODUCTS_DAYS, date(Y)));
		//$days = " and p.products_date_added > '".$date_new_products."' ";
	}

	$new_products_query = "SELECT distinct * FROM
	                                        ".TABLE_PRODUCTS." p,
	                                        ".TABLE_PRODUCTS_DESCRIPTION." pd,
	                                        ".TABLE_PRODUCTS_TO_CATEGORIES." p2c,
	                                        ".TABLE_CATEGORIES." c,
	                                        ".TABLE_CATEGORIES_DESCRIPTION." cd
	                                        where c.categories_status='1'
	                                        and p.products_startpage = '1'
	                                        and p.products_quantity > 0  
	                                        and p.products_id = p2c.products_id and p.products_id=pd.products_id
	                                        and p2c.categories_id = c.categories_id
	                                        and cd.categories_id = c.categories_id
	                                        ".$group_check."
	                                        ".$days."
	                                        ".$fsk_lock."
	                                        and p.products_status = '1' and p.products_quantity > 0 and pd.language_id = '".(int) $_SESSION['languages_id']."' and cd.language_id = '".(int) $_SESSION['languages_id']."'
	                                        group by p.products_id
	                                        order by p.products_id DESC limit ".MAX_DISPLAY_NEW_PRODUCTS;
} else {

	if (GROUP_CHECK == 'true')
		$group_check = "and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";

	if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
		$date_new_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_NEW_PRODUCTS_DAYS, date(Y)));
		//$days = " and p.products_date_added > '".$date_new_products."' ";
	}
	$new_products_query = "SELECT distinct * FROM
	                                        ".TABLE_PRODUCTS." p,
	                                        ".TABLE_PRODUCTS_DESCRIPTION." pd,
	                                        ".TABLE_PRODUCTS_TO_CATEGORIES." p2c,
	                                        ".TABLE_CATEGORIES." c
	                                        where c.categories_status='1'
	                                        and p.products_id = p2c.products_id and p.products_id=pd.products_id
	                                        and p2c.categories_id = c.categories_id
	                                        ".$group_check."
	                                        ".$days."
	                                        ".$fsk_lock."
	                                        and c.parent_id = '".$new_products_category_id."'
	                                        and p.products_status = '1' and p.products_quantity > 0 and pd.language_id = '".(int) $_SESSION['languages_id']."'
	                                        group by p.products_id
	                                        order by p.products_id DESC limit ".MAX_DISPLAY_NEW_PRODUCTS;
}
$row = 0;
$module_content = array ();
$new_products_query = vamDBquery($new_products_query);
while ($new_products = vam_db_fetch_array($new_products_query, true)) {
	$module_content[] = $product->buildDataArray($new_products);

}

if (PRODUCT_LISTING_ATTRIBUTES == 'true') {

// Attributes start
foreach($module_content as $k => $m)
{
$pID = $module_content[$k]['PRODUCTS_ID'];
if (vam_has_product_attributes($pID)) {
$products_options_name_query = vamDBquery("select distinct popt.products_options_id, popt.products_options_name,popt.products_options_type,popt.products_options_length,popt.products_options_rows,popt.products_options_size from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".$pID."' and patrib.options_id = popt.products_options_id and popt.language_id = '".(int) $_SESSION['languages_id']."' order by popt.products_options_name");
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

if (sizeof($module_content) >= 1) {
   $module->assign('NEW_PRODUCTS_LINK', vam_href_link(FILENAME_PRODUCTS_NEW));
	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $module_content);
	
	// set cache ID
	 if (!CacheCheck()) {
		$module->caching = 0;
		if ((!isset ($new_products_category_id)) || ($new_products_category_id == '0')) {
			$module = $module->fetch(CURRENT_TEMPLATE.'/module/new_products_default.html');
		} else {
			$module = $module->fetch(CURRENT_TEMPLATE.'/module/new_products_category.html');
		}
	} else {
		$module->caching = 1;
		$module->cache_lifetime = CACHE_LIFETIME;
		$module->cache_modified_check = CACHE_CHECK;
		$cache_id = $new_products_category_id.$_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'];
		if ((!isset ($new_products_category_id)) || ($new_products_category_id == '0')) {
			$module = $module->fetch(CURRENT_TEMPLATE.'/module/new_products_default.html', $cache_id);
		} else {
			$module = $module->fetch(CURRENT_TEMPLATE.'/module/new_products_category.html', $cache_id);
		}
	}
	$default->assign('MODULE_new_products', $module);
}
?>
