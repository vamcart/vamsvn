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

$breadcrumb->add(NAVBAR_TITLE_PRODUCTS_NEW);

require (DIR_WS_INCLUDES.'header.php');

//fsk18 lock
$fsk_lock = '';
$days = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}
if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
	//$date_new_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_NEW_PRODUCTS_DAYS, date(Y)));
	//$days = " and p.products_date_added > '".$date_new_products."' ";
}
	$products_new_query_raw = "select distinct
	                                    p.*, pd.*, cd.*, m.* 
	                                    from " . TABLE_PRODUCTS . " p
	                                    left join " . TABLE_MANUFACTURERS . " m
	                                    on p.manufacturers_id = m.manufacturers_id
	                                    left join " . TABLE_PRODUCTS_DESCRIPTION . " pd
	                                    on p.products_id = pd.products_id,
                                       ".TABLE_PRODUCTS_TO_CATEGORIES." p2c,
                                       ".TABLE_CATEGORIES." c,
                                       ".TABLE_CATEGORIES_DESCRIPTION." cd
	                                    WHERE pd.language_id = '" . (int) $_SESSION['languages_id'] . "'
	                                    and c.categories_status=1
                                       and cd.categories_id = c.categories_id
	                                    and p.products_id = p2c.products_id
	                                    and c.categories_id = p2c.categories_id
	                                    and products_quantity > 0 
	                                    and products_status = '1'
	                                    " . $group_check . "
	                                    " . $fsk_lock . "                                    
	                                    " . $days . "
	                                    group by p.products_id order
	                                    by
	                                    p.products_date_added DESC ";
$products_new_split = new splitPageResults($products_new_query_raw, $_GET['page'], MAX_DISPLAY_PRODUCTS_NEW);

$module_content = array();
$row = 0;
$products_new_query = vam_db_query($products_new_split->sql_query);
while ($products_new = vam_db_fetch_array($products_new_query)) {
	$module_content[] = $product->buildDataArray($products_new);
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
		//=======================================================================
		$products_options_photo_1 = $products_options['photo_1'];
		$products_options_photo_2 = $products_options['photo_2'];
		/*
			if($products_options['photo_1'] == '')
				$$products_options_photo_1 = DIR_WS_IMAGES.'product_attributes_images/'.'no_attribute_image.gif';
			else
				$products_options_photo_1 = DIR_WS_IMAGES.'product_attributes_images/'.$products_options['photo_1'];
			if($products_options['photo_2'] == '')
				$products_options_photo_2 = DIR_WS_IMAGES.'product_attributes_images/'.'no_attribute_image.gif';
			else
				$products_options_photo_2 = DIR_WS_IMAGES.'product_attributes_images/'.$products_options['photo_2'];
		*/
				
			if($products_options_photo_1 == 'no_attribute_image.gif' OR $products_options_photo_1 == '')
				$products_options_photo_1 = '';
			else
				$products_options_photo_1 = DIR_WS_IMAGES.'product_attributes_images/'.$products_options['photo_1'];
			if($products_options_photo_2 == 'no_attribute_image.gif' OR $products_options_photo_2 == '')
				$products_options_photo_2 = '';
			else
				$products_options_photo_2 = DIR_WS_IMAGES.'product_attributes_images/'.$products_options['photo_2'];
		//======================================================================
			if ($_SESSION['customers_status']['customers_status_show_price'] == '0') 
			{
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
				// added by itskander
				'PHOTO_1' => $products_options_photo_1,
				'PHOTO_2' => $products_options_photo_2
				);
			
				$price = '';
				$full_price = '';
			} 
			else 
			{
				if ($products_options['options_values_price'] != '0.00') 
				{
//					$price = $vamPrice->Format($products_options['options_values_price'], false, $product->data['products_tax_class_id']);
					$price = $vamPrice->GetOptionPrice($module_content[$k]['PRODUCTS_ID'], $products_options_name['products_options_id'], $products_options['products_options_values_id']);
					$price = $price['price'];
				}
				$products_price = $vamPrice->GetPrice($module_content[$k]['PRODUCTS_ID'], $format = false, 1, $module_content[$k]['PRODUCTS_TAX_INFO'], $module_content[$k]['PRODUCTS_PRICE']);
				if ($_SESSION['customers_status']['customers_status_discount_attributes'] == 1 && $products_options['price_prefix'] == '+')
					$price -= $price / 100 * $discount;				
					$attr_price=$price;
					//if ($products_options['price_prefix']=="-") { $attr_price=$price*(-1); $price=$attr_price; }
					$full_price = $products_price + $attr_price;
					//------ 02-08-2016 ---------
					$vpe_price = $full_price/$module_content[$k]['PRODUCTS_VPE_VALUE'];
					//---------------------------
					$price_plain = $vamPrice->Format($price, false);
					$price = $vamPrice->Format($price, true);
					$full_price = $vamPrice->Format($full_price, true);
					//------ 02-08-2016 ---------
					$vpe_price = $module_content[$k]['PRODUCTS_VPE'];
					//---------------------------------------
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
			'FULL_PRICE' => $full_price, 
			//--- 02-08-2016 -----------
			'VPE_PRICE' => $vpe_price,
			//-------------------------
			'PREFIX' => $products_options['price_prefix'],
			// added by mosq
            'CHECKED' => $checked,
			// added by itskander
			'PHOTO_1' => $products_options_photo_1,
			'PHOTO_2' => $products_options_photo_2
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

if (($products_new_split->number_of_rows > 0)) {
	$vamTemplate->assign('NAVIGATION_BAR', TEXT_RESULT_PAGE.' '.$products_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$vamTemplate->assign('NAVIGATION_BAR_PAGES', $products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW));
	$vamTemplate->assign('NAVIGATION_BOOTSTRAP', $products_new_split->display_links_bootstrap(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$vamTemplate->assign('NAVIGATION_COMPACT', $products_new_split->display_links_compact(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('module_content', $module_content);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/new_products_overview.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_PRODUCTS_NEW.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_PRODUCTS_NEW.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>