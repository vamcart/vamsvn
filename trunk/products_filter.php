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

  require_once (DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCTS_FILTERS);

// Block Robots
// Set a Robots NoIndex if the sort field is set
  $robots_tag = '';
  if ( (isset ($_GET['sort'])) || (preg_match ('/[1-9][ad]/', $_GET['sort'])) ) {
    $robots_tag = '<meta name="robots" content="noindex,follow">';
 }
  
  $category_sql = '';
  if ($current_category_id != 0) {
    $category_sql = "and s2c.categories_id = '" . $current_category_id . "'";
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
                        and sd.language_id = '" . (int) $languages_id . "'
                        " . $category_sql;
  // print $specs_query_raw . "<br>\n";
  $specs_query = tep_db_query ($specs_query_raw);

  //breadcrumbs : preserve the result of the specs_query
  $specs_array_breadcrumb = array(); 
  
  // Build a string of SQL to constrain the specification to the filter values
  $sql_array = array (
    'from' => '',
    'where' => ''
  );

  while ($specs_array = tep_db_fetch_array ($specs_query) ) {
    // Retrieve the GET vars used as filters
    // Variable names are the letter "f" followed by the specifications_id for that spec.
    $var = 'f' . $specs_array['specifications_id'];
    $$var = '0';
    if (isset ($_GET[$var]) && $_GET[$var] != '') {
      // Decode the URL-encoded names, including arrays
//      $$var = tep_decode_recursive ($_GET[$var]);

      $$var = $_GET[$var];
      
      // Sanitize variables to prevent hacking
     $$var = preg_replace("/^[ а-яА-Я\/]+$/","", $$var);
       
      // Get rid of extra values if Select All is selected
      $$var = tep_select_all_override ($$var);
      
      // Get the breadcrumbs data for the filters that are set
      $filter_breadcrumbs = tep_get_filter_breadcrumbs ($specs_array, $$var);
      $specs_array_breadcrumb = array_merge ($specs_array_breadcrumb, (array) $filter_breadcrumbs);
      
      // Set the correct variable type (All _GET variables are strings by default)
      $$var = tep_set_type ($$var);
    
      // Get the SQL to apply the filters
      $sql_string_array = tep_get_filter_sql ($specs_array['filter_class'], $specs_array['specifications_id'], $$var, $specs_array['products_column_name'], $languages_id);
      $sql_array['from'] .= $sql_string_array['from'];
      $sql_array['where'] .= $sql_string_array['where'];
      
    } // if (isset ($_GET[$var]
  } // while ($specs_array
    
  // create column list
  $define_list = array ('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                        'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                        'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                        'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                        'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                        'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                        'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                        'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);

  asort ($define_list);

  $column_list = array();
  reset ($define_list);

  while (list ($key, $value) = each ($define_list) ) {
    if ($value > 0) $column_list[] = $key;
  }

  $listing_sql = '            select distinct ';

  for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
    switch ($column_list[$i]) {
      case 'PRODUCT_LIST_MODEL':
        $listing_sql .= "p.products_model, \n";
        break;
      case 'PRODUCT_LIST_NAME':
        $listing_sql .= "pd.products_name, \n";
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $listing_sql .= "mi.manufacturers_name, \n";
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $listing_sql .= "p.products_quantity, \n";
        break;
      case 'PRODUCT_LIST_IMAGE':
        $listing_sql .= "p.products_image, \n";
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $listing_sql .= "p.products_weight, \n";
        break;
    } //switch
  } //for
  
  $listing_sql .= "p.products_id,
                   p.products_model,
                   p.manufacturers_id,
                   mi.manufacturers_name,
                   p.products_price,
                   p.products_tax_class_id,
                   IF(s.status, s.specials_new_products_price, NULL)
                     as specials_new_products_price,
                   IF(s.status, s.specials_new_products_price, p.products_price)
                     as final_price
                 from
                   " . TABLE_PRODUCTS . " p
                 left join " . TABLE_SPECIALS . " s
                   on p.products_id = s.products_id
                 left join " . TABLE_MANUFACTURERS_INFO . " mi
                   on p.manufacturers_id = mi.manufacturers_id
                 join " . TABLE_PRODUCTS_DESCRIPTION . " pd
                   on p.products_id = pd.products_id
                 join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                   on p.products_id = p2c.products_id
                   " . $sql_array['from'] . "
                 where
                   p.products_status = '1'
                   and pd.language_id = '" . (int) $languages_id . "'
                   " . $sql_array['where'] . "
                ";

  if ($current_category_id != 0) {
    $subcategories_array = array();
    tep_get_subcategories ($subcategories_array, $current_category_id);
        
    if (SPECIFICATIONS_FILTER_SUBCATEGORIES == 'True' && count ($subcategories_array) > 0) {
      $category_ids = $current_category_id . ',' . implode (',', $subcategories_array);
      $listing_sql .= '   ' . "and p2c.categories_id in (" . $category_ids . ") \n";
      
    } else {
      $listing_sql .= '   ' . "and p2c.categories_id = '" . $current_category_id . "' \n";
    }
  } // if ($current_category_id

  if ( (!isset($_GET['sort'])) || (!preg_match('/^[1-8][ad]$/', $_GET['sort'])) || (substr($_GET['sort'], 0, 1) > sizeof($column_list)) ) {
    $_GET['sort'] = 'products_name';
    $listing_sql .= "             order by pd.products_name";
    
  } else {
    $sort_col = substr ($_GET['sort'], 0 , 1);
    $sort_order = substr ($_GET['sort'], 1);

    switch ($column_list[$sort_col-1]) {
      case 'PRODUCT_LIST_MODEL':
        $listing_sql .= "             order by p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_NAME':
        $listing_sql .= "             order by pd.products_name " . ($sort_order == 'd' ? 'desc' : '');
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $listing_sql .= "             order by mi.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $listing_sql .= "             order by p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_IMAGE':
        $listing_sql .= "             order by pd.products_name";
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $listing_sql .= "             order by p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_PRICE':
        $listing_sql .= "             order by final_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
    } // switch ($column_list
  } // if ( (!isset($_GET['sort'] ... else ...
  // print $listing_sql . "<br>\n";

// Get the right image for the top-right
  $image = DIR_WS_IMAGES . 'table_background_list.gif';
  if ($current_category_id > 0) {
    $image = tep_db_query ("select categories_image 
                            from " . TABLE_CATEGORIES . " 
                            where categories_id = '" . (int) $current_category_id . "'
                          ");
    $image = tep_db_fetch_array ($image);
    $image = $image['categories_image'];
  }

  // Add Filter to Breadcrumbs if selected
  if (SPECIFICATIONS_FILTER_BREADCRUMB == 'True') {
    foreach ($specs_array_breadcrumb as $crumb) {
      $breadcrumb->add ($crumb['specification_name'] . ' : ' . $crumb['value'] . ' <span class="close">[X]</span>', tep_href_link (FILENAME_PRODUCTS_FILTERS, tep_get_all_get_params (array ('f' . $crumb['specifications_id']) ) ) );
    }
  }
 
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<?php
// BOF: WebMakers.com Changed: Header Tag Controller v1.0
// Replaced by header_tags.php
if ( file_exists(DIR_WS_INCLUDES . 'header_tags.php') ) {
  require(DIR_WS_INCLUDES . 'header_tags.php');
} else {
?>
  <title><?php echo TITLE ?></title>
<?php
}
// EOF: WebMakers.com Changed: Header Tag Controller v1.0
?>
<?php
// Block Robots
  echo $robots_tag;
?>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="3" cellpadding="3">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="0" cellpadding="2">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_specials.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  // Show the Filters module here if set in Admin
  if (SPECIFICATIONS_FILTERS_MODULE == 'True') {
?>
      <tr>
        <td><?php echo tep_draw_separator ('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td>
<?php
    require (DIR_WS_MODULES . 'products_filter.php');
?>
        </td>
      </tr>
<?php
  }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
      </tr>
      <tr>
        <td><br><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_COL); ?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="0" cellpadding="2">
<!-- right_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_right.php'); ?>
<!-- right_navigation_eof //-->
    </table></td>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>