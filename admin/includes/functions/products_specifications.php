<?php
/*
  $Id: products_specifications.php v1.0 20090909 kymation $
  $Loc: catalog/admin/includes/functions/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/


////
// Get the type of a string variable based on the contents
  function vam_get_type ($variable) {
    if (ctype_digit ($variable) == true) { // Integer
      return 'UNSIGNED';
    }

    if (is_numeric ($variable) == true) { // Float
      return 'DECIMAL';
    }

    // Not integer or float, so string
    return 'CHAR';
  } // function vam_get_type
  
/////
// Count category links, either total or from a group
//   Tables: specification_groups_to_categories
  function vam_count_links ($group = '0') {
    $check_query_raw = "select categories_id
                        from " . TABLE_SPECIFICATIONS_TO_CATEGORIES . "
                      ";
    if ($group != '0') {
      $check_query_raw .= " where specification_group_id = '" . (int) $group . "'";
    }
    // print $check_query_raw . "<br>\n";
    $check_query = vam_db_query ($check_query_raw);

    return vam_db_num_rows ($check_query);
  } // function vam_count_specifications

/////
// Count category groups
//   Tables: specification_groups
  function vam_count_groups () {
    $check_query_raw = "select specification_group_id
                        from " . TABLE_SPECIFICATION_GROUPS . "
                      ";
    // print $check_query_raw . "<br>\n";
    $check_query = vam_db_query ($check_query_raw);

    return vam_db_num_rows ($check_query);
  } // function vam_count_specifications

/////
// Count specifications, either total or in a group
//   Tables: specifications
  function vam_count_specifications ($group = '0') {
    $check_query_raw = "select specifications_id
                        from " . TABLE_SPECIFICATION . "
                      ";
    if ($group != '0') {
      $check_query_raw .= " where specification_group_id = '" . (int) $group . "'";
    }
    // print $check_query_raw . "<br>\n";
    $check_query = vam_db_query ($check_query_raw);

    return vam_db_num_rows ($check_query);
  } // function vam_count_specifications

/////
// Count filters, either total or in a group and/or specification
//   Tables: specifications, specification_filters
  function vam_count_filters ($group = '0', $specification = '0') {
    $check_query_raw = "select sf.specification_filters_id
                        from " . TABLE_SPECIFICATIONS_FILTERS . " sf,
                             " . TABLE_SPECIFICATION . " sp
                        where sf.specifications_id = sp.specifications_id
                      ";
    if ($group != '0') {
      $check_query_raw .= " and sp.specification_group_id = '" . (int) $group . "' ";
    }
    if ($specification != '0') {
      $check_query_raw .= " and sp.specifications_id = '" . (int) $specification . "'";
    }
    // print $check_query_raw . "<br>\n";
    $check_query = vam_db_query ($check_query_raw);

    return vam_db_num_rows ($check_query);
  } // function vam_count_specifications

/////
// Count specification values, either total or in a group and/or specification
//   Tables: specifications, specification_values
  function vam_count_values ($group = '0', $specification = '0') {
    $check_query_raw = "select sv.specification_values_id
                        from " . TABLE_SPECIFICATIONS_VALUES . " sv,
                             " . TABLE_SPECIFICATION . " sp
                        where sv.specifications_id = sp.specifications_id
                      ";
    if ($group != '0') {
      $check_query_raw .= " and sp.specification_group_id = '" . (int) $group . "' ";
    }
    if ($specification != '0') {
      $check_query_raw .= " and sp.specifications_id = '" . (int) $specification . "'";
    }
    // print $check_query_raw . "<br>\n";
    $check_query = vam_db_query ($check_query_raw);

    return vam_db_num_rows ($check_query);
  } // function vam_count_specifications

/////
// Count product specifications, either total or per group, specification, or product
//   Tables: specifications, products_specifications
  function vam_count_products ($group = '0', $specification = '0', $products_id = '0') {
    $check_query_raw = "select ps.products_specification_id
                        from " . TABLE_PRODUCTS_SPECIFICATIONS . " ps,
                             " . TABLE_SPECIFICATION . " sp
                        where ps.specifications_id = sp.specifications_id
                      ";
    if ($group != '0') {
      $check_query_raw .= " and sp.specification_group_id = '" . (int) $group . "' ";
    }

    if ($specification != '0') {
      $check_query_raw .= " and sp.specifications_id = '" . (int) $specification . "'";
    }

    if ($products_id != '0') {
      $check_query_raw .= " and ps.products_id = '" . (int) $products_id . "'";
    }
    // print $check_query_raw . "<br>\n";
    $check_query = vam_db_query ($check_query_raw);

    return vam_db_num_rows ($check_query);
  } // function vam_count_specifications

////
// Output an array of Specification Group names
  function vam_get_group_names () {
    $group_names = array();
    $groups_query_raw = "select specification_group_id,
                                specification_group_name
                         from " . TABLE_SPECIFICATION_GROUPS . "
                         order by specification_group_name
                        ";
    // print $groups_query_raw . "<br>\n";
    $groups_query = vam_db_query ($groups_query_raw);
    while ($groups = vam_db_fetch_array ($groups_query) ) {
      $group_names[] = array ('id' => $groups['specification_group_id'],
                              'text' => $groups['specification_group_name']
                             );
    } // while ($groups
    
    return $group_names;
  } // function vam_get_group_names

////
// Output an array of Specification names
  function vam_get_specification_names ($specification_group, $languages_id = 1) {
    $specification_names = array();
    $specifications_query_raw = "select sp.specifications_id,
                                        sd.specification_name
                                 from " . TABLE_SPECIFICATION_DESCRIPTION . " sd,
                                      " . TABLE_SPECIFICATION . " sp
                                 where sp.specifications_id = sd.specifications_id
                                   and sd.language_id = '" . $languages_id . "'
                                   and sp.specification_group_id = '" . $specification_group . "'
                                order by sp.specification_sort_order,
                                         sd.specification_name
                               ";
    // print $groups_query_raw . "<br>\n";
    $specifications_query = vam_db_query ($specifications_query_raw);
    while ($specifications = vam_db_fetch_array ($specifications_query) ) {
      $specification_names[] = array ('id' => $specifications['specifications_id'],
                              'text' => $specifications['specification_name']
                             );
    } // while ($specifications
    
    return $specification_names;
  } // function vam_get_specification_names

////
// Output an array of Specification Filter names
  function vam_get_specification_filters ($specification_id, $languages_id = 1) {
    $filter_names = array();
    $filters_query_raw = "select sf.specification_filters_id,
                                 sfd.filter
                          from " . TABLE_SPECIFICATIONS_FILTERS . " sf,
                               " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " sfd
                          where sfd.specification_filters_id = sf.specification_filters_id
                            and sf.specifications_id = '" . $specification_id . "'
                            and sfd.language_id = '" . $languages_id . "'
                          order by sf.filter_sort_order,
                                   sfd.filter
                        ";
    // print $filters_query_raw . "<br>\n";
    $filters_query = vam_db_query ($filters_query_raw);
    while ($filters = vam_db_fetch_array ($filters_query) ) {
      $filter_names[] = array ('id' => $filters['specification_filters_id'],
                              'text' => $filters['filter']
                             );
    } // while ($filters
    
    return $filter_names;
  } // function vam_get_specification_filters

////
// Output an array of Specification Group names
  function vam_get_specification_values ($specification_id, $languages_id = 1) {
    $value_names = array();
    $values_query_raw = "select sv.specification_values_id,
                                svd.specification_value
                         from " . TABLE_SPECIFICATIONS_VALUES . " sv,
                              " . TABLE_SPECIFICATIONS_VALUES_DESCRIPTION . " svd
                         where svd.specification_values_id = sv.specification_values_id
                           and sv.specifications_id = '" . $specification_id . "'
                           and svd.language_id = '" . $languages_id . "'
                         order by sv.value_sort_order,
                                  svd.specification_value
                       ";
    // print $values_query_raw . "<br>\n";
    $values_query = vam_db_query ($values_query_raw);
    while ($values = vam_db_fetch_array ($values_query) ) {
      $value_names[] = array ('id' => $values['specification_values_id'],
                              'text' => $values['specification_value']
                             );
    } // while ($values
    
    return $value_names;
  } // function vam_get_specification_values

////
// Output a multiple select form pull down menu
  function vam_draw_multi_pull_down_menu ($name, $values, $default = array(), $parameters = '', $required = false) {
    $field = '<select name="' . vam_output_string ($name) . '"';

    if (vam_not_null ($parameters) ) $field .= ' ' . $parameters;

    $field .= 'multiple="' . $name . '">';

    if (empty ($default) && ( (isset ($_GET[$name]) && is_string ($_GET[$name])) || (isset ($_POST[$name]) && is_string ($_POST[$name])) ) ) {
      if (isset ($_GET[$name]) && is_string ($_GET[$name])) {
        $default = stripslashes ($_GET[$name]);
      } elseif (isset ($_POST[$name]) && is_string ($_POST[$name]) ) {
        $default = stripslashes ($_POST[$name]);
      }
    }

    for ($i=0, $n=sizeof($values); $i<$n; $i++) {
      $field .= '<option value="' . vam_output_string ($values[$i]['id']) . '"';
      if (in_array ($values[$i]['id'], (array) $default) ) {
      //if (in_array_column($values[$i]['id'], "id", $default) ) {
        $field .= ' SELECTED';
      }

      $field .= '>' . vam_output_string ($values[$i]['text'], array ('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>';
    }
    $field .= '</select>';

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    $field .= '<br clear=all>';
    return $field;
  }

  function in_array_column($text, $column, $array)
  {
    if (!empty($array) && is_array($array))
    {
      for ($i=0; $i < count($array); $i++)
      {
        if ($array[$i][$column]==$text || strcmp($array[$i][$column],$text)==0) return true;
      }
    }
    return false;
  }

////
// Array-tolerant version of vam_get_all_get_params()
  function vam_get_array_get_params ($exclude_array = '') {
    if (!is_array ($exclude_array) ) $exclude_array = array();
    $get_url = '';
    
    if (is_array ($_GET) && (sizeof ($_GET) > 0) ) {
      reset ($_GET);

      foreach ($_GET as $key => $value) {
        if (is_array ($value) ) {
          foreach ($value as $new_key => $new_value) {
            if (!in_array ($key, $exclude_array) ) {
              $get_url .= $key . '[' . $new_key . ']' . '=' . rawurlencode (stripslashes ($new_value) ) . '&';
            }
          }
        } elseif ( (strlen($value) > 0) && ($key != vam_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y') ) {
          $get_url .= $key . '=' . rawurlencode (stripslashes ($value) ) . '&';
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
    if (!is_array($exclude_array)) $exclude_array = array();
    $html_string = '';
    if (is_array ($_GET) && (sizeof ($_GET) > 0) ) {
      reset ($_GET);
      foreach ($_GET as $key => $value) {
        if (is_array ($value) ) {
          foreach ($value as $new_key => $new_value) {
            if (!in_array ($key, $exclude_array) ) {
              $html_string .= vam_draw_hidden_field ($key . '[' . $new_key . ']', $new_value);
            }
          }
        } elseif ( (strlen ($value) > 0) && ($key != vam_session_name()) && ($key != 'error') && (!in_array ($key, $exclude_array)) && ($key != 'x') && ($key != 'y') ) {
          $html_string .= vam_draw_hidden_field ($key, $value);
        }
      }
    }
    return $html_string;
  }
  
/////
// Get the manufacturers_id when given the manufacturers_name
  function vam_get_manufacturer_id ($filter_array, $products_column_name) {
    if (is_array ($filter_array) && $products_column_name != '') {
      $new_filter_array = array();
      foreach ($filter_array as $filter) {
        if ($filter != '' && $filter != '0') {
          $manufacturer_query_raw = "select manufacturers_id
                                     from " . TABLE_MANUFACTURERS . "
                                     where manufacturers_name = '" . $filter . "'
                                    ";
          // print $manufacturer_query_raw . "<br>\n";
          $manufacturer_query = vam_db_query ($manufacturer_query_raw);
          $manufacturer = vam_db_fetch_array ($manufacturer_query);
          $new_filter_array[] =  $manufacturer['manufacturers_id'];
        } // if ($filter
      } // foreach ($filter_array
      
      return $new_filter_array;
    } // if (is_array ($filter_array
    
    return '0';
  } // function vam_get_manufacturer_id

////
// Output an HTML string containing data input fields
  function vam_get_values_menu ($display_type, $values_select_array, $specification_name, $specification_value) {
    $box_text = '';
    switch ($display_type) {
      case 'pulldown':
        $box_text .= vam_draw_pull_down_menu ($specification_name, $values_select_array, $specification_value);
        break;
            
      case 'radio':
        foreach ($values_select_array as $value) {
          $checked = ($value['id'] == $specification_value) ? true : false;
          $box_text .= vam_draw_radio_field ($specification_name, $value['id'], $checked) . '&nbsp;' . $value['text'];
          $box_text .= '<br>' . "\n";
        }
        break;
            
      case 'multi':
        $box_text .= vam_draw_multi_pull_down_menu ($specification_name . '[]', $values_select_array, $specification_value, 'data-placeholder="'.PULL_DOWN_DEFAULT.'" multiple="' . $specification_name . 'f"');
        break;
            
      case 'checkbox':
        $checkbox_id = 0;
        foreach ($values_select_array as $value) {
          $checked = false;
          if (is_array ($specification_value) ) {
            foreach ($specification_value as $spec) {
              if ($spec['id'] == $value['id']) {
                $checked = true;
                break;
              }
            }
          } else {
            $checked = ($value['id'] == $specification_value[$checkbox_id] ) ? true : false;
          } // if (is_array ... else ...
            
          $box_text .= vam_draw_checkbox_field ($specification_name . '[' . $checkbox_id . ']', $value['id'], $checked) . '&nbsp;' . $value['text'];
          $box_text .=  '<br>' . "\n";
          $checkbox_id++;
        } // foreach ($values_select_array
        break;
            
      case 'image':
        $value = ($specification_value != '0') ? $specification_value : '';
        foreach ($values_select_array as $value) {
          $checked = ($value['id'] == $specification_value) ? true : false;
          $box_text .= '<span class=image_box>';
          $box_text .= vam_draw_radio_field ($specification_name, $value['id'], $checked);
          $box_text .= '&nbsp;&nbsp;' . vam_image (DIR_WS_CATALOG_IMAGES . $value['text'], $value['text'], SPECIFICATIONS_FILTER_IMAGE_WIDTH, SPECIFICATIONS_FILTER_IMAGE_HEIGHT, ' class="image_filter"');
          $box_text .=  '</span>' . "\n";
        }
        break;
          
      case 'multiimage':
        foreach ($values_select_array as $value) {
          $checked = ($value['id'] == $specification_value) ? true : false;
          if ($value['id'] == '0') {
            $value['id'] = SPECIFICATIONS_GET_ALL_IMAGE;
            $value['text'] = SPECIFICATIONS_GET_ALL_IMAGE;
          }
          $box_text .= '<span class=image_box>';
          $box_text .= vam_draw_checkbox_field ($specification_name, $value['id'], $checked);
          $box_text .= '&nbsp;&nbsp;' . vam_image (DIR_WS_CATALOG_IMAGES . $value['text'], $value['text'], SPECIFICATIONS_FILTER_IMAGE_WIDTH, SPECIFICATIONS_FILTER_IMAGE_HEIGHT, ' class="image_filter"');
          $box_text .= '</span>' . "\n";
        }
        break;
            
      default:
      case 'text':
        $value = ($specification_value != 0) ? $specification_value : '';
        $box_text .= vam_draw_input_field ($specification_name, $value);
        break;
    } // switch ($display_type
    
    return $box_text;
  } //function vam_get_filter_string
  
?>