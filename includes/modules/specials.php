<?php
/* -----------------------------------------------------------------------------------------
   $Id: specials.php 1292 2007-02-06 20:41:56 VaM $   

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

require_once (DIR_FS_INC.'vam_get_categories.inc.php');

global $specials_products_category_id;
$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

//fsk18 lock
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0')
	$fsk_lock = ' and p.products_fsk18!=1';

if ((!isset ($specials_products_category_id)) || ($specials_products_category_id == '0')) {
	if (GROUP_CHECK == 'true')
		$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";

	if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
		$date_special_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_SPECIAL_PRODUCTS, date(Y)));
		//$days = " and p.products_date_added > '".$date_special_products."' ";
	}

	$specials_products_query = "select
                                           p.*,
                                           pd.*,
                                           s.specials_new_products_price
                                           from ".TABLE_PRODUCTS." p,
                                           ".TABLE_PRODUCTS_DESCRIPTION." pd,
                                           ".TABLE_SPECIALS." s where p.products_status = '1' and p.products_quantity > 0 
                                           and p.products_id = s.products_id
                                           and pd.products_id = s.products_id
                                           and pd.language_id = '".$_SESSION['languages_id']."'
                                           and s.status = '1'
                                           ".$group_check."
                                           ".$days."
                                           ".$fsk_lock."                                             
                                           order by p.products_startpage_sort ASC, p.products_id DESC limit ".MAX_DISPLAY_SPECIAL_PRODUCTS;
} else {

	if (GROUP_CHECK == 'true')
		$group_check = "and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";

	if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
		$date_special_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_SPECIAL_PRODUCTS, date(Y)));
		//$days = " and p.products_date_added > '".$date_special_products."' ";
	}
	
	$specials_products_query = "select distinct p.products_id,
                                p.label_id,
                                pd.products_name,
                                pd.products_short_description,
                                pd.products_description,
                                p.products_price,
                                p.products_tax_class_id,p.products_shippingtime,
                                p.products_image,p.products_vpe_status,p.products_vpe_value,p.products_vpe,p.products_fsk18,
                                s.specials_new_products_price from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd,
 " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, ".TABLE_SPECIALS." s, " . TABLE_CATEGORIES . " c where p2c.categories_id = c.categories_id 
 and p.products_id = p2c.products_id and 
 s.products_id = p.products_id
                                and p.products_id = pd.products_id
                                and p.products_quantity > 0 
                                and p.products_status = '1' 
                                ".$group_check."
                                ".$fsk_lock."
                                and pd.language_id = '".(int) $_SESSION['languages_id']."'
                                and s.status = '1'";
                                
  if($specials_products_category_id > 0)
	$specials_products_query .= " and p2c.categories_id in (".vam_get_categories_ids($specials_products_category_id).$specials_products_category_id.")";
	
  $specials_products_query .= " order by p.products_startpage_sort ASC, p.products_id DESC limit ".MAX_DISPLAY_SPECIAL_PRODUCTS;
                                           	
}
$row = 0;
$module_content = array ();
$specials_products_query = vamDBquery($specials_products_query);
while ($special_products = vam_db_fetch_array($specials_products_query, true)) {
	$module_content[] = $product->buildDataArray($special_products);

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
   $module->assign('SPECIALS_LINK', vam_href_link(FILENAME_SPECIALS));
	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $module_content);
	
	// set cache ID
	 if (!CacheCheck()) {
		$module->caching = 0;
		if ((!isset ($specials_products_category_id)) || ($specials_products_category_id == '0')) {
			$module = $module->fetch(CURRENT_TEMPLATE.'/module/specials_default.html');
		} else {
			$module = $module->fetch(CURRENT_TEMPLATE.'/module/specials_category.html');
		}
	} else {
		$module->caching = 1;
		$module->cache_lifetime = CACHE_LIFETIME;
		$module->cache_modified_check = CACHE_CHECK;
		$cache_id = $specials_products_category_id.$_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'];
		if ((!isset ($specials_products_category_id)) || ($specials_products_category_id == '0')) {
			$module = $module->fetch(CURRENT_TEMPLATE.'/module/specials_default.html', $cache_id);
		} else {
			$module = $module->fetch(CURRENT_TEMPLATE.'/module/specials_category.html', $cache_id);
		}
	}
	$default->assign('MODULE_specials_default', $module);
}
?>
