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
// BOF products_filters-sort

//error_log('$_GET=' . var_export($_GET, true) . "\n", 3, __FILE__ . '.log');

  require_once('includes/application_top.php');
// BOF products_filters-sort
define('TABLE_SPECIFICATION_FILTERS_STATISTICS', 'specification_filters_statistics');
// EOF products_filters-sort

  require_once(DIR_WS_FUNCTIONS . 'products_specifications.php');
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
//error_log('$_GET=' . var_export($_GET, true) . "\n", 3, __FILE__ . '-.log');

function get_specification_filters_id($sid, $val) { 
  if (substr($sid, 0, 1) == 'f') {
    $sid = substr($sid, 1);
  }
  $sql = "SELECT s.specifications_id, s.products_column_name, s.filter_class
          FROM " . TABLE_SPECIFICATION . " s
          WHERE s.specifications_id = " . (int)$sid . "";
  $specification_query = vamDBquery($sql);
  if (!$specification = vam_db_fetch_array($specification_query,true)) {
  //  error_log('ERROR!!! Not found specifications_id ' . $sid . "\n", 3, __FILE__.'.uri.log');
    return false;
  }
//  echo __LINE__ . ': ';var_export($specification);echo "\n";die;
  if (!in_array($specification['filter_class'], array('exact', 'multiple', ))) {
    return $val;
  }
  if ($specification['products_column_name'] == 'manufacturers_id') {
    $sql = "SELECT manufacturers_id FROM " . TABLE_MANUFACTURERS . " WHERE manufacturers_name = '" . vam_db_input($val) . "'";
    if (ctype_digit($val)) {
      $sql .= " OR manufacturers_id = '" . vam_db_input($val) . "'";
    }
//    echo __LINE__ . ': ';var_export($sql);echo "\n";
    $mid_query = vamDBquery($sql);
    if ($mid = vam_db_fetch_array($mid_query,true)) {
//      echo __LINE__ . ': ';var_export($mid);echo "\n";
      return $mid['manufacturers_id'];
    } else {
//      echo __LINE__ . ': ';var_export($sql);echo "\n";
      //error_log('ERROR!!! Not found manufacturers_name "' . vam_db_input($val) . '"' . "\n", 3, __FILE__.'.uri.log');
      return false;
    }
  } elseif ($specification['products_column_name'] == 'products_price' || $specification['products_column_name'] == 'final_price') {
//      echo 'products_price | final_price ' . "\n";
//      echo __LINE__ . ': ';var_export($specification);echo "\n";
      return $val;
      die;
  } else {
    $sql = "SELECT sf.specifications_id, sfd.specification_filters_description_id, sfd.filter
            FROM " . TABLE_SPECIFICATIONS_FILTERS . " sf,
                 " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " sfd
            WHERE sfd.specification_filters_id = sf.specification_filters_id
              AND sf.specifications_id = " . (int)$sid . "
              AND sfd.language_id = " . (int)$_SESSION['languages_id'] . "
              AND sfd.filter = '" . vam_db_input($val) . "'";
    if (ctype_digit($val)) {
      $sql .= " OR specification_filters_description_id = '" . vam_db_input($val) . "'";
    }
    $filters_query = vamDBquery($sql);
    if ($filters = vam_db_fetch_array($filters_query,true)) {
//      echo __LINE__ . ': ';var_export($filters);echo "\n";
      return $filters['specification_filters_description_id'];
    } else {
      //error_log('ERROR!!! Not found specification_id "' . $specification['specification_name'] . '" value "' . vam_db_input($val) . '"' . "\n", 3, __FILE__.'.uri.log');
//      echo __LINE__ . ': ';var_export($sql);echo "\n";
      return false;
    }
//      echo __LINE__ . ': ';var_export($specification);echo "\n";
//      die;

  }
  return false;
}$fCount=0;
if (isset($specification_uri) && $specification_uri['new_format'] != '1') {
  $gg = $_GET;
  //error_log('$specification_uri=' . var_export($specification_uri, true) . "\n", 3, __FILE__ . '.uri.log');
  //error_log('$gg=' . var_export($gg, true) . "\n", 3, __FILE__ . '.uri.log');
  foreach ($_GET as $ksid => $v) {
    if (substr($ksid, 0, 1) == 'f') {
      $spec_id = substr($ksid, 1);
      //error_log('$spec_id=' . var_export($spec_id, true) . ' $v=' . var_export($v, true) . "\n", 3, __FILE__ . '.uri.log');
      if (is_array($v)) {
        foreach ($v as $virow => $vrow) {
			$fCount++;
          $vi = get_specification_filters_id($spec_id, $vrow);
          //error_log('$spec_id=' . var_export($spec_id, true) . ' $vrow=' . var_export($vrow, true) . ' $vi=' . var_export($vi, true) . "\n", 3, __FILE__ . '.uri.log');
          $gg[$ksid][$virow] = $vi;
        }
      } else {$fCount++;
        $vi = get_specification_filters_id($spec_id, $v);
        //error_log('$spec_id=' . var_export($spec_id, true) . ' $v=' . var_export($v, true) . ' $vi=' . var_export($vi, true) . "\n", 3, __FILE__ . '.uri.log');
        $gg[$ksid][$v] = $vi;
      }
    }
  }
  //error_log('$gg=' . var_export($gg, true) . "\n", 3, __FILE__ . '.uri.log');
  $_GET = $gg;
}

$vamTemplate = new vamTemplate;

// include boxes
//require(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
$vamTemplate->assign('session', session_id());
$module = new vamTemplate;

  if ( (isset($_GET['sort'])) || (preg_match('/[1-9][ad]/', $_GET['sort'])) ) {
//    $metaTags['robots'] = 'noindex,follow';
  }

  $category_sql = '';
  if ($current_category_id != 0) {
    $category_sql = "and s2c.categories_id = " . (int)$current_category_id . "";
  }

  // Check for filters on each applicable Specification
  $specs_query_raw = "SELECT DISTINCT s.specifications_id,
                                      s.filter_class,
                                      s.products_column_name,
                                      sd.specification_name,
                                      sd.specification_seo_name,
                                      s.specification_seo_active,
                                      s.filter_display
                      FROM " . TABLE_SPECIFICATION . " s
                        INNER JOIN " . TABLE_SPECIFICATION_GROUPS . " sg ON s.specification_group_id = sg.specification_group_id
                        INNER JOIN " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c ON sg.specification_group_id = s2c.specification_group_id
                        INNER JOIN " . TABLE_SPECIFICATION_DESCRIPTION . " sd ON (sd.specifications_id = s.specifications_id AND sd.language_id = " . (int)$_SESSION['languages_id'] . ")
                      WHERE s.show_filter = 'True'
                        AND sg.show_filter = 'True'
                        " . $category_sql . "
                      ORDER BY s.specification_sort_order";
					  
  $specs_query = vam_db_query($specs_query_raw);

  //breadcrumbs : preserve the result of the specs_query
  $specs_array_breadcrumb = array();

  // Build a string of SQL to constrain the specification to the filter values
  $sql_array = array(
    'from' => '',
    'where' => ''
  );

// BOF products_filters_seo
  $specifications_founded = array();
  $specifications_id_brand = 0;
// EOF products_filters_seo
//error_log('$specs_query=' . var_export($specs_query, true) . "\n", 3, __FILE__ . '-.log');
  while ($specs_array = vam_db_fetch_array($specs_query) ) {
//error_log('$specs_array=' . var_export($specs_array, true) . "\n", 3, __FILE__ . '-.log');
    // Retrieve the GET vars used as filters
    // Variable names are the letter "f" followed by the specifications_id for that spec.
    $var = 'f' . $specs_array['specifications_id'];
    $$var = '0';
    if (isset($_GET[$var]) && $_GET[$var] != '') {
      // Decode the URL-encoded names, including arrays
      $$var = vam_decode_recursive($_GET[$var]);
// BOF products_filters-slider
      if ($specs_array['filter_display'] == 'slider' && is_array($_GET[$var])) {
        $$var = implode('-', $_GET[$var]);
      }
// EOF products_filters-slider

      // Sanitize variables to prevent hacking
     //$$var = preg_replace("/^[ а-яА-Я\/]+$/","", $$var);

      // Get rid of extra values if Select All is selected
      $$var = vam_select_all_override($$var);

      // Get the breadcrumbs data for the filters that are set
      $filter_breadcrumbs = vam_get_filter_breadcrumbs($specs_array, $$var);
// BOF products_filters_seo
      if ($specs_array['specification_seo_active'] == '0') {
        $metaTags['robots'] = 'noindex,follow';
      }
      if (is_array($filter_breadcrumbs) && count($filter_breadcrumbs) > 1) {
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
      $specs_array_breadcrumb = array_merge($specs_array_breadcrumb, (array)$filter_breadcrumbs);

      // Set the correct variable type (All _GET variables are strings by default)
      $$var = vam_set_type($$var);

      // Get the SQL to apply the filters
      $sql_string_array = vam_get_filter_sql($specs_array['filter_class'], $specs_array['specifications_id'], $$var, $specs_array['products_column_name'], $_SESSION['languages_id']);
// BOF products_filters-sort
      //if (in_array($specs_array['filter_class'], array('exact', 'multiple', ))) {
        //foreach ((array)vam_db_prepare_input($$var) as $specification_value) {
          //$sql = "INSERT INTO " . TABLE_SPECIFICATION_FILTERS_STATISTICS . " (specifications_id, specification_value_id) VALUES (" . (int)$specs_array['specifications_id'] . ", " . vam_db_input($specification_value) . ")";
//          error_log($sql . "\n", 3, __FILE__.'.log');
          //vam_db_query($sql);
        //}
      //}
	 
// EOF products_filters-sort
// BOF products_filters_seo
      $specifications_founded[$var] = $_GET[$var];
//error_log('$var=' . var_export($var, true) . ' $specifications_id=' . var_export($specs_array['specifications_id'], true) . ' $filter_class=' . var_export($specs_array['filter_class'], true) . ' $products_column_name=' . var_export($specs_array['products_column_name'], true) . "\n", 3, __FILE__ . '-.log');
      if (in_array($specs_array['filter_class'], array('exact', 'multiple', ))) {
        if (!isset($_GET[$var]) || !is_array($_GET[$var])) {
//          error_log('REQUEST_URI=' . var_export($_SERVER["REQUEST_URI"], true) . "\n" . '$var=' . var_export($var, true) . "\n" . '$_GET[$var]=' . var_export($_GET[$var], true) . "\n" . '(array)$_GET[$var]=' . var_export((array)$_GET[$var], true) . "\n", 3, __FILE__.'.log');
        }
        foreach ((array)$_GET[$var] as $specs_val_ind => $specs_val) {
          $count = $spec_object->getFilterCount($specs_val, $specs_array['specifications_id'], $specs_array['filter_class'], $specs_array['products_column_name']);
//error_log('$specs_val=' . var_export($specs_val, true) . ' $specifications_id=' . var_export($specs_array['specifications_id'], true) . ' $filter_class=' . var_export($specs_array['filter_class'], true) . ' $products_column_name=' . var_export($specs_array['products_column_name'], true) . ' $count=' . var_export($count, true) . "\n", 3, __FILE__ . '-.log');
          if ($count != 0) {
            unset($get_spec[$var][$specs_val_ind]);
            if (count($get_spec[$var]) == 0) unset($get_spec[$var]);
          }
        }
      } else {
        unset($get_spec[$var]);
      }
      if ($specs_array['products_column_name'] == 'manufacturers_id') {
        $specifications_id_brand = $specs_array['specifications_id'];
      }
// EOF products_filters_seo
      $sql_array['from'] .= $sql_string_array['from'];
      $sql_array['where'] .= $sql_string_array['where'];
    } // if (isset($_GET[$var]
  } // while ($specs_array
// BOF products_filters_seo
//error_log('$get_spec=' . var_export($get_spec, true) . "\n", 3, __FILE__ . '-.log');
  if (count($get_spec) > 0) {
    $get_ignore = $_GET;
    unset($get_ignore['cPath']);
    unset($get_ignore['cat']);
  //  $url = vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_array_get_params($get_ignore));
    $url = vam_href_link(FILENAME_DEFAULT, vam_get_array_get_params($get_ignore));
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
//      error_log(__LINE__.': ' . 'redirect url=' . var_export($url, true) . "\n", 3, __FILE__.'.log');
//      header("HTTP/1.1 301 Moved Permanently");
//      header('Location: ' . $url);
//      exit();
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
  if (count($specifications_not_founded) > 0) {
    $url = vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_array_get_params($specifications_not_founded));
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
//      error_log(__LINE__.': ' . 'redirect url=' . var_export($url, true) . "\n", 3, __FILE__.'.log');
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
      $recursive_check= "and (p2c.categories_id = " . (int)$current_category_id . " AND p2c.categories_id = c.categories_id OR p2c.categories_id = c.categories_id AND c.parent_id = " . (int)$current_category_id . ")";
      $recursive_table_categories = TABLE_CATEGORIES . " c, ";
    } else {
      $recursive_check="and p2c.categories_id = " . (int)$current_category_id . "";
      $recursive_table_categories = "";
    }

  $sql_array['from'] = str_replace("LEFT JOIN " . TABLE_SPECIALS . " s ON p.products_id = s.products_id", '', $sql_array['from']);
// BOF extra_sort
// add $extra_sort_fields
// EOF extra_sort
// ALTER TABLE `vamvelosiped`.`products` ADD INDEX `idx_status_manufacturers_id` ( `products_status` , `manufacturers_id` )
  $listing_sql .= "select p.products_id,
                          p.products_fsk18,
                          p.products_shippingtime,
                          p.products_model,
                          p.products_ean,
                          p.products_price,
                          p.products_tax_class_id,
                          m.manufacturers_name,
                          p.products_quantity,
                          p.products_image,
                          p.products_weight,
                          pd.products_name,
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
                          " . $extra_sort_fields . "
                 from " . TABLE_PRODUCTS . " p
                 left join " . TABLE_SPECIALS . " s on (p.products_id = s.products_id)
                 left join " . TABLE_MANUFACTURERS . " m on (p.manufacturers_id = m.manufacturers_id)
                 left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on (p.products_id = pd.products_id and pd.language_id = " . (int)$_SESSION['languages_id'] . ")
                 left join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c on (p.products_id = p2c.products_id)
                 left join " . TABLE_ORDERS_PRODUCTS . " op on (p.products_id = op.products_id)
                   " . $sql_array['from'] . "
                 where p.products_status = 1
                   " . $sql_array['where'] . "
                ";
  if ($current_category_id != 0) {
    $subcategories_array = array();
    vam_get_subcategories($subcategories_array, $current_category_id);

    if (SPECIFICATIONS_FILTER_SUBCATEGORIES == 'True' && count($subcategories_array) > 0) {
      $category_ids = $current_category_id . ',' . implode(',', $subcategories_array);
      $listing_sql .= "    and p2c.categories_id in (" . $category_ids . ") \n";
    } else {
      $listing_sql .= "    and p2c.categories_id = " . (int)$current_category_id . " \n";
    }
  } // if ($current_category_id

  $listing_sql .= '   ' . $fsk_lock;
  $listing_sql .= '   ' . $group_check;
  $listing_sql .= '   ' . $sorting;

//    print $listing_sql . "<br>\n";

//error_log('$listing_sql=' . var_export($listing_sql, true) . "\n", 3, __FILE__ . '-.log');
  $split_page = new splitPageResults($listing_sql, $page = 1, $max_rows = 9999, $count_key = '*');
//error_log('$split_page->number_of_rows=' . var_export($split_page->number_of_rows, true) . "\n", 3, __FILE__ . '-.log');
  if ($split_page->number_of_rows == 0) {
    $get_ignore = $_GET;
    unset($get_ignore['cPath']);
    unset($get_ignore['cat']);
  //  $url = vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_array_get_params($get_ignore));
    $url = vam_href_link(FILENAME_DEFAULT, vam_get_array_get_params($get_ignore));
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
//      error_log(__LINE__.': ' . 'redirect url=' . var_export($url, true) . "\n", 3, __FILE__.'.log');
      header("HTTP/1.1 301 Moved Permanently");
      header('Location: ' . $url);
      exit();
    }
  }
  $specifications_filter_listing_sql = $listing_sql;
// include boxes
  require(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

//die;

//  echo '<pre>';var_export($specs_array_breadcrumb);echo '</pre>';
  // Add Filter to Breadcrumbs if selected

  // Add Filter to Breadcrumbs if selected
if (SPECIFICATIONS_FILTER_BREADCRUMB == 'True') {
    foreach ($specs_array_breadcrumb as $crumb) {


        $get_key = 'f' . $crumb['specifications_id'];

        //if( $_GET['show_crumb'] == '1') echo is_array($_GET[$get_key])."\r\n";

        //if( $_GET['show_crumb'] == '1') {

            if (!is_array($_GET[$get_key])) {

                $exclude_array = array('f' . $crumb['specifications_id']);
                $breadcrumb->add('<span>'. $crumb['specification_name'] . ' : ' . $crumb['value'] . ' <span class="filter-close circle text-danger cart_delete"><i class="fas fa-times"></i></span></span>', vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_all_get_params($exclude_array)));

            } else {

                foreach ($_GET[$get_key] as $new_key => $new_value) {

                    if($crumb['value'] == $new_value) {
                        $exclude_array = array('f' . $crumb['specifications_id'] . '[' . $new_key . ']');
                        $breadcrumb->add('<span>'. $crumb['specification_name'] . ' : ' . $crumb['value'] . ' <span class="filter-close circle text-danger cart_delete"><i class="fas fa-times"></i></span></span>', vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_all_get_params_filters_breadhumps($exclude_array)));
                    }
                }

            }


        //}else{

            //$exclude_array = array('f' . $crumb['specifications_id']);
            //$breadcrumb->add($crumb['specification_name'] . ' : ' . $crumb['value'] . ' <span class="filter-close circle text-danger cart_delete"><i class="fas fa-times"></i></span>', vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_all_get_params($exclude_array)));

        //}

        //if( $_GET['show_crumb'] == '1') echo 'f' . $crumb['specifications_id'] . " \r\n\ ";
        
        //if( $_GET['show_crumb'] == '1' && $crumb['value'] == 'Comisa') var_dump(vam_get_all_get_params_filters_breadhumps (array ($exclude_array), true ));

      //$breadcrumb->add ($crumb['specification_name'] . ' : ' . $crumb['value'] . ' <span class="filter-close circle text-danger cart_delete"><i class="fas fa-times"></i></span>', FILENAME_PRODUCTS_FILTERS.'?'.$params[0];
    }
  }
// BOF products_filters_seo
  $seo_text = array();
  $man_name = '';
  foreach ($specs_array_breadcrumb as $crumb) {
    if ($crumb['specifications_id'] != $specifications_id_brand) {
      if (empty($crumb['specification_seo_name'])) $crumb['specification_seo_name'] = $crumb['specification_name'] . ' %s';
      if (strpos($crumb['specification_seo_name'], '%s') === false) $crumb['specification_seo_name'] .= ' %s';
      if ($crumb['specification_name'] == $crumb['value']) {
        $seo_text[] = sprintf($crumb['specification_seo_name'], '');
      } else {
        $seo_text[] = sprintf($crumb['specification_seo_name'], mb_strtolower($crumb['value']));
      }
    } else {
      $man_name = ' ' . $crumb['value'];
    }
  } 

  // Show the Filters module here if set in Admin
  if (SPECIFICATIONS_FILTERS_MODULE == 'True') {
  //  require(DIR_WS_MODULES . 'products_filter.php');
  }

	
require(DIR_WS_INCLUDES . 'header.php');
 $timeExec=time();
include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING);
$timeExec2=time();

$breadCrumbsToH1 = implode(", ", $specs_array_breadcrumb_titles);
$vamTemplate->assign('breadCrumbsToH1', $breadCrumbsToH1);
$vamTemplate->assign('language', $_SESSION['language']);

$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/' . CURRENT_TEMPLATE . '/' . FILENAME_PRODUCTS_FILTERS . '.html') ? CURRENT_TEMPLATE . '/' . FILENAME_PRODUCTS_FILTERS . '.html' : CURRENT_TEMPLATE . '/index.html');
$vamTemplate->display($template);

include('includes/application_bottom.php'); 
