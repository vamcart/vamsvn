<?php
/* -----------------------------------------------------------------------------------------
   $Id: print_product_info.php 1282 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_info.php,v 1.94 2003/05/04); www.oscommerce.com 
   (c) 2003	 nextcommerce (print_product_info.php,v 1.16 2003/08/25); www.nextcommerce.org
   (c) 2004	 xt:Commerce (print_product_info.php,v 1.16 2003/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

if (!isset($_GET['products_id'])) { 
	header('HTTP/1.1 404 Not Found');
	vam_redirect(vam_href_link(FILENAME_DEFAULT));
}

// include needed functions
require_once (DIR_FS_INC.'vam_get_products_mo_images.inc.php');
require_once (DIR_FS_INC.'vam_get_vpe_name.inc.php');

$vamTemplate = new vamTemplate;

include ('includes/header.php');

$product_info_query = vam_db_query("select * FROM ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_status = '1' and p.products_id = '".(int) $_GET['products_id']."' and pd.products_id = p.products_id and pd.language_id = '".(int) $_SESSION['languages_id']."'");
$product_info = vam_db_fetch_array($product_info_query);

$products_price = $vamPrice->GetPrice($product_info['products_id'], $format = true, 1, $product_info['products_tax_class_id'], $product_info['products_price'], 1);

$products_attributes_query = vam_db_query("select count(*) as total from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".(int) $_GET['products_id']."' and patrib.options_id = popt.products_options_id and popt.language_id = '".(int) $_SESSION['languages_id']."'");
$products_attributes = vam_db_fetch_array($products_attributes_query);
if ($products_attributes['total'] > 0) {
	$products_options_name_query = vam_db_query("select distinct popt.products_options_id, popt.products_options_name from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".(int) $_GET['products_id']."' and patrib.options_id = popt.products_options_id and popt.language_id = '".(int) $_SESSION['languages_id']."' order by popt.products_options_name");
	while ($products_options_name = vam_db_fetch_array($products_options_name_query)) {
		$selected = 0;

		$products_options_query = vam_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix,pa.attributes_stock, pa.attributes_model from ".TABLE_PRODUCTS_ATTRIBUTES." pa, ".TABLE_PRODUCTS_OPTIONS_VALUES." pov where pa.products_id = '".(int) $_GET['products_id']."' and pa.options_id = '".$products_options_name['products_options_id']."' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '".(int) $_SESSION['languages_id']."'");
		while ($products_options = vam_db_fetch_array($products_options_query)) {
			$module_content[] = array ('GROUP' => $products_options_name['products_options_name'], 'NAME' => $products_options['products_options_values_name']);

			if ($products_options['options_values_price'] != '0') {

				if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) {
					$tax_rate = $vamPrice->TAX[$product_info['products_tax_class_id']];
					$products_options['options_values_price'] = vam_add_tax($products_options['options_values_price'], $vamPrice->TAX[$product_info['products_tax_class_id']]);
				}
				if ($_SESSION['customers_status']['customers_status_show_price'] == 1) {
					$module_content[sizeof($module_content) - 1]['NAME'] .= ' ('.$products_options['price_prefix'].$vamPrice->Format($products_options['options_values_price'], true,0,true).')';
				}
			}
		}
	}
}

// assign language to template for caching
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('charset', $_SESSION['language_charset']);
$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

                      $extra_fields_query = vamDBquery("
                      SELECT pef.products_extra_fields_status as status, pef.products_extra_fields_name as name, ptf.products_extra_fields_value as value
                      FROM ". TABLE_PRODUCTS_EXTRA_FIELDS ." pef
             LEFT JOIN  ". TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS ." ptf
            ON ptf.products_extra_fields_id=pef.products_extra_fields_id
            WHERE ptf.products_id=". (int) $_GET['products_id'] ." and ptf.products_extra_fields_value<>'' and (pef.languages_id='0' or pef.languages_id='".$_SESSION['languages_id']."')
            ORDER BY products_extra_fields_order");

  while ($extra_fields = vam_db_fetch_array($extra_fields_query,true)) {
        if (! $extra_fields['status'])  // show only enabled extra field
           continue;
  
  $extra_fields_data[] = array (
  'NAME' => $extra_fields['name'], 
  'VALUE' => $extra_fields['value']
  );
  
  }

  $vamTemplate->assign('extra_fields_data', $extra_fields_data);
  
$image = '';
if ($product_info['products_image'] != '') {
	$image = DIR_WS_CATALOG.DIR_WS_INFO_IMAGES.$product_info['products_image'];
}
if ($_SESSION['customers_status']['customers_status_show_price'] != 0) {
	$tax_rate = $vamPrice->TAX[$product_info['products_tax_class_id']];
	// price incl tax
	if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] != 0) {
		$vamTemplate->assign('PRODUCTS_TAX_INFO', sprintf(TAX_INFO_INCL, $tax_rate.' %'));
	}
	// excl tax + tax at checkout
	if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		$vamTemplate->assign('PRODUCTS_TAX_INFO', sprintf(TAX_INFO_ADD, $tax_rate.' %'));
	}
	// excl tax
	if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) {
		$vamTemplate->assign('PRODUCTS_TAX_INFO', sprintf(TAX_INFO_EXCL, $tax_rate.' %'));
	}
}
$vamTemplate->assign('PRODUCTS_NAME', $product_info['products_name']);
$vamTemplate->assign('PRODUCTS_EAN', $product_info['products_ean']);
$vamTemplate->assign('PRODUCTS_QUANTITY', $product_info['products_quantity']);
$vamTemplate->assign('PRODUCTS_WEIGHT', $product_info['products_weight']);
$vamTemplate->assign('PRODUCTS_STATUS', $product_info['products_status']);
$vamTemplate->assign('PRODUCTS_ORDERED', $product_info['products_ordered']);
$vamTemplate->assign('PRODUCTS_MODEL', $product_info['products_model']);
$vamTemplate->assign('PRODUCTS_DESCRIPTION', $product_info['products_description']);
$vamTemplate->assign('PRODUCTS_IMAGE', $image);
$vamTemplate->assign('PRODUCTS_PRICE', $products_price['formated']);
if (ACTIVATE_SHIPPING_STATUS == 'true') {
	$vamTemplate->assign('SHIPPING_NAME', $main->getShippingStatusName($product_info['products_shippingtime']));
	if ($shipping_status['image'] != '')
		$vamTemplate->assign('SHIPPING_IMAGE', $main->getShippingStatusImage($product_info['products_shippingtime']));
}
if (SHOW_SHIPPING == 'true')
	$vamTemplate->assign('PRODUCTS_SHIPPING_LINK', ' '.SHIPPING_EXCL.'<a href="javascript:newWin=void(window.open(\''.vam_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS).'\', \'popup\', \'toolbar=0, width=640, height=600\'))"> '.SHIPPING_COSTS.'</a>');	
		

$discount = 0.00;
if ($_SESSION['customers_status']['customers_status_public'] == 1 && $_SESSION['customers_status']['customers_status_discount'] != '0.00') {
	$discount = $_SESSION['customers_status']['customers_status_discount'];
	if ($product_info['products_discount_allowed'] < $_SESSION['customers_status']['customers_status_discount'])
		$discount = $product_info['products_discount_allowed'];
	if ($discount != '0.00')
		$vamTemplate->assign('PRODUCTS_DISCOUNT', $discount.'%');
}

if ($product_info['products_vpe_status'] == 1 && $product_info['products_vpe_value'] != 0.0 && $products_price['plain'] > 0)
	$vamTemplate->assign('PRODUCTS_VPE', $vamPrice->Format($products_price['plain'] * (1 / $product_info['products_vpe_value']), true).TXT_PER.vam_get_vpe_name($product_info['products_vpe']));
$vamTemplate->assign('module_content', $module_content);

		$mo_images = vam_get_products_mo_images($product_info['products_id']);
        if ($mo_images != false) {
    $vamTemplate->assign('PRODUCTS_MO_IMAGES', $mo_images);
            foreach ($mo_images as $img) {
                $mo_img[] = array(
                'PRODUCTS_MO_IMAGE' => DIR_WS_CATALOG.DIR_WS_INFO_IMAGES . $img['image_name']
                );
        $vamTemplate->assign('mo_img', $mo_img);
            }
        }
		//mo_images EOF

// Parameters start

    $parameters_query = vamDBquery("SELECT * FROM ".TABLE_PRODUCTS_PARAMETERS2PRODUCTS." LEFT JOIN ".TABLE_PRODUCTS_PARAMETERS." using(products_parameters_id) WHERE products_id = ".(int) $_GET['products_id']." and products_parameters.products_parameters_id is not null and products_parameters_order >= 0 and products_parameters2products_order >= 0 order by IF(products_parameters2products_order > 0, products_parameters2products_order, products_parameters_order)");

    $parameters = array();
    $i = 0;
    while ($parameters_data = vam_db_fetch_array($parameters_query, true))
    {
        $i = $parameters_data['products_parameters_id'];

        $parameters[$i]["parameters_id"] = $parameters_data["products_parameters_id"];
        $parameters[$i]["parameters_name"] = $parameters_data["products_parameters_name"];
        $parameters[$i]["parameters_suff"] = $parameters_data["products_parameters_titlesuff"];
        $parameters[$i]["parameters_group"] = $parameters_data["products_parameters_group"];
        $parameters[$i]["is_group"] = $parameters_data["products_parameters_type"] == 'g';
        $parameters[$i]["parameters_value"] = $parameters_data["products_parameters2products_value"];
        $i++;
    }

    foreach($parameters as $i => $p)
    {
        foreach(array($product->data['products_id']) as $id)
        {
            if (!isset($parameters[$i]["parameters_values"][$id]))  $parameters[$i]["parameters_values"][$id] = "";
        }
    }


    $temp = array();
    foreach($parameters as $k => $p)
    {
        if ($p["parameters_group"] == 0) $temp[$p["parameters_id"]] = $p;
    }
    $parameters_query = vamDBquery("SELECT * FROM ".TABLE_PRODUCTS_PARAMETERS." WHERE products_parameters_type = 'g' order by products_parameters_order");
    while ($parameters_data = vam_db_fetch_array($parameters_query, true))
    {
        $parameters_data["is_group"] = $parameters_data["products_parameters_type"] == 'g';
        foreach($parameters as $k => $p)
        {
            if ($p["parameters_group"] == $parameters_data["products_parameters_id"])
            {
                if (!is_array($temp[$parameters_data["products_parameters_id"]]))
                {
                    $temp[$parameters_data["products_parameters_id"]] = array("parameters_id" => $parameters_data["products_parameters_id"],
                                                                              "parameters_name" => $parameters_data["products_parameters_name"],
                                                                              "is_group" => $parameters_data["is_group"]);
                }
                $temp[$p["parameters_id"]] = $p;
            }
        }
    }
    $parameters = $temp;
    $vamTemplate->assign('parameters', $parameters);

// Parameters end

// set cache ID
 if (!CacheCheck()) {
	$vamTemplate->caching = 0;
} else {
	$vamTemplate->caching = 1;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
}
$cache_id = $_SESSION['language'].'_'.$product_info['products_id'];

$vamTemplate->display(CURRENT_TEMPLATE.'/module/print_product_info.html', $cache_id);
?>