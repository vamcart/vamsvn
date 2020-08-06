<?php
/* -----------------------------------------------------------------------------------------
   $Id: news.php 1292 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_products.php,v 1.33 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (new_products.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (new_products.php,v 1.9 2003/08/17); www.xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

global $faq_category_id;

$module_listing = new vamTemplate;
$module_listing->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

if ((!isset ($faq_category_id)) || ($faq_category_id == '0')) {
	
$sql_faq = "
    SELECT
        *
    FROM " . TABLE_FAQ . "
    WHERE
         status = '1'
         and language = '" . (int)$_SESSION['languages_id'] . "'
    ORDER BY date_added DESC
    LIMIT " . MAX_DISPLAY_FAQ . "
    ";

} else {

$sql_faq = "
    SELECT
        f.*
    FROM " . TABLE_FAQ . " f , " . TABLE_FAQ_TO_CATEGORIES . " f2c
    WHERE
         f2c.categories_id = '" . (int)$faq_category_id . "'
         and f.faq_id = f2c.faq_id 
         and f.status = '1'
         and f.language = '" . (int)$_SESSION['languages_id'] . "'
    ORDER BY f.date_added DESC
    LIMIT " . MAX_DISPLAY_FAQ . "
    ";
    
}

$row = 0;
$module_listing_content_faq = array ();


if ($faq_category_id > 0) {

    $faq_category_name_query = "select
                                      c.categories_id,
                                      cd.categories_name
                                      from " . TABLE_CATEGORIES . " c,
                                       " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                       where c.categories_id = '" . vam_db_input($faq_category_id) . "'
                                       and c.categories_id = cd.categories_id
                                       and c.categories_status != 0
                                       and cd.language_id = '" . $_SESSION['languages_id'] . "'
                                       order by sort_order, cd.categories_name";

    $faq_category_name_query  = vamDBquery($faq_category_name_query);

    $faq_category_name = vam_db_fetch_array($faq_category_name_query,true);

    // sorting query
    $faq_sorting_query = vamDBquery("SELECT products_sorting,
                                                products_sorting2 FROM ".TABLE_CATEGORIES."
                                                where categories_id='".$faq_category_id."'");
    $faq_sorting_data = vam_db_fetch_array($faq_sorting_query,true);
    my_sorting_products($faq_sorting_data);
    if (!$faq_sorting_data['products_sorting'] or $faq_sorting_data['products_sorting']== 'p.products_sort') {
    $faq_sorting_data['products_sorting'] = 'p.products_ordered DESC, p.products_id DESC';
    $faq_sorting_data['products_sorting2'] = '';
    }
    $faq_sorting = ' GROUP BY p.products_id ORDER BY '.$faq_sorting_data['products_sorting'].' '.$faq_sorting_data['products_sorting2'].' ';
    // We show them all
    if (GROUP_CHECK == 'true') {
    $group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
    }
    if (PRODUCT_LIST_RECURSIVE == 'true') {
    $faq_recursive_check= "and (p2c.categories_id = '".$faq_category_id."' AND p2c.categories_id = c.categories_id OR p2c.categories_id = c.categories_id AND c.parent_id = '".$faq_category_id."')";
    $faq_recursive_table_categories=TABLE_CATEGORIES." c, ";
    } else {
    $faq_recursive_check="and p2c.categories_id = '".$faq_category_id."'";
    $faq_recursive_table_categories="";
    }
    $faq_listing_sql = "select p.products_fsk18,
                                  p.products_shippingtime,
                                  p.products_model,
                                  p.label_id,
                                  p.products_ean,
                                  pd.products_name,
                                  m.manufacturers_name,
                                  p.products_quantity,
                                  p.products_image,
                                  p.products_length,
                                  p.products_width,
                                  p.products_height,
                                  p.products_volume,
                                  p.products_weight,
                                  pd.products_short_description,
                                  pd.products_description,
                                  p.products_id,
                                  p.manufacturers_id,
                                  p.products_price,
                                  p.products_vpe,
                                  p.products_vpe_status,
                                  p.products_vpe_value,                             
                                  p.products_discount_allowed,
                                  p.products_tax_class_id
                                  from  ".$faq_recursive_table_categories.TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_PRODUCTS." p left join ".TABLE_MANUFACTURERS." m on p.manufacturers_id = m.manufacturers_id
                                  left join ".TABLE_SPECIALS." s on p.products_id = s.products_id
                                  where p.products_status = '1'
                                  and p.products_id = p2c.products_id
                                  and pd.products_id = p2c.products_id
                                  ".$faq_group_check."
                                  ".$faq_fsk_lock."                             
                                  and pd.language_id = '".(int) $_SESSION['languages_id']."' "
                                  .$faq_recursive_check
                                  .$faq_sorting. " limit 5";
          
	$faq_listing_query = vamDBquery($faq_listing_sql);
	while ($faq_listing = vam_db_fetch_array($faq_listing_query, true)) {
		$rows ++;
		$faq_products_content[] =  $product->buildDataArray($faq_listing);		
	}                                  
    
//echo $faq_listing_sql;    
    
//echo var_dump($faq_products_content);    

}

if ($faq_category_id > 0) {

    // sorting query
    $faq_discount_sorting_query = vamDBquery("SELECT products_sorting,
                                                products_sorting2 FROM ".TABLE_CATEGORIES."
                                                where categories_id='".$faq_category_id."'");
    $faq_discount_sorting_data = vam_db_fetch_array($faq_discount_sorting_query,true);
    my_sorting_products($faq_discount_sorting_data);
    if (!$faq_discount_sorting_data['products_sorting'] or $faq_discount_sorting_data['products_sorting']== 'p.products_sort') {
    $faq_discount_sorting_data['products_sorting'] = 'p.products_price ASC, p.products_id DESC';
    $faq_discount_sorting_data['products_sorting2'] = '';
    }
    $faq_discount_sorting = ' GROUP BY p.products_id ORDER BY '.$faq_discount_sorting_data['products_sorting'].' '.$faq_discount_sorting_data['products_sorting2'].' ';
    // We show them all
    if (GROUP_CHECK == 'true') {
    $group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
    }
    if (PRODUCT_LIST_RECURSIVE == 'true') {
    $faq_discount_recursive_check= "and (p2c.categories_id = '".$faq_category_id."' AND p2c.categories_id = c.categories_id OR p2c.categories_id = c.categories_id AND c.parent_id = '".$faq_category_id."')";
    $faq_discount_recursive_table_categories=TABLE_CATEGORIES." c, ";
    } else {
    $faq_discount_recursive_check="and p2c.categories_id = '".$faq_category_id."'";
    $faq_discount_recursive_table_categories="";
    }
    $faq_discount_listing_sql = "select p.products_fsk18,
                                  p.products_shippingtime,
                                  p.products_model,
                                  p.label_id,
                                  p.products_ean,
                                  pd.products_name,
                                  m.manufacturers_name,
                                  p.products_quantity,
                                  p.products_image,
                                  p.products_length,
                                  p.products_width,
                                  p.products_height,
                                  p.products_volume,
                                  p.products_weight,
                                  pd.products_short_description,
                                  pd.products_description,
                                  p.products_id,
                                  p.manufacturers_id,
                                  p.products_price,
                                  p.products_vpe,
                                  p.products_vpe_status,
                                  p.products_vpe_value,                             
                                  p.products_discount_allowed,
                                  p.products_tax_class_id
                                  from  ".$faq_discount_recursive_table_categories.TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_PRODUCTS." p left join ".TABLE_MANUFACTURERS." m on p.manufacturers_id = m.manufacturers_id
                                  left join ".TABLE_SPECIALS." s on p.products_id = s.products_id
                                  where p.products_status = '1'
                                  and p.products_id = p2c.products_id
                                  and pd.products_id = p2c.products_id
                                  ".$faq_discount_group_check."
                                  ".$faq_discount_fsk_lock."                             
                                  and pd.language_id = '".(int) $_SESSION['languages_id']."' "
                                  .$faq_discount_recursive_check
                                  .$faq_discount_sorting. " limit 5";
          
	$faq_discount_listing_query = vamDBquery($faq_discount_listing_sql);
	while ($faq_discount_listing = vam_db_fetch_array($faq_discount_listing_query, true)) {
		$rows ++;
		$faq_discount_products_content[] =  $product->buildDataArray($faq_discount_listing);		
	}                                  
    
//echo $faq_discount_listing_sql;    
    
//echo var_dump($faq_discount_products_content);    

}
$query_faq = vamDBquery($sql_faq);
while ($one_faq = vam_db_fetch_array($query_faq,true)) {

$faqI=0; $faqIcon='';
//echo strpos($one_faq['answer'],'src="')." ";
if ($faqI=strpos($one_faq['answer'],'src="')) {
	$faqI=$faqI+5;
	$faqIcon=substr ($one_faq['answer'] , $faqI);
	$faqI=strpos($faqIcon,'"');
	$faqIcon= substr($faqIcon, 0, $faqI);
//echo "<pre>".$qIcon."</pre>";
}

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&headline='.vam_cleanName($one_faq['question']);

$answer = $one_faq['answer'];
$answer = str_replace('{$CATEGORY_NAME}', mb_strtolower($faq_category_name['categories_name']), $answer);
$answer = str_replace('{$PRODUCT_POPULAR_NAME_1}', $faq_products_content[0]['PRODUCTS_NAME'], $answer);
$answer = str_replace('{$PRODUCT_POPULAR_LINK_1}', $faq_products_content[0]['PRODUCTS_LINK'], $answer);
$answer = str_replace('{$PRODUCT_POPULAR_NAME_2}', $faq_products_content[1]['PRODUCTS_NAME'], $answer);
$answer = str_replace('{$PRODUCT_POPULAR_LINK_2}', $faq_products_content[1]['PRODUCTS_LINK'], $answer);
$answer = str_replace('{$PRODUCT_POPULAR_NAME_3}', $faq_products_content[2]['PRODUCTS_NAME'], $answer);
$answer = str_replace('{$PRODUCT_POPULAR_LINK_3}', $faq_products_content[2]['PRODUCTS_LINK'], $answer);
$answer = str_replace('{$PRODUCT_POPULAR_NAME_4}', $faq_products_content[3]['PRODUCTS_NAME'], $answer);
$answer = str_replace('{$PRODUCT_POPULAR_LINK_4}', $faq_products_content[3]['PRODUCTS_LINK'], $answer);
$answer = str_replace('{$PRODUCT_POPULAR_NAME_5}', $faq_products_content[4]['PRODUCTS_NAME'], $answer);
$answer = str_replace('{$PRODUCT_POPULAR_LINK_5}', $faq_products_content[4]['PRODUCTS_LINK'], $answer);
$answer = str_replace('{$PRODUCT_DISCOUNT_NAME_1}', $faq_discount_products_content[0]['PRODUCTS_NAME'], $answer);
$answer = str_replace('{$PRODUCT_DISCOUNT_LINK_1}', $faq_discount_products_content[0]['PRODUCTS_LINK'], $answer);
$answer = str_replace('{$PRODUCT_DISCOUNT_NAME_2}', $faq_discount_products_content[1]['PRODUCTS_NAME'], $answer);
$answer = str_replace('{$PRODUCT_DISCOUNT_LINK_2}', $faq_discount_products_content[1]['PRODUCTS_LINK'], $answer);
$answer = str_replace('{$PRODUCT_DISCOUNT_NAME_3}', $faq_discount_products_content[2]['PRODUCTS_NAME'], $answer);
$answer = str_replace('{$PRODUCT_DISCOUNT_LINK_3}', $faq_discount_products_content[2]['PRODUCTS_LINK'], $answer);
$answer = str_replace('{$PRODUCT_DISCOUNT_NAME_4}', $faq_discount_products_content[3]['PRODUCTS_NAME'], $answer);
$answer = str_replace('{$PRODUCT_DISCOUNT_LINK_4}', $faq_discount_products_content[3]['PRODUCTS_LINK'], $answer);
$answer = str_replace('{$PRODUCT_DISCOUNT_NAME_5}', $faq_discount_products_content[4]['PRODUCTS_NAME'], $answer);
$answer = str_replace('{$PRODUCT_DISCOUNT_LINK_5}', $faq_discount_products_content[4]['PRODUCTS_LINK'], $answer);

    $module_listing_content_faq[]=array(
        'CATEGORY_NAME' => mb_strtolower($faq_category_name['categories_name']),
        'FAQ_PRODUCTS_POPULAR' => $faq_products_content,
        'FAQ_PRODUCTS_DISCOUNT' => $faq_discount_products_content,
        'PRODUCT_POPULAR_NAME_1' => $faq_products_content[0]['PRODUCTS_NAME'],
        'PRODUCT_POPULAR_LINK_1' => $faq_products_content[0]['PRODUCTS_LINK'],
        'PRODUCT_POPULAR_NAME_2' => $faq_products_content[1]['PRODUCTS_NAME'],
        'PRODUCT_POPULAR_LINK_2' => $faq_products_content[1]['PRODUCTS_LINK'],
        'PRODUCT_POPULAR_NAME_3' => $faq_products_content[2]['PRODUCTS_NAME'],
        'PRODUCT_POPULAR_LINK_3' => $faq_products_content[2]['PRODUCTS_LINK'],
        'PRODUCT_POPULAR_NAME_4' => $faq_products_content[3]['PRODUCTS_NAME'],
        'PRODUCT_POPULAR_LINK_4' => $faq_products_content[3]['PRODUCTS_LINK'],
        'PRODUCT_POPULAR_NAME_5' => $faq_products_content[4]['PRODUCTS_NAME'],
        'PRODUCT_POPULAR_LINK_5' => $faq_products_content[4]['PRODUCTS_LINK'],
        'PRODUCT_DISCOUNT_NAME_1' => $faq_discount_products_content[0]['PRODUCTS_NAME'],
        'PRODUCT_DISCOUNT_LINK_1' => $faq_discount_products_content[0]['PRODUCTS_LINK'],
        'PRODUCT_DISCOUNT_NAME_2' => $faq_discount_products_content[1]['PRODUCTS_NAME'],
        'PRODUCT_DISCOUNT_LINK_2' => $faq_discount_products_content[1]['PRODUCTS_LINK'],
        'PRODUCT_DISCOUNT_NAME_3' => $faq_discount_products_content[2]['PRODUCTS_NAME'],
        'PRODUCT_DISCOUNT_LINK_3' => $faq_discount_products_content[2]['PRODUCTS_LINK'],
        'PRODUCT_DISCOUNT_NAME_4' => $faq_discount_products_content[3]['PRODUCTS_NAME'],
        'PRODUCT_DISCOUNT_LINK_4' => $faq_discount_products_content[3]['PRODUCTS_LINK'],
        'PRODUCT_DISCOUNT_NAME_5' => $faq_discount_products_content[4]['PRODUCTS_NAME'],
        'PRODUCT_DISCOUNT_LINK_5' => $faq_discount_products_content[4]['PRODUCTS_LINK'],
        'FAQ_ICON' => $faqIcon,
        'FAQ_SHOW_POPULAR_PRODUCTS' => $one_faq['show_popular_products'],
        'FAQ_SHOW_DISCOUNT_PRODUCTS' => $one_faq['show_discount_products'],
        'FAQ_QUESTION' => $one_faq['question'],
        'FAQ_ANSWER' => $answer,
        'FAQ_ID'      => $one_faq['faq_id'],
        'FAQ_DATA'    => vam_date_short($one_faq['date_added']),
        'FAQ_LINK_MORE'    => vam_href_link(FILENAME_FAQ, 'faq_id='.$one_faq['faq_id'] . $SEF_parameter, 'NONSSL'),
        );

}
if (sizeof($module_listing_content_faq) > 0) {
    $module_listing->assign('FAQ_LINK', vam_href_link(FILENAME_FAQ));
    $module_listing->assign('language', $_SESSION['language']);
    $module_listing->assign('module_content',$module_listing_content_faq);
	
	// set cache ID
	 if (!CacheCheck()) {
		$module_listing->caching = 0;
      $module_listing= $module_listing->fetch(CURRENT_TEMPLATE.'/module/faq_product_listing.html');
	} else {
        $module_listing->caching = 1;
        $module_listing->cache_lifetime=CACHE_LIFETIME;
        $module_listing->cache_modified_check=CACHE_CHECK;
        $module_listing = $module_listing->fetch(CURRENT_TEMPLATE.'/module/faq_product_listing.html',$cache_id);
	}
	$module->assign('MODULE_faq', $module_listing);
}
?>