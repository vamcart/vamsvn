<?php
/*
  $Id: products_specifications.php v1.0.1 20090917 kymation $
  $Loc: catalog/includes/functions/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

  ////
  // Sanitize all _GET variables to prevent hacking
  // Function copied from Security Pro addon, with thanks
  // ***** Warning ***** Remove this function if you have
  //    SecurityPro installed *****
  function vam_clean_get__recursive ($get_var) {
    if (!is_array($get_var)) {
      return preg_replace("/[^ (){}a-zA-Zа-яА-Я0-9_.-]/ui", "", urldecode($get_var));
    }

    // Add the preg_replace to every element.
    return array_map ('vam_clean_get__recursive', $get_var);
  } // function vam_clean_get__recursive

  ////
  // Set the type of a string variable based on the contents
  function vam_set_type ($variable) {
    if (!is_array ($variable)) {
      if (ctype_digit ($variable) == true) { // Integer
        return (int) $variable;
      }

      if (is_numeric ($variable) == true) { // Float
        return floatval ($variable);
      }

      // Not integer or float, so leave it a string
      return strval ($variable);

    } else {
      // Variable is an array, so apply to every value individually
      return array_map ('vam_set_type', $variable);

    } // if (!is_array ... else ...
  } // function vam_set_type

  ////
  // Set the type of a string variable based on the contents
  function vam_decode_recursive ($variable) {
    if (!is_array ($variable)) {
      return  ($variable);
//      return rawurldecode ($variable);

    } else {
      // Variable is an array, so apply to every value individually
      return array_map ('vam_decode_recursive', $variable);

    } // if (!is_array ... else ...
  } // function vam_decode_recursive

  ////
  // Remove all other selections if Select All is set
  function vam_select_all_override ($filter_array) {
    if (is_array ($filter_array) ) {
      $select_all = false;
      foreach ($filter_array as $type => $filter) {
        if ($filter == '' || $filter == '0') {
          return array ($type => '0');
        }
      }
      
      return $filter_array;
    } // if (is_array
    
    return $filter_array;
  } // function vam_select_all_override

  ////
  // Set up array of values that can be used in breadcrumbs
  function vam_get_filter_breadcrumbs ($specs_array, $filter_value) {
    $specs_array_breadcrumb = array();
    if ($specs_array['filter_display'] != 'image' && $specs_array['filter_display'] != 'multiimage' && $filter_value != '0') {
      if (is_array ($filter_value) ) { // Multiselect filters can be an array if more than one is selected
        foreach ($filter_value as $value) { 
          if ($value != '0') {
            $specs_array_breadcrumb[] = array ('specification_name' => $specs_array['specification_name'],
                                               'specifications_id' => $specs_array['specifications_id'],
                                               'value' => $value
                                              ); 
          } // if ($value
        } // foreach ($filter_value
        
      } else { // Only one value
        $specs_array_breadcrumb[] = array ('specification_name' => $specs_array['specification_name'],
                                           'specifications_id' => $specs_array['specifications_id'],
                                           'value' => $filter_value
                                          ); 
      } // if (is_array
    } // if ($specs_array['filter_display']
    return $specs_array_breadcrumb;
  } // function

  /////
  // Determine if a category has a linked Specification Group
  //   Tables: specification_groups, specifications_to_categories
  function vam_has_spec_group($category_id, $show_group) {
    $check_query_raw = "select sg.specification_group_id
                              from " . TABLE_SPECIFICATION_GROUPS . " sg,
                                   " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
                              where sg." . $show_group . " = 'True'
                                and sg.specification_group_id = sg2c.specification_group_id
                                and sg2c.categories_id = '" . (int) $category_id . "'
                            ";
    // print $check_query_raw . "<br>\n";
    $check_query = vam_db_query($check_query_raw);

    if (vam_db_num_rows($check_query) > 0) {
      return true;
    }

    return false;
  } // function vam_has_spec_group

  ////
  // Output a menu as a list of links
  function vam_draw_links_menu ($name, $values, $target, $default = '') {
    $field = '';

    foreach ($values as $link_data) {

      switch (true) {
        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'none'):
          break;
        
        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'grey'):
          $field .= '&nbsp;&nbsp;';
          $field .= '<span class="no_results">';
          $field .= vam_output_string ($link_data['text'] );
          $field .= '</span>';
          if ($link_data['count'] != '' && SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            $field .= '<span class="filter_count"> (' . $link_data['count'] . ')</span>';
          }
          $field .= '<br>';
          break;
        
        default:
          $field .= '&nbsp;&nbsp;';
          if ($default == $link_data['id']) {
            $field .= '<b>';
          }
          $field .= '<a href="' . vam_href_link ($target, vam_get_array_get_params (array ( $name, 'page') ) . ($link_data['id'] == '0' ? '' : $name . '=' . vam_output_string($link_data['id']))) . '">';
          $field .= vam_output_string ($link_data['text'] );
          $field .= '</a>';

          if ($default == $link_data['id']) {
            $field .= '</b>';
          }
            
          if ($link_data['count'] != '' && SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            $field .= '<span class="filter_count"> (' . $link_data['count'] . ')</span>';
          }
          $field .= '<br>';
          break;
      } // switch (true)
    } // foreach ($values

    $field .= '<br clear=all>';
    return $field;
  } //  function vam_draw_links_menu

  ////
  // Output a menu as a list of images
  function vam_draw_images_menu ($name, $values, $target, $default = '') {
    $field = '';

    foreach ($values as $link_data) {
      if ($link_data['id'] == '0') {
        $link_data['text'] = SPECIFICATIONS_GET_ALL_IMAGE;
      }

      switch (true) {
        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'none'):
          break;
        
        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'grey'):
          $field .= '<span class="no_results">';
          $field .= vam_image (DIR_WS_IMAGES . trim ($link_data['text']), $link_data['text'], SPECIFICATIONS_FILTER_IMAGE_WIDTH, SPECIFICATION_FILTER_IMAGE_HEIGHT, ' class="image_filter"');
          $field .= '</span>';
          break;
        
        default:
          $field .= '<a href="' . vam_href_link ($target, vam_get_array_get_params (array ( $name, 'page') ) . ($link_data['id'] == '0' ? '' : $name . '=' . vam_output_string ($link_data['id']) ) ) . '">';
          $field .= vam_image (DIR_WS_IMAGES . trim ($link_data['text']), $link_data['text'], SPECIFICATIONS_FILTER_IMAGE_WIDTH, SPECIFICATION_FILTER_IMAGE_HEIGHT, ' class="image_filter"');
          $field .= '</a>';
          break;
      } // switch (true)
    }

    $field .= '<br clear=all>';
    return $field;
  }

  ////
  // Output a multiple select form pull down menu
  function vam_draw_multi_pull_down_menu($name, $values, $default = array (), $parameters = '', $required = false) {
    $field = '<select name="' . vam_output_string($name) . '"';

    if (vam_not_null($parameters))
      $field .= ' ' . $parameters;

    $field .= 'multiple="' . $name . '">';

    if (empty ($default) && ((isset ($_GET[$name]) && is_string($_GET[$name])) || (isset ($_POST[$name]) && is_string($_POST[$name])))) {
      if (isset ($_GET[$name]) && is_string($_GET[$name])) {
        $default = stripslashes($_GET[$name]);
      } elseif (isset ($_POST[$name]) && is_string($_POST[$name])) {
        $default = stripslashes($_POST[$name]);
      }
    }

    foreach ($values as $link_data) {
      switch (true) {
        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'none'):
          break;
        
        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'grey'):
          $field .= '<optgroup class="no_results" label="';
          $field .= vam_output_string ($link_data['text'] );
          if ($link_data['count'] != '' && SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            $field .= ' (' . $link_data['count'] . ')';
          }
          $field .= '"></optgroup>';
          break;
        
        default:
          $field .= '<option value="' . vam_output_string ($link_data['id']) . '"';
          if (in_array ($link_data['id'], (array) $default) ) {
            $field .= ' SELECTED';
          }

          $field .= '>' . vam_output_string ($link_data['text'], array (
            '"' => '&quot;',
            '\'' => '&#039;',
            '<' => '&lt;',
            '>' => '&gt;'
          ));
            
          if ($link_data['count'] != '' && SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            $field .= '<span class="filter_count"> (' . $link_data['count'] . ')</span>';
          }
          $field .= '</option>';
          break;
      } // switch (true)
    } // foreach ($values
    $field .= '</select>';

    if ($required == true)
      $field .= TEXT_FIELD_REQUIRED;

    $field .= '<br clear=all>';
    return $field;
  }

  ////
  // Array-tolerant version of vam_get_all_get_params()
  function vam_get_array_get_params($exclude_array = '') {
    if (!is_array($exclude_array))
      $exclude_array = array ();
    $get_url = '';

    if (is_array($_GET) && (sizeof($_GET) > 0)) {
      reset($_GET);

      foreach ($_GET as $key => $value) {
        if (is_array($value)) {
          foreach ($value as $new_key => $new_value) {
            if (!in_array($key, $exclude_array)) {
              $get_url .= $key . '[' . $new_key . ']' . '=' . rawurlencode(stripslashes($new_value)) . '&';
            }
          }
        }
        elseif ((strlen($value) > 0) && ($key != vam_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y')) {
          $get_url .= $key . '=' . rawurlencode(stripslashes($value)) . '&';
        }
      }
    }

    return $get_url;
  }

  ////
  // Output a string of HTML hidden fields containing all relevant $_GET variables. Excludes:
  //   Variables that are not set
  //   The Session variable (see vam_hide_session_id)
  //   Any variable named 'error', 'x', or 'y'
  //   Any variable passed in the exclude array
  function vam_get_hidden_get_variables ($exclude_array) {
    if (!is_array ($exclude_array) ) {
      $exclude_array = array ();
    }
      
    $html_string = '';
    if (is_array($_GET) && (sizeof($_GET) > 0)) {
      reset($_GET);
      foreach ($_GET as $key => $value) {
        if (is_array($value)) {
          foreach ($value as $new_key => $new_value) {
            if (!in_array($key, $exclude_array)) {
              $html_string .= vam_draw_hidden_field($key . '[' . $new_key . ']', $new_value);
            }
          }
        } elseif ((strlen($value) > 0) && ($key != vam_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y')) {
          $html_string .= vam_draw_hidden_field($key, $value);
        }
      }
    }
    return $html_string;
  }

  /////
  // Get the manufacturers_id when given the manufacturers_name
  function vam_get_manufacturer_id ($filter_array, $products_column_name, $languages_id) {
    if (is_array($filter_array) && $products_column_name != '') {
      $new_filter_array = array ();
      foreach ($filter_array as $filter) {
        if ($filter != '' && $filter != '0') {
          $manufacturer_query_raw = "select manufacturers_id
                                     from " . TABLE_MANUFACTURERS_INFO . "
                                     where languages_id = '" . (int)$languages_id . "' and manufacturers_name = '" . $filter . "'
                                    ";
          // print $manufacturer_query_raw . "<br>\n";
          $manufacturer_query = vam_db_query($manufacturer_query_raw);
          $manufacturer = vam_db_fetch_array($manufacturer_query);
          $new_filter_array[] = $manufacturer['manufacturers_id'];
        } // if ($filter
      } // foreach ($filter_array

      return $new_filter_array;
    } // if (is_array ($filter_array

    return '0';
  } // function vam_get_manufacturer_id

  /////
  // Add quotes to the filter values if strings
  function vam_set_filter_case ($filter_value) {
    if (is_numeric ($filter_value) ) { // Float or integer
      return $filter_value;
    } else {
      return "'" . $filter_value . "'";
    }
  }
  
  /////
  // Generate the SQL to return the filtered values
  function vam_get_filter_sql ($filter_class, $specifications_id, $filter_array = array (), $products_column_name, $languages_id) {
    global $customer_zone_id, $customer_country_id;
    $sql_array = array (
      'from' => '',
      'where' => ''
    );

    $filter_array = (is_array ($filter_array) ) ? $filter_array : array ($filter_array);
 
    // If the Show All option is set, return a blank string
    if (isset ($filter_array[0]) && ($filter_array[0] == '0' || $filter_array[0] == '')) {
      return $sql_array;
      
    } else {
      // Scrub the filter array so apostrophes in filters don't error out.
      foreach ($filter_array as $filterKey => $filterValue) {
        $filter_array[$filterKey] = vam_db_input($filterValue);
      }

      // The Manufacturer's column contains an ID and not the name, so we have to change it
      if ($products_column_name == 'manufacturers_id') {
        $filter_array = vam_get_manufacturer_id($filter_array, $products_column_name,$languages_id);
        $products_column_name = 'p.' . $products_column_name;
      } // if ($products_column_name == 'manufacturers_id')

      // The final_price column doesn't actually exist, so we have to generate it
      $final_price = false;
      if ($products_column_name == 'final_price') {
        $final_price = true;
        $products_column_name = ' IF(s.status, s.specials_new_products_price, p.products_price) ';
      } // if ($products_column_name == 'final_price')

      switch ($filter_class) {
        case 'exact' :
          $filter_array = array_map ('vam_set_filter_case', $filter_array);
          foreach ($filter_array as $filter) {
            if (isset ($filter) && $filter != '0' && $filter != '') {
              if (strlen($products_column_name) > 1) { // Use an existing column
                $sql_array['where'] .= " AND " . $products_column_name . " <=> " . $filter . " ";
              } else {
                $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
                $sql_array['where'] .= " AND ps" . $specifications_id . ".specification <=> " . $filter . "
                              AND ps" . $specifications_id . ".specifications_id = '" . $specifications_id . "'
                              AND ps" . $specifications_id . ".language_id = '" . (int) $languages_id . "'
                              ";
              } // if (strlen ($products_column_name ... else ...
            } // if (isset ($filter
          } // foreach ($filter_array
          break;

        case 'multiple' :
          $filter_array = array_map ('vam_set_filter_case', $filter_array);
          if (strlen($products_column_name) > 1) {
            $sql_array['where'] .= " and " . $products_column_name . " in (";
            $first = true;
            foreach ($filter_array as $filter) {
              if ($first == true) {
                $first = false;
                $sql_array['where'] .= " " . $filter . " ";
              } else {
                $sql_array['where'] .= ", " . $filter . " ";
              }
            }
            $sql_array['where'] .= ") ";

          } else {
            $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
            $first = true;
            foreach ($filter_array as $filter) {
              if ($filter != '0') {
                if ($first == true) {
                  $first = false;
                  $sql_array['where'] .= " AND ps" . $specifications_id . ".specification in (" . $filter . "
                                  ";
                } else {
                  $sql_array['where'] .= ", " . $filter . "
                                  ";
                }
              }
            }

            $sql_array['where'] .= ") AND ps" . $specifications_id . ".specifications_id = '" . $specifications_id . "'
                      AND ps" . $specifications_id . ".language_id = '" . (int) $languages_id . "'
                      ";

            foreach ($filter_array as $filter) {
              if ($filter == '0') {
                $sql_array = array (
                  'from' => '',
                  'where' => ''
                );
              }
            }
          }
          break;

        case 'range' :
          $filters_range = explode ('-', $filter_array[0]);
          $filters_range = array_map ('vam_set_filter_case', $filters_range);

          if (!vam_session_is_registered('customer_id')) {
            $country_id = STORE_COUNTRY;
            $zone_id = STORE_ZONE;
          } else {
            $country_id = $customer_country_id;
            $zone_id = $customer_zone_id;
          }

          if (strlen ($products_column_name) > 1) {
            if (count ($filters_range) < 2) { // There is only one parameter, so it is a minimum
              if (DISPLAY_PRICE_WITH_TAX == 'true' && ($products_column_name == 'products_price' || $final_price == true) ) {
                $sql_array['from'] .= " inner join " . TABLE_TAX_RATES . " tr 
                                          on tr.tax_class_id = p.products_tax_class_id
                                        left join " . TABLE_ZONES_TO_GEO_ZONES . " za 
                                          on (tr.tax_zone_id = za.geo_zone_id) 
                                        left join " . TABLE_GEO_ZONES . " tz 
                                          on (tz.geo_zone_id = tr.tax_zone_id) 
                                      ";
                $sql_array['where'] .= " AND (" . $products_column_name . " * (1.0 + (tr.tax_rate / 100) ) ) > " . $filters_range[0] . "
                                         and (za.zone_country_id is null 
                                           or za.zone_country_id = '0' 
                                           or za.zone_country_id = '" . (int) $country_id . "') 
                                         and (za.zone_id is null 
                                           or za.zone_id = '0' 
                                           or za.zone_id = '" . (int) $zone_id . "') 
                                      ";
              } else {
                $sql_array['where'] .= " and " . $products_column_name . " > " . $filters_range[0] . " ";
              }
            } else {
              if (DISPLAY_PRICE_WITH_TAX == 'true' && ($products_column_name == 'products_price' || $final_price == true) ) {
                $sql_array['from'] .= " inner join " . TABLE_TAX_RATES . " tr 
                                          on tr.tax_class_id = p.products_tax_class_id
                                        left join " . TABLE_ZONES_TO_GEO_ZONES . " za 
                                          on (tr.tax_zone_id = za.geo_zone_id) 
                                        left join " . TABLE_GEO_ZONES . " tz 
                                          on (tz.geo_zone_id = tr.tax_zone_id) 
                                      ";
                $sql_array['where'] .= " and ( (" . $products_column_name . " * (1.0 + (tr.tax_rate / 100) ) ) between " . $filters_range[0] . " and " . $filters_range[1] . ") 
                                         and (za.zone_country_id is null 
                                           or za.zone_country_id = '0' 
                                           or za.zone_country_id = '" . (int) $country_id . "') 
                                         and (za.zone_id is null 
                                           or za.zone_id = '0' 
                                           or za.zone_id = '" . (int) $zone_id . "')
                                      ";
              } else {
                $sql_array['where'] .= " and (" . $products_column_name . " between " . $filters_range[0] . " and " . $filters_range[1] . ") ";
              }
            }
          } else {
            if (count($filters_range) < 2) { // There is only one parameter, so it is a minimum
              $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
              $sql_array['where'] .= " AND ps" . $specifications_id . ".specification > " . $filters_range[0] . "
                          AND ps" . $specifications_id . ".specifications_id = '" . $specifications_id . "'
                          AND ps" . $specifications_id . ".language_id = '" . (int) $languages_id . "'
                          ";

            } else { // There are two parameters, so treat them as minimum and maximum
              $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
              $sql_array['where'] .= " AND (ps" . $specifications_id . ".specification between " . $filters_range[0] . " and " . $filters_range[1] . ")
                          AND ps" . $specifications_id . ".specifications_id = '" . $specifications_id . "'
                          AND ps" . $specifications_id . ".language_id = '" . (int) $languages_id . "'
                          ";
            }
          }
          break;

        case 'reverse' :
          // No existing columns are set up as a reverse range, so this filter class has no provision for existing columns
          $filter_array = array_map ('vam_set_filter_case', $filter_array);
          $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
          $sql_array['where'] .= " AND " . $filter_array[0] . " BETWEEN SUBSTRING_INDEX(ps.specification,'-',1) AND SUBSTRING_INDEX(ps.specification,'-',-1)
                  AND ps" . $specifications_id . ".specifications_id = '" . $specifications_id . "'
                  AND ps" . $specifications_id . ".language_id = '" . (int) $languages_id . "'
                  ";
          break;

        case 'start' :
          if (strlen($products_column_name) > 1) {
            $sql_array['where'] .= " and " . $products_column_name . " like '" . $filter_array[0] . "%' ";
          } else {
            $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
            $sql_array['where'] .= " AND ps" . $specifications_id . ".specification LIKE '" . $filter_array[0] . "%'
                      AND ps" . $specifications_id . ".specifications_id = '" . $specifications_id . "'
                      AND ps" . $specifications_id . ".language_id = '" . (int) $languages_id . "'
                      ";
          }
          break;

        case 'partial' :
          if (strlen($products_column_name) > 1) {
            $sql_array['where'] .= " and " . $products_column_name . " like '%" . $filter_array[0] . "%' ";
          } else {
            $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
            $sql_array['where'] .= " AND ps" . $specifications_id . ".specification like '%" . $filter_array[0] . "%'
                      AND ps" . $specifications_id . ".specifications_id = '" . $specifications_id . "'
                      AND ps" . $specifications_id . ".language_id = '" . (int) $languages_id . "'
                      ";
          }
          break;

        case 'like' :
          // Function currently uses 'sounds like' to do a soundex match
          if (strlen($products_column_name) > 1) {
            $sql_array['where'] .= " and " . $products_column_name . " sounds like '%" . $filter_array[0] . "%' ";
          } else {
            $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
            $sql_array['where'] .= " AND ps" . $specifications_id . ".specification sounds like '" . $filter_array[0] . "'
                      AND ps" . $specifications_id . ".specifications_id = '" . $specifications_id . "'
                      AND ps" . $specifications_id . ".language_id = '" . (int) $languages_id . "'
                      ";
          }
          break;

        case 'none' :
        case '' :
        default :
          break;
      } // switch ($filter_class
    } // if (count ($filter_array) ... else ...
    return $sql_array;
  }
  
  ////
  // Output an HTML string containing forms/links of all applicable Filters
  function vam_get_filter_string ($display_type, $filters_select_array, $target, $filter_name, $filter_value) {
    $filter_name = (string) $filter_name;
    if (is_array($filter_value)) {
    } else {
      $filter_value = (string) $filter_value;
    }

    $exclude_array = array ($filter_name, 'page');
    $additional_variables = vam_get_hidden_get_variables ($exclude_array);
    $box_text = '';

    switch ($display_type) {
      case 'pulldown':
        $box_text .= vam_draw_form('filter', $target, 'get');
        $box_text .= vam_draw_pull_down_menu ($filter_name, $filters_select_array, $filter_value, 'onChange="this.form.submit();"');
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= '<noscript>' . vam_image_submit('icon_next.gif', TEXT_FIND_PRODUCTS) . '</noscript>';
        $box_text .= '</form>';
        break;

      case 'radio':
        $box_text .= vam_draw_form('filter', $target, 'get');
        foreach ($filters_select_array as $filter) {
          
          $checked = ($filter['id'] == $filter_value) ? true : false;
          switch (true) {
            case ($filter['count'] != '' && $filter['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'none'):
              break;
        
            case ($filter['count'] != '' && $filter['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'grey'):
              $box_text .= '<input type="radio" name="0" value="0" disabled="disabled">';
              $box_text .= '<span class="no_results">' . '&nbsp;';
              $box_text .= vam_output_string ($filter['text'] );
              $box_text .= '</span>';
              if (SPECIFICATIONS_FILTER_SHOW_COUNT == 'True' && $filter['count'] != '') {
                $box_text .= '<span class="filter_count"> (' . $filter['count'] . ')</span>';
              }
              $box_text .= '<br>' . "\n";
              break;

            default:
              $box_text .= vam_draw_radio_field ($filter_name, $filter['id'], $checked, 'onClick="this.form.submit();"') . '&nbsp;' . $filter['text'];

              if (SPECIFICATIONS_FILTER_SHOW_COUNT == 'True' && $filter['count'] != '') {
                $box_text .= '<span class="filter_count"> (' . $filter['count'] . ')</span>';
              }
              $box_text .= '<br>' . "\n";
              break;
          } // switch (true)
        }
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= '<noscript>' . vam_image_submit ('icon_next.gif', TEXT_FIND_PRODUCTS) . '</noscript>';
        $box_text .= '</form>';
        break;

      case 'text':
        $value = ($filter_value != 0) ? $filter_value : '';
        $box_text .= vam_draw_form ('filter', $target, 'get');
        $box_text .= vam_draw_input_field($filter_name, $value);
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= '<noscript>' . vam_image_submit('icon_next.gif', TEXT_FIND_PRODUCTS) . '</noscript>';
        $box_text .= '</form>';
        break;

      case 'multi':
        $box_text .= vam_draw_form ('filter', $target, 'get');
        $box_text .= vam_draw_multi_pull_down_menu ($filter_name . '[]', $filters_select_array, $filter_value, 'multiple="' . $filter_name . 'f"');
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= vam_image_submit ('icon_next.gif', TEXT_FIND_PRODUCTS);
        $box_text .= '</form>';
        break;

      case 'checkbox':
        $box_text .= vam_draw_form ('filter', $target, 'get');
        $checkbox_id = 0;
        foreach ($filters_select_array as $filter) {
          $checked = ($filter['id'] == $filter_value[$checkbox_id]) ? true : false;
          switch (true) {
            case ($filter['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'none'):
              break;
        
            case ($filter['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'grey'):
              $box_text .= '<input type="checkbox" name="0" value="0" disabled="disabled">';
              $box_text .= '<span class="no_results">' . '&nbsp;';
              $box_text .= vam_output_string ($filter['text'] );
              $box_text .= '</span>';
              if (SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
                $box_text .= '<span class="filter_count"> (' . $filter['count'] . ')</span>';
              }
              $box_text .= '<br>' . "\n";
              break;
        
            default:
              $box_text .= vam_draw_checkbox_field ($filter_name . '[' . $checkbox_id . ']', $filter['id'], $checked) . '&nbsp;' . $filter['text'];

              if (SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
                $box_text .= '<span class="filter_count"> (' . $filter['count'] . ')</span>';
              }
              $box_text .= '<br>' . "\n";
              break;
          } // switch (true)
          $checkbox_id++;
        }
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= vam_image_submit('icon_next.gif', TEXT_FIND_PRODUCTS);
        $box_text .= '</form>';
        break;

      case 'image':
        $value = ($filter_value != 0) ? $filter_value : '';
        $box_text .= vam_draw_images_menu($filter_name, $filters_select_array, $target, $value);
        break;

      case 'multiimage':
        $box_text .= vam_draw_form('filter', $target, 'get');
        foreach ($filters_select_array as $filter) {
          $checked = ($filter['id'] == $filter_value) ? true : false;
          $box_text .= vam_draw_checkbox_field($filter_name, $filter['id'], $checked);
          $box_text .= '&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . $filter['text'], $filter['text'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '<br>' . "\n";
          $box_text .= '<br>' . "\n";
        }
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= vam_image_submit('icon_next.gif', TEXT_FIND_PRODUCTS);
        $box_text .= '</form>';
        break;

      case 'links':
      default :
        $box_text .= vam_draw_links_menu ($filter_name, $filters_select_array, $target, $filter_value);
        break;
    } // switch ($display_type

    return $box_text;
  } //function vam_get_filter_string

?>