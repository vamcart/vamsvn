<?php
/*
  $Id: products_filter.php, v1.0.1 20090917 kymation Exp $
  $From: index.php 1739 2007-12-20 00:52:16Z hpdl $
  $Loc: catalog/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

/*
 * This file processes the variables passed from the filter box and displays the
 * products that meet the filter criteria.
 */
// BOF products_filters_seo

  require_once ('includes/application_top.php');

if (!function_exists('_templateReplace')) {
  function _templateReplace($templateArray, $text) {
    foreach ($templateArray as $key => $value) {
      $text = str_replace('{' . $key . '}', $value, $text);
    }
    return $text;
  }
}

  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');
// BOF products_filters_seo
  require_once(DIR_WS_CLASSES  . 'specifications.php');
  $spec_object = new Specifications();
// EOF products_filters_seo
// BOF products_filters_seo
  $get_spec = array();
  foreach ($_GET as $key => $val) {
//    if (preg_match('@f([\d]+)@', $key, $m) != 1) continue;
    if (preg_match('@^f[0-9]+$@', $key) == 0) continue;
    $get_spec[$key] = (array)$val;
  }
// EOF products_filters_seo
// BOF products_filters-sort
//$sql = "DELETE FROM " . TABLE_SPECIFICATION_FILTERS_STATISTICS . " WHERE TO_DAYS(NOW()) - TO_DAYS(date_added) > 30";
//vam_db_query($sql);
//$sql = "SELECT *, COUNT(*) AS count FROM " . TABLE_SPECIFICATION_FILTERS_STATISTICS . " GROUP BY specifications_id, specification_value ORDER BY count";
//$specification_statisctics_query = vam_db_query($sql);
//while ($specification_statisctics = vam_db_fetch_array($specification_statisctics_query)) {
  //unset($specification_statisctics['date_added']);
//}
// EOF products_filters-sort
//if ($_SERVER['REMOTE_ADDR'] == '95.31.38.56') {
//error_log('$_GET=' . var_export($_GET, true) . "\n", 3, __FILE__ . '-.log');
//}

$vamTemplate = new vamTemplate;

// include boxes
//require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$vamTemplate->assign('session', session_id());
$module = new vamTemplate;

  if ( (isset ($_GET['sort'])) || (preg_match ('/[1-9][ad]/', $_GET['sort'])) ) {
    $metaTags['robots'] = 'noindex,follow';
  }

  $category_sql = '';
  if ($current_category_id != 0) {
    $category_sql = "and s2c.categories_id = '" . (int)$current_category_id . "'";
  }

  // Check for filters on each applicable Specification
  $specs_query_raw = "SELECT DISTINCT
                        s.specifications_id,
                        s.filter_class,
                        s.products_column_name,
                        sd.specification_name
                      FROM
                        " . TABLE_SPECIFICATION . " AS s
                      Inner Join " . TABLE_SPECIFICATION_GROUPS . " AS sg
                        ON s.specification_group_id = sg.specification_group_id
                      Inner Join " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " AS s2c
                        ON sg.specification_group_id = s2c.specification_group_id
                      Inner Join " . TABLE_SPECIFICATION_DESCRIPTION . " sd
                        ON sd.specifications_id = s.specifications_id
                      WHERE
                        s.show_filter = 'True'
                        AND sg.show_filter = 'True'
                        and sd.language_id = '" . (int) $_SESSION['languages_id'] . "'
                        " . $category_sql;
// BOF products_filters_seo
  $specs_query_raw = str_replace('sd.specification_name', 'sd.specification_name, sd.specification_seo_name, s.specification_seo_active', $specs_query_raw);
  $specs_query_raw .= " ORDER BY s.specification_sort_order";
// EOF products_filters_seo
// BOF products_filters-slider
  $specs_query_raw = str_replace('s.filter_class', 's.filter_class, s.filter_display', $specs_query_raw);
// EOF products_filters-slider
  // print $specs_query_raw . "<br>\n";
  $specs_query = vam_db_query($specs_query_raw);

  //breadcrumbs : preserve the result of the specs_query
  $specs_array_breadcrumb = array();

  // Build a string of SQL to constrain the specification to the filter values
  $sql_array = array (
    'from' => '',
    'where' => ''
  );

// BOF products_filters_seo
  $specifications_founded = array();
  $specifications_id_brand = 0;
// EOF products_filters_seo
//if ($_SERVER['REMOTE_ADDR'] == '95.31.38.56') {
//error_log('$specs_query=' . var_export($specs_query, true) . "\n", 3, __FILE__ . '-.log');
//}
  while ($specs_array = vam_db_fetch_array ($specs_query) ) {
//if ($_SERVER['REMOTE_ADDR'] == '95.31.38.56') {
//error_log('$specs_array=' . var_export($specs_array, true) . "\n", 3, __FILE__ . '-.log');
//}
    // Retrieve the GET vars used as filters
    // Variable names are the letter "f" followed by the specifications_id for that spec.
    $var = 'f' . $specs_array['specifications_id'];
    $$var = '0';
    if (isset ($_GET[$var]) && $_GET[$var] != '') {
      // Decode the URL-encoded names, including arrays
      $$var = vam_decode_recursive ($_GET[$var]);
// BOF products_filters-slider
      if ($specs_array['filter_display'] == 'slider' && is_array($_GET[$var])) {
        $$var = implode('-', $_GET[$var]);
      }
// EOF products_filters-slider

      // Sanitize variables to prevent hacking
     //$$var = preg_replace("/^[ а-яА-Я\/]+$/","", $$var);

      // Get rid of extra values if Select All is selected
      $$var = vam_select_all_override ($$var);

      // Get the breadcrumbs data for the filters that are set
      $filter_breadcrumbs = vam_get_filter_breadcrumbs ($specs_array, $$var);
// BOF products_filters_seo
      if ($specs_array['specification_seo_active'] == '0') {
        $metaTags['robots'] = 'noindex,follow';
      }
      if (is_array($filter_breadcrumbs) && sizeof($filter_breadcrumbs) > 1) {
        $val_array = array();
        foreach ($filter_breadcrumbs as $ind => $val) {
          $val_array[] = $filter_breadcrumbs[$ind]['value'];
        }
        $tmp = array();
        $tmp[0] = $filter_breadcrumbs[0];
        $tmp[0]['value'] = implode(', ', $val_array);
        $filter_breadcrumbs = $tmp;
      }
      $filter_breadcrumbs[0]['specification_seo_name'] = $specs_array['specification_seo_name'];
// EOF products_filters_seo
      $specs_array_breadcrumb = array_merge ($specs_array_breadcrumb, (array) $filter_breadcrumbs);

      // Set the correct variable type (All _GET variables are strings by default)
      $$var = vam_set_type ($$var);

      // Get the SQL to apply the filters
      $sql_string_array = vam_get_filter_sql ($specs_array['filter_class'], $specs_array['specifications_id'], $$var, $specs_array['products_column_name'], $_SESSION['languages_id']);
// BOF products_filters-sort
      //if (in_array($specs_array['filter_class'], array('exact', 'multiple', ))) {
        //foreach ((array)vam_db_prepare_input($$var) as $specification_value) {
          //$sql = "INSERT INTO " . TABLE_SPECIFICATION_FILTERS_STATISTICS . " (specifications_id, specification_value) VALUES (" . (int)$specs_array['specifications_id'] . ", '" . vam_db_input($specification_value) . "')";
          //vam_db_query($sql);
        //}
      //}
// EOF products_filters-sort
// BOF products_filters_seo
      $specifications_founded[$var] = $_GET[$var];
//if ($_SERVER['REMOTE_ADDR'] == '95.31.38.56') {
//error_log('$var=' . var_export($var, true) . ' $specifications_id=' . var_export($specs_array['specifications_id'], true) . ' $filter_class=' . var_export($specs_array['filter_class'], true) . ' $products_column_name=' . var_export($specs_array['products_column_name'], true) . "\n", 3, __FILE__ . '-.log');
//}
      if (in_array($specs_array['filter_class'], array('exact', 'multiple', ))) {
        if (!isset($_GET[$var]) || !is_array($_GET[$var])) {
//          error_log('REQUEST_URI=' . var_export($_SERVER["REQUEST_URI"], true) . "\n" . '$var=' . var_export($var, true) . "\n" . '$_GET[$var]=' . var_export($_GET[$var], true) . "\n" . '(array)$_GET[$var]=' . var_export((array)$_GET[$var], true) . "\n", 3, __FILE__.'.log');
        }
        foreach ((array)$_GET[$var] as $specs_val_ind => $specs_val) {
          $count = $spec_object->getFilterCount($specs_val, $specs_array['specifications_id'], $specs_array['filter_class'], $specs_array['products_column_name']);
if ($_SERVER['REMOTE_ADDR'] == '95.31.38.56') {
error_log('$specs_val=' . var_export($specs_val, true) . ' $specifications_id=' . var_export($specs_array['specifications_id'], true) . ' $filter_class=' . var_export($specs_array['filter_class'], true) . ' $products_column_name=' . var_export($specs_array['products_column_name'], true) . ' $count=' . var_export($count, true) . "\n", 3, __FILE__ . '-.log');
}
          if ($count != 0) {
            unset($get_spec[$var][$specs_val_ind]);
            if (sizeof($get_spec[$var]) == 0) unset($get_spec[$var]);
          }
        }
      }
      if ($specs_array['products_column_name'] == 'manufacturers_id') {
        $specifications_id_brand = $specs_array['specifications_id'];
      }
// EOF products_filters_seo
      $sql_array['from'] .= $sql_string_array['from'];
      $sql_array['where'] .= $sql_string_array['where'];
    } // if (isset ($_GET[$var]
  } // while ($specs_array
// BOF products_filters_seo
if ($_SERVER['REMOTE_ADDR'] == '95.31.38.56') {
error_log('$get_spec=' . var_export($get_spec, true) . "\n", 3, __FILE__ . '-.log');
}
  if (sizeof($get_spec) > 0) {
    $get_ignore = $_GET;
    unset($get_ignore['cPath']);
    unset($get_ignore['cat']);
  //  $url = vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_array_get_params($get_ignore));
    $url = vam_href_link(FILENAME_DEFAULT, vam_get_array_get_params($get_ignore));
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
      header("HTTP/1.1 301 Moved Permanently");
      header('Location: ' . $url);
      exit();
    }
  }
  $specifications_not_founded = array();
  foreach ($_GET as $key => $val) {
//    if (substr($key, 0, 1) == 'f') {
    if (preg_match('@^f[0-9]+$@', $key)) {
      if (!isset($specifications_founded[$key])) {
        $specifications_not_founded[] = $key;
      } elseif ($specifications_founded[$key] != $val) {
        $specifications_not_founded[$key] = array_diff_assoc($val, $specifications_founded[$key]);
      }
    }
  }
////    $url = vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_array_get_params($specifications_not_founded));
  if (sizeof($specifications_not_founded) > 0) {
    $url = vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_array_get_params($specifications_not_founded));
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
      header("HTTP/1.1 301 Moved Permanently");
      header('Location: ' . $url);
      exit();
    }
  }
// EOF products_filters_seo

$listing_sql = '';

  //fsk18 lock
  $fsk_lock = '';
  if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
  $fsk_lock = ' and p.products_fsk18!=1';
  }

// BOF extra_sort
  include(DIR_WS_MODULES . 'extra_sort.php');
  if (!vam_not_null($sorting)) {
// EOF extra_sort
    // sorting query
    $sorting_query = vamDBquery("SELECT products_sorting,
                                                products_sorting2 FROM ".TABLE_CATEGORIES."
                                                where categories_id='".$current_category_id."'");
    $sorting_data = vam_db_fetch_array($sorting_query,true);
    my_sorting_products($sorting_data);
    if (!$sorting_data['products_sorting'])
    $sorting_data['products_sorting'] = 'pd.products_name';
    $sorting = ' ORDER BY products_on_stock_flag desc, '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
// BOF extra_sort
  }
// EOF extra_sort
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

  $sql_array['from'] = str_replace("LEFT JOIN " . TABLE_SPECIALS . " s ON p.products_id = s.products_id", '', $sql_array['from']);

  $listing_sql .= "select distinct p.products_id,
                                  p.products_fsk18,
                                  p.products_shippingtime,
                                  p.products_model,
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
                                  p.products_tax_class_id,
                   if(ISNULL(s.specials_new_products_price), 0, 1) AS specials_price_sort_flag,
                   IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price,
                   IF(s.status, s.specials_new_products_price, p.products_price) as final_price,
                   IF(p.products_quantity > 0, 1, 0) AS products_on_stock_flag
                 from
                   " . TABLE_PRODUCTS . " p
                 left join " . TABLE_SPECIALS . " s
                   on p.products_id = s.products_id
                 left join " . TABLE_MANUFACTURERS . " m
                   on p.manufacturers_id = m.manufacturers_id
                 join " . TABLE_PRODUCTS_DESCRIPTION . " pd
                   on p.products_id = pd.products_id
                 join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                   on p.products_id = p2c.products_id
                   " . $sql_array['from'] . "
                 where
                   p.products_status = '1'
                  /* and p.products_quantity > 0 */
                   and pd.language_id = '" . (int) $_SESSION['languages_id'] . "'
                   " . $sql_array['where'] . "
                ";

  if ($current_category_id != 0) {
    $subcategories_array = array();
    vam_get_subcategories ($subcategories_array, $current_category_id);

    if (SPECIFICATIONS_FILTER_SUBCATEGORIES == 'True' && count ($subcategories_array) > 0) {
      $category_ids = $current_category_id . ',' . implode (',', $subcategories_array);
      $listing_sql .= '   ' . "and p2c.categories_id in (" . $category_ids . ") \n";

    } else {
      $listing_sql .= '   ' . "and p2c.categories_id = '" . (int)$current_category_id . "' \n";
    }
  } // if ($current_category_id

      $listing_sql .= '   ' . $fsk_lock;
      $listing_sql .= '   ' . $group_check;
      $listing_sql .= '   ' . $sorting;

//    print $listing_sql . "<br>\n";

  $specifications_filter_listing_sql = $listing_sql;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

//die;

  // Add Filter to Breadcrumbs if selected
  if (SPECIFICATIONS_FILTER_BREADCRUMB == 'True') {
    foreach ($specs_array_breadcrumb as $crumb) {
      $breadcrumb->add($crumb['specification_name'] . ' : ' . $crumb['value'] . ' [X]', vam_href_link (FILENAME_PRODUCTS_FILTERS, vam_get_all_get_params (array ('f' . $crumb['specifications_id']) ) ) );
    }
  }
// BOF products_filters_seo
  $seo_text = array();
  $man_name = '';
  foreach ($specs_array_breadcrumb as $crumb) {
    if ($crumb['specifications_id'] != $specifications_id_brand) {
      if (empty($crumb['specification_seo_name'])) $crumb['specification_seo_name'] = $crumb['specification_name'] . ' %s';
      if (strpos($crumb['specification_seo_name'], '%s') === false) $crumb['specification_seo_name'] .= ' %s';
      $seo_text[] = sprintf($crumb['specification_seo_name'], mb_strtolower($crumb['value']));
      $seo_text_val[] = mb_strtolower($crumb['value']);
    } else {
      $man_name = ' ' . $crumb['value'];
      $seo_text_val[] = $crumb['value'];
    }
  }
//  $sql = "SELECT categories_name, categories_meta_keywords, categories_meta_description, categories_meta_title, categories_heading_title
  $sql = "SELECT categories_name
          FROM " . TABLE_CATEGORIES_DESCRIPTION . "
          WHERE categories_id=" . (int)$current_category_id . "
            AND language_id=" . (int)$_SESSION['languages_id'] . "";
  $categories_meta_query = vamDBquery($sql);
  $categories_meta = vam_db_fetch_array($categories_meta_query, true);
  if (!empty($manufacturers_meta['manufacturers_name'])) $man_name = ' ' . $manufacturers_meta['manufacturers_name'];
 $metaTags_tpl['h1'] = '{cname} {filterval} оптом';
//Пример формируемого H1 заголовока: Детское велокресло заднее оптом:
 $metaTags_tpl['title'] = 'Купить {cnamelower} {filterval} оптом по ценам от производителя - opt.vamvelosiped.ru';
//Пример формируемого title: Купить детское велокресло заднее оптом по ценам от производителя - opt.vamvelosiped.ru
 $metaTags_tpl['description'] = 'Заказать {cnamelower} {filterval} оптом, {cnamelower} {filterval} dropshipping на лучших условиях в России';
//Пример формируемого description: Заказать детское велокресло заднее оптом, детское велокресло заднее dropshipping на лучших условиях в России
 $metaTags_tpl['keywords'] = 'Купить {cnamelower} {filterval} оптом, дропшиппинг {cnamelower} {filterval}, {cnamelower} {filterval} оптом';
//Пример формируемого keywords: Купить детское велокресло заднее оптом, дропшиппинг детское велокресло заднее, детское велокресло заднее оптом
  $metaTags_tpl_array = array(
    'cname' => $categories_meta['categories_name'],
    'cnamelower' => mb_strtolower($categories_meta['categories_name']),
    'filter' => implode(', ', $seo_text),
    'filterval' => implode(', ', $seo_text_val),
  );
  $metaTags['h1'] = _templateReplace($metaTags_tpl_array, $metaTags_tpl['h1']);
  $metaTags['title'] = _templateReplace($metaTags_tpl_array, $metaTags_tpl['title']);
  $metaTags['description'] = _templateReplace($metaTags_tpl_array, $metaTags_tpl['description']);
  $metaTags['keywords'] = _templateReplace($metaTags_tpl_array, $metaTags_tpl['keywords']);
/*
  $metaTags['h1'] = $categories_meta['categories_name'] . $man_name . ': ' . implode(', ', $seo_text);
  $metaTags['title'] = $metaTags['h1'] . ' по низким ценам – Vamvelosiped.ru';
  $metaTags['description'] = 'У нас можно купить ' . $metaTags['h1'] . ' по низким ценам. Быстрая доставка по всей России.';
  $metaTags['keywords'] = '';
*/
//var_dump(sizeof($seo_text), $seo_text);die;
  if (sizeof($seo_text) > 1) {
    $metaTags['robots'] = 'noindex, follow';
  } else {
    $metaTags['robots'] = 'index, follow';
  }
// EOF products_filters_seo
?>
<?php
  // Show the Filters module here if set in Admin
  if (SPECIFICATIONS_FILTERS_MODULE == 'True') {
?>
<?php
    require (DIR_WS_MODULES . 'products_filter.php');
?>
<?php
  }
?>

<?php

require (DIR_WS_INCLUDES.'header.php');

include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING);

$vamTemplate->assign('language', $_SESSION['language']);

$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_PRODUCTS_FILTERS.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_PRODUCTS_FILTERS.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);

include ('includes/application_bottom.php');

?>