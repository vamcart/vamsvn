<?php
/*
  $Id: products_specifications.php vv1.0 20090909 kymation 
  Based on: categories.php 1755 2007-12-21 14:02:36Z hpdl
  $Loc: catalog/admin/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

  require_once ('includes/application_top.php');

  require_once (DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');

// Get the $action value and filter it
  $action = (isset ($_GET['action']) ? $_GET['action'] : '');
  $action = preg_replace ("(\r\n|\n|\r)", '', $action);  // Remove CR &/ LF
  $action = preg_replace ("/[^0-9a-z_-]/i", '', $action); // strip all but numbers, lower case alpha, - and _

// Define variables for Selected items and Paths
  $specs_group_id = (isset ($_GET['sgid']) ? (int) $_GET['sgid'] : 0); // Selected Specification Group
  $specification_id = (isset ($_GET['spid']) ? (int) $_GET['spid'] : 0); // Selected Specification
  $filter_id = (isset ($_GET['fid']) ? (int) $_GET['fid'] : 0); // Selected Filter
  $value_id = (isset ($_GET['vid']) ? (int) $_GET['vid'] : 0); // Selected Filter Value
  $specs_group_path = (isset ($_GET['sgpath']) ? (int) $_GET['sgpath'] : 0); // Specification Group contents
  $specs_path = (isset ($_GET['spath']) ? (int) $_GET['spath'] : 0); // Specification contents
  $value = (isset ($_GET['value']) ? (int) $_GET['value'] : 0); // Show Values
  $flag = (isset ($_GET['flag']) ? (int) $_GET['flag'] : 0); // Flag sets true/false values

// Start the processing by $action
  if (vam_not_null ($action)) {
    switch ($action) {
////
// Actions for the second pass

// Specification Groups section
      // Turn the Comparison page on and off for this Specification Group
      case 'flag_comparison':
        if ( ($flag == '0' || $flag == '1') && $specs_group_id != 0) {
          $db_flag = ($flag == '1') ? 'True' : 'False';
          vam_db_query ("update " . TABLE_SPECIFICATION_GROUPS . " 
                         set show_comparison = '" . $db_flag . "' 
                         where specification_group_id = '" . $specs_group_id . "'
                      ");
        }

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $specs_group_id) );
        break;
        
      // Turn the Products Info page display on and off for this Specification Group
      case 'flag_products':
        if ( ($flag == '0' || $flag == '1') && $specs_group_id != 0) {
          $db_flag = ($flag == '1') ? 'True' : 'False';
          vam_db_query ("update " . TABLE_SPECIFICATION_GROUPS . " 
                         set show_products = '" . $db_flag . "' 
                         where specification_group_id = '" . $specs_group_id . "'
                      ");
        }
        
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $specs_group_id) );
        break;
        
      // Turn this Specification Group's Filters on and off 
      case 'flag_filters':
        if ( ($flag == '0' || $flag == '1') && $specs_group_id != 0) {
          $db_flag = ($flag == '1') ? 'True' : 'False';
          vam_db_query ("update " . TABLE_SPECIFICATION_GROUPS . " 
                         set show_filter = '" . $db_flag . "' 
                         where specification_group_id = '" . $specs_group_id . "'
                      ");
        }
        
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $specs_group_id) );
        break;
      
      // New or modified Specification Group
      case 'new_group_confirm':
      case 'update_group_confirm':
        $show_comparison = 'False';
        if ($_POST['show_comparison'] == 'False' || $_POST['show_comparison'] == 'True') {
          $show_comparison = ($_POST['show_comparison'] == 'True') ? 'True' : 'False';
        }
        
        $show_products = 'False';
        if ($_POST['show_products'] == 'False' || $_POST['show_products'] == 'True') {
          $show_products = ($_POST['show_products'] == 'True') ? 'True' : 'False';
        }
        
        $show_filter = 'False';
        if ($_POST['show_filter'] == 'False' || $_POST['show_filter'] == 'True') {
          $show_filter = ($_POST['show_filter'] == 'True') ? 'True' : 'False';
        }

        $show_filter_mainpage = 'False';
        if ($_POST['show_filter_mainpage'] == 'False' || $_POST['show_filter_mainpage'] == 'True') {
          $show_filter_mainpage = ($_POST['show_filter_mainpage'] == 'True') ? 'True' : 'False';
        }
        
        $sql_data_array = array ('specification_group_name' => vam_db_prepare_input ($_POST['specification_group_name']),
                                 'show_comparison' => $show_comparison,
                                 'show_products' => $show_products,
                                 'show_filter' => $show_filter,
                                 'show_filter_mainpage' => $show_filter_mainpage
        );

        if ($action == 'new_group_confirm') { //Add a new row
          vam_db_perform (TABLE_SPECIFICATION_GROUPS, $sql_data_array);
          $specifications_group_id = vam_db_insert_id();
          
        } elseif ($action == 'update_group_confirm') { //Modify the existing row
          $specifications_group_id = (int) $_POST['specification_group_id'];
          vam_db_perform (TABLE_SPECIFICATION_GROUPS, $sql_data_array, 'update', "specification_group_id = '" . $specifications_group_id . "'");
        }

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $specifications_group_id) );
        break;
        
      // Copy a Specification Group
      case 'copy_group_confirm':
        $group_id = (int) $_POST['specification_group_id'];
        if (isset ($_POST['specification_group_id']) && $_POST['specification_group_id'] != 0) {
          $group_query_raw = "select specification_group_name,
                                     show_comparison,
                                     show_products,
                                     show_filter,
                                     show_filter_mainpage
                              from " . TABLE_SPECIFICATION_GROUPS . " 
                              where specification_group_id = '" . $group_id . "'
                             ";
          $group_query = vam_db_query ($group_query_raw);
          $group_array = vam_db_fetch_array ($group_query);

          $sql_data_array = array ('specification_group_name' => $group_array['specification_group_name'],
                                   'show_comparison' => $group_array['show_comparison'],
                                   'show_products' => $group_array['show_products'],
                                   'show_filter' => $group_array['show_filter'],
                                   'show_filter_mainpage' => $group_array['show_filter_mainpage']
                                  );
          vam_db_perform (TABLE_SPECIFICATION_GROUPS, $sql_data_array);
          $new_group_id = vam_db_insert_id();
        
          // Also copy specifications if selected
          if (isset ($_POST['copy_specs']) && $_POST['copy_specs'] == 'True') {
            $specs_query_raw = "select specifications_id,
                                       specification_sort_order,
                                       show_comparison,
                                       show_products,
                                       show_filter,
                                       show_filter_mainpage,
                                       products_column_name,
                                       column_justify,
                                       filter_class,
                                       filter_display,
                                       filter_show_all,
                                       enter_values
                                from " . TABLE_SPECIFICATION . "
                                where specification_group_id = '" . $group_id . "' 
                              ";
            // print $specs_query_raw . "<br />\n";
            $specs_query = vam_db_query ($specs_query_raw);
            
            $specifications_ids = array();
            while ($specs_array = vam_db_fetch_array ($specs_query) ) {
              $sql_data_array = array ('specification_group_id' => $new_group_id,
                                       'specification_sort_order' => $specs_array['specification_sort_order'],
                                       'show_comparison' => $specs_array['show_comparison'],
                                       'show_products' => $specs_array['show_products'],
                                       'show_filter' => $specs_array['show_filter'],
                                       'show_filter_mainpage' => $specs_array['show_filter_mainpage'],
                                       'products_column_name' => $specs_array['products_column_name'],
                                       'column_justify' => $specs_array['column_justify'],
                                       'filter_class' => $specs_array['filter_class'],
                                       'filter_display' => $specs_array['filter_display'],
                                       'filter_show_all' => $specs_array['filter_show_all'],
                                       'enter_values' => $specs_array['enter_values']
                                      );
              vam_db_perform (TABLE_SPECIFICATION, $sql_data_array);
              $new_specs_id = vam_db_insert_id();
              $specifications_ids[] = array ('old_id' => $specs_array['specifications_id'],
                                             'new_id' => $new_specs_id
                                            );
              
            }
          } // if (isset ($_POST['copy_specs']

          // Also copy links to Categories if selected
          if (isset ($_POST['copy_links']) && $_POST['copy_links'] == 'True') {
            $links_query_raw = "select categories_id
                                from " . TABLE_SPECIFICATIONS_TO_CATEGORIES . "
                                where specification_group_id = '" . $group_id . "' 
                              ";
            // print $links_query_raw . "<br />\n";
            $links_query = vam_db_query ($links_query_raw);

            while ($links_data = vam_db_fetch_array ($links_query) ) {
              $sql_data_array = array ('categories_id' => $group_array['categories_id'],
                                       'specification_group_id' => $new_specs_id
                                      );
              vam_db_perform (TABLE_SPECIFICATIONS_TO_CATEGORIES, $sql_data_array);
            }
          } // if (isset ($_POST['copy_links']
        
          // Also copy product specifications if selected
          if (isset ($_POST['copy_products']) && $_POST['copy_products'] == 'True') {
            foreach ($specifications_ids as $specs_id) {
              $products_query_raw = "select products_id,
                                            language_id,
                                            specification
                                     from " . TABLE_PRODUCTS_SPECIFICATIONS . "
                                     where specifications_id = '" . $specs_id['old_id'] . "' 
                                   ";
              // print $products_query_raw . "<br />\n";
              $products_query = vam_db_query ($products_query_raw);

              while ($products_data = vam_db_fetch_array ($products_query) ) {
                $sql_data_array = array ('specifications_id' => $specs_id['new_id'],
                                         'products_id' => $specs_array['products_id'],
                                         'language_id' => $specs_array['language_id'],
                                         'specification' => $specs_array['specification']
                                        );
                vam_db_perform (TABLE_PRODUCTS_SPECIFICATIONS, $sql_data_array);
              }
            }
          } // if (isset ($_POST['copy_products']
        
          // Also copy filters if selected
          if (isset ($_POST['copy_filter']) && $_POST['copy_filter'] == 'True') {
            foreach ($specifications_ids as $specs_id) {
              $filters_query_raw = "select specification_filters_id,
                                           filter_sort_order
                                    from " . TABLE_SPECIFICATIONS_FILTERS . "
                                    where specifications_id = '" . $specs_id['old_id'] . "' 
                                  ";
              // print $filters_query_raw . "<br />\n";
              $filters_query = vam_db_query ($filters_query_raw);

              while ($filters_data = vam_db_fetch_array ($filters_query) ) {
                $sql_data_array = array ('specifications_id' => $specs_id['new_id'],
                                         'filter_sort_order' => $filters_data['filter_sort_order']
                                        );
                vam_db_perform (TABLE_SPECIFICATIONS_FILTERS, $sql_data_array);
                $new_specification_filters_id = vam_db_insert_id();
                
                $languages = vam_get_languages();
                for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
                  $filters_description_query_raw = "select filter
                                                    from " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . "
                                                    where specification_filters_id = '" . $filters_data['specification_filters_id'] . "' 
                                                      and language_id = '" . (int) $languages[$i]['id'] . "' 
                                                  ";
                  // print $filters_description_query_raw . "<br />\n";
                  $filters_description_query = vam_db_query ($filters_description_query_raw);

                  $filters_description_data = vam_db_fetch_array ($filters_description_query);
                  $sql_data_array = array ('specification_filters_id' => $new_specification_filters_id,
                                           'language_id' => (int) $languages[$i]['id'],
                                           'filter' => $filters_description_data['filter']
                                          );
                  vam_db_perform (TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION, $sql_data_array);
                } // for ($i=0
              } // while ($filters_data
            } // foreach ($specifications_ids
          } // if (isset ($_POST['copy_filter']
        
          // Also copy specification values if selected
          if (isset ($_POST['copy_values']) && $_POST['copy_values'] == 'True') {
            foreach ($specifications_ids as $specs_id) {
              $values_query_raw = "select specification_values_id,
                                          value_sort_order
                                     from " . TABLE_SPECIFICATIONS_VALUES . "
                                     where specifications_id = '" . $specs_id['old_id'] . "' 
                                   ";
              // print $values_query_raw . "<br />\n";
              $values_query = vam_db_query ($values_query_raw);

              while ($values_data = vam_db_fetch_array ($values_query) ) {
                $sql_data_array = array ('specifications_id' => $specs_id['new_id'],
                                         'value_sort_order' => $values_data['value_sort_order']
                                        );
                vam_db_perform (TABLE_SPECIFICATIONS_VALUES, $sql_data_array);
                $new_specification_values_id = vam_db_insert_id();
                
                $languages = vam_get_languages();
                for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
                  $values_description_query_raw = "select specification_value
                                                    from " . TABLE_SPECIFICATIONS_VALUES_DESCRIPTION . "
                                                    where specification_values_id = '" . $values_data['specification_values_id'] . "' 
                                                      and language_id = '" . (int) $languages[$i]['id'] . "' 
                                                  ";
                  // print $values_description_query_raw . "<br />\n";
                  $values_description_query = vam_db_query ($values_description_query_raw);

                  $values_description_data = vam_db_fetch_array ($values_description_query);
                  $sql_data_array = array ('specification_values_id' => $new_specification_values_id,
                                           'language_id' => (int) $languages[$i]['id'],
                                           'specification_value' => $values_description_data['specification_value']
                                          );
                  vam_db_perform (TABLE_SPECIFICATIONS_VALUES_DESCRIPTION, $sql_data_array);
                } // for ($i=0
              } // while ($products_data
            } // foreach ($specifications_ids
          } // if (isset ($_POST['copy_values']
          
        } // if (isset ($_POST['specification_group_id'
        
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $new_group_id) );
        break;
        
      // Delete a Specification Group
      case 'delete_group_confirm':
        if (isset ($_POST['specification_group_id']) &&  $_POST['specification_group_id'] != 0) {
          $specs_group_id = (int) $_POST['specification_group_id'];
          // Check if there are any specifications attached
          $specs_query_raw = "select specifications_id
                              from " . TABLE_SPECIFICATION . "
                              where specification_group_id = '" . $specs_group_id . "' 
                            ";
          // print $specs_query_raw . "<br />\n";
          $specs_query = vam_db_query ($specs_query_raw);
          if (vam_db_num_rows ($specs_query) > 0) { //We have specifications attached
            while ($specs_data = vam_db_fetch_array ($specs_query) ) {
              // Check if we have any filters attached to each specification
              $filters_query_raw = "select specification_filters_id
                                    from " . TABLE_SPECIFICATIONS_FILTERS . "
                                    where specifications_id = '" . $specs_data['specifications_id'] . "' 
                                  ";
              // print $filters_query_raw . "<br />\n";
              $filters_query = vam_db_query ($filters_query_raw);
              if (vam_db_num_rows ($filters_query) > 0) { //Delete the filters
                $filters_data = vam_db_fetch_array ($filters_query);
                vam_db_query ("delete from " . TABLE_SPECIFICATIONS_FILTERS . " where specifications_id = '" . $specs_data['specifications_id'] . "'");
                vam_db_query ("delete from " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " where specification_filters_id = '" . $filters_data['specification_filters_id'] . "'");
              } //if (vam_db_num_rows ($filters_query
            
              // Check if we have any specification values attached to each specification
              $values_query_raw = "select specification_values_id
                                    from " . TABLE_SPECIFICATIONS_VALUES . "
                                    where specifications_id = '" . $specs_data['specifications_id'] . "' 
                                  ";
              // print $values_query_raw . "<br />\n";
              $values_query = vam_db_query ($values_query_raw);
              if (vam_db_num_rows ($values_query) > 0) { //Delete the values
                $values_data = vam_db_fetch_array ($values_query);
                vam_db_query ("delete from " . TABLE_SPECIFICATIONS_VALUES . " where specifications_id = '" . $specs_data['specifications_id'] . "'");
                vam_db_query ("delete from " . TABLE_SPECIFICATIONS_VALUES_DESCRIPTION . " where specification_values_id = '" . $values_data['specification_values_id'] . "'");
              } //if (vam_db_num_rows ($filters_query

              // Check if we have any products with specification data attached to each specification
              $products_query_raw = "select products_specification_id
                                    from " . TABLE_PRODUCTS_SPECIFICATIONS . "
                                    where specifications_id = '" . $specs_data['specifications_id'] . "' 
                                  ";
              // print $products_query_raw . "<br />\n";
              $products_query = vam_db_query ($products_query_raw);
              if (vam_db_num_rows ($products_query) > 0) { // Delete the product data
                vam_db_query ("delete from " . TABLE_PRODUCTS_SPECIFICATIONS . " where specifications_id = '" . $specs_data['specifications_id'] . "'");
              } //if (vam_db_num_rows ($filters_query
            } // while ($specs_data
            
            // Once everything attached to this specification is deleted, delete the specification
            vam_db_query ("delete from " . TABLE_SPECIFICATION . " where specifications_id = '" . $specs_data['specifications_id'] . "'");
            vam_db_query ("delete from " . TABLE_SPECIFICATION_DESCRIPTION . " where specifications_id = '" . $specs_data['specifications_id'] . "'");
          } //if (vam_db_num_rows ($specs_query
          
          // Once everything attached to this group is deleted, delete the group and the links
          vam_db_query ("delete from " . TABLE_SPECIFICATION_GROUPS . " where specification_group_id = '" . $specs_group_id . "'");
          vam_db_query ("delete from " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " where specification_group_id = '" . $specs_group_id . "'");
        }

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS) );
        break;
        
      // Link a Specification Group to a Category
      case 'link_category_confirm':
        // Link a specification group to a product category
        $specification_group_id = (int) $_POST['specification_group_id'];
        $categories_id = (int) $_POST['link_category_id'];
        $link_subcats = ($_POST['link_subcats'] == 'True') ? 'True' : 'False';
        
        if ($specification_group_id != 0) {
          $links_query_raw = "select specification_group_id
                              from " . TABLE_SPECIFICATIONS_TO_CATEGORIES . "
                              where specification_group_id = '" . $specification_group_id . "' 
                                and categories_id = '" . $categories_id . "'
                            ";
          //print $links_query_raw . "<br />\n";
          $links_query = vam_db_query ($links_query_raw);
          if (vam_db_num_rows ($links_query) < 1) {
            $sql_data_array = array ('specification_group_id' => $specification_group_id,
                                     'categories_id' => $categories_id
            );
            vam_db_perform (TABLE_SPECIFICATIONS_TO_CATEGORIES, $sql_data_array);
          } // if (vam_db_num_rows
        }
        
        // Link all subcategories if selected
        if ($link_subcats == 'True' && vam_has_category_subcategories ($categories_id)) {
          $categories_array = array();
          vam_get_subcategories ($categories_array, $categories_id);
          foreach ($categories_array as $categories_id) {
            $sql_data_array = array();
            $links_query_raw = "select specification_group_id
                                from " . TABLE_SPECIFICATIONS_TO_CATEGORIES . "
                                where specification_group_id = '" . $specification_group_id . "' 
                                  and categories_id = '" . $categories_id . "'
                              ";
            //print $links_query_raw . "<br />\n";
            $links_query = vam_db_query ($links_query_raw);
            if (vam_db_num_rows ($links_query) < 1) {
              $sql_data_array = array ('specification_group_id' => $specification_group_id,
                                       'categories_id' => $categories_id
              );
              vam_db_perform (TABLE_SPECIFICATIONS_TO_CATEGORIES, $sql_data_array);
            } // if (vam_db_num_rows
          } // foreach ($categories_array
        } // if ($link_subcats
        
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $specification_group_id) );
        break;
        
      // Link a Specification Group to all Categories
      case 'link_all_categories_confirm':
        // Link a specification group to all product categories
        if (isset ($_POST['specification_group_id']) &&  $_POST['specification_group_id'] != 0) {
          $specification_group_id = (int) $_POST['specification_group_id'];
          $categories_array = vam_get_category_tree();
          foreach ($categories_array as $category_data) {
            $sql_data_array = array();
            $links_query_raw = "select specification_group_id
                                from " . TABLE_SPECIFICATIONS_TO_CATEGORIES . "
                                where specification_group_id = '" . $specification_group_id . "' 
                                  and categories_id = '" . $category_data['id'] . "'
                              ";
            //print $links_query_raw . "<br />\n";
            $links_query = vam_db_query ($links_query_raw);
            if (vam_db_num_rows ($links_query) < 1) {
              $sql_data_array = array ('specification_group_id' => $specification_group_id,
                                       'categories_id' => $category_data['id']
              );
              vam_db_perform (TABLE_SPECIFICATIONS_TO_CATEGORIES, $sql_data_array);
            } // if (vam_db_num_rows
          } // foreach ($categories_array
        } // if (isset 

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $specification_group_id) );
        break;
        
      // Unlink a Specification Group from a Category
      case 'unlink_category_confirm':
        // Delete the link from a specification group to a product category
        $specification_group_id = (int) $_POST['specification_group_id'];
        if (isset ($_POST['specification_group_id']) &&  $_POST['specification_group_id'] != 0) {
          $categories_id = (int) $_POST['categories_id'];
          
          vam_db_query ("delete from " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " 
                         where specification_group_id = '" . $specification_group_id . "'
                           and categories_id = '" . $categories_id . "'
                       ");
        }

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $specification_group_id) );
        break;
        
      // Unlink a Specification Group from all Categories
      case 'unlink_all_categories_confirm':
        // Delete all links from a specification group to any product category
        $specification_group_id = (int) $_POST['specification_group_id'];
        if (isset ($_POST['specification_group_id']) &&  $_POST['specification_group_id'] != 0) {
          
          vam_db_query ("delete from " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " 
                         where specification_group_id = '" . $specification_group_id . "'
                       ");
        }

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $specification_group_id) );
        break;

////
// Specifications section
      // Show this Specification on the Comparison page
      case 'flag_comparison_spec':
        if ( ($flag == '0' || $flag == '1') && $specification_id != 0) {
          $db_flag = ($flag == '1') ? 'True' : 'False';
          vam_db_query ("update " . TABLE_SPECIFICATION . " 
                         set show_comparison = '" . $db_flag . "' 
                         where specifications_id = '" . $specification_id . "'
                      ");
        }

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spid=' . $specification_id) );
        break;
        
      // Show this Specification on the Products Info page
      case 'flag_products_spec':
        if ( ($flag == '0' || $flag == '1') && $specification_id != 0) {
          $db_flag = ($flag == '1') ? 'True' : 'False';
          vam_db_query ("update " . TABLE_SPECIFICATION . " 
                         set show_products = '" . $db_flag . "' 
                         where specifications_id = '" . $specification_id . "'
                      ");
        }
        
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . 'spid=' . $specification_id) );
        break;
        
      // Use this Specification in the Filters section
      case 'flag_filters_spec':
        if ( ($flag == '0' || $flag == '1') && $specification_id != 0) {
          $db_flag = ($flag == '1') ? 'True' : 'False';
          vam_db_query ("update " . TABLE_SPECIFICATION . " 
                         set show_filter = '" . $db_flag . "' 
                         where specifications_id = '" . $specification_id . "'
                      ");
        }
        
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . 'spid=' . $specs_group_id) );
        break;
      
      // Add or modify a specification
      case 'new_specification_confirm':
      case 'edit_specification_confirm':
        $show_comparison = 'False';
        if ($_POST['show_comparison'] == 'False' || $_POST['show_comparison'] == 'True') {
          $show_comparison = ($_POST['show_comparison'] == 'True') ? 'True' : 'False';
        }
        
        $show_products = 'False';
        if ($_POST['show_products'] == 'False' || $_POST['show_products'] == 'True') {
          $show_products = ($_POST['show_products'] == 'True') ? 'True' : 'False';
        }
        
        $show_filter = 'False';
        if ($_POST['show_filter'] == 'False' || $_POST['show_filter'] == 'True') {
          $show_filter = ($_POST['show_filter'] == 'True') ? 'True' : 'False';
        }

        $show_filter_mainpage = 'False';
        if ($_POST['show_filter_mainpage'] == 'False' || $_POST['show_filter_mainpage'] == 'True') {
          $show_filter_mainpage = ($_POST['show_filter_mainpage'] == 'True') ? 'True' : 'False';
        }
        
        // Set specification sort order to 0 when left blank
        $sort_order = ($_POST['specification_sort_order'] == '') ? 0 : (int) $_POST['specification_sort_order'];

        $sql_data_array = array ('specification_group_id' => vam_db_prepare_input ($_POST['specification_group_id']),
                                 'specification_sort_order' => $sort_order,
                                 'show_comparison' => $show_comparison,
                                 'show_products' => $show_products,
                                 'show_filter' => $show_filter,
                                 'show_filter_mainpage' => $show_filter_mainpage,
                                 'products_column_name' => vam_db_prepare_input ($_POST['products_column_name']),
                                 'column_justify' => vam_db_prepare_input ($_POST['column_justify']),
                                 'filter_class' => vam_db_prepare_input ($_POST['filter_class']),
                                 'filter_show_all' => vam_db_prepare_input ($_POST['filter_show_all']),
                                 'filter_display' => vam_db_prepare_input ($_POST['filter_display']),
                                 'enter_values' => vam_db_prepare_input ($_POST['enter_values'])
                                );
// BOF products_filters_seo
        $sql_data_array['specification_seo_active'] = vam_db_prepare_input($_POST['specification_seo_active']);
// EOF products_filters_seo

        switch ($action) {
          case 'new_specification_confirm':
            vam_db_perform (TABLE_SPECIFICATION, $sql_data_array);
            $specification_id = vam_db_insert_id();
            break;
              
          case 'edit_specification_confirm':
            $specification_id = (int) $_POST['specifications_id'];
            vam_db_perform (TABLE_SPECIFICATION, $sql_data_array, 'update', "specifications_id = '" . $specification_id . "'");
            break;
        } //switch ($action)
        
        // Insert/modify multiple rows, one per language
        $specification_name_array = $_POST['specification_name'];
        $specification_description_array = $_POST['specification_description'];
        $specification_prefix_array = $_POST['specification_prefix'];
        $specification_suffix_array = $_POST['specification_suffix'];
// BOF products_filters_seo
        $specification_seo_url_array = $_POST['specification_seo_url'];
        $specification_seo_name_array = $_POST['specification_seo_name'];
// EOF products_filters_seo

        $languages = vam_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $language_id = (int) $languages[$i]['id'];

          $sql_data_array = array ('specification_name' => vam_db_prepare_input ($specification_name_array[$language_id]),
                                   'specification_description' => vam_db_prepare_input ($specification_description_array[$language_id]),
                                   'specification_prefix' => vam_db_prepare_input ($specification_prefix_array[$language_id]),
                                   'specification_suffix' => vam_db_prepare_input ($specification_suffix_array[$language_id])
                                  );
// BOF products_filters_seo
          $sql_data_array['specification_seo_url'] = vam_db_prepare_input($specification_seo_url_array[$language_id]);
          $sql_data_array['specification_seo_name'] = vam_db_prepare_input($specification_seo_name_array[$language_id]);
// EOF products_filters_seo

          switch ($action) {
            case 'new_specification_confirm':
              $new_sql_data = array ('specifications_id' => $specification_id,
                                     'language_id' => $language_id);

              $sql_data_array = array_merge ($sql_data_array, $new_sql_data);

              vam_db_perform (TABLE_SPECIFICATION_DESCRIPTION, $sql_data_array);
              break;
              
            case 'edit_specification_confirm':
              vam_db_perform (TABLE_SPECIFICATION_DESCRIPTION, $sql_data_array, 'update', "specifications_id = '" . $specification_id . "' and language_id = '" . $language_id . "'");
              break;
          } //switch ($action)
        } //for ($i=0

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spid=' . $specification_id) );
        break;
        
      // Move a Specification
      case 'move_specification_confirm':
        // Move a specification to a different group
        $specification_id = (int) $_POST['specifications_id'];
        $group_id = (int) $_POST['group_id'];
        if (isset ($_POST['specifications_id']) && $_POST['specifications_id'] != 0) {
          vam_db_query ("update " . TABLE_SPECIFICATION . " 
                         set specification_group_id = '" . $group_id . "'
                         where specifications_id = '" . $specification_id . "'
                       ");
        }
        
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $group_id . '&spid=' . $specification_id) );
        break;
        
      // Copy a Specification
      case 'copy_specification_confirm':
        // Copy a specification from one spec group to another
        $specification_id = (int) $_POST['specifications_id'];
        if (isset ($_POST['specifications_id']) && $_POST['specifications_id'] != 0) {
          $specification_query_raw = "select specification_sort_order,
                                             show_comparison,
                                             show_products,
                                             show_filter,
                                             show_filter_mainpage,
                                             products_column_name,
                                             column_justify,
                                             filter_class,
                                             filter_show_all,
                                             filter_display,
                                             enter_values
                                      from " . TABLE_SPECIFICATION . " 
                                      where specifications_id = '" . $specification_id . "'
                                     ";
// BOF products_filters_seo
          $specification_query_raw = str_replace('products_column_name,', 'products_column_name, specification_seo_active,', $specification_query_raw);
// EOF products_filters_seo
          $specification_query = vam_db_query ($specification_query_raw);
          $specification_array = vam_db_fetch_array ($specification_query);

          $sql_data_array = array ('specification_group_id' => (int) $_POST['group_id'],
                                   'specification_sort_order' => $specification_array['specification_sort_order'],
                                   'show_comparison' => $specification_array['show_comparison'],
                                   'show_products' => $specification_array['show_products'],
                                   'show_filter' => $specification_array['show_filter'],
                                   'show_filter_mainpage' => $specification_array['show_filter_mainpage'],
                                   'products_column_name' => $specification_array['products_column_name'],
                                   'column_justify' => $specification_array['column_justify'],
                                   'filter_class' => $specification_array['filter_class'],
                                   'filter_show_all' => $specification_array['filter_show_all'],
                                   'filter_display' => $specification_array['filter_display'],
                                   'enter_values' => $specification_array['enter_values']
                                  );
// BOF products_filters_seo
        $sql_data_array['specification_seo_active'] = vam_db_prepare_input($_POST['specification_seo_active']);
// EOF products_filters_seo
          vam_db_perform (TABLE_SPECIFICATION, $sql_data_array);
          $specification_id_copy = vam_db_insert_id();
          
          // Insert multiple rows in the description table, one per language
          $languages = vam_get_languages();
          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
            $language_id = (int) $languages[$i]['id'];
            $specification_query_raw = "select specification_name,
                                               specification_description,
                                               specification_prefix,
                                               specification_suffix
                                        from " . TABLE_SPECIFICATION_DESCRIPTION . " 
                                        where specifications_id = '" . $specification_id . "'
                                          and language_id = '" . $language_id . "'
                                       ";
// BOF products_filters_seo
            $specification_query_raw = str_replace('specification_name,', 'specification_name, specification_seo_name, specification_seo_url,', $specification_query_raw);
// EOF products_filters_seo
            $specification_query = vam_db_query ($specification_query_raw);
            $specification_array = vam_db_fetch_array ($specification_query);

            $sql_data_array = array ('specifications_id' => $specification_id_copy,
                                     'language_id' => $language_id,
                                     'specification_name' => $specification_array['specification_name'],
                                     'specification_description' => $specification_array['specification_description'],
                                     'specification_prefix' => $specification_array['specification_prefix'],
                                     'specification_suffix' => $specification_array['specification_suffix']
                                    );
// BOF products_filters_seo
            $sql_data_array['specification_seo_url'] = $specification_array['specification_seo_url'];
            $sql_data_array['specification_seo_name'] = $specification_array['specification_seo_name'];
// EOF products_filters_seo
            vam_db_perform (TABLE_SPECIFICATION_DESCRIPTION, $sql_data_array);
          } // for ($i=0
        } // if ($specification_id

        // Also copy filters if selected
        if (isset ($_POST['copy_filter']) && $_POST['copy_filter'] == 'True') {
          $filters_query_raw = "select specification_filters_id,
                                       filter_sort_order
                                from " . TABLE_SPECIFICATIONS_FILTERS . "
                                where specifications_id = '" . $specification_id . "'
                              ";
          // print $filters_query_raw . "<br>\n";
          $filters_query = vam_db_query ($filters_query_raw);

          while ($filters_data = vam_db_fetch_array ($filters_query) ) {
            $sql_data_array = array ('specifications_id' => $specification_id_copy,
                                     'filter_sort_order' => $filters_data['filter_sort_order']
                                    );
            vam_db_perform (TABLE_SPECIFICATIONS_FILTERS, $sql_data_array);
            $new_specification_filters_id = vam_db_insert_id();

            $languages = vam_get_languages();
            for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
              $filters_description_query_raw = "select filter
                                                from " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . "
                                                where specification_filters_id = '" . $filters_data['specification_filters_id'] . "'
                                                  and language_id = '" . (int) $languages[$i]['id'] . "'
                                              ";
              // print $filters_description_query_raw . "<br>\n";
              $filters_description_query = vam_db_query ($filters_description_query_raw);

              $filters_description_data = vam_db_fetch_array ($filters_description_query);
              $sql_data_array = array ('specification_filters_id' => $new_specification_filters_id,
                                       'language_id' => (int) $languages[$i]['id'],
                                       'filter' => $filters_description_data['filter']
                                      );
              vam_db_perform (TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION, $sql_data_array);
            } // for ($i=0
          } // while ($filters_data
        } // if (isset ($_POST['copy_filter']

        // Also copy specification values if selected
        if (isset ($_POST['copy_values']) && $_POST['copy_values'] == 'True') {
          $values_query_raw = "select specification_values_id,
                                      value_sort_order
                               from " . TABLE_SPECIFICATIONS_VALUES . "
                               where specifications_id = '" . $specification_id . "'
                             ";
          // print $values_query_raw . "<br>\n";
          $values_query = vam_db_query ($values_query_raw);

          while ($values_data = vam_db_fetch_array ($values_query) ) {
            $sql_data_array = array ('specifications_id' => $specification_id_copy,
                                     'value_sort_order' => $values_data['value_sort_order']
                                    );
            vam_db_perform (TABLE_SPECIFICATIONS_VALUES, $sql_data_array);
            $new_specification_values_id = vam_db_insert_id();

            $languages = vam_get_languages();
            for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
              $values_description_query_raw = "select specification_value
                                               from " . TABLE_SPECIFICATIONS_VALUES_DESCRIPTION . "
                                               where specification_values_id = '" . $values_data['specification_values_id'] . "'
                                                 and language_id = '" . (int) $languages[$i]['id'] . "'
                                              ";
              // print $values_description_query_raw . "<br>\n";
              $values_description_query = vam_db_query ($values_description_query_raw);

              $values_description_data = vam_db_fetch_array ($values_description_query);
              $sql_data_array = array ('specification_values_id' => $new_specification_values_id,
                                       'language_id' => (int) $languages[$i]['id'],
                                       'specification_value' => $values_description_data['specification_value']
                                      );
              vam_db_perform (TABLE_SPECIFICATIONS_VALUES_DESCRIPTION, $sql_data_array);
            } // for ($i=0
          } // while ($products_data
        } // if (isset ($_POST['copy_values']
                
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spid=' . $specification_id_copy) );
        break;
        
      // Delete a specification and any associated product data, values, or filters
      case 'delete_specification_confirm':
        if ( (int) $_POST['specifications_id'] != 0) {
          $specifications_id = (int) $_POST['specifications_id'];
          // Check if we have any filters attached to each specification
          $filters_query_raw = "select specification_filters_id
                                from " . TABLE_SPECIFICATIONS_FILTERS . "
                                where specifications_id = '" . $specifications_id . "' 
                              ";
          // print $filters_query_raw . "<br />\n";
          $filters_query = vam_db_query ($filters_query_raw);
            
          if (vam_db_num_rows ($filters_query) > 0) { // If we have any filters
            while ($filters_array = vam_db_fetch_array ($filters_query)) { // Delete the filters
              $specification_filters_id = $filters_array['specification_filters_id'];
              vam_db_query ("delete from " . TABLE_SPECIFICATIONS_FILTERS . " where specification_filters_id = '" . $specification_filters_id . "'");
              vam_db_query ("delete from " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " where specification_filters_id = '" . $specification_filters_id . "'");
            } //  while ($filters_array
          } // if (vam_db_num_rows ($filters_query
            
          // Check if we have any specification values attached to each specification
          $values_query_raw = "select specification_values_id
                                from " . TABLE_SPECIFICATIONS_VALUES . "
                                where specifications_id = '" . $specifications_id . "' 
                              ";
          // print $values_query_raw . "<br />\n";
          $values_query = vam_db_query ($values_query_raw);
          if (vam_db_num_rows ($values_query) > 0) { //Delete the values
            while ($values_array = vam_db_fetch_array ($values_query)) { // Delete the filters
              $specification_values_id = $filters_array['specification_values_id'];
              vam_db_query ("delete from " . TABLE_SPECIFICATIONS_VALUES . " where specification_values_id = '" . $specification_values_id . "'");
              vam_db_query ("delete from " . TABLE_SPECIFICATIONS_VALUES_DESCRIPTION . " where specification_values_id = '" . $specification_values_id . "'");
            } // while ($filters_array
          } // if (vam_db_num_rows ($values_query

          // Check if we have any products with specification data
          $products_query_raw = "select products_id
                                 from " . TABLE_PRODUCTS_SPECIFICATIONS . "
                                 where specifications_id = '" . $specifications_id . "' 
                                ";
          // print $products_query_raw . "<br />\n";
          $products_query = vam_db_query ($products_query_raw);
            
          if (vam_db_num_rows ($products_query) > 0) { // Delete the product data
            vam_db_query ("delete from " . TABLE_PRODUCTS_SPECIFICATIONS . " where specifications_id = '" . $specifications_id . "'");
          } //if (vam_db_num_rows ($filters_query
          
          // Once everything attached to this specification is deleted, delete the specification
          vam_db_query ("delete from " . TABLE_SPECIFICATION . " where specifications_id = '" . $specifications_id . "'");
          vam_db_query ("delete from " . TABLE_SPECIFICATION_DESCRIPTION . " where specifications_id = '" . $specifications_id . "'");
        } // if ($specification_id

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path) );
        break;
        
// Filters section
      // Add or modify a Filter
      case 'new_filter_confirm':
      case 'edit_filter_confirm':
        // Set filter sort order to 0 when left blank
        $sort_order = ($_POST['filter_sort_order'] == '') ? 0 : (int) $_POST['filter_sort_order'];
        $specifications_id = (int) ($_POST['specifications_id']);
          
        $sql_data_array = array ('specifications_id' => $specifications_id,
                                 'filter_sort_order' => $sort_order
                                );

        switch ($action) {
          case 'new_filter_confirm':
            vam_db_perform (TABLE_SPECIFICATIONS_FILTERS, $sql_data_array);
            $specification_filters_id = vam_db_insert_id();
            break;
              
          case 'edit_filter_confirm':
            $specification_filters_id = (int) $_POST['specification_filters_id'];
            vam_db_perform (TABLE_SPECIFICATIONS_FILTERS, $sql_data_array, 'update', "specification_filters_id = '" . $specification_filters_id . "'");
            break;
        } //switch ($action)
        
        // Insert/modify multiple rows, one per language
        $languages = vam_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $language_id = (int) $languages[$i]['id'];
          $sql_data_array = array ();

          if ($_POST['entry_type'] == 'image') { // Upload an image
            $filter_image = new upload ('filter' . $language_id);
            $filter_image->set_destination (DIR_FS_CATALOG_IMAGES);

            if ($filter_image->parse() && $filter_image->save()) {
              $sql_data_array = array ('filter' => vam_db_input ($filter_image->filename) );
            }
            
          } else {
          	
			  if (vam_db_prepare_input ($_POST['filter'][$language_id]) != vam_db_prepare_input ($_POST['old_val'])){
				  
				 $sql_update = array ( 'specification' => vam_db_prepare_input ($_POST['filter'][$language_id]) );
				 vam_db_perform (TABLE_PRODUCTS_SPECIFICATIONS, $sql_update, 'update', 
				 "specifications_id = '" . vam_db_prepare_input ($_POST['spath_val']) . "' and 
				 specification = '" . vam_db_prepare_input ($_POST['old_val']) . "'");
				}
          	
            $sql_data_array = array ('filter' => vam_db_prepare_input ($_POST['filter'][$language_id]) );
          } // if ($_POST['entry_type'] ... else ...

          switch ($action) {
            case 'new_filter_confirm':
              $new_sql_data = array ('language_id' => $language_id,
                                     'specification_filters_id' => $specification_filters_id
                                    );

              $sql_data_array = array_merge ($sql_data_array, $new_sql_data);

              vam_db_perform (TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION, $sql_data_array);
              break;
              
            case 'edit_filter_confirm':
              if (count ($sql_data_array) > 0) {
                vam_db_perform (TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION, $sql_data_array, 'update', "language_id = '" . $language_id . "' and specification_filters_id = '" . $specification_filters_id . "'");
              }
              break;
              
          } //switch ($action)
        } //for ($i=0

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $specification_filters_id) );
        break;
        
      // Move a Filter
      case 'move_filter_confirm':
        if (isset ($_POST['specification_filters_id']) && $_POST['specification_filters_id'] != 0 && $_POST['move_to_filter_id'] != 0) {
          $specification_filters_id = (int) $_POST['specification_filters_id'];
          $move_to_filter_id = (int) $_POST['move_to_filter_id'];
          vam_db_query ("update " . TABLE_SPECIFICATIONS_FILTERS . " 
                         set specifications_id = '" . $move_to_filter_id . "'
                         where specification_filters_id = '" . $specification_filters_id . "'
                       ");
        }
        
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $specification_filters_id) );
        break;
        
      // Copy a Filter
      case 'copy_filter_confirm':
        if (isset ($_POST['specification_filters_id']) && $_POST['specification_filters_id'] != 0 && $_POST['copy_to_filter_id'] != 0) {
          $specification_filters_id = (int) $_POST['specification_filters_id'];
          $copy_to_filter_id = (int) $_POST['copy_to_filter_id'];

          $filter_query_raw = "select specifications_id,
                                      filter_sort_order
                               from " . TABLE_SPECIFICATIONS_FILTERS . " 
                               where specification_filters_id = '" . $specification_filters_id . "'
                              ";
          // print $filter_query_raw . "<br />\n";
          $filter_query = vam_db_query ($filter_query_raw);
          $filter_array = vam_db_fetch_array ($filter_query);

          $sql_data_array = array ('specifications_id' => $copy_to_filter_id,
                                   'filter_sort_order' => $filter_array['filter_sort_order']
                                  );
          vam_db_perform (TABLE_SPECIFICATIONS_FILTERS, $sql_data_array);
          $filter_id_copy = vam_db_insert_id();
        
          // Copy multiple rows, one per language
          $languages = vam_get_languages();
          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
            $language_id = (int) $languages[$i]['id'];
          
            $sql_data_array = array ('specification_filters_id' => $filter_id_copy,
                                     'filter' => vam_db_prepare_input ($_POST['filter'][$language_id]),
                                     'language_id' => $language_id
                                    );
            vam_db_perform (TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION, $sql_data_array);
          } //for ($i=0
        } // if ($specification_id
        
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $copy_to_filter_id . '&fid=' . $filter_id_copy) );
        break;
        
      // Delete a Filter
      case 'delete_filter_confirm':
        // So delete the filter already
        $filter_id = (int) $_POST['specification_filters_id'];
        if ($filter_id != 0) {
          vam_db_query ("delete from " . TABLE_SPECIFICATIONS_FILTERS . " where specification_filters_id = '" . $filter_id . "'");
          vam_db_query ("delete from " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " where specification_filters_id = '" . $filter_id . "'");
        } //if ($filter_id
          
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path) );
        break;
        
      // Copy all Manufacturers to Filters
      case 'import_manufacturers':
        $manufacturer_query_raw = "select manufacturers_name
                                   from " . TABLE_MANUFACTURERS . " 
                                   order by manufacturers_name
                                  ";
        // print $manufacturer_query_raw . "<br />\n";
        $manufacturer_query = vam_db_query ($manufacturer_query_raw);

        $sort_order = 1;
        while ($manufacturer_data = vam_db_fetch_array ($manufacturer_query) ) {
          $sql_data_array = array ('specifications_id' => $specs_path,
                                   'filter_sort_order' => $sort_order
                                  );

          vam_db_perform (TABLE_SPECIFICATIONS_FILTERS, $sql_data_array);
          $specification_filters_id = vam_db_insert_id();
          
          $languages = vam_get_languages();
          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
            $language_id = (int) $languages[$i]['id'];
            $sql_data_array = array ('specification_filters_id' => $specification_filters_id,
                                     'language_id' => $language_id,
                                     'filter' => $manufacturer_data['manufacturers_name']
                                     );
            vam_db_perform (TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION, $sql_data_array);
          }

          $sort_order++;
        }

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $specification_filters_id) );
        break;
        
      // Copy all Manufacturers to Filters
      case 'update_manufacturers':
        $check_query_raw = "select max(filter_sort_order) as count
                                   from " . TABLE_SPECIFICATIONS_FILTERS . " 
                                   where specifications_id = '" . $specs_path . "'
                                  ";
        // print $manufacturer_query_raw . "<br />\n";
        $check_query = vam_db_query ($check_query_raw);
        $check_data = vam_db_fetch_array ($check_query);
        $sort_order = $check_data['count'] + 1;

        $manufacturer_query_raw = "SELECT manufacturers_name
                                   FROM " . TABLE_MANUFACTURERS . " 
                                   WHERE manufacturers_name NOT IN (
                                     SELECT filter
                                     FROM " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . "
                                   )
                                   ORDER BY manufacturers_name
                                  ";
        // print $manufacturer_query_raw . "<br />\n";
        $manufacturer_query = vam_db_query ($manufacturer_query_raw);

        while ($manufacturer_data = vam_db_fetch_array ($manufacturer_query) ) {
          $sql_data_array = array ('specifications_id' => $specs_path,
                                   'filter_sort_order' => $sort_order
                                  );

          vam_db_perform (TABLE_SPECIFICATIONS_FILTERS, $sql_data_array);
          $specification_filters_id = vam_db_insert_id();
          
          $languages = vam_get_languages();
          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
            $language_id = (int) $languages[$i]['id'];
            $sql_data_array = array ('specification_filters_id' => $specification_filters_id,
                                     'language_id' => $language_id,
                                     'filter' => $manufacturer_data['manufacturers_name']
                                     );
            vam_db_perform (TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION, $sql_data_array);
          }

          $sort_order++;
        }

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $specification_filters_id) );
        break;
        
      // Copy all Manufacturers to Filters
      case 'sort_filters':
        $check_query_raw = "select sfd.filter
                             from " . TABLE_SPECIFICATIONS_FILTERS . " sf,
                                  " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " sfd
                             where sfd.specification_filters_id = sf.specification_filters_id
                               and sf.specifications_id = '" . $specs_path . "'
                               and sfd.language_id = '" . $_SESSION['languages_id'] . "'
                             limit 1
                            ";
        // print $check_query_raw . "<br />\n";
        $check_query = vam_db_query ($check_query_raw);

        $filter_data = vam_db_fetch_array ($check_query);
        $type_spec = vam_get_type ($filter_data['filter']);

        $filter_query_raw = "select sfd.filter,
                                    sf.specification_filters_id
                             from " . TABLE_SPECIFICATIONS_FILTERS . " sf,
                                  " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " sfd
                             where sfd.specification_filters_id = sf.specification_filters_id
                               and sf.specifications_id = '" . $specs_path . "'
                               and sfd.language_id = '" . $_SESSION['languages_id'] . "'
                             order by (CONVERT (sfd.filter, $type_spec) ) 
                            ";
        // print $filter_query_raw . "<br />\n";
        $filter_query = vam_db_query ($filter_query_raw);

        $sort_order = 1;
        while ($filter_data = vam_db_fetch_array ($filter_query) ) {
          $specification_filters_id = $filter_data['specification_filters_id'];
          $sql_data_array = array ('filter_sort_order' => $sort_order);

          vam_db_perform (TABLE_SPECIFICATIONS_FILTERS, $sql_data_array, 'update', "specification_filters_id = '" . $specification_filters_id . "'");
          $sort_order++;
        }

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $specification_filters_id) );
        break;
        
// Specification Values section
      // Add or modify a Specification Value
      case 'new_value_confirm':
      case 'edit_value_confirm':
        // Set value sort order to 0 when left blank
        $sort_order = ($_POST['value_sort_order'] == '') ? 0 : (int) $_POST['value_sort_order'];
        
        // Insert/modify soet order and specs ID
        $return_value_id = '0';
        $languages = vam_get_languages();
        $specifications_id = (int) ($_POST['specifications_id']);
            
        $sql_data_array = array ('specifications_id' => $specifications_id,
                                 'value_sort_order' => $sort_order
                                );

        switch ($action) {
          case 'new_value_confirm':
            vam_db_perform (TABLE_SPECIFICATIONS_VALUES, $sql_data_array);
            $specification_values_id = vam_db_insert_id();
            break;
              
          case 'edit_value_confirm':
            $specification_values_id = (int) ($_POST['specification_values_id']);
            vam_db_perform (TABLE_SPECIFICATIONS_VALUES, $sql_data_array, 'update', "specification_values_id = '" . $specification_values_id . "'");
            break;
        } //switch ($action)
        
        // Insert/modify language-dependent values
        $languages = vam_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $language_id = (int) $languages[$i]['id'];
          $sql_data_array = array ('specification_values_id' => $specification_values_id);

          if ($_POST['entry_type'] == 'image') { // Upload an image
            $value_data_array = array ('specification_value' => '');
            $filter_image = new upload ('specification_value' . $language_id);
            $filter_image->set_destination (DIR_FS_CATALOG_IMAGES);

            if ($filter_image->parse() && $filter_image->save()) {
              $value_data_array = array ('specification_value' => vam_db_input ($filter_image->filename) );
            }
            
          } else {
            $value_data_array = array ('specification_value' => vam_db_prepare_input ($_POST['specification_value'][$language_id]) );

          } // if ($_POST['entry_type'] ... else ...
          $sql_data_array = array_merge ($sql_data_array, $value_data_array);
          
          switch ($action) {
            case 'new_value_confirm':
              $new_sql_data = array ('language_id' => $language_id);
              $sql_data_array = array_merge ($sql_data_array, $new_sql_data);

              vam_db_perform (TABLE_SPECIFICATIONS_VALUES_DESCRIPTION, $sql_data_array);
              break;
              
            case 'edit_value_confirm':
              vam_db_perform (TABLE_SPECIFICATIONS_VALUES_DESCRIPTION, $sql_data_array, 'update', "language_id = '" . $language_id . "' and specification_values_id = '" . $specification_values_id . "'");
              break;
          } //switch ($action)
        } //for ($i=0

        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&value=1&vid=' . $specification_values_id) );
        break;
        
      // Move a Specification Value
      case 'move_value_confirm':
        if (isset ($_POST['specification_values_id']) && $_POST['specification_values_id'] != 0 && $_POST['move_to_value_id'] != 0) {
          $specification_values_id = (int) $_POST['specification_values_id'];
          $move_to_value_id = (int) $_POST['move_to_value_id'];
          vam_db_query ("update " . TABLE_SPECIFICATIONS_VALUES . " 
                         set specifications_id = '" . $move_to_value_id . "'
                         where specification_values_id = '" . $specification_values_id . "'
                       ");
        }
        
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $move_to_value_id . '&value=1&vid=' . $specification_values_id) );
        break;
        
      // Copy a Specification Value
      case 'copy_value_confirm':
        if (isset ($_POST['specification_values_id']) && $_POST['specification_values_id'] != 0 && $_POST['copy_to_value_id'] != 0) {
          $specification_values_id = (int) $_POST['specification_values_id'];
          $copy_to_value_id = (int) $_POST['copy_to_value_id'];

          $filter_query_raw = "select value_sort_order
                               from " . TABLE_SPECIFICATIONS_VALUES . " 
                               where specification_values_id = '" . $specification_values_id . "'
                              ";
          $filter_query = vam_db_query ($filter_query_raw);
          $filter_array = vam_db_fetch_array ($filter_query);

          $sql_data_array = array ('specifications_id' => $copy_to_value_id,
                                   'value_sort_order' => $filter_array['value_sort_order']
                                  );
          vam_db_perform (TABLE_SPECIFICATIONS_VALUES, $sql_data_array);
          $new_specification_values_id = vam_db_insert_id();

          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
            $language_id = (int) $languages[$i]['id'];
            $filter_query_raw = "select specification_value,
                                        value_sort_order
                                 from " . TABLE_SPECIFICATIONS_VALUES_DESCRIPTION . " 
                                 where specification_values_id = '" . $specification_values_id . "'
                                ";
            $filter_query = vam_db_query ($filter_query_raw);
            $filter_array = vam_db_fetch_array ($filter_query);

            $sql_data_array = array ('specification_values_id' => $new_specification_values_id,
                                     'language_id' => $language_id,
                                     'specification_value' => $filter_array['specification_value']
                                    );
            vam_db_perform (TABLE_SPECIFICATIONS_VALUES_DESCRIPTION, $sql_data_array);
          }
        } // if (isset ($_POST['specification_values_id']
        
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $copy_to_value_id . '&value=1&vid=' . $new_specification_values_id) );
        break;
        
      // Delete a Specification Value
      case 'delete_value_confirm':
        // So delete the filter already
        $specification_values_id = (int) $_POST['specification_values_id'];
        if ($specification_values_id != 0) {
          vam_db_query ("delete from " . TABLE_SPECIFICATIONS_VALUES . " where specification_values_id = '" . $specification_values_id . "'");
          vam_db_query ("delete from " . TABLE_SPECIFICATIONS_VALUES_DESCRIPTION . " where specification_values_id = '" . $specification_values_id . "'");
        } //if ($filter_id
          
        vam_redirect (vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&value=1') );
        break;
        
////
// Actions for the first pass
//   These set up data used in the right column box
      case 'new_group':
      case 'edit_group':
      case 'copy_group':
      case 'delete_group':
        // Check for specifications, product data, or filters in this group
        $count_links = 0;
        $count_specs = 0;
        $count_products = 0;
        $count_filters = 0;
        $count_values = 0;

        // Count the number of Categories linked from this group
        $links_query_raw = "select categories_id
                            from " . TABLE_SPECIFICATIONS_TO_CATEGORIES . "
                            where specification_group_id = '" . $specs_group_id . "' 
                          ";
        // print $links_query_raw . "<br />\n";
        $links_query = vam_db_query ($links_query_raw);
        $count_links = vam_db_num_rows ($links_query);

        // Check if there are any specifications attached and count them
        $specs_query_raw = "select specifications_id
                            from " . TABLE_SPECIFICATION . "
                            where specification_group_id = '" . $specs_group_id . "' 
                          ";
        // print $specs_query_raw . "<br />\n";
        $specs_query = vam_db_query ($specs_query_raw);
        if (vam_db_num_rows ($specs_query) > 0) { //We have specifications attached
          
          while ($specs_data = vam_db_fetch_array ($specs_query) ) {
            $count_specs++;

            // Check if we have any filters attached to each specification and count
            $filters_query_raw = "select specification_filters_id
                                  from " . TABLE_SPECIFICATIONS_FILTERS . "
                                  where specifications_id = '" . $specs_data['specifications_id'] . "' 
                                ";
            // print $filters_query_raw . "<br />\n";
            $filters_query = vam_db_query ($filters_query_raw);
            $count_filters += vam_db_num_rows ($filters_query);

            // Check if we have any values attached to each specification and count them
            $values_query_raw = "select specification_values_id
                                  from " . TABLE_SPECIFICATIONS_VALUES . "
                                  where specifications_id = '" . $specs_data['specifications_id'] . "' 
                                ";
            // print $filters_query_raw . "<br />\n";
            $values_query = vam_db_query ($values_query_raw);
            $count_values += vam_db_num_rows ($values_query);

            // Check if we have any products with specification data and count
            $products_query_raw = "select products_id
                                   from " . TABLE_PRODUCTS_SPECIFICATIONS . "
                                   where specifications_id = '" . $specs_data['specifications_id'] . "' 
                                     and language_id = '" . $language_id . "'
                                 ";
            // print $products_query_raw . "<br />\n";
            $products_query = vam_db_query ($products_query_raw);
            $count_products += vam_db_num_rows ($products_query);
          } // while ($specs_data
        } // if (vam_db_num_rows ($specs_query
        break;

      case 'link_category':
      case 'link_all_categories':
      case 'unlink_all_categories':
        break;
        
      case 'unlink_category':
        $categories_list = array();
        $categories_query_raw = "select sg2c.categories_id, 
                                        cd.categories_name                                      
                                 from " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c, 
                                      " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                 where cd.categories_id = sg2c.categories_id 
                                   and sg2c.specification_group_id = '" . $specs_group_id . "' 
                                   and cd.language_id = '" . (int) $_SESSION['languages_id'] . "' 
                                 order by cd.categories_name";
        // print $specifications_query_raw . "<br />\n";
        $categories_query = vam_db_query ($categories_query_raw);
        if (vam_db_num_rows ($categories_query) > 0) {
          while ($categories_array = vam_db_fetch_array ($categories_query) ) {
            $categories_list[] = array ('id' => $categories_array['categories_id'],
                                        'text' => $categories_array['categories_name'],
                                       );
          }
        } else {
          $categories_list[] = array ('id' => '',
                                      'text' => TEXT_NO_CATEGORIES,
                                     );
        }
        
        break;

      case 'new_specification':
      case 'edit_specification':
        // Set up the array to fill the pulldown for existing product fields
        // Start with the empty field "None" 
        //   Then add a field for Combination (Components set in Admin)
        $static_array = array (array ('id' => '',
                                      'text' => TEXT_NONE),
                               array ('id' => 'combi',
                                      'text' => TEXT_COMBI),
                               array ('id' => 'buy_now',
                                      'text' => TEXT_BUY_NOW),
                               array ('id' => 'final_price',
                                      'text' => TEXT_FINAL_PRICE)
                             );
  
        // Add the existing fields that we might want to use
        $describe_query_raw = "describe " . TABLE_PRODUCTS;
        $describe_query = vam_db_query ($describe_query_raw);
  
        $products_array = array();
        while ($row = vam_db_fetch_array ($describe_query) ) {
          switch ($row['Field']) { 
            case 'products_id': // Remove fields we don't want to see in the pulldown
            case 'products_status': // Add to this list if there are other fields you don't want
            case 'products_tax_class_id': // Anything NOT on this list will be selectable
            case 'products_date_added':
            case 'products_last_modified':
            case 'products_date_available':
            case 'products_ordered':
            case 'products_ship_method':
            case 'products_ready_to_ship':
            case 'vendors_id':
            case 'vendors_product_price':
            case 'vendors_prod_id':
            case 'vendors_prod_comments':
            case 'age':
            case 'products_ship_fee':
            case 'products_carrier':
            case 'products_ship_price':
              break;
       
            case 'products_model':  
              $products_array[] = array ('id' => $row['Field'],
                                         'text' => TEXT_PRODUCTS_MODEL
              );
              break;
        
            case 'products_image':  
              $products_array[] = array ('id' => $row['Field'],
                                         'text' => TEXT_PRODUCTS_IMAGE
              );
              break;
        
            case 'products_price':  
              $products_array[] = array ('id' => $row['Field'],
                                         'text' => TEXT_PRODUCTS_PRICE
              );
              break;
        
            case 'products_weight':  
              $products_array[] = array ('id' => $row['Field'],
                                         'text' => TEXT_PRODUCTS_WEIGHT
              );
              break;
        
            case 'manufacturers_id':
              $products_array[] = array ('id' => $row['Field'],
                                         'text' => TEXT_PRODUCTS_MANUFACTURER
              );
              break;
        
            default:  // Show everything else by formatting the field name
              $title_string = preg_replace ('/_/', ' ', $row['Field']);
              $title_string = ucwords ($title_string);
              $products_array[] = array ('id' => $row['Field'],
                                         'text' => $title_string
              );
              break;
          } // switch ($row['Field']
        } // while ($row

        // Add the fields from the Products Description table
        $describe_query_raw = "describe " . TABLE_PRODUCTS_DESCRIPTION;
        $describe_query = vam_db_query ($describe_query_raw);
  
        $products_description_array = array();
        while ($row = vam_db_fetch_array ($describe_query) ) {
          switch ($row['Field']) { 
            case 'products_id': // Remove fields we don't want to see in the pulldown
            case 'language_id': // Add to this list if there are other fields you don't want
            case 'products_description':
            case 'products_url':
            case 'products_viewed':
        
            case 'products_name':
              $products_array[] = array ('id' => $row['Field'],
                                         'text' => TEXT_PRODUCTS_NAME
              );
              break;
        
            default:  // Show everything else by formatting the field name
              $title_string = preg_replace ('/_/', ' ', $row['Field']);
              $title_string = ucwords ($title_string);
              $products_array[] = array ('id' => $row['Field'],
                                         'text' => $title_string
              );
              break;
          } // switch ($row['Field']
        } // while ($row
  
        $products_database_fields = array_merge ($static_array, (array) $products_array, (array) $products_description_array);
        
        // Set up the pulldown for the Column Alignment field
        $alignment_array = array (array ('id' => 'left',
                                         'text' => TEXT_LEFT),
                                  array ('id' => 'center',
                                         'text' => TEXT_CENTER),
                                  array ('id' => 'right',
                                         'text' => TEXT_RIGHT)
                                 );
                                 
        $filter_classes = array (array ('id' => 'none',
                                        'text' => TEXT_NO_FILTER),
                                 array ('id' => 'exact',
                                        'text' => TEXT_EXACT),
                                 array ('id' => 'multiple',
                                        'text' => TEXT_MULTIPLE),
                                 array ('id' => 'range',
                                        'text' => TEXT_RANGE),
                                 array ('id' => 'reverse',
                                        'text' => TEXT_REVERSE),
                                 array ('id' => 'start',
                                        'text' => TEXT_START),
                                 array ('id' => 'partial',
                                        'text' => TEXT_PARTIAL),
                                 array ('id' => 'like',
                                        'text' => TEXT_LIKE)
                                );
                                 
        $filter_display_array = array (array ('id' => '',
                                              'text' => TEXT_NONE),
                                       array ('id' => 'pulldown',
                                              'text' => TEXT_PULLDOWN),
                                       array ('id' => 'radio',
                                              'text' => TEXT_RADIO),
                                       array ('id' => 'links',
                                              'text' => TEXT_LINKS),
                                       array ('id' => 'text',
                                              'text' => TEXT_TEXT_BOX),
                                       array ('id' => 'multi',
                                              'text' => TEXT_MULTI),
                                       array ('id' => 'checkbox',
                                              'text' => TEXT_CHECK_BOXES),
                                       array ('id' => 'image',
                                              'text' => TEXT_IMAGES),
                                       array ('id' => 'multiimage',
                                              'text' => TEXT_MULTI_IMAGE)
                                     );
                                 
        $enter_filter_array = array (array ('id' => 'text',
                                            'text' => TEXT_TEXT_BOX),
                                     array ('id' => 'pulldown',
                                            'text' => TEXT_PULLDOWN),
                                     array ('id' => 'radio',
                                            'text' => TEXT_RADIO),
                                     array ('id' => 'multi',
                                            'text' => TEXT_MULTI),
                                     array ('id' => 'checkbox',
                                            'text' => TEXT_CHECK_BOXES),
                                     array ('id' => 'image',
                                            'text' => TEXT_IMAGES),
                                     array ('id' => 'multiimage',
                                            'text' => TEXT_MULTI_IMAGE)
                                   );
        break;
        
      case 'delete_specification':
        // Check for data attached to this group
        // Check if we have any filters attached to this specification
        $count_filters = vam_count_filters ('0', $specification_id);

        // Check if we have any values attached to this specification
        $count_values = vam_count_values ('0', $specification_id);
        
        // Check if we have any products with specification data
        $count_products = vam_count_products ('0', $specification_id);
        break;

      case 'move_specification':
      case 'copy_specification':
        $count_products = 0;
        $count_filters = 0;
        $count_values = 0;
        $groups_array = array();

        // Check if we have any filters attached to each specification and count
        $filters_query_raw = "select specification_filters_id
                              from " . TABLE_SPECIFICATIONS_FILTERS . "
                              where specifications_id = '" . $specification_id . "'
                            ";
        // print $filters_query_raw . "<br>\n";
        $filters_query = vam_db_query ($filters_query_raw);
        $count_filters += vam_db_num_rows ($filters_query);

        // Check if we have any values attached to each specification and count them
        $values_query_raw = "select specification_values_id
                             from " . TABLE_SPECIFICATIONS_VALUES . "
                             where specifications_id = '" . $specification_id . "'
                            ";
        // print $filters_query_raw . "<br>\n";
        $values_query = vam_db_query ($values_query_raw);
        $count_values += vam_db_num_rows ($values_query);

        // Check if we have any products with specification data and count
        $products_query_raw = "select products_id
                               from " . TABLE_PRODUCTS_SPECIFICATIONS . "
                               where specifications_id = '" . $specification_id . "'
                             ";
        // print $products_query_raw . "<br>\n";
        $products_query = vam_db_query ($products_query_raw);
        $count_products += vam_db_num_rows ($products_query);

        $specification_group_query_raw = "select specification_group_id,
                                                 specification_group_name                                      
                                          from " . TABLE_SPECIFICATION_GROUPS . "
                                          order by specification_group_name
                                         ";
        // print $specification_group_query_raw . "<br />\n";
        $specification_group_query = vam_db_query ($specification_group_query_raw);
        if (vam_db_num_rows ($specification_group_query) > 0) {
          while ($specification_group = vam_db_fetch_array ($specification_group_query) ) {
            $groups_array[] = array ('id' => $specification_group['specification_group_id'],
                                     'text' => $specification_group['specification_group_name'],
                                    );
          } // while ($specification_group
        } else {
          $groups_array[] = array ('id' => '',
                                   'text' => TEXT_NO_GROUP_SELECT
                                  );
        } // if (vam_db_num_rows ... else ...
        break;
        
      case 'new_filter':
      case 'move_filter':
      case 'copy_filter':
      case 'move_value':
      case 'copy_value':
        $filters_query_raw = "select s.filter_class,
                                     sd.specification_name
                              from " . TABLE_SPECIFICATION . " s,
                                   " . TABLE_SPECIFICATION_DESCRIPTION . " sd
                              where s.specifications_id = '" . $specs_path . "'
                                and sd.specifications_id = '" . $specs_path . "'
                                and sd.language_id = '" . $_SESSION['languages_id'] . "'
                            ";
        // print $filters_query_raw . "<br />\n";
        $filters_query = vam_db_query ($filters_query_raw);
        $filters_data = vam_db_fetch_array ($filters_query);
        
        $specifications_query_raw = "select sd.specifications_id,
                                            sd.specification_name
                                     from " . TABLE_SPECIFICATION . " s,
                                          " . TABLE_SPECIFICATION_DESCRIPTION . " sd
                                     where s.show_filter = 'True'
                                       and s.specifications_id = sd.specifications_id
                                       and sd.language_id = '" . $_SESSION['languages_id'] . "'
                                   ";
        // print $specifications_query_raw . "<br />\n";
        $specifications_query = vam_db_query ($specifications_query_raw);
        
        $specification_list = array();
        while ($specifications_data = vam_db_fetch_array ($specifications_query) ) {
          $specification_list[] = array ('id' => $specifications_data['specifications_id'],
                                         'text' => $specifications_data['specification_name']
                                        );
        }
        break;
        
      case 'edit_filter':
      case 'delete_filter':
        break;
        
      case 'new_value':
      case 'edit_value':
      case 'delete_value':
        break;
        
      default:
        break;
    }
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'false') { ?>
    <td width="<?php echo BOX_WIDTH; ?>" align="left" valign="top">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </td>
<?php } ?>
<!-- body_text //-->
    <td width="100%" valign="top">
    
<?php
// Listings in the center section of the page
//   There are three possible lists:
//   * Specifications categories list
//   * Specifications in a category
//   * Filters attached to a specification
//   Products data is added through the regular Categories/Products page
    switch (true) {
      case ($specs_group_path == 0 && $specs_path == 0):
      // Top level -- Show Specification Groups
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
				<h1 class="contentBoxHeading"><?php echo HEADING_TITLE_GROUPS; ?></h1>    
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smallText" align="right">
<?php
    echo vam_draw_form ('search', FILENAME_PRODUCTS_SPECIFICATIONS, '', 'get');
    echo HEADING_TITLE_SEARCH_GROUPS . ' ' . vam_draw_input_field ('search');
    echo vam_draw_hidden_field(vam_session_name(), vam_session_id()) . '</form>';
?>
                </td>
              </tr>
              <tr>
                <td class="smallText" align="right">
<?php
    echo vam_draw_form('goto', FILENAME_PRODUCTS_SPECIFICATIONS, '', 'get');
    echo HEADING_TITLE_GOTO . ' ' . vam_draw_pull_down_menu ('sgid', vam_get_group_names(), $specs_group_id, 'onsubmit="this.form.submit();"');
    echo vam_draw_hidden_field(vam_session_name(), vam_session_id()) . '</form>';
?>
                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_GROUPS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_COMPARISON; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_FILTER; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $specifications_in_group = 0;
    $filters_in_specifications = 0;
    $groups_count = 0;
    $specs_count = 0;
    $filters_count = 0;
    $rows = 0;
    $search = '';
    if (isset($_GET['search'])) {
      $search = preg_replace ("(\r\n|\n|\r)", '', $_GET['search']);  // Remove CR &/ LF
      $search = preg_replace ("/[^a-zA-Z0-9_]/i", '', $search); // strip anything we don't want
      $search = "where specification_group_name like '%" . $search . "%'";
    }
    $categories_query_raw = "select specification_group_id, 
                                    specification_group_name,
                                    show_comparison, 
                                    show_products, 
                                    show_filter,
                                    show_filter_mainpage
                             from " . TABLE_SPECIFICATION_GROUPS . "
                             " . $search . "
                             order by specification_group_name
                            ";
    // print $cztegories_query_raw . "<br />\n";
    $categories_query = vam_db_query ($categories_query_raw);
    while ($categories = vam_db_fetch_array ($categories_query) ) {
      $groups_count++;
      $specifications_query_raw = "select specifications_id
                                   from " . TABLE_SPECIFICATION . "
                                   where specification_group_id = '" . (int) $categories['specification_group_id'] . "'
                                 ";
      // print $specifications_query_raw . "<br />\n";
      $specifications_query = vam_db_query ($specifications_query_raw);
      $specifications_in_group += vam_db_num_rows ($specifications_query);
      $specs_count += vam_db_num_rows ($specifications_query);

      $rows++;
      $categories['specifications_in_group'] = $specifications_in_group;
      $categories['filters_in_specifications'] = vam_count_filters ('0', '0');
      $filters_count = vam_count_filters ('0', '0');
      
      // Set the selected Specification Category
      if ( ($specs_group_id == 0 || $specs_group_id == $categories['specification_group_id']) && !isset ($cInfo) && (substr ($action, 0, 3) != 'new') ) {
        $cInfo = new objectInfo ($categories);
      }

      if (isset ($cInfo) && is_object ($cInfo) && ($categories['specification_group_id'] == $cInfo->specification_group_id) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $categories['specification_group_id']) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $categories['specification_group_id']) . '\'">' . "\n";
      }      
?>
                <td class="dataTableContent"><?php echo '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $categories['specification_group_id']) . '">' . vam_image (DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . '</a>&nbsp;<b>' . $categories['specification_group_name'] . '</b>'; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($categories['show_comparison'] == 'True') {
        echo vam_image (DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=flag_comparison&flag=0&sgid=' . $categories['specification_group_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=flag_comparison&flag=1&sgid=' . $categories['specification_group_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image (DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?>
                </td>
                <td class="dataTableContent" align="center">
<?php
      if ($categories['show_products'] == 'True') {
        echo vam_image (DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=flag_products&flag=0&sgid=' . $categories['specification_group_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=flag_products&flag=1&sgid=' . $categories['specification_group_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image (DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?>
                </td>
                <td class="dataTableContent" align="center">
<?php
      if ($categories['show_filter'] == 'True') {
        echo vam_image (DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=flag_filters&flag=0&sgid=' . $categories['specification_group_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=flag_filters&flag=1&sgid=' . $categories['specification_group_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image (DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?>
                </td>
                <td class="dataTableContent" align="right">
<?php 
        if (isset ($cInfo) && is_object ($cInfo) && ($categories['specification_group_id'] == $cInfo->specification_group_id) ) { 
          echo vam_image (DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); 
        } else { 
          echo '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path. '&sgid=' . $categories['specification_group_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; 
        } 
?>
                &nbsp;</td>
              </tr>
<?php
        } // while ($categories
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo TEXT_GROUPS_TOTAL . '&nbsp;' . $groups_count . '<br />' . TEXT_SPECS_TOTAL . '&nbsp;' . $specs_count . '<br />' . TEXT_FILTERS_TOTAL . '&nbsp;' . $filters_count; ?></td>
                    <td align="right" class="smallText"><?php echo '<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=new_group') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/categories.png', '', '12', '12') . '&nbsp;' . IMAGE_NEW_SPECIFICATION_GROUP . '</span></a>'; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
<?php
      break;
  case ($specs_group_path != 0 && $specs_path == 0):
  // In a Specification Group -- Show specifications
  
    $group_name_query_raw = "select specification_group_name
                             from " . TABLE_SPECIFICATION_GROUPS . "
                             where specification_group_id = '" . $specs_group_path . "'
                            ";
    // print $group_name_query_raw . "<br />\n";
    $group_name_query = vam_db_query ($group_name_query_raw);

    $group_name = vam_db_fetch_array ($group_name_query);
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
				<h1 class="contentBoxHeading"><?php echo HEADING_TITLE_SPECIFICATIONS . $group_name['specification_group_name']; ?></h1>    
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smallText" align="right">
<?php
    echo vam_draw_form ('search', FILENAME_PRODUCTS_SPECIFICATIONS, '', 'get');
    echo vam_draw_hidden_field ('sgpath', $specs_group_path);
    echo HEADING_TITLE_SEARCH_SPECIFICATIONS . ' ' . vam_draw_input_field('search');
    echo vam_draw_hidden_field(vam_session_name(), vam_session_id()) . '</form>';
?>
                </td>
              </tr>
              <tr>
                <td class="smallText" align="right">
<?php
    echo vam_draw_form ('goto', FILENAME_PRODUCTS_SPECIFICATIONS, '', 'get');
    echo vam_draw_hidden_field ('sgpath', $specs_group_path);
    echo HEADING_TITLE_GOTO . ' ' . vam_draw_pull_down_menu ('spid', vam_get_specification_names ($specs_group_path, $_SESSION['languages_id']), $specification_id, 'onClick="this.form.submit();"');
    echo vam_draw_hidden_field(vam_session_name(), vam_session_id()) . '</form>';
?>
                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SPECS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ON_COMPARISON; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_IN_FILTER; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_SORT_ORDER; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;
    $search = '';
    
    $specs_count = vam_count_specifications ($specs_group_path);
    $filters_count = vam_count_filters ($specs_group_path);
    $values_count = vam_count_values ($specs_group_path);

    if (isset($_GET['search']) ) {
      $search = preg_replace ("(\r\n|\n|\r)", '', $_GET['search']);  // Remove CR &/ LF
      $search = preg_replace ("/[^a-zA-Z0-9_]/i", '', $search); // strip anything we don't want
      $search = " sd.and specification_name like '%" . $search . "%' ";
    }
    
    $specifications_query_raw = "select sp.specifications_id,
                                        sp.specification_group_id,
                                        sp.specification_sort_order,
                                        sp.show_comparison,
                                        sp.show_products,
                                        sp.show_filter,
                                        sp.show_filter_mainpage,
                                        sp.products_column_name,
                                        sp.column_justify,
                                        sp.filter_class,
                                        sp.filter_display,
                                        sp.enter_values,
                                        sp.filter_show_all,
                                        sd.specification_name,
                                        sd.specification_description,
                                        sd.specification_prefix, 
                                        sd.specification_suffix
                                 from " . TABLE_SPECIFICATION_DESCRIPTION . " sd,
                                      " . TABLE_SPECIFICATION . " sp
                                 where sp.specifications_id = sd.specifications_id
                                   and sd.language_id = '" . $_SESSION['languages_id'] . "'
                                   and sp.specification_group_id = '" . $specs_group_path . "'
                                   " . $search . "
                                order by sp.specification_sort_order,
                                         sd.specification_name
                               ";
// BOF products_filters_seo
    $specifications_query_raw = str_replace('sd.specification_name,', 'sd.specification_name, sd.specification_seo_name, sd.specification_seo_url, specification_seo_active,', $specifications_query_raw);
// EOF products_filters_seo
    // print $specifications_query_raw . "<br />\n";
    $specifications_query = vam_db_query ($specifications_query_raw);

    while ($specifications = vam_db_fetch_array ($specifications_query) ) {
      $rows++;
      $specifications['specifications_in_group'] = $specs_count;
      $specifications['filters_in_specifications'] = $filters_count;
      $specifications['values_in_specifications'] = $values_count;
      
      // Set the selected Specification
      if ( ($specification_id == 0 || $specification_id == $specifications['specifications_id']) && !isset ($sInfo) && (substr ($action, 0, 3) != 'new') ) {
        $sInfo = new objectInfo ($specifications);
      }

      if (isset ($sInfo) && is_object ($sInfo) && ($specifications['specifications_id'] == $sInfo->specifications_id) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spid=' . $specifications['specifications_id']) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spid=' . $specifications['specifications_id']) . '\'">' . "\n";
      }      

      $filter_link = vam_image (DIR_WS_ICONS . 'blank.png', ICON_BLANK);
      if ($specifications['show_filter'] == 'True' && $specifications['filter_class'] != 'none') {
        $filter_link = '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specifications['specifications_id']) . '">' . vam_image (DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . '</a>';
      }

      $value_link = vam_image (DIR_WS_ICONS . 'blank.png', ICON_BLANK);
      if ($specifications['enter_values'] != 'text') {
        $value_link = '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specifications['specifications_id'] . '&value=1') . '">' . vam_image (DIR_WS_ICONS . 'folder_blue.gif', ICON_FOLDER) . '</a>';
      }
?>
                <td class="dataTableContent"><?php echo $filter_link . '&nbsp;' . $value_link . '&nbsp;<b>' . $specifications['specification_name'] . '</b>'; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($specifications['show_comparison'] == 'True') {
        echo vam_image (DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=flag_comparison_spec&flag=0&sgpath=' . $specs_group_path . '&spid=' . $specifications['specifications_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=flag_comparison_spec&flag=1&sgpath=' . $specs_group_path . '&spid=' . $specifications['specifications_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image (DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?>
                </td>
                <td class="dataTableContent" align="center">
<?php
      if ($specifications['show_products'] == 'True') {
        echo vam_image (DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=flag_products_spec&flag=0&sgpath=' . $specs_group_path . '&spid=' . $specifications['specifications_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=flag_products_spec&flag=1&sgpath=' . $specs_group_path . '&spid=' . $specifications['specifications_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image (DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?>
                </td>
                <td class="dataTableContent" align="center">
<?php
      if ($specifications['show_filter'] == 'True') {
        echo vam_image (DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=flag_filters_spec&flag=0&sgpath=' . $specs_group_path . '&spid=' . $specifications['specifications_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'action=flag_filters_spec&flag=1&sgpath=' . $specs_group_path . '&spid=' . $specifications['specifications_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image (DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?>
                </td>
                <td class="dataTableContent" align="right"><?php echo '&nbsp;' . $specifications['specification_sort_order']; ?></td>
                <td class="dataTableContent" align="right">
<?php 
        if (isset ($sInfo) && is_object ($sInfo) && ($specifications['specification_description_id'] == $sInfo->specification_description_id) ) { 
          echo vam_image (DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); 
        } else { 
          echo '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'spath=' . $specs_path . '&spid=' . $specifications['specification_description_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; 
        } 
?>
                &nbsp;</td>
              </tr>
<?php
    } // while ($specifications
?>
             <tr>
                <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo TEXT_SPECS_TOTAL_GROUP . '&nbsp;' . $specs_count . '<br />' . TEXT_FILTERS_TOTAL_GROUP . '&nbsp;' . $filters_count . '<br />' . TEXT_VALUES_TOTAL_GROUP . '&nbsp;' . $values_count; ?></td>
                    <td align="right" class="smallText"><?php echo '<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $specs_group_path) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . IMAGE_BACK . '</span></a>&nbsp;<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&action=new_specification') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/products.png', '', '12', '12') . '&nbsp;' . IMAGE_NEW_PRODUCT . '</span></a>'; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><?php echo vam_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
              </tr>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="main"><b><?php echo TEXT_SPECS_LEGEND; ?></b></td>
                  </tr>
                  <tr>
                    <td class="smallText"><?php echo vam_image (DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . ' ' . TEXT_SPECS_LEGEND_FILTERS; ?>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="smallText"><?php echo vam_image (DIR_WS_ICONS . 'folder_blue.gif', ICON_FOLDER) . ' ' . TEXT_SPECS_LEGEND_VALUES; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
<?php
      break;
    
    case ($specs_path != '0' && $value != '1'):
      // In a Specification -- Show filters
  
      $specification_name_query_raw = "select specification_name
                                       from " . TABLE_SPECIFICATION_DESCRIPTION . "
                                       where specifications_id = '" . $specs_path . "'
                                         and language_id = '" . $_SESSION['languages_id'] . "'
                                     ";
      // print $specification_name_query_raw . "<br />\n";
      $specification_name_query = vam_db_query ($specification_name_query_raw);

      $specification_name = vam_db_fetch_array ($specification_name_query);
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
				<h1 class="contentBoxHeading"><?php echo HEADING_TITLE_FILTERS . $specification_name['specification_name']; ?></h1>    
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smallText" align="right">
<?php
    echo vam_draw_form ('search', FILENAME_PRODUCTS_SPECIFICATIONS, '', 'get');
    echo vam_draw_hidden_field ('sgpath', $specs_group_path);
    echo vam_draw_hidden_field ('spath', $specs_path);
    echo HEADING_TITLE_SEARCH_FILTERS . ' ' . vam_draw_input_field ('search');
    echo vam_draw_hidden_field(vam_session_name(), vam_session_id()) . '</form>';
?>
                </td>
              </tr>
              <tr>
                <td class="smallText" align="right">
<?php
    echo vam_draw_form ('goto', FILENAME_PRODUCTS_SPECIFICATIONS, '', 'get');
    echo vam_draw_hidden_field ('sgpath', $specs_group_path);
    echo vam_draw_hidden_field ('spath', $specs_path);
    echo HEADING_TITLE_GOTO . ' ' . vam_draw_pull_down_menu ('fid', vam_get_specification_filters ($specs_path, $_SESSION['languages_id'] = 1), $filter_id, 'onClick="this.form.submit();"');
    echo vam_draw_hidden_field(vam_session_name(), vam_session_id()) . '</form>';
?>
                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FILTERS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_SORT_ORDER; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $filters_count = 0;
    $rows = 0;
    $search = '';
    if (isset($_GET['search']) ) {
      $search = preg_replace ("(\r\n|\n|\r)", '', $_GET['search']);  // Remove CR &/ LF
      $search = preg_replace ("/[^a-zA-Z0-9_]/i", '', $search); // strip anything we don't want
      $search = " and sfd.filter like '%" . $search . "%' ";
    }
    
    $filters_query_raw = "select sf.specification_filters_id,
                                 sf.specifications_id,
                                 sf.filter_sort_order,
                                 sfd.filter,
                                 sp.products_column_name,
                                 sp.filter_class
                          from " . TABLE_SPECIFICATIONS_FILTERS . " sf,
                               " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " sfd,
                               " . TABLE_SPECIFICATION . " sp
                          where sfd.specification_filters_id = sf.specification_filters_id
                            and sp.specifications_id = '" . $specs_path . "'
                            and sf.specifications_id = '" . $specs_path . "'
                            and sfd.language_id = '" . $_SESSION['languages_id'] . "'
                            " . $search . "
                          order by sf.filter_sort_order,
                                   sfd.filter
                        ";
    // print $filters_query_raw . "<br />\n";
    $filters_query = vam_db_query ($filters_query_raw);
    $filters_count += vam_db_num_rows ($filters_query);

    while ($filters_array = vam_db_fetch_array ($filters_query) ) {
      // Set the selected Filter
      if ( ($filter_id == 0 || $filter_id == $filters_array['specification_filters_id']) && !isset ($fInfo) && (substr ($action, 0, 3) != 'new') ) {
        $fInfo = new objectInfo ($filters_array);
      }

      if (isset ($fInfo) && is_object ($fInfo) && ($filters_array['specification_filters_id'] == $fInfo->specification_filters_id) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $filters_array['specification_filters_id']) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $filters_array['specification_filters_id']) . '\'">' . "\n";
      }      

?>
                <td class="dataTableContent"><?php echo '<b>' . $filters_array['filter'] . '</b>'; ?></td>
                <td class="dataTableContent" align="right"><?php echo $filters_array['filter_sort_order']; ?></td>
                <td class="dataTableContent" align="right">
<?php 
        if (isset ($fInfo) && is_object ($fInfo) && ($filters_array['specification_filters_id'] == $fInfo->specification_filters_id) ) { 
          echo vam_image (DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); 
        } else { 
          echo '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $filters_array['specification_filters_id']) . '">' . vam_image (DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; 
        } 
?>
                &nbsp;</td>
              </tr>
<?php
      $rows++;
    } // while ($specifications
?>
             <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo TEXT_FILTERS_TOTAL . '&nbsp;' . $filters_count; ?></td>
                    <td align="right" class="smallText">
<?php 
    echo '<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spid=' . $specs_path) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . IMAGE_BACK . '</span></a>'; 
    echo '&nbsp;<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&action=new_filter') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . IMAGE_NEW_FILTER . '</span></a>'; 
?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
<?php
    break;
    case ($specs_path != '0' && $value == '1'):
      // In a Specification -- Show values
  
      $specification_name_query_raw = "select specification_name
                                       from " . TABLE_SPECIFICATION_DESCRIPTION . "
                                       where specifications_id = '" . $specs_path . "'
                                         and language_id = '" . $_SESSION['languages_id'] . "'
                                     ";
      // print $specification_name_query_raw . "<br />\n";
      $specification_name_query = vam_db_query ($specification_name_query_raw);

      $specification_name = vam_db_fetch_array ($specification_name_query);
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
				<h1 class="contentBoxHeading"><?php echo HEADING_TITLE_VALUES . $specification_name['specification_name']; ?></h1>    
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smallText" align="right">
<?php
    echo vam_draw_form ('search', FILENAME_PRODUCTS_SPECIFICATIONS, '', 'get');
    echo vam_draw_hidden_field ('sgpath', $specs_group_path);
    echo vam_draw_hidden_field ('spath', $specs_path);
    echo vam_draw_hidden_field ('value', '1');
    echo HEADING_TITLE_SEARCH_VALUES . ' ' . vam_draw_input_field ('search');
    echo vam_draw_hidden_field(vam_session_name(), vam_session_id()) . '</form>';
?>
                </td>
              </tr>
              <tr>
                <td class="smallText" align="right">
<?php
    echo vam_draw_form ('goto', FILENAME_PRODUCTS_SPECIFICATIONS, '', 'get');
    echo vam_draw_hidden_field ('sgpath', $specs_group_path);
    echo vam_draw_hidden_field ('spath', $specs_path);
    echo vam_draw_hidden_field ('value', '1');
    echo HEADING_TITLE_GOTO . ' ' . vam_draw_pull_down_menu ('vid', vam_get_specification_values ($specs_path, $_SESSION['languages_id']), $value_id, 'onClick="this.form.submit();"');
    echo vam_draw_hidden_field(vam_session_name(), vam_session_id()) . '</form>';
?>
                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_VALUES; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_SORT_ORDER; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $values_count = 0;
    $rows = 0;
    $search = '';
    if (isset($_GET['search']) ) {
      $search = preg_replace ("(\r\n|\n|\r)", '', $_GET['search']);  // Remove CR &/ LF
      $search = preg_replace ("/[^a-zA-Z0-9_]/i", '', $search); // strip anything we don't want
      $search = "and svd.specification_value like '%" . $search . "%' ";
    }
    
    $values_query_raw = "select sv.specification_values_id,
                                sv.specifications_id,
                                sv.value_sort_order,
                                svd.specification_value,
                                s.enter_values
                         from " . TABLE_SPECIFICATIONS_VALUES . " sv,
                              " . TABLE_SPECIFICATIONS_VALUES_DESCRIPTION . " svd,
                              " . TABLE_SPECIFICATION . " s
                         where svd.specification_values_id = sv.specification_values_id
                           and sv.specifications_id = '" . $specs_path . "'
                           and s.specifications_id = '" . $specs_path . "'
                           and svd.language_id = '" . $_SESSION['languages_id'] . "'
                           " . $search . "
                         order by sv.value_sort_order,
                                  svd.specification_value
                       ";
    // print $filters_query_raw . "<br />\n";
    $values_query = vam_db_query ($values_query_raw);
    $values_count += vam_db_num_rows ($values_query);

    while ($values_array = vam_db_fetch_array ($values_query) ) {
      // Set the selected Value
      if ( ($value_id == 0 || $value_id == $values_array['specification_values_id']) && !isset ($vInfo) && (substr ($action, 0, 3) != 'new') ) {
        $vInfo = new objectInfo ($values_array);
      }

      if (isset ($vInfo) && is_object ($vInfo) && ($values_array['specification_values_id'] == $vInfo->specification_values_id) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&vid=' . $values_array['specification_values_id'] . '&value=1') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&vid=' . $values_array['specification_values_id'] . '&value=1') . '\'">' . "\n";
      }      

?>
                <td class="dataTableContent"><?php echo '<b>' . $values_array['specification_value'] . '</b>'; ?></td>
                <td class="dataTableContent" align="right"><?php echo $values_array['value_sort_order']; ?></td>
                <td class="dataTableContent" align="right">
<?php 
        if (isset ($vInfo) && is_object ($vInfo) && ($filters_array['specification_values_id'] == $vInfo->specification_values_id) ) { 
          echo vam_image (DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); 
        } else { 
          echo '<a href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&vid=' . $values_array['specification_values_id'] . '&value=1') . '">' . vam_image (DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; 
        } 
?>
                &nbsp;</td>
              </tr>
<?php
      $rows++;
    } // while ($specifications
?>
             <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo TEXT_VALUES_TOTAL . '&nbsp;' . $values_count; ?></td>
                    <td align="right" class="smallText"><?php echo '<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spid=' . $specs_path) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . IMAGE_BACK . '</span></a>&nbsp;<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&action=new_value&value=1') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . IMAGE_NEW_VALUE . '</span></a>'; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
<?php
    break;
  } // switch --  end of center section
?>
            </table></td>
<?php
// Right column box
    $heading = array();
    $contents = array();
// Actions:
    switch ($action) {
      case 'new_group':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_NEW_GROUP . '</b>');

        $contents = array ('form' => vam_draw_form ('new_group', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=new_group_confirm', 'post') );
        $contents[] = array ('text' => TEXT_NEW_GROUP_INTRO);

        $contents[] = array ('text' => '<br />' . TEXT_GROUP_NAME . '<br />' . vam_draw_input_field ('specification_group_name') );
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_COMPARISON . '<br />' . vam_draw_radio_field ('show_comparison', 'True', true) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_comparison', 'False', false) . '&nbsp;' . TEXT_DONT_SHOW);
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_ON_PRODUCTS . '<br />' . vam_draw_radio_field ('show_products', 'True', true) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_products', 'False', false) . '&nbsp;' . TEXT_DONT_SHOW);
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_FILTER . '<br />' . vam_draw_radio_field ('show_filter', 'True', true) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_filter', 'False', false) . '&nbsp;' . TEXT_DONT_SHOW);

        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'edit_group':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_EDIT_GROUP . '</b>');

        $contents = array ('form' => vam_draw_form ('categories', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=update_group_confirm', 'post') );
        $contents[] = array ('text' => TEXT_EDIT_INTRO . vam_draw_hidden_field ('specification_group_id', $cInfo->specification_group_id) );

        $contents[] = array ('text' => '<br />' . TEXT_GROUP_NAME . '<br />' . vam_draw_input_field ('specification_group_name', $cInfo->specification_group_name) );

        $show_comparison = 'True';
        $dont_show_comparison = 'False';
        if ($cInfo->show_comparison == 'False') {
          $show_comparison = 'False';
          $dont_show_comparison = 'True';
        }
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_COMPARISON . '<br />' . vam_draw_radio_field ('show_comparison', 'True', true, $dont_show_comparison) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_comparison', 'False', false, $show_comparison) . '&nbsp;' . TEXT_DONT_SHOW);

        $show_products = 'True';
        $dont_show_products = 'False';
        if ($cInfo->show_products == 'False') {
          $show_products = 'False';
          $dont_show_products = 'True';
        }
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_ON_PRODUCTS . '<br />' . vam_draw_radio_field ('show_products', 'True', true, $dont_show_products) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_products', 'False', false, $show_products) . '&nbsp;' . TEXT_DONT_SHOW);

        $show_filter = 'True';
        $dont_show_filter = 'False';
        if ($cInfo->show_filter == 'False') {
          $show_filter = 'False';
          $dont_show_filter = 'True';
        }
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_FILTER . '<br />' . vam_draw_radio_field ('show_filter', 'True', true, $dont_show_filter) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_filter', 'False', false, $show_filter) . '&nbsp;' . TEXT_DONT_SHOW );

        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;

      case 'copy_group':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_COPY_GROUP . '</b>');

        $contents = array ('form' => vam_draw_form ('copy_group', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=copy_group_confirm', 'post') );
        $contents[] = array ('text' => TEXT_COPY_GROUP_INTRO . vam_draw_hidden_field ('specification_group_id', $cInfo->specification_group_id) . '<br />' );
        $contents[] = array ('text' => '&nbsp;');
        if ($count_links > 0) $contents[] = array ('text' => vam_draw_checkbox_field ('copy_links', 'True') . ' ' . sprintf (TEXT_COPY_QUERY_LINKS, $count_links) );
        if ($count_specs > 0) $contents[] = array ('text' => vam_draw_checkbox_field ('copy_specs', 'True') . ' ' . sprintf (TEXT_COPY_QUERY_SPECS, $count_specs) );
        if ($count_products > 0) $contents[] = array ('text' => vam_draw_checkbox_field ('copy_products', 'True') . ' ' . sprintf (TEXT_COPY_QUERY_PRODUCTS, $count_products) );
        if ($count_filters > 0) $contents[] = array ('text' => vam_draw_checkbox_field ('copy_filter', 'True') . ' ' . sprintf (TEXT_COPY_QUERY_FILTERS, $count_filters) );
        if ($count_values > 0) $contents[] = array ('text' => vam_draw_checkbox_field ('copy_values', 'True') . ' ' . sprintf (TEXT_COPY_QUERY_VALUES, $count_values) );

        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;

      case 'delete_group':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_DELETE_GROUP . '</b>');
        $contents = array ('form' => vam_draw_form ('delete_group', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=delete_group_confirm') );
        $contents[] = array ('text' => TEXT_DELETE_GROUP_INTRO . vam_draw_hidden_field ('specification_group_id', $cInfo->specification_group_id));
        $contents[] = array ('text' => '<br /><b>' . $cInfo->specification_group_name . '</b>');
        // $count_specs, $count_products, $count_filters are populated in the first $action section
        if ($count_specs > 0) $contents[] = array ('text' => '<br />' . sprintf (TEXT_DELETE_WARNING_SPECS, $count_specs) );
        if ($count_products > 0) $contents[] = array ('text' => '<br />' . sprintf (TEXT_DELETE_WARNING_PRODUCTS, $count_products) );
        if ($count_filters > 0) $contents[] = array ('text' => '<br />' . sprintf (TEXT_DELETE_WARNING_FILTERS, $count_filters) );
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . IMAGE_DELETE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'link_category':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_LINK_CATEGORY . '</b>');

        $contents = array ('form' => vam_draw_form ('link_category_confirm', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=link_category_confirm'));
        $contents[] = array ('text' => sprintf (TEXT_LINK_CATEGORIES_INTRO, $cInfo->categories_name) . vam_draw_hidden_field ('specification_group_id', $cInfo->specification_group_id));
        $contents[] = array ('text' => '<br />' . TEXT_LINK_TO . '<br />' . vam_draw_pull_down_menu ('link_category_id', vam_get_category_tree() ) );
        $contents[] = array ('text' => vam_draw_checkbox_field ('link_subcats', 'True') . ' ' . TEXT_LINK_TO_SUBCATS);
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_LINK . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_LINK . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'link_all_categories':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_LINK_ALL_CATEGORIES . '</b>');

        $contents = array ('form' => vam_draw_form ('link_all_categories', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=link_all_categories_confirm') );
        $contents[] = array ('text' => TEXT_LINK_ALL_INTRO . vam_draw_hidden_field ('specification_group_id', $cInfo->specification_group_id) );
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_LINK_ALL . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_LINK_ALL . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'unlink_category':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_UNLINK_CATEGORY . '</b>');

        $contents = array ('form' => vam_draw_form ('categories', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=unlink_category_confirm') );
        $contents[] = array ('text' => TEXT_UNLINK_INTRO . vam_draw_hidden_field ('specification_group_id', $cInfo->specification_group_id) );
        $contents[] = array ('text' => TEXT_UNLINK_CATEGORY . '<br />' . vam_draw_pull_down_menu ('categories_id', $categories_list) );
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_UNLINK . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_UNLINK . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'unlink_all_categories':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_UNLINK_ALL_CATEGORIES . '</b>');

        $contents = array ('form' => vam_draw_form ('categories', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=unlink_all_categories_confirm') );
        $contents[] = array ('text' => TEXT_UNLINK_ALL_INTRO . vam_draw_hidden_field ('specification_group_id', $cInfo->specification_group_id) );
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_UNLINK_ALL . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_UNLINK_ALL . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'new_specification':
        $group_query_raw = "select specification_group_name
                            from " . TABLE_SPECIFICATION_GROUPS . "
                            where specification_group_id = '" . $specs_group_path . "'
                            limit 1
                           ";
        $group_query = vam_db_query ($group_query_raw);
        $group = vam_db_fetch_array ($group_query);

        $heading[] = array ('text' => '<b>' . sprintf (TEXT_INFO_HEADING_NEW_SPECIFICATION, $group['specification_group_name']) . '</b>');

        $contents = array ('form' => vam_draw_form ('new_specification', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=new_specification_confirm&sgpath=' . $specs_group_path, 'post') );
        $contents[] = array ('text' => TEXT_NEW_SPECIFICATION_INTRO . $sInfo->specification_group_id . vam_draw_hidden_field ('specification_group_id', $specs_group_path) );

        $languages = vam_get_languages();
        $specification_name_string = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $specification_name_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('specification_name[' . $languages[$i]['id'] . ']');
        }

        $specification_description_string = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $specification_description_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_textarea_field ('specification_description[' . $languages[$i]['id'] . ']', 'soft', '40', '5');
        }
// BOF products_filters_seo
        $specification_seo_name_string = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $specification_seo_name_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('specification_seo_name[' . $languages[$i]['id'] . ']');
        }
        $specification_seo_url_string = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $specification_seo_url_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('specification_seo_url[' . $languages[$i]['id'] . ']');
        }
// EOF products_filters_seo

        $specification_prefix_string = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $specification_prefix_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('specification_prefix[' . $languages[$i]['id'] . ']');
        }

        $specification_suffix_string = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $specification_suffix_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('specification_suffix[' . $languages[$i]['id'] . ']');
        }

        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_NAME . $specification_name_string);
        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_DESCRIPTION . $specification_description_string);
// BOF products_filters_seo
        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_SEO_ACTIVE . '<br />' . vam_draw_radio_field('specification_seo_active', '1', true) . '&nbsp;' . TEXT_SPECIFICATION_SEO_ACTIVE_YES . '<br />' . vam_draw_radio_field('specification_seo_active', '0', false) . '&nbsp;' . TEXT_SPECIFICATION_SEO_ACTIVE_NO);
        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_SEO_NAME . $specification_seo_name_string);
//        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_SEO_URL . $specification_seo_url_string);
// EOF products_filters_seo
        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_PREFIX . $specification_prefix_string);
        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_SUFFIX . $specification_suffix_string);
        $contents[] = array ('text' => '<br />' . TEXT_EDIT_SORT_ORDER . '<br />' . vam_draw_input_field ('specification_sort_order', '', 'size="5"'));
        $contents[] = array ('text' => '<br />' . TEXT_COLUMN_JUSTIFY . '<br />' . vam_draw_pull_down_menu ('column_justify', $alignment_array) . '<br />' . TEXT_EXISTING_FIELD_NOTE);
        $contents[] = array ('text' => '<br />' . TEXT_EXISTING_FIELD . '<br />' . vam_draw_pull_down_menu ('products_column_name', $products_database_fields) . '<br />');
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_COMPARISON . '<br />' . vam_draw_radio_field ('show_comparison', 'True', true) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_comparison', 'False', false) . '&nbsp;' . TEXT_DONT_SHOW);
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_ON_PRODUCTS . '<br />' . vam_draw_radio_field ('show_products', 'True', true) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_products', 'False', false) . '&nbsp;' . TEXT_DONT_SHOW);
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_FILTER . '<br />' . vam_draw_radio_field ('show_filter', 'True', true) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_filter', 'False', false) . '&nbsp;' . TEXT_DONT_SHOW);
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_FILTER_MAINPAGE . '<br />' . vam_draw_radio_field ('show_filter_mainpage', 'True', true) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_filter_mainpage', 'False', false) . '&nbsp;' . TEXT_DONT_SHOW);
        $contents[] = array ('text' => '<br />' . TEXT_FILTER_CLASS . '<br />' . vam_draw_pull_down_menu ('filter_class', $filter_classes) );
        $contents[] = array ('text' => '<br />' . TEXT_FILTER_SHOW_ALL . '<br />' . vam_draw_radio_field ('filter_show_all', 'True', true) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('filter_show_all', 'False', false) . '&nbsp;' . TEXT_DONT_SHOW );
        $contents[] = array ('text' => '<br />' . TEXT_FILTER_DISPLAY . '<br />' . vam_draw_pull_down_menu ('filter_display', $filter_display_array) );
        $contents[] = array ('text' => '<br />' . TEXT_ENTER_VALUE . '<br />' . vam_draw_pull_down_menu ('enter_values', $enter_filter_array) );

        $contents[] = array('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'spid=' . $specification_id . '&sgpath=' . $specs_group_path) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'edit_specification':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_EDIT_SPECIFICATION . '</b>');

        $contents = array ('form' => vam_draw_form ('edit_specification', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=edit_specification_confirm&spid=' . $sInfo->specifications_id . '&sgpath=' . $specs_group_path, 'post') );
        $contents[] = array ('text' => TEXT_EDIT_INTRO . vam_draw_hidden_field ('specifications_id', $sInfo->specifications_id) . vam_draw_hidden_field ('specification_group_id', $sInfo->specification_group_id) );

        $languages = vam_get_languages();
        $specification_name_string = '';
        $specification_description_string = '';
// BOF products_filters_seo
        $specification_seo_name_string = '';
        $specification_seo_url_string = '';
// EOF products_filters_seo
        $specification_prefix_string = '';
        $specification_suffix_string = '';
        $specification_query_raw = "select products_column_name,
                                           specification_sort_order,
                                           show_filter,
                                           show_filter_mainpage,
                                           filter_class,
                                           filter_show_all,
                                           filter_display,
                                           enter_values
                                    from " . TABLE_SPECIFICATION . "
                                    where specifications_id = '" . $sInfo->specifications_id . "'
                                    limit 1";
        // print $specifications_query_raw . "<br />\n";
// BOF products_filters_seo
        $specification_query_raw = str_replace('products_column_name,', 'products_column_name, specification_seo_active,', $specification_query_raw);
// EOF products_filters_seo
        $specification_query = vam_db_query ($specification_query_raw);
        $specification_fixed_data = vam_db_fetch_array ($specification_query);
        
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $specification_query_raw = "select specification_name, 
                                             specification_description, 
                                             specification_prefix, 
                                             specification_suffix
                                      from " . TABLE_SPECIFICATION_DESCRIPTION . "
                                      where language_id = '" . $languages[$i]['id'] . "'
                                        and specifications_id = '" . $sInfo->specifications_id . "'
                                      limit 1";
// BOF products_filters_seo
          $specification_query_raw = str_replace('specification_name,', 'specification_name, specification_seo_name, specification_seo_url,', $specification_query_raw);
// EOF products_filters_seo
          // print $specifications_query_raw . "<br />\n";
          $specification_query = vam_db_query ($specification_query_raw);
          $specification_data = vam_db_fetch_array ($specification_query);
          
          $specification_data = array_merge ( (array) $specification_fixed_data, (array) $specification_data);
          
          $specification_name_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('specification_name[' . $languages[$i]['id'] . ']', $specification_data['specification_name'] );

          $specification_description_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_textarea_field ('specification_description[' . $languages[$i]['id'] . ']', 'soft', '40', '5', $specification_data['specification_description'] );
// BOF products_filters_seo
          $specification_seo_name_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('specification_seo_name[' . $languages[$i]['id'] . ']', $specification_data['specification_seo_name']);
          $specification_seo_url_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('specification_seo_url[' . $languages[$i]['id'] . ']', $specification_data['specification_seo_url']);
// EOF products_filters_seo
          $specification_prefix_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('specification_prefix[' . $languages[$i]['id'] . ']', $specification_data['specification_prefix'] );

          $specification_suffix_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('specification_suffix[' . $languages[$i]['id'] . ']', $specification_data['specification_suffix'] );
        }

        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_NAME . $specification_name_string);
        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_DESCRIPTION . $specification_description_string);
// BOF products_filters_seo
        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_SEO_ACTIVE . '<br />' . vam_draw_radio_field('specification_seo_active', '1', $sInfo->specification_seo_active === '1') . '&nbsp;' . TEXT_SPECIFICATION_SEO_ACTIVE_YES . '<br />' . vam_draw_radio_field('specification_seo_active', '0', $sInfo->specification_seo_active === '0') . '&nbsp;' . TEXT_SPECIFICATION_SEO_ACTIVE_NO);
        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_SEO_NAME . $specification_seo_name_string);
//        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_SEO_URL . $specification_seo_url_string);
// EOF products_filters_seo
        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_PREFIX . $specification_prefix_string);
        $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_SUFFIX . $specification_suffix_string);
        $contents[] = array ('text' => '<br />' . TEXT_EDIT_SORT_ORDER . '<br />' . vam_draw_input_field ('specification_sort_order', $specification_data['specification_sort_order'], 'size="5"'));
        $contents[] = array ('text' => '<br />' . TEXT_COLUMN_JUSTIFY . '<br />' . vam_draw_pull_down_menu ('column_justify', $alignment_array, $specification_data['column_justify']) . '<br />');
        $contents[] = array ('text' => '<br />' . TEXT_EXISTING_FIELD . '<br />' . vam_draw_pull_down_menu ('products_column_name', $products_database_fields, $specification_data['products_column_name']) . '<br />' . TEXT_EXISTING_FIELD_NOTE);

        $show_comparison = 'True';
        $dont_show_comparison = 'False';
        if ($sInfo->show_comparison == 'False') {
          $show_comparison = 'False';
          $dont_show_comparison = 'True';
        }
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_COMPARISON . '<br />' . vam_draw_radio_field ('show_comparison', 'True', true, $dont_show_comparison) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_comparison', 'False', false, $show_comparison) . '&nbsp;' . TEXT_DONT_SHOW);

        $show_products = 'True';
        $dont_show_products = 'False';
        if ($sInfo->show_products == 'False') {
          $show_products = 'False';
          $dont_show_products = 'True';
        }
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_ON_PRODUCTS . '<br />' . vam_draw_radio_field ('show_products', 'True', true, $dont_show_products) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_products', 'False', false, $show_products) . '&nbsp;' . TEXT_DONT_SHOW);

        $show_filter = 'True';
        $dont_show_filter = 'False';
        if ($sInfo->show_filter == 'False') {
          $show_filter = 'False';
          $dont_show_filter = 'True';
        }
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_FILTER . '<br />' . vam_draw_radio_field ('show_filter', 'True', true, $dont_show_filter) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_filter', 'False', false, $show_filter) . '&nbsp;' . TEXT_DONT_SHOW );

        $show_filter_mainpage = 'True';
        $dont_show_filter_mainpage = 'False';
        if ($sInfo->show_filter_mainpage == 'False') {
          $show_filter_mainpage = 'False';
          $dont_show_filter_mainpage = 'True';
        }
        $contents[] = array ('text' => '<br />' . TEXT_SHOW_FILTER_MAINPAGE . '<br />' . vam_draw_radio_field ('show_filter_mainpage', 'True', true, $dont_show_filter_mainpage) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('show_filter_mainpage', 'False', false, $show_filter_mainpage) . '&nbsp;' . TEXT_DONT_SHOW );

        $contents[] = array ('text' => '<br />' . TEXT_FILTER_CLASS . '<br />' . vam_draw_pull_down_menu ('filter_class', $filter_classes, $specification_data['filter_class']) );
        $contents[] = array ('text' => '<br />' . TEXT_FILTER_DISPLAY . '<br />' . vam_draw_pull_down_menu ('filter_display', $filter_display_array, $specification_data['filter_display']) );

        $filter_show_all = 'True';
        $filter_dont_show_all = 'False';
        if ($sInfo->filter_show_all == 'False') {
          $filter_show_all = 'False';
          $filter_dont_show_all = 'True';
        }
        $contents[] = array ('text' => '<br />' . TEXT_FILTER_SHOW_ALL . '<br />' . vam_draw_radio_field ('filter_show_all', 'True', true, $filter_dont_show_all) . '&nbsp;' . TEXT_SHOW . '<br />' . vam_draw_radio_field ('filter_show_all', 'False', false, $filter_show_all) . '&nbsp;' . TEXT_DONT_SHOW );
        $contents[] = array ('text' => '<br />' . TEXT_ENTER_VALUE . '<br />' . vam_draw_pull_down_menu ('enter_values', $enter_filter_array, $specification_data['enter_values']) );

        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'spid=' . $specification_id . '&sgpath=' . $specs_group_path) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
         
      case 'delete_specification':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_DELETE_SPECIFICATION . '</b>');

        $contents = array ('form' => vam_draw_form ('delete_specification', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=delete_specification_confirm&spid=' . $sInfo->specifications_id . '&sgpath=' . $specs_group_path, 'post') );
        $contents[] = array ('text' => TEXT_DELETE_SPECIFICATION_INTRO . vam_draw_hidden_field ('specifications_id', $sInfo->specifications_id) );
        $contents[] = array ('text' => '<br /><b>' . $sInfo->specification_name . '</b>');

        // $count_products, $count_filters are populated in the first $action section
        if ($count_products > 0) $contents[] = array ('text' => '<br />' . sprintf (TEXT_DELETE_WARNING_PRODUCTS, $count_products) );
        if ($count_filters > 0) $contents[] = array ('text' => '<br />' . sprintf (TEXT_DELETE_WARNING_FILTERS, $count_filters) );

        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . IMAGE_DELETE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'spid=' . $specification_id . '&sgpath=' . $specs_group_path) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'move_specification':
        // Move a Specification to a different Group
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_MOVE_SPECIFICATION . '</b>');

        $contents = array ('form' => vam_draw_form ('move_specification', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=move_specification_confirm&spid=' . $sInfo->specifications_id . '&sgpath=' . $specs_group_path, 'post') );
        $contents[] = array ('text' => sprintf (TEXT_MOVE_SPECIFICATION_INTRO, $sInfo->specification_name) . vam_draw_hidden_field ('specifications_id', $sInfo->specifications_id) . vam_draw_hidden_field ('specification_group_id', $sInfo->specification_group_id) );
        $contents[] = array ('text' => '<br />' . TEXT_MOVE_SPECIFICATION_TO . '<br />' . vam_draw_pull_down_menu ('group_id', $groups_array, $specs_group_path) );
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_MOVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_MOVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'spid=' . $specification_id . '&sgpath=' . $specs_group_path) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'copy_specification':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_COPY_SPECIFICATION . '</b>');

        $contents = array ('form' => vam_draw_form ('copy_specification', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=copy_specification_confirm&spid=' . $sInfo->specifications_id . '&sgpath=' . $specs_group_path, 'post') );
        $contents[] = array ('text' => sprintf (TEXT_INFO_COPY_SPECIFICATION_INTRO, $sInfo->specification_name) . $sInfo->specifications_id . vam_draw_hidden_field ('specifications_id', $sInfo->specifications_id) . vam_draw_hidden_field ('specification_group_id', $sInfo->specification_group_id) );
        if ($count_filters > 0) $contents[] = array ('text' => vam_draw_checkbox_field ('copy_filter', 'True') . ' ' . sprintf (TEXT_COPY_QUERY_FILTERS, $count_filters) );
        if ($count_values > 0) $contents[] = array ('text' => vam_draw_checkbox_field ('copy_values', 'True') . ' ' . sprintf (TEXT_COPY_QUERY_VALUES, $count_values) );
        $contents[] = array ('text' => '<br />' . TEXT_COPY_SPECIFICATION_TO . '<br />' . vam_draw_pull_down_menu ('group_id', $groups_array, $specs_group_path) );
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_COPY . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_COPY . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'spid=' . $specification_id . '&sgpath=' . $specs_group_path) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
//Filters       
      case 'new_filter':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_NEW_FILTER . '</b>');

        $contents = array ('form' => vam_draw_form ('new_filter', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=new_filter_confirm&sgpath=' . $specs_group_path . '&spath=' . $specs_path, 'post', 'enctype="multipart/form-data"') );
        $contents[] = array ('text' => sprintf (TEXT_NEW_FILTER_INTRO, $filters_data['specification_name'], $filters_data['filter_class']) . vam_draw_hidden_field ('specifications_id', $specs_path) );

        $check_query_raw = "select products_column_name,
                                   filter_display
                            from " . TABLE_SPECIFICATION . "
                            where specifications_id = '" . $specs_path . "'
                        ";
        // print $check_query_raw . "<br />\n";
        $check_query = vam_db_query ($check_query_raw);
        $check_data = vam_db_fetch_array ($check_query);
        if ($check_data['products_column_name'] == 'manufacturers_id') {
          $contents[] = array ('text' => '<br /><a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $fInfo->specification_filters_id . '&action=import_manufacturers') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/import.png', '', '12', '12') . '&nbsp;' . IMAGE_IMPORT_MANUFACTURERS . '</span></a>');
        }

        $entry_type = 'text';
        if ($check_data['filter_display'] == 'image' || $check_data['filter_display'] == 'multiimage') {
          $entry_type = 'image';
        }
        
        $filter_inputs_string = '';
        $languages = vam_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          if ($entry_type == 'image') {
            $filter_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_file_field ('filter[' . $languages[$i]['id'] . ']');
          } else {
            $filter_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('filter[' . $languages[$i]['id'] . ']');
          }
        }

        $contents[] = array ('text' => '<br />' . TEXT_NEW_FILTER . $filter_inputs_string . vam_draw_hidden_field ('entry_type', $entry_type) );
        $contents[] = array ('text' => '<br />' . TEXT_FILTER_SORT_ORDER . '<br />' . vam_draw_input_field ('filter_sort_order', '', 'size="5"'));
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'edit_filter':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_FILTER . '</b>');

        $contents = array('form' => vam_draw_form ('edit_filter', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=edit_filter_confirm&sgpath=' . $specs_group_path . '&spath=' . $specs_path, 'post', 'enctype="multipart/form-data"') );
        $contents[] = array('text' => sprintf (TEXT_EDIT_FILTER_INTRO, $filters_data['specification_name'], $filters_data['filter_class']) . vam_draw_hidden_field ('specification_filters_id', $fInfo->specification_filters_id) . vam_draw_hidden_field ('specifications_id', $fInfo->specifications_id) );

        $check_query_raw = "select products_column_name,
                                   filter_display
                            from " . TABLE_SPECIFICATION . "
                            where specifications_id = '" . $specs_path . "'
                        ";
        // print $check_query_raw . "<br />\n";
        $check_query = vam_db_query ($check_query_raw);
        $check_data = vam_db_fetch_array ($check_query);

        $entry_type = 'text';
        if ($check_data['filter_display'] == 'image' || $check_data['filter_display'] == 'multiimage') {
          $entry_type = 'image';
        }

        $filter_inputs_string = '';
        $languages = vam_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $filter_data_query_raw = "select sfd.filter
                                    from " . TABLE_SPECIFICATIONS_FILTERS . " sf,
                                         " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " sfd
                                    where sfd.specification_filters_id = sf.specification_filters_id
                                      and sf.specification_filters_id = '" . $fInfo->specification_filters_id . "'
                                      and sfd.language_id = '" . $languages[$i]['id'] . "'
                                  ";
          // print $filter_data_query_raw . "<br />\n";
          $filter_data_query = vam_db_query ($filter_data_query_raw);
          $filter_data = vam_db_fetch_array ($filter_data_query);
          if ($entry_type == 'image') {
            $filter_inputs_string .= '<br />' . vam_image (DIR_WS_CATALOG_IMAGES . $filter_data['filter'], $filter_data['filter'], SPECIFICATIONS_FILTER_IMAGE_WIDTH, SPECIFICATIONS_FILTER_IMAGE_HEIGHT, ' class="image_filter"') . '<br />' . DIR_WS_CATALOG_IMAGES . '<br /><b>' . $filter_data['filter'] . '</b>';
            $filter_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_file_field ('filter' . $languages[$i]['id']);
            $filter_inputs_string .= '<br />';
          } else {
            $filter_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('filter[' . $languages[$i]['id'] . ']', $filter_data['filter'] );
          } // if ($entry_type
        } // for ($i = 0

        $contents[] = array ('text' => '<br />' . TEXT_EDIT_FILTER . $filter_inputs_string . vam_draw_hidden_field ('entry_type', $entry_type) .vam_draw_hidden_field ('old_val', $filter_data['filter']) . vam_draw_hidden_field ('spath_val', $_GET['spath']) );
        $contents[] = array ('text' => '<br />' . TEXT_FILTER_SORT_ORDER . '<br />' . vam_draw_input_field ('filter_sort_order', $fInfo->filter_sort_order, 'size="5"'));
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $fInfo->specification_filters_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');

        $import = '';
        if ($check_data['products_column_name'] == 'manufacturers_id') {
          $import = '<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $fInfo->specification_filters_id . '&action=update_manufacturers') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/import.png', '', '12', '12') . '&nbsp;' . IMAGE_IMPORT_MANUFACTURERS . '</span></a>&nbsp;';
        }
        $contents[] = array ('align' => 'center', 'text' => $import . '<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $fInfo->specification_filters_id . '&action=sort_filters') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/sort.png', '', '12', '12') . '&nbsp;' . IMAGE_SORT . '</span></a>');
        break;
        
      case 'delete_filter':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_DELETE_FILTER . '</b>');

        $contents = array ('form' => vam_draw_form ('delete_filter', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=delete_filter_confirm&sgpath=' . $specs_group_path . '&spath=' . $specs_path) );
        $contents[] = array ('text' => TEXT_DELETE_FILTER_INTRO . vam_draw_hidden_field ('specification_filters_id', $fInfo->specification_filters_id) . vam_draw_hidden_field ('specifications_id', $fInfo->specifications_id) );
        $contents[] = array ('text' => '<br /><b>' . $fInfo->filter . '</b>');
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . IMAGE_DELETE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $fInfo->specification_filters_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'move_filter':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_MOVE_FILTER . '</b>');

        $contents = array ('form' => vam_draw_form ('move_filter', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=move_filter_confirm&sgpath=' . $specs_group_path . '&spath=' . $specs_path));
        $contents[] = array ('text' => sprintf (TEXT_MOVE_FILTER_INTRO, $fInfo->filter) . vam_draw_hidden_field ('specification_filters_id', $fInfo->specification_filters_id) . vam_draw_hidden_field ('specifications_id', $fInfo->specifications_id) );
        $contents[] = array ('text' => '<br />' . sprintf(TEXT_MOVE_FILTER_TO, $fInfo->filter) . '<br />' . vam_draw_pull_down_menu ('move_to_filter_id', $specification_list, $specs_path));
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_MOVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_MOVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $fInfo->specification_filters_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'copy_filter':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_COPY_FILTER . '</b>');

        $contents = array ('form' => vam_draw_form ('copy_filter', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=copy_filter_confirm&sgpath=' . $specs_group_path . '&spath=' . $specs_path));
        $contents[] = array ('text' => sprintf (TEXT_COPY_FILTER_INTRO, $fInfo->filter) . vam_draw_hidden_field ('specification_filters_id', $fInfo->specification_filters_id) . vam_draw_hidden_field ('specifications_id', $fInfo->specifications_id) );
        $contents[] = array ('text' => '<br />' . sprintf (TEXT_COPY_FILTER_TO, $fInfo->filter) . '<br />' . vam_draw_pull_down_menu ('copy_to_filter_id', $specification_list, $specs_path) );
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_COPY . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/copy.png', '', '12', '12') . '&nbsp;' . IMAGE_COPY . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $fInfo->specification_filters_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;

// Specification Values
      case 'new_value':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_NEW_VALUE . '</b>');

        $contents = array ('form' => vam_draw_form ('new_value', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=new_value_confirm&sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&value=1', 'post', 'enctype="multipart/form-data"') );
        $contents[] = array ('text' => sprintf (TEXT_NEW_VALUE_INTRO, $values_data['specification_name'], $values_data['value_class']) . vam_draw_hidden_field ('specifications_id', $specs_path) );

        $values_entry_query_raw = "select enter_values
                                   from " . TABLE_SPECIFICATION . "
                                   where specifications_id = '" . $specs_path . "'
                                  ";
        // print $values_entry_query_raw . "<br />\n";
        $values_entry_query = vam_db_query ($values_entry_query_raw);
        $values_entry_data = vam_db_fetch_array ($values_entry_query);
        $entry_type = 'text';
        if ($values_entry_data['enter_values'] == 'image' || $values_entry_data['enter_values'] == 'multiimage') {
          $entry_type = 'image';
        }

        $value_inputs_string = '';
        $languages = vam_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          if ($entry_type == 'image') {
            $value_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_file_field ('specification_value' . $languages[$i]['id']);
          } else {
            $value_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('specification_value[' . $languages[$i]['id'] . ']');
          }
        }

        $contents[] = array ('text' => '<br />' . TEXT_NEW_VALUE . $value_inputs_string . vam_draw_hidden_field ('entry_type', $entry_type) );
        $contents[] = array ('text' => '<br />' . TEXT_VALUE_SORT_ORDER . '<br />' . vam_draw_input_field ('value_sort_order', '', 'size="5"'));
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&value=1&spath=' . $specs_path) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'edit_value':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_VALUE . '</b>');

        $contents = array('form' => vam_draw_form ('edit_value', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=edit_value_confirm&sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&value=1', 'post', 'enctype="multipart/form-data"') );
        $contents[] = array('text' => TEXT_EDIT_VALUE_INTRO . vam_draw_hidden_field ('specification_values_id', $vInfo->specification_values_id) . vam_draw_hidden_field ('specifications_id', $specs_path) );

        $values_entry_query_raw = "select enter_values
                                   from " . TABLE_SPECIFICATION . "
                                   where specifications_id = '" . $specs_path . "'
                                  ";
        // print $values_entry_query_raw . "<br />\n";
        $values_entry_query = vam_db_query ($values_entry_query_raw);
        $values_entry_data = vam_db_fetch_array ($values_entry_query);

        $entry_type = 'text';
        if ($values_entry_data['enter_values'] == 'image' || $values_entry_data['enter_values'] == 'multiimage') {
          $entry_type = 'image';
        }

        $value_inputs_string = '';
        $languages = vam_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $specification_value_query_raw = "select svd.specification_value
                                            from " . TABLE_SPECIFICATIONS_VALUES . " sv,
                                                 " . TABLE_SPECIFICATIONS_VALUES_DESCRIPTION . " svd
                                            where svd.specification_values_id = sv.specification_values_id
                                              and svd.language_id = '" . $languages[$i]['id'] . "'
                                              and sv.specification_values_id = '" . $vInfo->specification_values_id . "'
                                            limit 1";
          // print $specifications_query_raw . "<br />\n";
          $specification_value_query = vam_db_query ($specification_value_query_raw);
          $specification_value_data = vam_db_fetch_array ($specification_value_query);

          $specification_value = $specification_value_data['specification_value'];
          if ($entry_type == 'image') {
            $value_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_file_field ('specification_value' . $languages[$i]['id']);
          } else {
            $value_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field ('specification_value[' . $languages[$i]['id'] . ']', $specification_value);
          }
        }

        $contents[] = array ('text' => '<br />' . TEXT_EDIT_VALUE . $value_inputs_string . vam_draw_hidden_field ('entry_type', $entry_type) );
        $contents[] = array ('text' => '<br />' . TEXT_VALUE_SORT_ORDER . '<br />' . vam_draw_input_field ('value_sort_order', $vInfo->value_sort_order, 'size="5"'));
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&value=1&vid=' . $vInfo->specification_values_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'delete_value':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_DELETE_VALUE . '</b>');

        $contents = array ('form' => vam_draw_form ('delete_value', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=delete_value_confirm&sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&value=1') );
        $contents[] = array ('text' => TEXT_DELETE_VALUE_INTRO . vam_draw_hidden_field ('specification_values_id', $vInfo->specification_values_id) . vam_draw_hidden_field ('specifications_id', $vInfo->specifications_id) );
        $contents[] = array ('text' => '<br /><b>' . $vInfo->value . '</b>');
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . IMAGE_DELETE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&value=1&vid=' . $vInfo->specification_values_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'move_value':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_MOVE_VALUE . '</b>');

        $contents = array ('form' => vam_draw_form ('move_value', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=move_value_confirm&sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&value=1') );
        $contents[] = array ('text' => sprintf (TEXT_MOVE_VALUE_INTRO, $vInfo->value) . vam_draw_hidden_field ('specification_values_id', $vInfo->specification_values_id) . vam_draw_hidden_field ('specifications_id', $vInfo->specifications_id) );
        $contents[] = array ('text' => '<br />' . sprintf (TEXT_MOVE_VALUE_TO, $vInfo->value) . '<br />' . vam_draw_pull_down_menu ('move_to_value_id', $specification_list, $specs_path));
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_MOVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_MOVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&value=1&vid=' . $vInfo->specification_values_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      case 'copy_value':
        $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_COPY_VALUE . '</b>');

        $contents = array ('form' => vam_draw_form ('copy_value', FILENAME_PRODUCTS_SPECIFICATIONS, 'action=copy_value_confirm&sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&value=1') );
        $contents[] = array ('text' => sprintf (TEXT_COPY_VALUE_INTRO, $vInfo->value) . vam_draw_hidden_field ('specification_values_id', $fInfo->specification_values_id) );
        $contents[] = array ('text' => '<br />' . sprintf (TEXT_COPY_VALUE_TO, $vInfo->value) . '<br />' . vam_draw_pull_down_menu ('copy_to_value_id', $specification_list, $specs_path) );
        $contents[] = array ('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . IMAGE_MOVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . IMAGE_MOVE . '</button></span>' . ' <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&value=1&vid=' . $vInfo->specification_values_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . IMAGE_CANCEL . '</span></a>');
        break;
        
      default:
        switch (true) {
          // Top level -- Show specification groups
          case ($specs_group_path == 0 && $specs_path == 0):
            if ($rows > 0) {
              if (isset ($cInfo) && is_object ($cInfo)) { // Specification groups info box contents
                $heading[] = array ('text' => '<b>' . $cInfo->specification_group_name . '</b>');

                $contents[] = array ('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id . '&action=edit_group') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . IMAGE_EDIT . '</span></a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id . '&action=delete_group') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . IMAGE_DELETE . '</span></a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id . '&action=copy_group') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/copy.png', '', '12', '12') . '&nbsp;' . IMAGE_COPY . '</span></a>');
                $contents[] = array ('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id . '&action=link_category') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/link.png', '', '12', '12') . '&nbsp;' . IMAGE_LINK . '</span>' . '</a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id . '&action=link_all_categories') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/link_all.png', '', '12', '12') . '&nbsp;' . IMAGE_LINK_ALL . '</span>' . '</a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id . '&action=unlink_category') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/unlink.png', '', '12', '12') . '&nbsp;' . IMAGE_UNLINK . '</span>' . '</a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgid=' . $cInfo->specification_group_id . '&action=unlink_all_categories') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/unlink_all.png', '', '12', '12') . '&nbsp;' . IMAGE_UNLINK_ALL . '</span>' . '</a> ');
                $categories_query_raw = "select categories_name                                     
                                         from " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c,
                                              " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                         where cd.language_id = '" . $_SESSION['languages_id'] . "'
                                           and s2c.categories_id = cd.categories_id
                                           and s2c.specification_group_id = '" . $cInfo->specification_group_id . "'
                                        ";
                // print $specifications_query_raw . "<br />\n";
                $categories_query = vam_db_query ($categories_query_raw);
                if (vam_db_num_rows ($categories_query) > 0) { //We have categories linked
                  $contents[] = array ('text' => TEXT_LIST_CATEGORIES_LINKED);
                  while ($categories_data = vam_db_fetch_array ($categories_query) ) {
                    $contents[] = array ('text' => '&nbsp;&nbsp;&nbsp;' . $categories_data['categories_name']);
                  } // while ($categories_data
                } // if (vam_db_num_rows
                $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATIONS . ' ' . $cInfo->specifications_in_group);
                $contents[] = array ('text' => TEXT_FILTERS_GROUP . ' ' . $cInfo->filters_in_specifications);
              } 
            } else { // There are no groups, so show create new group info
              $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_EMPTY_GROUP . '</b>');

              $contents[] = array ('text' => TEXT_NO_GROUPS);
            }
            break;

          // In a Specification Group -- Show specifications
          case ($specs_group_path != 0 && $specs_path == 0):
            if ($rows > 0) {
              if (isset ($sInfo) && is_object ($sInfo)) { // Specification info box contents
                $heading[] = array ('text' => '<b>' . TEXT_SPECIFICATION . '</b>');

                $contents[] = array ('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spid=' . $sInfo->specifications_id . '&action=edit_specification') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . IMAGE_EDIT . '</span>' . '</a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spid=' . $sInfo->specifications_id . '&action=delete_specification') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . IMAGE_DELETE . '</span>' . '</a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spid=' . $sInfo->specifications_id . '&action=copy_specification') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/copy.png', '', '12', '12') . '&nbsp;' . IMAGE_COPY . '</span>' . '</a>  <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spid=' . $sInfo->specifications_id . '&action=move_specification') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/move.png', '', '12', '12') . '&nbsp;' . IMAGE_MOVE . '</span>' . '</a>');
                $contents[] = array ('text' => '<br />' . TEXT_SPEC_NAME . ' ' . $sInfo->specification_name);
                $contents[] = array ('text' => TEXT_SPEC_DESCRIPTION . ' ' . $sInfo->specification_description);
                $contents[] = array ('text' => TEXT_SPEC_PREFIX . ' ' . $sInfo->specification_prefix);
                $contents[] = array ('text' => TEXT_SPEC_SUFFIX . ' ' . $sInfo->specification_suffix);
                $contents[] = array ('text' => TEXT_SPEC_SORT_ORDER . ' ' . $sInfo->specification_sort_order);
                $contents[] = array ('text' => TEXT_SPEC_JUSTIFICATION . ' ' . $sInfo->column_justify);
                $contents[] = array ('text' => TEXT_SPEC_COLUMN_NAME . ' ' . $sInfo->products_column_name);
                $contents[] = array ('text' => TEXT_FILTER_CLASS . ': ' . $sInfo->filter_class);
                $contents[] = array ('text' => TEXT_FILTER_DISPLAY . ': ' . $sInfo->filter_display);
                $contents[] = array ('text' => TEXT_FILTER_SHOW_ALL . ': ' . $sInfo->filter_show_all);
                $contents[] = array ('text' => TEXT_ENTER_VALUE . ': ' . $sInfo->enter_values);
                $contents[] = array ('text' => '<br />' . TEXT_FILTERS_SPEC . ' ' . $sInfo->filters_in_specifications);
                $contents[] = array ('text' => ' ');
              } 
            } else { // There are no specifications, so show create new specifications info
              $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_EMPTY_SPECIFICATIONS . '</b>');

              $contents[] = array ('text' => TEXT_NO_SPECIFICATIONS);
            }
            break;
            
          // In a Specification -- Show filters
          case ($specs_path != '0' && $value != '1'):
            if ($rows > 0) {
              if (isset ($fInfo) && is_object ($fInfo)) { // Filters info box contents
                $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_FILTER . ' ' . $fInfo->filter_class . '</b>');

                $contents[] = array ('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $fInfo->specification_filters_id . '&action=edit_filter') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . IMAGE_EDIT . '</span>' . '</a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $fInfo->specification_filters_id . '&action=delete_filter') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . IMAGE_DELETE . '</span>' . '</a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $fInfo->specification_filters_id . '&action=copy_filter') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/copy.png', '', '12', '12') . '&nbsp;' . IMAGE_COPY . '</span>' . '</a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&fid=' . $fInfo->specification_filters_id . '&action=move_filter') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/move.png', '', '12', '12') . '&nbsp;' . IMAGE_MOVE . '</span>' . '</a>');
                if ($fInfo->filter_class == 'image' || $fInfo->filter_class == 'multiimage') {
                  $contents[] = array ('text' => '<br />' . TEXT_FILTER_VALUE . $fInfo->filter . '<br />' . vam_image (DIR_WS_CATALOG_IMAGES . $fInfo->filter, $fInfo->filter, SPECIFICATIONS_FILTER_IMAGE_WIDTH, SPECIFICATIONS_FILTER_IMAGE_HEIGHT, ' class="image_filter"') );
                } else {
                  $contents[] = array ('text' => '<br />' . TEXT_FILTER_VALUE . ' ' . $fInfo->filter);
                }
                $contents[] = array ('text' => TEXT_FILTER_SORT_ORDER . ' ' . $fInfo->filter_sort_order);
                $contents[] = array ('text' => ' ');
              } 
            } else { // There are no filters, so show create new filters info
              $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_EMPTY_FILTERS . '</b>');

              $contents[] = array ('text' => TEXT_NO_FILTERS);
            }
            break;
            
          // In a Specification -- Show values
          case ($specs_path != '0' && $value == '1'):
            if ($rows > 0) {
              if (isset ($vInfo) && is_object ($vInfo)) { // filter values info box contents
                $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_VALUE . ' ' . $vInfo->enter_values . '</b>');

                $contents[] = array ('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&vid=' . $vInfo->specification_values_id . '&value=1&action=edit_value') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . IMAGE_EDIT . '</span>' . '</a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&vid=' . $vInfo->specification_values_id . '&value=1&action=delete_value') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . IMAGE_DELETE . '</span>' . '</a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&vid=' . $vInfo->specification_values_id . '&value=1&action=copy_value') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/copy.png', '', '12', '12') . '&nbsp;' . IMAGE_COPY . '</span>' . '</a> <a class="button" href="' . vam_href_link (FILENAME_PRODUCTS_SPECIFICATIONS, 'sgpath=' . $specs_group_path . '&spath=' . $specs_path . '&vid=' . $vInfo->specification_values_id . '&value=1&action=move_value') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/move.png', '', '12', '12') . '&nbsp;' . IMAGE_MOVE . '</span>' . '</a>');
                if ($vInfo->enter_values == 'image' || $vInfo->enter_values == 'multiimage') {
                  $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_VALUE . ' ' . $vInfo->specification_value . '<br />' . vam_image (DIR_WS_CATALOG_IMAGES . $vInfo->specification_value, $vInfo->specification_value, SPECIFICATIONS_FILTER_IMAGE_WIDTH, SPECIFICATIONS_FILTER_IMAGE_HEIGHT, ' class="image_filter"') );
                } else {
                  $contents[] = array ('text' => '<br />' . TEXT_SPECIFICATION_VALUE . ' ' . $vInfo->specification_value);
                }
                $contents[] = array ('text' => TEXT_VALUE_SORT_ORDER . ' ' . $vInfo->value_sort_order);
                $contents[] = array ('text' => '&nbsp;');
              } 
            } else { // There are no values, so show create new values info
              $heading[] = array ('text' => '<b>' . TEXT_INFO_HEADING_EMPTY_VALUES . '</b>');

              $contents[] = array ('text' => TEXT_NO_VALUES);
            }
            break;
      } //switch (true)
    } //switch ($action)

    if ( (vam_not_null ($heading)) && (vam_not_null ($contents) ) ) {
      echo '            <td width="25%" valign="top">' . "\n";

      $box = new box;
      echo $box->infoBox ($heading, $contents);

      echo '            </td>' . "\n";
    }
?>
          </tr>
        </table></td>
      </tr>
    </table>
<?php
//  }
?>
    </td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require_once(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require_once(DIR_WS_INCLUDES . 'application_bottom.php'); ?>