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
require_once (DIR_FS_INC.'vam_get_categories.inc.php');
require_once (DIR_FS_INC.'vam_special_categories_menu.inc.php');

$breadcrumb->add(NAVBAR_TITLE_SPECIALS);

require (DIR_WS_INCLUDES.'header.php');

//fsk18 lock
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}

$categories_id=0;
if(isset($_GET["categories_id"]) && ctype_digit(trim($_GET["categories_id"])))
  $categories_id=$_GET["categories_id"];

$specials_query_raw = "select distinct p.products_id,
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
                                and p.products_status = '1' 
                                ".$group_check."
                                ".$fsk_lock."
                                and pd.language_id = '".(int) $_SESSION['languages_id']."'
                                and s.status = '1'";
                                
  if($categories_id > 0)
	$specials_query_raw .= " and p2c.categories_id in (".vam_get_categories_ids($categories_id).$categories_id.")";
	
  $specials_query_raw .= " order by s.specials_date_added DESC";
                                  
$specials_split = new splitPageResults($specials_query_raw, $_GET['page'], MAX_DISPLAY_SPECIAL_PRODUCTS);

$module_content = array();
$row = 0;
$specials_query = vam_db_query($specials_split->sql_query);
while ($specials = vam_db_fetch_array($specials_query)) {
	$module_content[] = $product->buildDataArray($specials);
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

if (($specials_split->number_of_rows > 0)) {
	$vamTemplate->assign('NAVBAR', TEXT_RESULT_PAGE.' '.$specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$vamTemplate->assign('NAVBAR_PAGES', $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS));

}

$select_cat_specials = "SELECT DISTINCT 
  ptc.categories_id, 
  cd.categories_name 
  FROM specials s, 
  products_to_categories ptc, 
  categories_description cd,
  products p 
  WHERE ptc.products_id = s.products_id 
  AND cd.categories_id = ptc.categories_id
  AND p.products_id = s.products_id
  AND p.products_status = 1
  AND s.status = 1;";

$cat_specials_query = vamDBquery($select_cat_specials);

$cat_array[] = array('id' => '0', 'text' => TEXT_ALL_CATEGORIES);

while ($cat = vam_db_fetch_array($cat_specials_query,true)) {
    $cat_array[] = array(
        'id' => $cat['categories_id'],
        'text' => $cat['categories_name']
    );
}

$vamTemplate->assign('SPECIAL_CATEGORY', vam_draw_pull_down_menu('categories_id', $cat_array, $categories_id, 'class="form-control col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-3" onChange="location.href=\''.vam_href_link(FILENAME_SPECIALS, "categories_id='+this.value+'").'\'"'));


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