<?php
/* -----------------------------------------------------------------------------------------
  $Id: default.php 1292 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
  -----------------------------------------------------------------------------------------
  based on:
  © 2000-2001 The Exchange Project  (earlier name of osCommerce)
  © 2002-2003 osCommerce(default.php,v 1.84 2003/05/07); www.oscommerce.com
  © 2003  nextcommerce (default.php,v 1.11 2003/08/22); www.nextcommerce.org
  © 2004  xt:Commerce (default.php,v 1.11 2003/08/22); xt-commerce.com

  Released under the GNU General Public License
  -----------------------------------------------------------------------------------------
  Third Party contributions:
  Enable_Disable_Categories 1.3        Autor: Mikel Williams | mikel@ladykatcostumes.com
  Customers Status v3.x  © 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs...by=date#dirlist

  Released under the GNU General Public License
  ---------------------------------------------------------------------------------------*/


$default = new vamTemplate;
$default->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$default->assign('session', session_id());
$main_content = '';


// Start product/catalog variables set fot template
$default->assign( 'product_name_tpl', $product_name_tpl );
$default->assign( 'products_category_tpl', $products_category_tpl_arr );
$default->assign( 'category_path_tpl', $category_path_tpl_arr );
// End product/catalog variables set fot template


// include needed functions
require_once (DIR_FS_INC.'vam_customer_greeting.inc.php');
require_once (DIR_FS_INC.'vam_get_path.inc.php');
require_once (DIR_FS_INC.'vam_check_categories_status.inc.php');

// Products Specifications
  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');
  
if (PRODUCT_LIST_RECURSIVE == 'true') {
  if (isset ($_GET['cat']) && vam_not_null($_GET['cat'])) {
    $parent_query = "select c.parent_id, c.categories_id
        from ".TABLE_CATEGORIES." c where c.categories_id = '".$current_category_id."'";
    $parent_query = vamDBquery($parent_query);

    $parent = vam_db_fetch_array($parent_query, true);
//    if($parent['parent_id'] != '0' ){
      $category_depth = "products";
//    }
  }
}


if (vam_check_categories_status($current_category_id) >= 1) {

$error = CATEGORIE_NOT_FOUND;
include (DIR_WS_MODULES.FILENAME_ERROR_HANDLER);

} else {

if ($category_depth == 'nested') {

  if (GROUP_CHECK == 'true') {
  $group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
  }
  $category_query = "select
                                      cd.categories_description,
                                      cd.categories_name,
          cd.categories_heading_title,       
                                      c.categories_template,
                                      c.categories_image from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
                                      where c.categories_id = '".$current_category_id."'
                                      and cd.categories_id = '".$current_category_id."'
                                      ".$group_check."
                                      and cd.language_id = '".(int) $_SESSION['languages_id']."'";

  $category_query = vamDBquery($category_query);

  $category = vam_db_fetch_array($category_query, true);


  if (isset ($cPath) && preg_match('/_/', $cPath)) {
  // check to see if there are deeper categories within the current category
  $category_links = array_reverse($cPath_array);


  for ($i = 0, $n = sizeof($category_links); $i < $n; $i ++) {
    if (GROUP_CHECK == 'true') {
    $group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
    }
    if (PRODUCT_LIST_RECURSIVE == 'true') {
    $recursive_check="and c.parent_id = '".$category_links[$i]."'";
    } else {
    $recursive_check="";
    }

    $categories_query = "select      cd.categories_description,
                                              c.categories_id,
                                              cd.categories_name,
                                              cd.categories_heading_title,
                                              c.categories_image,
                                              c.parent_id from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
                                              where c.categories_status = '1'
                                              and c.parent_id = '".$category_links[$i]."'
                                              and c.categories_id = cd.categories_id
                                              ".$recursive_check."
                                              ".$group_check."
                                              and cd.language_id = '".(int) $_SESSION['languages_id']."'
                                              order by sort_order, cd.categories_name";

    $categories_query = vamDBquery($categories_query);

    if (vam_db_num_rows($categories_query, true) < 1) {
    // do nothing, go through the loop
    } else {
    break; // we've found the deepest category the customer is in
    }
  }
  } else {
  if (GROUP_CHECK == 'true') {
    $group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
  }
  if (PRODUCT_LIST_RECURSIVE == 'true') {
    $recursive_check="and c.parent_id = '".$current_category_id."'";
  } else {
    $recursive_check="";
  }
  $categories_query = "select      cd.categories_description,
                                          c.categories_id,
                                          cd.categories_name,
                                          cd.categories_heading_title,
                                          c.categories_image,
                                          c.parent_id from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
                                          where c.categories_status = '1'
                                          and c.parent_id = '".$current_category_id."'
                                          and c.categories_id = cd.categories_id
                                          ".$recursive_check."
                                          ".$group_check."
                                          and cd.language_id = '".(int) $_SESSION['languages_id']."'
                                          order by sort_order, cd.categories_name";

  $categories_query = vamDBquery($categories_query);
  }

  $rows = 0;
  while ($categories = vam_db_fetch_array($categories_query, true)) {
  $rows ++;
 
  $cPath_new = vam_category_link($categories['categories_id'],$categories['categories_name']);
 
  $width = (int) (100 / MAX_DISPLAY_CATEGORIES_PER_ROW).'%';
  $image = '';

if ($categories['categories_image'] != '')
               {
                    $image = DIR_WS_IMAGES.'categories/'.$categories['categories_image'];
               }
               else
               {
                    $image = DIR_WS_IMAGES.'product_images/noimage.gif';
               }

  $categories_content[] = array ('CATEGORIES_NAME' => $categories['categories_name'], 'CATEGORIES_HEADING_TITLE' => $categories['categories_heading_title'], 'CATEGORIES_IMAGE' => $image, 'CATEGORIES_LINK' => vam_href_link(FILENAME_DEFAULT, $cPath_new), 'CATEGORIES_DESCRIPTION' => $categories['categories_description']);

  }
  $new_products_category_id = $current_category_id;
  include (DIR_WS_MODULES.FILENAME_NEW_PRODUCTS);

  $featured_products_category_id = $current_category_id;
  include (DIR_WS_MODULES.FILENAME_FEATURED);

  $image = '';
  if ($category['categories_image'] != '') {
  $image = DIR_WS_IMAGES.'categories/'.$category['categories_image'];
  }
  $default->assign('CATEGORIES_NAME', $category['categories_name']);
  $default->assign('CATEGORIES_HEADING_TITLE', $category['categories_heading_title']);

  $default->assign('CATEGORIES_IMAGE', $image);
  $default->assign('CATEGORIES_DESCRIPTION', $category['categories_description']);

  $default->assign('language', $_SESSION['language']);
  $default->assign('module_content', $categories_content);

  // get default template
  if ($category['categories_template'] == '' or $category['categories_template'] == 'default') {
  $files = array ();
  if ($dir = opendir(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/categorie_listing/')) {
    while (($file = readdir($dir)) !== false) {
    if (is_file(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/categorie_listing/'.$file) and ($file != "index.html") and (substr($file, 0, 1) !=".")) {
      $files[] = array ('id' => $file, 'text' => $file);
    } //if
    } // while
    closedir($dir);
  }
  $category['categories_template'] = $files[0]['id'];
  }

  $default->caching = 0;
  $main_content = $default->fetch(CURRENT_TEMPLATE.'/module/categorie_listing/'.$category['categories_template']);
  $vamTemplate->assign('main_content', $main_content);

}
elseif ($category_depth == 'products' || $_GET['manufacturers_id']) {
  //fsk18 lock
  $fsk_lock = '';
  if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
  $fsk_lock = ' and p.products_fsk18!=1';
  }
  // show the products of a specified manufacturer
  if (isset ($_GET['manufacturers_id'])) {
  if (isset ($_GET['filter_id']) && vam_not_null($_GET['filter_id'])) {

    // sorting query
    $sorting_query = vamDBquery("SELECT products_sorting,
                                                products_sorting2 FROM ".TABLE_CATEGORIES."
                                                where categories_id='".(int) $_GET['filter_id']."'");
    $sorting_data = vam_db_fetch_array($sorting_query,true);
    my_sorting_products($sorting_data);
    if (!$sorting_data['products_sorting'] or $sorting_data['products_sorting']== 'p.products_sort') {
    $sorting_data['products_sorting'] = 'p.products_quantity DESC, p.products_id DESC';
    $sorting_data['products_sorting2'] = '';
    }
    $sorting = ' GROUP BY p.products_id ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
    // We are asked to show only a specific category
    if (GROUP_CHECK == 'true') {
    $group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
    }
    $listing_sql = "select DISTINCT p.products_fsk18,
                                  p.products_shippingtime,
                                  p.products_model,
                                  p.label_id,
                                  pd.products_name,
                                  p.products_ean,
                                  p.products_price,
                                  p.products_tax_class_id,
                                  m.manufacturers_name,
                                  p.products_quantity,
                                  p.products_image,
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
                                  from ".TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_MANUFACTURERS." m, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_PRODUCTS." p left join ".TABLE_SPECIALS." s on p.products_id = s.products_id
                                  where p.products_status = '1'
                                  and p.manufacturers_id = m.manufacturers_id
                                  and m.manufacturers_id = '".(int) $_GET['manufacturers_id']."'
                                  and p.products_id = p2c.products_id
                                  and pd.products_id = p2c.products_id
                                  ".$group_check."
                                  ".$fsk_lock."
                                  and pd.language_id = '".(int) $_SESSION['languages_id']."'
                                  and p2c.categories_id = '".(int) $_GET['filter_id']."'".$sorting;
  } else {
  	
    // sorting query
    $sorting_query = vamDBquery("SELECT products_sorting,
                                                products_sorting2 FROM ".TABLE_CATEGORIES."
                                                where categories_id='".(int) $_GET['filter_id']."'");
    $sorting_data = vam_db_fetch_array($sorting_query,true);
    my_sorting_products($sorting_data);
    if (!$sorting_data['products_sorting'] or $sorting_data['products_sorting']== 'p.products_sort') {
    $sorting_data['products_sorting'] = 'p.products_quantity DESC, p.products_id DESC';
    $sorting_data['products_sorting2'] = '';
    }
    $sorting = ' GROUP BY p.products_id ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
    // We show them all
    if (GROUP_CHECK == 'true') {
    $group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
    }
    $listing_sql = "select p.products_fsk18,
                            p.products_shippingtime,
                            p.products_model,
                            p.label_id,
                            p.products_ean,
                            pd.products_name,
                            p.products_id,
                            p.products_price,
                            m.manufacturers_name,
                            p.products_quantity,
                            p.products_image,
                            p.products_weight,
                            pd.products_short_description,
                            pd.products_description,
                            p.manufacturers_id,
                            p.products_vpe,
                            p.products_vpe_status,
                            p.products_vpe_value,     
                            p.products_discount_allowed,
                            p.products_tax_class_id
                            from ".TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_MANUFACTURERS." m, ".TABLE_PRODUCTS." p left join ".TABLE_SPECIALS." s on p.products_id = s.products_id
                            where p.products_status = '1'
                            and pd.products_id = p.products_id
                            ".$group_check."
                            ".$fsk_lock."
                            and pd.language_id = '".(int) $_SESSION['languages_id']."'
                            and p.manufacturers_id = m.manufacturers_id
                            and m.manufacturers_id = '".(int) $_GET['manufacturers_id']."'".$sorting;
  }
  } else {
  // show the products in a given categorie
  if (isset ($_GET['filter_id']) && vam_not_null($_GET['filter_id'])) {

    // sorting query
    $sorting_query = vamDBquery("SELECT products_sorting,
                                                products_sorting2 FROM ".TABLE_CATEGORIES."
                                                where categories_id='".$current_category_id."'");
    $sorting_data = vam_db_fetch_array($sorting_query,true);
    my_sorting_products($sorting_data);
    if (!$sorting_data['products_sorting'] or $sorting_data['products_sorting']== 'p.products_sort') {
    $sorting_data['products_sorting'] = 'p.products_quantity DESC, p.products_id DESC';
    $sorting_data['products_sorting2'] = '';
    }
    $sorting = ' GROUP BY p.products_id ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
    // We are asked to show only specific catgeory
    if (GROUP_CHECK == 'true') {
    $group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
    }
    if (PRODUCT_LIST_RECURSIVE == 'true') {
    $recursive_check= "and (p2c.categories_id = '".$current_category_id."' AND p2c.categories_id = c.categories_id OR p2c.categories_id = c.categories_id AND c.parent_id = '".$current_category_id."')";
    $recursive_table_categories=TABLE_CATEGORIES." c, ";
    } else {
    $recursive_check="and p2c.categories_id = '".$current_category_id."'";
    $recursive_table_categories="";
    }
    $listing_sql = "select p.products_fsk18,
                                  p.products_shippingtime,
                                  p.products_model,
                                  p.label_id,
                                  p.products_ean,
                                  pd.products_name,
                                  p.products_id,
                                  m.manufacturers_name,
                                  p.products_quantity,
                                  p.products_image,
                                  p.products_weight,
                                  pd.products_short_description,
                                  pd.products_description,
                                  p.manufacturers_id,
                                  p.products_price,
                                  p.products_vpe,
                                  p.products_vpe_status,
                                  p.products_vpe_value,                           
                                  p.products_discount_allowed,
                                  p.products_tax_class_id
                                  from  ".$recursive_table_categories.TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_MANUFACTURERS." m, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_PRODUCTS." p left join ".TABLE_SPECIALS." s on p.products_id = s.products_id
                                  where p.products_status = '1'
                                  and p.manufacturers_id = m.manufacturers_id
                                  and m.manufacturers_id = '".(int) $_GET['filter_id']."'
                                  and p.products_id = p2c.products_id
                                  and pd.products_id = p2c.products_id
                                  ".$group_check."
                                  ".$fsk_lock."
                                  and pd.language_id = '".(int) $_SESSION['languages_id']."' "
                                  .$recursive_check
                                  .$sorting;
  } else {

    // sorting query
    $sorting_query = vamDBquery("SELECT products_sorting,
                                                products_sorting2 FROM ".TABLE_CATEGORIES."
                                                where categories_id='".$current_category_id."'");
    $sorting_data = vam_db_fetch_array($sorting_query,true);
    my_sorting_products($sorting_data);
    if (!$sorting_data['products_sorting'] or $sorting_data['products_sorting']== 'p.products_sort') {
    $sorting_data['products_sorting'] = 'p.products_quantity DESC, p.products_id DESC';
    $sorting_data['products_sorting2'] = '';
    }
    $sorting = ' GROUP BY p.products_id ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
    // We show them all
    if (GROUP_CHECK == 'true') {
    $group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
    }
    if (PRODUCT_LIST_RECURSIVE == 'true') {
    $recursive_check= "and (p2c.categories_id = '".$current_category_id."' AND p2c.categories_id = c.categories_id OR p2c.categories_id = c.categories_id AND c.parent_id = '".$current_category_id."')";
    $recursive_table_categories=TABLE_CATEGORIES." c, ";
    } else {
    $recursive_check="and p2c.categories_id = '".$current_category_id."'";
    $recursive_table_categories="";
    }
    $listing_sql = "select p.products_fsk18,
                                  p.products_shippingtime,
                                  p.products_model,
                                  p.label_id,
                                  p.products_ean,
                                  pd.products_name,
                                  m.manufacturers_name,
                                  p.products_quantity,
                                  p.products_image,
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
                                  from  ".$recursive_table_categories.TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_PRODUCTS." p left join ".TABLE_MANUFACTURERS." m on p.manufacturers_id = m.manufacturers_id
                                  left join ".TABLE_SPECIALS." s on p.products_id = s.products_id
                                  where p.products_status = '1'
                                  and p.products_id = p2c.products_id
                                  and pd.products_id = p2c.products_id
                                  ".$group_check."
                                  ".$fsk_lock."                             
                                  and pd.language_id = '".(int) $_SESSION['languages_id']."' "
                                  .$recursive_check
                                  .$sorting;
  }
  }
  // optional Product List Filter
  if (PRODUCT_LIST_FILTER > 0) {
  if (isset ($_GET['manufacturers_id'])) {
    $filterlist_sql = "select distinct p.manufacturers_id,  c.categories_id as id, cd.categories_name as name from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd where p.products_status = '1' and c.categories_status = '1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p2c.categories_id = cd.categories_id and cd.language_id = '".(int) $_SESSION['languages_id']."' and p.manufacturers_id = '".(int) $_GET['manufacturers_id']."' order by c.sort_order, cd.categories_name asc";
  } else {
    if (PRODUCT_LIST_RECURSIVE == 'true') {
    $filterlist_sql = "select distinct p.manufacturers_id,  m.manufacturers_id as id, m.manufacturers_name as name from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_CATEGORIES." c,".TABLE_MANUFACTURERS." m where p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_status = '1' and p.products_id = p2c.products_id and (p2c.categories_id = '".$current_category_id."' AND p2c.categories_id = c.categories_id OR p2c.categories_id = c.categories_id AND c.parent_id = '".$current_category_id."') group by p.manufacturers_id order by m.sort_order, m.manufacturers_name asc";
    } else {
    $filterlist_sql = "select distinct m.manufacturers_id as id,  m.manufacturers_name as name from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_MANUFACTURERS." m where p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_status = '1' and p.products_id = p2c.products_id and p2c.categories_id = '".$current_category_id."' group by p.manufacturers_id order by m.sort_order, m.manufacturers_name asc";
    }
  }
  $filterlist_query = vamDBquery($filterlist_sql);
  if (vam_db_num_rows($filterlist_query, true) >= 1) {
    $manufacturer_dropdown = vam_draw_form('filter', vam_href_link(FILENAME_DEFAULT, 'cat='.$current_category_id), 'get');
    if (isset ($_GET['manufacturers_id'])) {
    $manufacturer_dropdown .= vam_draw_hidden_field('manufacturers_id', (int)$_GET['manufacturers_id']);
    $options = array (array ('text' => TEXT_ALL_CATEGORIES));
    } else {
    $manufacturer_dropdown .= vam_draw_hidden_field('cat', $_GET['cat']);
    $options = array (array ('text' => TEXT_ALL_MANUFACTURERS));
    }
    $manufacturer_dropdown .= vam_draw_hidden_field('sort', $_GET['sort']);
    global $current_category_id;
    while ($filterlist = vam_db_fetch_array($filterlist_query, true)) {
    $options[] = array ('id' => $filterlist['id'], 'text' => $filterlist['name']);
	if ($current_category_id > 0) {
    $manufacturer_sort .= '<a href="'.vam_href_link(FILENAME_DEFAULT, 'cat='.$current_category_id.'&filter_id='.$filterlist['id']).'">' . $filterlist['name'] . '</a> ';
    } else {
    $manufacturer_sort .= '<a href="'.vam_href_link(FILENAME_DEFAULT, 'filter_id='.$filterlist['id'].'&manufacturers_id='.(int)$_GET['manufacturers_id']).'">' . $filterlist['name'] . '</a> ';
    }
    }
    $manufacturer_sort .= '<a href="'.vam_href_link(FILENAME_DEFAULT, 'cat='.$current_category_id).'">' . TEXT_ALL_MANUFACTURERS . '</a> ';
    $manufacturer_dropdown .= vam_draw_pull_down_menu('filter_id', $options, $_GET['filter_id'], 'class="form-control col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3" onchange="this.form.submit()"');
    $manufacturer_dropdown .= '</form>'."\n"; 
  }
  }

  // Get the right image for the top-right
  $image = DIR_WS_IMAGES.'table_background_list.gif';
  if (isset ($_GET['manufacturers_id'])) {
  $image = vamDBquery("select manufacturers_image from ".TABLE_MANUFACTURERS." where manufacturers_id = '".(int) $_GET['manufacturers_id']."'");
  $image = vam_db_fetch_array($image,true);
  $image = $image['manufacturers_image'];
  }
  elseif ($current_category_id) {
  $image = vamDBquery("select categories_image from ".TABLE_CATEGORIES." where categories_id = '".$current_category_id."'");
  $image = vam_db_fetch_array($image,true);
  $image = $image['categories_image'];
  }

  include (DIR_WS_MODULES.FILENAME_PRODUCT_LISTING);

} else { // default page
  if (GROUP_CHECK == 'true') {
  $group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
  }
  $shop_content_query = vamDBquery("SELECT
                      content_title,
                      content_heading,
                      content_text,
                      content_file
                      FROM ".TABLE_CONTENT_MANAGER."
                      WHERE content_group='5'
                      ".$group_check."
                      AND languages_id='".$_SESSION['languages_id']."'");
  $shop_content_data = vam_db_fetch_array($shop_content_query,true);

  $default->assign('title', $shop_content_data['content_heading']);
  include (DIR_WS_INCLUDES.FILENAME_CENTER_MODULES);

  if ($shop_content_data['content_file'] != '') {
  ob_start();
  if (strpos($shop_content_data['content_file'], '.txt'))
    echo '<pre>';
  include (DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
  if (strpos($shop_content_data['content_file'], '.txt'))
    echo '</pre>';
  $shop_content_data['content_text'] = ob_get_contents();
  ob_end_clean();
  }

  $default->assign('greeting', vam_customer_greeting());
  $default->assign('text', $shop_content_data['content_text']);
  $default->assign('language', $_SESSION['language']);

  // set cache ID
  if (!CacheCheck()) {
  $default->caching = 0;
  $main_content = $default->fetch(CURRENT_TEMPLATE.'/module/main_content.html');
  } else {
  $default->caching = 1;
  $default->cache_lifetime = CACHE_LIFETIME;
  $default->cache_modified_check = CACHE_CHECK;
  $cache_id = $_SESSION['language'].$_SESSION['currency'].$_SESSION['customer_id'];
  $main_content = $default->fetch(CURRENT_TEMPLATE.'/module/main_content.html', $cache_id);
  }

  $vamTemplate->assign('main_content', $main_content);
}
}
?>