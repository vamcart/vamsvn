<?php
/* -----------------------------------------------------------------------------------------
   $Id: product_compare.php 1124 2009-04-29 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   for VaM Shop by Darth AleX
   
   input: GET,  products[]=ID&products[]=ID...&products[]=ID - max 5 int

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

//include needed functions
require_once (DIR_FS_INC.'vam_check_categories_status.inc.php');
require_once (DIR_FS_INC.'vam_get_products_mo_images.inc.php');
require_once (DIR_FS_INC.'vam_get_vpe_name.inc.php');
require_once (DIR_FS_INC.'get_cross_sell_name.inc.php');

$info = new vamTemplate;
$info->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$module_content = false;


$temp = array();
//$_REQUEST["products"] = array(3259, 1624);
if (is_array($_REQUEST["products"]))
{
    foreach($_REQUEST["products"] as $v)
    {
        if (is_numeric(intval(trim($v)))) $temp[] = $v;
    }
}

if (is_array($temp) && sizeof($temp) > 0)
{
    $products_query = vamDBquery("SELECT
                                     *
                                     FROM ".TABLE_PRODUCTS." p,
                                     ".TABLE_PRODUCTS_DESCRIPTION." pd
                                     WHERE p.products_id IN (".implode(", ", $temp).") and 
                                     p.products_id = pd.products_id
                                     and pd.language_id = '".(int) $_SESSION['languages_id']."'
                                     and p.products_status=1 order by products_name limit 5");
    $c_id = array();
    $temp_parameters = array();
    while ($products_data = vam_db_fetch_array($products_query, true))
    {
        $module_content[] =  $product->buildDataArray($products_data);
        $temp_parameters[$products_data['products_id']] = array();
        $c_id[] = $products_data['products_id'];
    }
    
    if (is_array($c_id) && sizeof($c_id) > 0)
    {
        $cats = vamDBquery("SELECT DISTINCT MAX(categories_id) as categories_id FROM products_to_categories WHERE products_id IN (".implode(", ", $c_id).") GROUP by products_id");
        $temp = array(-1);
	    while ($c = vam_db_fetch_array($cats, true))
	    {
	        $temp[] =  $c['categories_id'];
	    }

        $parameters_query = vamDBquery("SELECT * FROM `products_parameters2products`
        LEFT JOIN `products_parameters` using(products_parameters_id)
        WHERE products_id IN (".implode(", ", $c_id).") and categories_id IN (".implode(", ", $temp).") and 
        products_parameters.products_parameters_id is not null and
        products_parameters_order >= 0 and
        products_parameters2products_order >= 0
        order by IF(products_parameters2products_order > 0, products_parameters2products_order, products_parameters_order)");

        $parameters = array();
        $i = 0;
        while ($parameters_data = vam_db_fetch_array($parameters_query, true))
        {
            $i = $parameters_data['products_parameters_id'];
            
            $parameters[$i]["parameters_id"] = $parameters_data["products_parameters_id"];
            $parameters[$i]["parameters_name"] = $parameters_data["products_parameters_title"];
            $parameters[$i]["parameters_group"] = $parameters_data["products_parameters_group"];
            $parameters[$i]["is_group"] = $parameters_data["products_parameters_type"] == 'g';
            if (!is_array($parameters[$i]["parameters_values"]))
            {
                $parameters[$i]["parameters_values"] = $temp_parameters;
            }
            $parameters[$i]["parameters_values"][$parameters_data['products_id']] = array("value" => $parameters_data["products_parameters2products_value"]);
            $i++;
        }
    }
    
    if (is_array($parameters) && sizeof($parameters) > 0)
    {
        foreach($parameters as $i => $p)
        {
            foreach($c_id as $id)
            {
                if (!isset($parameters[$i]["parameters_values"][$id]))  $parameters[$i]["parameters_values"][$id] = "";
            }
        }
        
        
        $temp = array();
        foreach($parameters as $k => $p)
        {
            if ($p["parameters_group"] == 0) $temp[$p["parameters_id"]] = $p;
        }
    }
    
    $parameters_query = vamDBquery("SELECT * FROM `products_parameters` WHERE products_parameters_type = 'g' order by products_parameters_order");
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
}

if (!is_array($module_content) || sizeof($module_content) == 0) { // products not found in database
    $error = TEXT_PRODUCT_NOT_FOUND;
    include (DIR_WS_MODULES.FILENAME_ERROR_HANDLER);
} else {
    
    $info->assign('language', $_SESSION['language']);
    $info->assign('module_content', $module_content);
    $info->assign('parameters', $parameters);
    
    // set cache ID
     if (!CacheCheck()) {
        $info->caching = 0;
        $product_info = $info->fetch(CURRENT_TEMPLATE.'/module/product_compare.html');
    } else {
        $info->caching = 1;
        $info->cache_lifetime = CACHE_LIFETIME;
        $info->cache_modified_check = CACHE_CHECK;
        $cache_id = implode(".", $c_id).$_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'];
        $product_info = $info->fetch(CURRENT_TEMPLATE.'/module/product_compare.html', $cache_id);
    }
    
    $vamTemplate->assign('main_content', $product_info);    
}
?>