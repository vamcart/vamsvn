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


  require_once ('includes/application_top.php');

  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');

$vamTemplate = new vamTemplate;

// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$vamTemplate->assign('session', session_id());
$module = new vamTemplate;
  
// Block Robots
// Set a Robots NoIndex if the sort field is set
  $robots_tag = '';
  if ( (isset ($_GET['sort'])) || (preg_match ('/[1-9][ad]/', $_GET['sort'])) ) {
    $robots_tag = '<meta name="robots" content="noindex,follow">';
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
                        sd.specification_name,
                        sd.specification_description
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
  // print $specs_query_raw . "<br>\n";
  $specs_query = vam_db_query ($specs_query_raw);

  //breadcrumbs : preserve the result of the specs_query
  $specs_array_breadcrumb = array(); 
  
  // Build a string of SQL to constrain the specification to the filter values
  $sql_array = array (
    'from' => '',
    'where' => ''
  );

  while ($specs_array = vam_db_fetch_array ($specs_query) ) {
    // Retrieve the GET vars used as filters
    // Variable names are the letter "f" followed by the specifications_id for that spec.
    $var = 'f' . $specs_array['specifications_id'];
    $$var = '0';
    if (isset ($_GET[$var]) && $_GET[$var] != '') {
      // Decode the URL-encoded names, including arrays
      $$var = vam_decode_recursive ($_GET[$var]);

      // Sanitize variables to prevent hacking     //$$var = preg_replace("/^[ а-яА-Я\/]+$/","", $$var);
       
      // Get rid of extra values if Select All is selected      $$var = vam_select_all_override ($$var);
      
      // Get the breadcrumbs data for the filters that are set
      $filter_breadcrumbs = vam_get_filter_breadcrumbs ($specs_array, $$var);
      $specs_array_breadcrumb = array_merge ($specs_array_breadcrumb, (array) $filter_breadcrumbs);
      
      // Set the correct variable type (All _GET variables are strings by default)
      $$var = vam_set_type ($$var);
    
      // Get the SQL to apply the filters
      $sql_string_array = vam_get_filter_sql ($specs_array['filter_class'], $specs_array['specifications_id'], $$var, $specs_array['products_column_name'], $_SESSION['languages_id']);
      $sql_array['from'] .= $sql_string_array['from'];
      $sql_array['where'] .= $sql_string_array['where'];
      
    } // if (isset ($_GET[$var]
  } // while ($specs_array
    
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
    if (!$sorting_data['products_sorting'])
    $sorting_data['products_sorting'] = 'pd.products_name';
    $sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
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
      
  $listing_sql .= "select distinct p.products_id,
                                  p.label_id,
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
                   IF(s.status, s.specials_new_products_price, NULL)
                     as specials_new_products_price,
                   IF(s.status, s.specials_new_products_price, p.products_price)
                     as final_price
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

  // print $listing_sql . "<br>\n";

  // Add Filter to Breadcrumbs if selected
if (SPECIFICATIONS_FILTER_BREADCRUMB == 'True') {
    foreach ($specs_array_breadcrumb as $crumb) {


        $get_key = 'f' . $crumb['specifications_id'];

        //if( $_GET['show_crumb'] == '1') echo is_array($_GET[$get_key])."\r\n";

        //if( $_GET['show_crumb'] == '1') {

            if (!is_array($_GET[$get_key])) {

                $exclude_array = array('f' . $crumb['specifications_id']);
                $breadcrumb->add('<span>'. $crumb['specification_name'] . ' : ' . $crumb['value'] . ' <span class="circle text-danger cart_delete"><i class="fas fa-times"></i></span></span>', vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_all_get_params($exclude_array)));

            } else {

                foreach ($_GET[$get_key] as $new_key => $new_value) {

                    if($crumb['value'] == $new_value) {
                        $exclude_array = array('f' . $crumb['specifications_id'] . '[' . $new_key . ']');
                        $breadcrumb->add('<span>'. $crumb['specification_name'] . ' : ' . $crumb['value'] . ' <span class="circle text-danger cart_delete"><i class="fas fa-times"></i></span></span>', vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_all_get_params_filters_breadhumps($exclude_array)));
                    }
                }

            }


        //}else{

            //$exclude_array = array('f' . $crumb['specifications_id']);
            //$breadcrumb->add($crumb['specification_name'] . ' : ' . $crumb['value'] . ' <span class="close">[X]</span>', vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_all_get_params($exclude_array)));

        //}

        //if( $_GET['show_crumb'] == '1') echo 'f' . $crumb['specifications_id'] . " \r\n\ ";
        
        //if( $_GET['show_crumb'] == '1' && $crumb['value'] == 'Comisa') var_dump(vam_get_all_get_params_filters_breadhumps (array ($exclude_array), true ));

      //$breadcrumb->add ($crumb['specification_name'] . ' : ' . $crumb['value'] . ' <span class="close">[X]</span>', FILENAME_PRODUCTS_FILTERS.'?'.$params[0];
    }
  }
 
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