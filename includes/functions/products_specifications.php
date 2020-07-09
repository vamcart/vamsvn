<?php
// shaklov добавлен word_limiter()
/*
  $Id: products_specifications.php v1.0.1 20090917 kymation $
  $Loc: catalog/includes/functions/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/
// BOF products_filters-multilinks
// BOF products_filters-sort
define('TABLE_SPECIFICATION_FILTERS_STATISTICS_AGREGATE', 'specification_filters_statistics_agregate');

function filters_array_sort($specifications_id, $filters_select_array, $max=10) {
//  error_log(var_export($specifications_id, true) . "\n", 3, __FILE__.'.log');
//  error_log(var_export($filters_select_array, true) . "\n", 3, __FILE__.'.log');
  //$specification_statisctics_sort_array = array();
  //foreach ($filters_select_array as $i => $row) {
    //if ($i == 0) continue;
    //if ($filters_select_array[$i]['count'] > 0) {
      //$sql = "SELECT total FROM " . TABLE_SPECIFICATION_FILTERS_STATISTICS_AGREGATE . " WHERE specifications_id=" . (int)$specifications_id . " AND specification_value_id='" . vam_db_input($filters_select_array[$i]['id']) . "'";
//      $specification_statisctics_query = vam_db_query($sql);
//error_log($sql . "\n", 3, __FILE__.'.log');
      //$specification_statisctics_query = vamDBquery($sql);
      //if ($specification_statisctics = vam_db_fetch_array($specification_statisctics_query)) {
//error_log(var_export($specification_statisctics, true) . "\n", 3, __FILE__.'.log');
        //$specification_statisctics_sort_array[$i] = $specification_statisctics['total'];
      //} else {
        //$specification_statisctics_sort_array[$i] = 0;
      //}
    //} else {
      //$specification_statisctics_sort_array[$i] = -1;
    //}
    //$filters_select_array[$i]['display'] = 0;
  //}
  //arsort($specification_statisctics_sort_array);
//  error_log(var_export($specification_statisctics_sort_array, true) . "\n", 3, __FILE__.'.log');
  //$ii = 0;
  //$filters_select_array[0]['display'] = 1;
  //foreach ($specification_statisctics_sort_array as $i => $t) {
    //$filters_select_array[$i]['display'] = 1;
    //$ii++;
    //if ($ii >= $max) {
      //break;
    //}
  //}
//  uasort($filters_select_array, 'filters_select_array_sort');
//  usort($filters_select_array, 'filters_select_array_sort');
//  error_log(var_export($filters_select_array, true) . "\n", 3, __FILE__.'.log');
  return $filters_select_array;
}

function filters_select_array_sort($a, $b) {
  if ($a['id'] == '0') return -1;
  if ($b['id'] == '0') return 1;
  $sort = (mb_strtolower($a['text']) > mb_strtolower($b['text'])) ? 1 : -1;
  return $sort;
}
// EOF products_filters-sort

  ////
  // Sanitize all _GET variables to prevent hacking
  // Function copied from Security Pro addon, with thanks
  // ***** Warning ***** Remove this function if you have
  //    SecurityPro installed *****
  function vam_clean_get__recursive($get_var) {
    if (!is_array($get_var)) {
      return preg_replace("/[^ (){}a-zA-Zа-яА-ЯёЁ0-9\+_.,-]/ui", "", rawurldecode($get_var));
    }

    // Add the preg_replace to every element.
    return array_map('vam_clean_get__recursive', $get_var);
  } // function vam_clean_get__recursive

  ////
  // Set the type of a string variable based on the contents
  function vam_set_type($variable) {
    if (!is_array($variable)) {
      if (ctype_digit($variable) == true) { // Integer
        return (int)$variable;
      }

      if (is_numeric($variable) == true) { // Float
        return floatval($variable);
      }

      // Not integer or float, so leave it a string
      return strval($variable);

    } else {
      // Variable is an array, so apply to every value individually
      return array_map('vam_set_type', $variable);

    } // if (!is_array ... else ...
  } // function vam_set_type

  ////
  // Set the type of a string variable based on the contents
  function vam_decode_recursive($variable) {
    if (!is_array($variable)) {
      return  ($variable);
//      return rawurldecode ($variable);

    } else {
      // Variable is an array, so apply to every value individually
      return array_map('vam_decode_recursive', $variable);

    } // if (!is_array ... else ...
  } // function vam_decode_recursive

  ////
  // Remove all other selections if Select All is set
  function vam_select_all_override($filter_array) {
    if (is_array($filter_array) ) {
      $select_all = false;
      foreach ($filter_array as $type => $filter) {
        if ($filter == '' || $filter == '0') {
          return array($type => '0');
        }
      }

      return $filter_array;
    } // if (is_array

    return $filter_array;
  } // function vam_select_all_override

  function vam_specification_products_column_name($specifications_id) {
    static $products_column_name_cache = array();
    if (!isset($products_column_name_cache[$specifications_id])) {
      $sql = "SELECT s.products_column_name, s.*
              FROM " . TABLE_SPECIFICATION . " s
              WHERE s.specifications_id = " . (int)$specifications_id . "";
  //error_log(__LINE__ . ': ' . ' $sql=' . var_export($sql, true) . "\n", 3, __FILE__.'.log');
      $specification_query = vamDBquery($sql);
      $specification = vam_db_fetch_array($specification_query, true);
  //error_log(__LINE__ . ': ' . ' $specification=' . var_export($specification, true) . "\n", 3, __FILE__.'.log');
      $products_column_name_cache[$specifications_id] = $specification['products_column_name'];
    }
    return $products_column_name_cache[$specifications_id];
  }

  function vam_get_filter_value($filter_id, $specifications_id) {
    if (is_array($filter_id)) {
      foreach ($filter_id as $i => $filter) {
        $filter_id[$i] = vam_get_filter_value($filter, $specifications_id);
      }
      return $filter_id;
    }
    if (vam_specification_products_column_name($specifications_id) == 'manufacturers_id') {
      $sql = "SELECT m.manufacturers_name AS filter
              FROM " . TABLE_MANUFACTURERS . " m
              WHERE m.manufacturers_id = " . (int)$filter_id . "";
    } else {
      $sql = "SELECT sfd.filter
              FROM " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " sfd
              WHERE sfd.specification_filters_id = " . (int)$filter_id . "
                AND sfd.language_id = " . (int)$_SESSION['languages_id'] . "";
    }
//error_log(__LINE__ . ': ' . ' $sql=' . var_export($sql, true) . "\n", 3, __FILE__.'.log');
    $filter_value_query = vamDBquery($sql);
    if ($filter_value = vam_db_fetch_array($filter_value_query, true)) {
//error_log(__LINE__ . ': ' . ' $filter_value=' . var_export($filter_value, true) . "\n", 3, __FILE__.'.log');
      return $filter_value['filter'];
    }
    return $filter_id;
  }

  ////
  // Set up array of values that can be used in breadcrumbs
  function vam_get_filter_breadcrumbs($specs_array, $filter_value) {
    $specs_array_breadcrumb = array();
//error_log(__LINE__ . ': ' . ' $specs_array=' . var_export($specs_array, true) . "\n", 3, __FILE__.'.log');
    if ($specs_array['filter_display'] != 'image' && $specs_array['filter_display'] != 'multiimage' && $filter_value != '0') {
      if (is_array($filter_value)) { // Multiselect filters can be an array if more than one is selected
//error_log(__LINE__ . ': ' . ' $filter_value=' . var_export($filter_value, true) . "\n", 3, __FILE__.'.log');
        foreach ($filter_value as $value) {
          if ($value != '0') {
            $specs_array_breadcrumb[] = array('specification_name' => $specs_array['specification_name'],
                                              'specification_description' => $specs_array['specification_description'],
                                              'specifications_id' => $specs_array['specifications_id'],
//                                            'value' => $value,
                                              'value' => vam_get_filter_value($value, $specs_array['specifications_id']),
                                              );
          } // if ($value
        } // foreach ($filter_value

      } else { // Only one value
//error_log(__LINE__ . ': ' . ' $filter_value=' . var_export($filter_value, true) . "\n", 3, __FILE__.'.log');
        if ($specs_array['filter_class'] == 'range') {
          if ($specs_array['products_column_name'] == 'final_price' || $specs_array['products_column_name'] == 'products_price') {
            $tmp = explode('-', $filter_value);
            $specs_array_breadcrumb[] = array('specification_name' => $specs_array['specification_name'],
                                              'specification_description' => $specs_array['specification_description'],
                                              'specifications_id' => $specs_array['specifications_id'],
                                              'value' => number_format($tmp[0], $vamPrice->currencies['RUB']['decimal_places'], $vamPrice->currencies['RUB']['decimal_point'], $vamPrice->currencies['RUB']['thousands_point']) . ' - ' . number_format($tmp[1], $vamPrice->currencies['RUB']['decimal_places'], $vamPrice->currencies['RUB']['decimal_point'], $vamPrice->currencies['RUB']['thousands_point']) . ' руб.',
                                              );

          } else {
            $specs_array_breadcrumb[] = array('specification_name' => $specs_array['specification_name'],
                                              'specification_description' => $specs_array['specification_description'],
                                              'specifications_id' => $specs_array['specifications_id'],
//                                            'value' => $filter_value,
                                              'value' => vam_get_filter_value($filter_value, $specs_array['specifications_id']),
                                              );
          }
        } else {
          $specs_array_breadcrumb[] = array('specification_name' => $specs_array['specification_name'],
                                            'specification_description' => $specs_array['specification_description'],
                                            'specifications_id' => $specs_array['specifications_id'],
//                                          'value' => $filter_value,
                                            'value' => vam_get_filter_value($filter_value, $specs_array['specifications_id']),
                                            );
        }
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
                                and sg2c.categories_id = '" . (int)$category_id . "'
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
// BOF products_filters-multilinks
//  function vam_draw_links_menu($name, $values, $target, $default = '') {
  function vam_draw_links_menu($name, $values, $target, $default = '', $filter_class='') {
//echo '<pre>'.__LINE__."\n";var_dump($name, $values, $target, $default, $filter_class);echo '</pre>';
// EOF products_filters-multilinks
    $field = '';

    $field .= '<div class="filter-list list-group list-group-flush">';
    foreach ($values as $link_data) {
      $link_data['id'] = trim($link_data['id']);
      switch (true) {
        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'none'):
          break;

        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'grey'):
          $field .= '<div>';
          $field .= '<span class="no_results">';
          $field .= vam_output_string($link_data['text'] );
          if ($link_data['count'] != '' && SPECIFICATIONS_FILTER_SHOW_COUNT == 'True' && $link_data['count'] > 1) {
            $field .= '<span class="filter_count"> (' . $link_data['count'] . ')</span>';
          }
          $field .= '</span>';
          $field .= '</div>';
          break;

        default:
          //$field .= '<li class="filter-item' . ($link_data['display'] == 0 ? ' filter-list_toggle' : '') . '">';
          $flag_active = false;
          if ($default == $link_data['id']) {
            //$field .= '<span class="active">';
// BOF products_filters-multilinks
            $flag_active = true;
// EOF products_filters-multilinks
          }
// BOF products_filters-multilinks
          if (is_array($default)) {
            if (in_array($link_data['id'], $default)) {
              //$field .= '<span class="active">';
              $flag_active = true;
            }
          }
// EOF products_filters-multilinks

          unset($link);
// BOF products_filters-multilinks
          if ($filter_class == 'multiple') {
// BOF products_filters_seo
            $link = filter_href_link($target, ($link_data['id'] == '0' ? vam_get_array_get_params(array($name, 'page')) : vam_get_array_get_params(array($name => $link_data['id'], 'page')) . ($flag_active ? '' : $name . '[]' . '=' . vam_output_string($link_data['id']))));
// EOF products_filters_seo
          } elseif ($filter_class == 'notzero' || $filter_class == 'discount') {
            $link = filter_href_link($target, ($link_data['id'] == '0' ? vam_get_array_get_params(array($name, 'page')) : vam_get_array_get_params(array($name => $link_data['id'], 'page')) . ($flag_active ? '' : $name . '[]' . '=' . vam_output_string($link_data['id']))));
          } else {
// EOF products_filters-multilinks
// BOF products_filters_seo
//          $field .= '<a class="filter-item-link" href="' . vam_href_link($target, vam_get_array_get_params(array( $name, 'page') ) . ($link_data['id'] == '0' ? '' : $name . '=' . vam_output_string($link_data['id']))) . '">';
            $link = filter_href_link($target, vam_get_array_get_params(array($name, 'page')) . ($link_data['id'] == '0' ? '' : $name . '=' . vam_output_string($link_data['id'])));
// EOF products_filters_seo
// BOF products_filters-multilinks
          }
// EOF products_filters-multilinks
// BOF nolink_active (remarka)
          if (!$flag_active) {
            $field .= '<a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="' . $link . '"><i class="far fa-square"></i> ';
          } else {
            $field .= '<div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center disabled'.(($link_data['id']) != '0' ? ' active' : '').'" data-href="' . $link . '"><i class="fas fa-check-square"></i> ';
          }
// EOF nolink_active (remarka)

          $field .= '<span class="pl-2 flex-grow-1 small">'.vam_output_string($link_data['text'] ).'</span>';
          if ($link_data['count'] != '' && $link_data['count'] > 1 && SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            $field .= '<span class="filter_count badge badge-light badge-pill">' . $link_data['count'] . '</span>';
          }

//          $field .= '</a>';
// BOF nolink_active (remarka)
          if (!$flag_active) {
            $field .= '</a>';
          } else {
            $field .= '</div>';
          }
// EOF nolink_active (remarka)

          if ($default == $link_data['id']) {
            //$field .= '</span>';
          }
          //$field .= '</li>';
          break;
      } // switch (true)
    } // foreach ($values

    $field .= '</div>';
    return $field;
  } //  function vam_draw_links_menu

  ////
  // Output a menu as a list of images
  function vam_draw_images_menu($name, $values, $target, $default = '') {
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
          $field .= vam_image(DIR_WS_IMAGES . trim($link_data['text']), $link_data['text'], SPECIFICATIONS_FILTER_IMAGE_WIDTH, SPECIFICATION_FILTER_IMAGE_HEIGHT, ' class="image_filter"');
          $field .= '</span>';
          break;

        default:
          $field .= '<a href="' . vam_href_link($target, vam_get_array_get_params(array( $name, 'page') ) . ($link_data['id'] == '0' ? '' : $name . '=' . vam_output_string($link_data['id']) ) ) . '">';
          $field .= vam_image(DIR_WS_IMAGES . trim($link_data['text']), $link_data['text'], SPECIFICATIONS_FILTER_IMAGE_WIDTH, SPECIFICATION_FILTER_IMAGE_HEIGHT, ' class="image_filter"');
          $field .= '</a>';
          break;
      } // switch (true)
    }

    $field .= '<br clear=all>';
    return $field;
  }

  ////
  // Output a multiple select form pull down menu
  function vam_draw_multi_pull_down_menu($name, $values, $default = array(), $parameters = '', $required = false) {
    $field = '<select name="' . vam_output_string($name) . '"';

    if (vam_not_null($parameters))
      $field .= ' ' . $parameters;

    $field .= 'multiple="' . $name . '">';

    if (empty($default) && ((isset($_GET[$name]) && is_string($_GET[$name])) || (isset($_POST[$name]) && is_string($_POST[$name])))) {
      if (isset($_GET[$name]) && is_string($_GET[$name])) {
        $default = stripslashes($_GET[$name]);
      } elseif (isset($_POST[$name]) && is_string($_POST[$name])) {
        $default = stripslashes($_POST[$name]);
      }
    }

    foreach ($values as $link_data) {
      switch (true) {
        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'none'):
          break;

        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'grey'):
          $field .= '<optgroup class="no_results" label="';
          $field .= vam_output_string($link_data['text'] );
          if ($link_data['count'] != '' && SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            $field .= ' (' . $link_data['count'] . ')';
          }
          $field .= '"></optgroup>';
          break;

        default:
          $field .= '<option value="' . vam_output_string($link_data['id']) . '"';
          if (in_array($link_data['id'], (array)$default) ) {
            $field .= ' SELECTED';
          }

          $field .= '>' . vam_output_string($link_data['text'], array(
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
      $exclude_array = array();
    $get_url = '';
    if (is_array($_GET) && (count($_GET) > 0)) {
      reset($_GET);
// BOF products_filters-multilinks
      $get = array();
// EOF products_filters-multilinks
      foreach ($_GET as $key => $value) {
        if (!vam_not_null($value) || $key == vam_session_name() || $key == 'error' || $key == 'x' || $key == 'y') {
          continue;
        }
        if (in_array($key, $exclude_array)) {
          continue;
        }
        if (is_array($value)) {
          foreach ($value as $new_key => $new_value) {
// BOF products_filters-multilinks
            if (!isset($exclude_array[$key])) {
              $get[$key][] = stripslashes($new_value);
            } else {
              if (is_array($exclude_array[$key])) {
                if (!in_array($new_value, $exclude_array[$key])) {
                  $get[$key][] = stripslashes($new_value);
                }
              } elseif ($new_value != $exclude_array[$key]) {
                $get[$key][] = stripslashes($new_value);
              }
// EOF products_filters-multilinks
            }
          }
        } else {
          $get[$key] = stripslashes($value);
        }
      }
      $get_url = http_build_query($get) . '&';
      $get_url = urldecode($get_url);
// EOF products_filters-multilinks
    }
    return $get_url;
  }

  ////
  // Output a string of HTML hidden fields containing all relevant $_GET variables. Excludes:
  //   Variables that are not set
  //   The Session variable (see vam_hide_session_id)
  //   Any variable named 'error', 'x', or 'y'
  //   Any variable passed in the exclude array
  function vam_get_hidden_get_variables($exclude_array) {
    if (!is_array($exclude_array) ) {
      $exclude_array = array();
    }

    $html_string = '';
    if (is_array($_GET) && (count($_GET) > 0)) {
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
  function vam_get_manufacturer_id($filter_array, $products_column_name, $languages_id = 1) {
    if (is_array($filter_array) && $products_column_name != '') {
      $new_filter_array = array();
      foreach ($filter_array as $filter) {
        if ($filter != '' && $filter != '0') {
//          $filter = str_replace("\'", "'", $filter);
          $filter = trim($filter);
          $manufacturer_query_raw = "SELECT manufacturers_id
                                     FROM " . TABLE_MANUFACTURERS . "
                                     WHERE TRIM(manufacturers_name) = '" . vam_db_input($filter) . "'";
          $manufacturer_query = vam_db_query($manufacturer_query_raw);
          if (!($manufacturer = vam_db_fetch_array($manufacturer_query)) && $filter != 'Бренд' && $filter != '100') {
            $not_found = true;
//error_log(__LINE__ . ': ' . '$manufacturer_query_raw=' . var_export($manufacturer_query_raw, true) . "\n", 3, __FILE__.'.log');
          }
          $new_filter_array[] = $manufacturer['manufacturers_id'];
        } // if ($filter
      } // foreach ($filter_array
if ($not_found) {
//error_log(__LINE__ . ': ' . '$filter_array[0]=' . $filter_array[0] . "\n", 3, __FILE__.'.log');
//error_log(__LINE__ . ': ' . '$filter_array=' . var_export($filter_array, true) . "\n", 3, __FILE__.'.log');
//error_log(__LINE__ . ': ' . '$new_filter_array=' . var_export($new_filter_array, true) . "\n", 3, __FILE__.'.log');
//error_log(__LINE__ . ': ' . '$manufacturer_query_raw=' . var_export($manufacturer_query_raw, true) . "\n", 3, __FILE__.'.log');
//error_log(__LINE__ . ': ' . '$manufacturer=' . var_export($manufacturer, true) . "\n", 3, __FILE__.'.log');
//error_log(__LINE__ . ': ' . '$new_filter_array=' . var_export($new_filter_array, true) . "\n", 3, __FILE__.'.log');
//error_log(__LINE__ . ': ' . 'is_null($new_filter_array[0])=' . var_export(is_null($new_filter_array[0]), true) . "\n", 3, __FILE__.'.log');
}
      return $new_filter_array;
    } // if (is_array($filter_array

    return '0';
  } // function vam_get_manufacturer_id

  /////
  // Add quotes to the filter values if strings
  function vam_set_filter_case($filter_value) {
    if (is_numeric($filter_value) ) { // Float or integer
      return $filter_value;
    } else {
      return "'" . $filter_value . "'";
    }
  }

  /////
  // Generate the SQL to return the filtered values
  function vam_get_filter_sql($filter_class, $specifications_id, $filter_array = array(), $products_column_name, $languages_id) {
    global $customer_zone_id, $customer_country_id;
    $sql_array = array(
      'from' => '',
      'where' => ''
    );

    $filter_array = (is_array($filter_array)) ? $filter_array : array($filter_array);

    // If the Show All option is set, return a blank string
    if (isset($filter_array[0]) && ($filter_array[0] == '0' || $filter_array[0] == '')) {
      return $sql_array;

    } else {
      // Scrub the filter array so apostrophes in filters don't error out.
      foreach ($filter_array as $filterKey => $filterValue) {
        $filter_array[$filterKey] = vam_db_input($filterValue);
      }

      // The Manufacturer's column contains an ID and not the name, so we have to change it
      if ($products_column_name == 'manufacturers_id') {
// BOF use filter_id
//        $filter_array = vam_get_manufacturer_id($filter_array, $products_column_name);
// EOF use filter_id
        $products_column_name = 'p.' . $products_column_name;
      } // if ($products_column_name == 'manufacturers_id')

      if ($products_column_name == 'products_quantity') {
//echo '<pre>';var_dump($products_column_name, $filter_class, $specifications_id, $filter_array);echo '</pre>';
        $products_column_name = 'p.' . $products_column_name;
      }

      // The final_price column doesn't actually exist, so we have to generate it
      $final_price = false;
      if ($products_column_name == 'final_price') {
        $final_price = true;
        $products_column_name = ' IF(s.status, s.specials_new_products_price, p.products_price) ';
      } // if ($products_column_name == 'final_price')

      switch ($filter_class) {
        case 'exact' :
// BOF use filter_id
          if (vam_specification_products_column_name($specifications_id) != 'manufacturers_id') {
            $filter_array = vam_get_filter_value($filter_array, $specifications_id);
          }
// EOF use filter_id
          $filter_array = array_map('vam_set_filter_case', $filter_array);
          foreach ($filter_array as $filter) {
            if (isset($filter) && $filter != '0' && $filter != '') {
              if (strlen($products_column_name) > 1) { // Use an existing column
                $sql_array['where'] .= " AND " . $products_column_name . " <=> " . $filter . " ";
              } else {
                $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
                $sql_array['where'] .= " AND ps" . $specifications_id . ".specification <=> " . $filter . "
                                        AND ps" . $specifications_id . ".specifications_id = " . (int)$specifications_id . "
                                        AND ps" . $specifications_id . ".language_id = " . (int)$languages_id . "";
              } // if (strlen($products_column_name ... else ...
            } // if (isset($filter
          } // foreach ($filter_array
          break;

        case 'multiple' :
// BOF use filter_id
          if (vam_specification_products_column_name($specifications_id) != 'manufacturers_id') {
            $filter_array = vam_get_filter_value($filter_array, $specifications_id);
          }
// EOF use filter_id
          $filter_array = array_map('vam_db_input', $filter_array);
          $filter_array = array_map('vam_set_filter_case', $filter_array);
          if (strlen($products_column_name) > 1) {
/*
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
*/
            $sql_array['where'] .= " AND " . $products_column_name . " IN (" . implode(', ', $filter_array) . ")";
//error_log(__LINE__ . ': ' . ' $sql_array[where]=' . var_export($sql_array['where'], true) . "\n", 3, __FILE__.'.log');

          } else {
            $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
/*
            $first = true;
            foreach ($filter_array as $filter) {
              if ($filter != '0') {
                if ($first == true) {
                  $first = false;
                  $sql_array['where'] .= " AND ps" . $specifications_id . ".specification IN (" . $filter . "";
                } else {
                  $sql_array['where'] .= ", " . $filter . "";
                }
              }
            }

            $sql_array['where'] .= ") AND ps" . $specifications_id . ".specifications_id = " . (int)$specifications_id . "
                      AND ps" . $specifications_id . ".language_id = " . (int)$languages_id . "";
*/
            $sql_array['where'] .= " AND ps" . $specifications_id . ".specification IN (" . implode(', ', $filter_array) . ")";
            $sql_array['where'] .= " AND ps" . $specifications_id . ".specifications_id = " . (int)$specifications_id . " AND ps" . $specifications_id . ".language_id = " . (int)$languages_id . "";
//error_log(__LINE__ . ': ' . ' $sql_array[where]=' . var_export($sql_array['where'], true) . "\n", 3, __FILE__.'.log');

            foreach ($filter_array as $filter) {
              if ($filter == '0') {
                $sql_array = array(
                  'from' => '',
                  'where' => ''
                );
              }
            }
          }
          break;

        case 'range' :
          $filters_range = explode('-', $filter_array[0]);
          $filters_range = array_map('vam_set_filter_case', $filters_range);

          if (!vam_session_is_registered('customer_id')) {
            $country_id = STORE_COUNTRY;
            $zone_id = STORE_ZONE;
          } else {
            $country_id = $customer_country_id;
            $zone_id = $customer_zone_id;
          }

          if (strlen($products_column_name) > 1) {
            if (count($filters_range) < 2) { // There is only one parameter, so it is a minimum
              if (DISPLAY_PRICE_WITH_TAX == 'true' && ($products_column_name == 'products_price' || $final_price == true) ) {
                $sql_array['from'] .= " inner join " . TABLE_TAX_RATES . " tr on tr.tax_class_id = p.products_tax_class_id
                                        left join " . TABLE_ZONES_TO_GEO_ZONES . " za on (tr.tax_zone_id = za.geo_zone_id)
                                        left join " . TABLE_GEO_ZONES . " tz on (tz.geo_zone_id = tr.tax_zone_id)";
                $sql_array['where'] .= " AND (" . $products_column_name . " * (1.0 + (tr.tax_rate / 100) ) ) > " . $filters_range[0] . "
                                         and (za.zone_country_id is null
                                           or za.zone_country_id = '0'
                                           or za.zone_country_id = '" . (int)$country_id . "')
                                         and (za.zone_id is null
                                           or za.zone_id = '0'
                                           or za.zone_id = '" . (int)$zone_id . "')";
              } else {
                $sql_array['where'] .= " and " . $products_column_name . " > " . $filters_range[0] . " ";
              }
            } else {
              if (DISPLAY_PRICE_WITH_TAX == 'true' && ($products_column_name == 'products_price' || $final_price == true) ) {
                $sql_array['from'] .= " inner join " . TABLE_TAX_RATES . " tr on tr.tax_class_id = p.products_tax_class_id
                                        left join " . TABLE_ZONES_TO_GEO_ZONES . " za on (tr.tax_zone_id = za.geo_zone_id)
                                        left join " . TABLE_GEO_ZONES . " tz on (tz.geo_zone_id = tr.tax_zone_id)";
                $sql_array['where'] .= " and ((" . $products_column_name . " * (1.0 + (tr.tax_rate / 100))) between " . $filters_range[0] . " and " . $filters_range[1] . ")
                                         and (za.zone_country_id is null
                                           or za.zone_country_id = '0'
                                           or za.zone_country_id = '" . (int)$country_id . "')
                                         and (za.zone_id is null
                                           or za.zone_id = '0'
                                           or za.zone_id = '" . (int)$zone_id . "')";
              } else {
                $sql_array['where'] .= " and (" . $products_column_name . " between " . $filters_range[0] . " and " . $filters_range[1] . ") ";
              }
            }
            $sql_array['from'] .= "LEFT JOIN " . TABLE_SPECIALS . " s ON p.products_id = s.products_id" . "\n";
          } else {
            if (count($filters_range) < 2) { // There is only one parameter, so it is a minimum
              $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
              $sql_array['where'] .= " AND ps" . $specifications_id . ".specification > " . $filters_range[0] . "
                          AND ps" . $specifications_id . ".specifications_id = " . (int)$specifications_id . "
                          AND ps" . $specifications_id . ".language_id = " . (int)$languages_id . "";

            } else { // There are two parameters, so treat them as minimum and maximum
              $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
              $sql_array['where'] .= " AND (ps" . $specifications_id . ".specification between " . $filters_range[0] . " and " . $filters_range[1] . ")
                          AND ps" . $specifications_id . ".specifications_id = " . (int)$specifications_id . "
                          AND ps" . $specifications_id . ".language_id = " . (int)$languages_id . "";
            }
          }
          break;

        case 'reverse' :
          // No existing columns are set up as a reverse range, so this filter class has no provision for existing columns
          $filter_array = array_map('vam_set_filter_case', $filter_array);
          $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
          $sql_array['where'] .= " AND " . $filter_array[0] . " BETWEEN SUBSTRING_INDEX(ps" . $specifications_id . ".specification, '-', 1) AND SUBSTRING_INDEX(ps" . $specifications_id . ".specification, '-', -1)
                  AND ps" . $specifications_id . ".specifications_id = " . (int)$specifications_id . "
                  AND ps" . $specifications_id . ".language_id = " . (int)$languages_id . "";
          break;

        case 'start' :
          if (strlen($products_column_name) > 1) {
            $sql_array['where'] .= " AND " . $products_column_name . " LIKE '" . $filter_array[0] . "%' ";
          } else {
            $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
            $sql_array['where'] .= " AND ps" . $specifications_id . ".specification LIKE '" . $filter_array[0] . "%'
                      AND ps" . $specifications_id . ".specifications_id = " . (int)$specifications_id . "
                      AND ps" . $specifications_id . ".language_id = " . (int)$languages_id . "";
          }
          break;

        case 'partial' :
          if (strlen($products_column_name) > 1) {
            $sql_array['where'] .= " AND " . $products_column_name . " LIKE '%" . $filter_array[0] . "%' ";
          } else {
            $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
            $sql_array['where'] .= " AND ps" . $specifications_id . ".specification LIKE '%" . $filter_array[0] . "%'
                      AND ps" . $specifications_id . ".specifications_id = " . (int)$specifications_id . "
                      AND ps" . $specifications_id . ".language_id = " . (int)$languages_id . "";
          }
          break;

        case 'like' :
          // Function currently uses 'sounds like' to do a soundex match
          if (strlen($products_column_name) > 1) {
            $sql_array['where'] .= " and " . $products_column_name . " sounds LIKE '%" . $filter_array[0] . "%' ";
          } else {
            $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
            $sql_array['where'] .= " AND ps" . $specifications_id . ".specification sounds like '" . $filter_array[0] . "'
                      AND ps" . $specifications_id . ".specifications_id = " . (int)$specifications_id . "
                      AND ps" . $specifications_id . ".language_id = " . (int)$languages_id . "";
          }
          break;

        case 'notzero' :
          $filter_array = array_map('vam_set_filter_case', $filter_array);
          foreach ($filter_array as $filter) {
            if (isset($filter) && $filter != '0' && $filter != '') {
              if (strlen($products_column_name) > 1) { // Use an existing column
                $sql_array['where'] .= " AND " . $products_column_name . "> '0'";
              }
            }
          }
          break;

        case 'discount' :
          $filter_array = array_map('vam_set_filter_case', $filter_array);
          foreach ($filter_array as $filter) {
            if (isset($filter) && $filter != '0' && $filter != '') {
              $sql_array['from'] .= " INNER JOIN  " . TABLE_SPECIALS  . " ps" . $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id ";
            }
          }
          break;

        case 'none' :
        case '' :
        default :
          break;
      } // switch ($filter_class
    } // if (count($filter_array) ... else ...
    return $sql_array;
  }

  ////
  // Output an HTML string containing forms/links of all applicable Filters
// BOF products_filters-multilinks
//  function vam_get_filter_string($display_type, $filters_select_array, $target, $filter_name, $filter_value) {
  function vam_get_filter_string($display_type, $filters_select_array, $target, $filter_name, $filter_value, $filter_class='') {
//    error_log('$display_type=' . var_export($display_type, true) . "\n" . '$filters_select_array=' . var_export($filters_select_array, true) . "\n" . '$target=' . var_export($target, true) . "\n" . '$filter_name=' . var_export($filter_name, true) . "\n" . '$filter_value=' . var_export($filter_value, true) . "\n" . '$filter_class=' . var_export($filter_class, true) . "\n", 3, __FILE__.'.log');
// EOF products_filters-multilinks
    $filter_name = (string)$filter_name;
    if (is_array($filter_value)) {
    } else {
      $filter_value = (string)$filter_value;
    }

    $exclude_array = array($filter_name, 'page');
    $additional_variables = vam_get_hidden_get_variables($exclude_array);
    $box_text = '';

    switch ($display_type) {
      case 'pulldown':
        $box_text .= vam_draw_form('filter', $target, 'get');
        $box_text .= vam_draw_pull_down_menu($filter_name, $filters_select_array, $filter_value, 'onChange="this.form.submit();"');
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= '<noscript>' . vam_image_submit('submit.png', TEXT_FIND_PRODUCTS) . '</noscript>';
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
              $box_text .= vam_output_string($filter['text'] );
              $box_text .= '</span>';
              if (SPECIFICATIONS_FILTER_SHOW_COUNT == 'True' && $filter['count'] != '' && $filter['count'] > 1) {
                $box_text .= '<span class="filter_count"> (' . $filter['count'] . ')</span>';
              }
              $box_text .= '<br>' . "\n";
              break;

            default:
              $box_text .= vam_draw_radio_field($filter_name, $filter['id'], $checked, 'onClick="this.form.submit();"') . '&nbsp;' . $filter['text'];

              if (SPECIFICATIONS_FILTER_SHOW_COUNT == 'True' && $filter['count'] != '' && $filter['count'] > 1) {
                $box_text .= '<span class="filter_count"> (' . $filter['count'] . ')</span>';
              }
              $box_text .= '<br>' . "\n";
              break;
          } // switch (true)
        }
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= '<noscript>' . vam_image_submit('submit.png', TEXT_FIND_PRODUCTS) . '</noscript>';
        $box_text .= '</form>';
        break;

      case 'text':
        $value = ($filter_value != 0) ? $filter_value : '';
        $box_text .= vam_draw_form('filter', $target, 'get');
        $box_text .= vam_draw_input_field($filter_name, $value);
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= '<noscript>' . vam_image_submit('submit.png', TEXT_FIND_PRODUCTS) . '</noscript>';
        $box_text .= '</form>';
        break;

      case 'multi':
        $box_text .= vam_draw_form('filter', $target, 'get');
        $box_text .= vam_draw_multi_pull_down_menu($filter_name . '[]', $filters_select_array, $filter_value, 'multiple="' . $filter_name . 'f"');
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= vam_image_submit('submit.png', TEXT_FIND_PRODUCTS);
        $box_text .= '</form>';
        break;

      case 'checkbox':
        $box_text .= vam_draw_form('filter', $target, 'get');
        $checkbox_id = 0;
        foreach ($filters_select_array as $filter) {
          $checked = ($filter['id'] == $filter_value[$checkbox_id]) ? true : false;
          switch (true) {
            case ($filter['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'none'):
              break;

            case ($filter['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'grey'):
              $box_text .= '<input type="checkbox" name="0" value="0" disabled="disabled">';
              $box_text .= '<span class="no_results">' . '&nbsp;';
              $box_text .= vam_output_string($filter['text'] );
              $box_text .= '</span>';
              if (SPECIFICATIONS_FILTER_SHOW_COUNT == 'True' && $filter['count'] > 1) {
                $box_text .= '<span class="filter_count"> (' . $filter['count'] . ')</span>';
              }
              $box_text .= '<br>' . "\n";
              break;

            default:
              $box_text .= vam_draw_checkbox_field($filter_name . '[' . $checkbox_id . ']', $filter['id'], $checked, 'onClick="this.form.submit();"') . '&nbsp;' . $filter['text'];

              if (SPECIFICATIONS_FILTER_SHOW_COUNT == 'True' && $filter['count'] > 1) {
                $box_text .= '<span class="filter_count"> (' . $filter['count'] . ')</span>';
              }
              $box_text .= '<br>' . "\n";
              break;
          } // switch (true)
          $checkbox_id++;
        }
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= '<noscript>' . vam_image_submit('submit.png', TEXT_FIND_PRODUCTS) . '</noscript>';
        $box_text .= '</form>';
        break;

      case 'image':
        $value = ($filter_value != 0) ? $filter_value : '';
        $box_text .= vam_draw_images_menu($filter_name, $filters_select_array, $target, $value);
        break;

      case 'multiimage':
        $box_text .= vam_draw_form('filter', $target, 'get');
        foreach ($filters_select_array as $filter) {
          $checked = ($filter['id'] == $filter_value[$checkbox_id]) ? true : false;
          $box_text .= vam_draw_checkbox_field($filter_name . '[' . $checkbox_id . ']', $filter['id'], $checked);
          $box_text .= '  ' . vam_image(DIR_WS_IMAGES . trim($filter['text']), $filter['text']) . '<br>' . "\n";
          $box_text .= '<br>' . "\n";
          $checkbox_id++;
        }
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= vam_image_submit('submit.png', TEXT_FIND_PRODUCTS);
        $box_text .= '</form>';
        break;

// BOF products_filters-slider
      case 'slider':
        $range = explode('-', $filters_select_array[0]['id']);
if (is_array($filter_value)) {
//  error_log('$filters_select_array=' . var_export($filters_select_array, true) . "\n", 3, __FILE__.'.log');
//  error_log('$filter_name=' . var_export($filter_name, true) . "\n", 3, __FILE__.'.log');
//  error_log('$filter_value=' . var_export($filter_value, true) . "\n", 3, __FILE__.'.log');
//  error_log('$_GET=' . var_export($_GET, true) . "\n", 3, __FILE__.'.log');
}
        if (is_array($filter_value)) {
          $value = $filter_value;
        } else {
          $value = ($filter_value != '0') ? explode('-', $filter_value) : $range;
        }
        if ($value[0] < $range[0]) $value[0] = $range[0];
        if ($value[1] > $range[1]) $value[1] = $range[1];
        $box_text .= '<div class="filter-slider-content">';
        $box_text .= vam_draw_form($filter_name, $target, 'get', 'class="filter filter-slider" data-min="' . $range[0] . '" data-max="' . $range[1] . '" ');
        $box_text .= $additional_variables . vam_hide_session_id();
        $box_text .= '<div class="filter-slider-wrapper">';
        $box_text .= 'от ' . vam_draw_input_field($filter_name . '[]', $value[0], 'class="filter-slider"');
        $box_text .= ' до ' . vam_draw_input_field($filter_name . '[]', $value[1], 'class="filter-slider"') . ' руб.';
        $box_text .= '<button class="btn" type="submit"><i class="ui-icon ui-icon-check"></i></button>';
        $box_text .= '</div>';
//        $box_text .= vam_image_submit('submit.png', TEXT_FIND_PRODUCTS);
        $box_text .= '</form>';
        $box_text .= '</div>';
        break;
// EOF products_filters-slider

      case 'links':
      default :
// BOF products_filters-multilinks
//        $box_text .= vam_draw_links_menu($filter_name, $filters_select_array, $target, $filter_value);
        $box_text .= vam_draw_links_menu($filter_name, $filters_select_array, $target, $filter_value, $filter_class);
// EOF products_filters-multilinks
        break;
    } // switch ($display_type

    return $box_text;
  } //function vam_get_filter_string

////
// Fill the table data fields in a comparison or category page with data from the existing osC fields
  function vam_fill_existing_fields($products_id, $languages_id) {
  	global $currencies, $cPath, $PHP_SELF;

    $columns_query_raw = "select
                            p.products_id,
                            pd.products_name,
                            pd.products_description,
                            p.products_quantity,
                            p.products_model,
                            p.products_image,
                            p.products_price,
                            p.products_weight,
                            p.products_tax_class_id,
                            m.manufacturers_name,
                            IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price,
                            IF(s.status, s.specials_new_products_price, p.products_price) as final_price
                          from " . TABLE_PRODUCTS . " p
                            INNER join " . TABLE_PRODUCTS_DESCRIPTION . " pd on (pd.products_id = p.products_id AND pd.language_id = " . (int)$languages_id . ")
                            left join " . TABLE_SPECIALS . " s on (p.products_id = s.products_id)
                            left join " . TABLE_MANUFACTURERS . " m on (p.manufacturers_id = m.manufacturers_id)
                          where p.products_id = " . (int)$products_id . "";
    // print $columns_query_raw . "<br>\n";
    $columns_query = vam_db_query($columns_query_raw);
    $columns_array = vam_db_fetch_array($columns_query);

    $field_array = array();
    // Quantities may be used in columns or combination column
    $field_array['products_quantity'] = ($columns_array['products_quantity'] == '') ? TEXT_NOT_AVAILABLE : $columns_array['products_quantity'];

    $field_array['products_model'] = ($columns_array['products_model'] == '') ? TEXT_NOT_AVAILABLE : $columns_array['products_model'];

    $field_array['products_index_description'] = ($columns_array['products_index_description'] == '') ? TEXT_NOT_AVAILABLE : $columns_array['products_index_description'];

    $field_array['products_description'] = ($columns_array['products_description'] == '') ? TEXT_NOT_AVAILABLE : $columns_array['products_description'];

    $cPath_new = vam_get_product_path( $columns_array['products_id'] );
    $product_link = vam_href_link( FILENAME_PRODUCT_INFO, 'cPath=' . $cPath_new . '&products_id=' . $columns_array['products_id'] );

    $field_array['products_image'] = '<a href="' . $product_link . '">' . vam_image(DIR_WS_IMAGES . trim($columns_array['products_image']), $columns_array['products_name']) . '</a>';

    $field_array['products_name'] = ($columns_array['products_name'] == '') ? TEXT_NOT_AVAILABLE : '<a href="' . $product_link . '">' . $columns_array['products_name'] . '</a>';

    if (vam_not_null($columns_array['specials_new_products_price'])) {
      //$field_array['products_price'] = '<s>' . $currencies->display_price($columns_array['products_price'], vam_get_tax_rate($columns_array['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price($columns_array['specials_new_products_price'], vam_get_tax_rate($columns_array['products_tax_class_id'])) . '</span>';
      $field_array['products_price'] = '<s>' . $columns_array['products_price'] . '</s><br><span class="productSpecialPrice">' . $columns_array['specials_new_products_price'] . '</span>';
    } else {
      //$field_array['products_price'] = $currencies->display_price($columns_array['products_price'], vam_get_tax_rate($columns_array['products_tax_class_id']));
      $field_array['products_price'] = $columns_array['products_price'];
    }

    //$field_array['final_price'] = $currencies->display_price($columns_array['final_price'], vam_get_tax_rate($columns_array['products_tax_class_id']));
    $field_array['final_price'] = $columns_array['final_price'];

    if( $columns_array['price_in_cart_only'] == '1' ) {
      $field_array['products_price'] = '                <span class="smalltext">';

      $field_array['products_price'] .= '<script language="javascript"><!--' . "\n";
      $field_array['products_price'] .= 'document.write(\'' . '<a href="javascript:popupWindow(\\\'' . vam_href_link( FILENAME_POPUP_PRICE_IN_CART ) . '\\\')">' . TEXT_WHY_HIDE_PRICE . '</a>\');' . "\n";
      $field_array['products_price'] .= '//--></script>' . "\n";
      $field_array['products_price'] .= '<noscript>';
      $field_array['products_price'] .= '<a href="' . vam_href_link( FILENAME_POPUP_PRICE_IN_CART ) . '" target="_new">' . TEXT_WHY_HIDE_PRICE . '</a>';
      $field_array['products_price'] .= '</noscript>';
      $field_array['products_price'] .= '                </span>';

      $field_array['final_price'] = $field_array['products_price'];
    }

    $raw_weight = number_format($columns_array['products_weight'], 1);
    if ($raw_weight -floor($raw_weight) == 0) {
      $raw_weight = number_format($columns_array['products_weight'], 0);
    }
    $field_array['products_weight'] = ($raw_weight == 0.0) ? TEXT_NOT_AVAILABLE : $raw_weight;

    $field_array['manufacturers_name'] = ($columns_array['manufacturers_name'] == '') ? TEXT_NOT_AVAILABLE : $columns_array['manufacturers_name'];

    $field_array['buy_now'] = '              <div class="buttonSet" style="margin-left:10px;">
                <span class="buttonAction">' . vam_draw_hidden_field('products_id', $columns_array['products_id']) . 'incart_button' . '</span>
              </div>';

    // Show Option/Attribute values if there are any
    $field_array['products_options'] ='&nbsp;';
    //$options_array = vam_get_products_attributes ($columns_array['products_id'], (int)$languages_id, $columns_array['products_tax_class_id']);
    if (is_array($options_array) && count($options_array) > 0) {
      $field_array['products_options'] = '';
      foreach( $options_array as $options ) {
        $field_array['products_options'] .= vam_select_attributes($columns_array['products_id'], $options, $languages_id, $columns_array['products_tax_class_id']);
      }
    }

    $field_array['popup_image'] = TEXT_NOT_AVAILABLE;
    $popup_array['image'] = $columns_array['products_image'];

    if( vam_not_null( $popup_array[ 'image' ] ) ) {
      $field_array['popup_image'] = '<script language="javascript"><!--' . "\n";
      $field_array['popup_image'] .= 'document.write(\'<a href="javascript:popupWindow(\\\'' . vam_href_link (FILENAME_POPUP_IMAGE, 'pID=' . $columns_array['products_id']) . '\\\')">' . TEXT_POPUP . '</a>\');' . "\n";
      $field_array['popup_image'] .= '//--></script>' . "\n";
      $field_array['popup_image'] .= '<noscript>' . "\n";
      $field_array['popup_image'] .= '<a href="' . vam_href_link (DIR_WS_IMAGES . $columns_array['image']) . '" target="_blank">' . TEXT_POPUP . '</a>' . "\n";
      $field_array['popup_image'] .= '</noscript>' . "\n";
    }

    return $field_array;
  }

////
// Draw a table cell in a comparison table or alternate category page
  function vam_specification_table_cell($specs_id, $products_id, $languages_id, $field_array, $specs_data) {
    $products_specifications_query_raw = "select specification
                                          from " . TABLE_PRODUCTS_SPECIFICATIONS . "
                                          where specifications_id = " . (int)$specs_id . "
                                            and language_id = " . (int)$languages_id . "
                                            and products_id = " . (int)$products_id . "
                                          limit 1";
    // print $products_specifications_query_raw . "<br>\n";
    $products_specifications_query = vam_db_query($products_specifications_query_raw);
    $products_specifications = vam_db_fetch_array($products_specifications_query);

    if ($products_specifications['specification'] == '') {
      $specs_data['specification'] = TEXT_NOT_AVAILABLE;
    } else {
      $specs_data['specification'] = $products_specifications['specification'];
    }

    // Get the data for the table cell, either from an existing column or from the specification
    switch ($specs_data['column_name']) {
       // If an existing column was selcted, use that data
      case 'products_quantity' :
        $box_text = $field_array['products_quantity'];
        $box_align = 'center';
        break;

      case 'products_model' :
        $box_text = $field_array['products_model'];
        $box_align = 'center';
        break;

      case 'products_image' :
        $box_text = $field_array['products_image'];
        $box_align = 'center';
        break;

      case 'products_price' :
        $box_text = $field_array['products_price'];
        $box_align = 'right';
        break;

      case 'final_price' :
        $box_text = $field_array['final_price'];
        $box_align = 'right';
        break;

      case 'products_weight' :
        $box_text = $field_array['products_weight'];
        $box_align = 'center';
        break;

      case 'products_options' :
        $box_text = $field_array['products_options'];
        $box_align = 'center';
        break;

      case 'manufacturers_id' :
        $box_text = $field_array['manufacturers_name'];
        $box_align = 'center';
        break;

      case 'products_name' :
        $box_text = $field_array['products_name'];
        $box_align = 'center';
        break;

      case 'products_description' :
        $box_text = stripslashes( stripslashes( $field_array['products_description'] ) );
        break;

      case 'products_index_description' :
        $box_text = stripslashes( stripslashes( $field_array['products_index_description'] ) );
        break;

      case 'buy_now' :
        $box_text = '<span style="font-size:0.8em;">' . $field_array['buy_now'] . '</span>';
        $box_align = 'center';
        break;

      case 'combi' : // Contents of this column are set globally in the Admin Config
        $combi_components = array();
        if (SPECIFICATIONS_COMBO_MODEL > 0)
          $combi_components[SPECIFICATIONS_COMBO_MODEL] = $field_array['products_model'];
        if (SPECIFICATIONS_COMBO_IMAGE > 0)
          $combi_components[SPECIFICATIONS_COMBO_IMAGE] = $field_array['products_image'];
        if (SPECIFICATIONS_COMBO_PRICE > 0)
          $combi_components[SPECIFICATIONS_COMBO_PRICE] = $field_array['products_price'];
        if (SPECIFICATIONS_COMBO_WEIGHT > 0)
          $combi_components[SPECIFICATIONS_COMBO_WEIGHT] = $field_array['products_weight'];
        if (SPECIFICATIONS_COMBO_MFR > 0)
          $combi_components[SPECIFICATIONS_COMBO_MFR] = $field_array['manufacturers_name'];
        if (SPECIFICATIONS_COMBO_NAME > 0)
          $combi_components[SPECIFICATIONS_COMBO_NAME] = $field_array['products_name'];
        if (SPECIFICATIONS_COMBO_BUY_NOW > 0)
          $combi_components[SPECIFICATIONS_COMBO_BUY_NOW] = $field_array['buy_now'];
        ksort($combi_components);
        $box_text = implode('<br>', $combi_components);
        $box_align = 'center';
        break;

      case '' : // No existing column, so use specification data
      default :
        $box_text = $specs_data['prefix'] . ' ' . PHP_EOL;

        if ($specs_data['display'] == 'image' || $specs_data['display'] == 'multiimage' || $specs_data['enter'] == 'image' || $specs_data['enter'] == 'multiimage') {
          $box_text .= vam_image(DIR_WS_IMAGES . trim($specs_data['specification']), $specs_data['column_name']) . PHP_EOL;
        } else {
          $box_text .= $specs_data['specification'] . ' ' . PHP_EOL;
        }

        if ($specs_data['suffix'] != '' && SPECIFICATIONS_COMP_SUFFIX != 'True') {
          $box_text .= ' ' . $specs_data['suffix'] . PHP_EOL;
        }

        $box_align = $specs_data['column_justify'];
        break;
    } // switch ($specs_data['column_name']

    return array('box_text' => $box_text, 'box_align' => $box_align);
  }


/**
 * Word Limiter
 *
 * Limits a string to X number of words.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @param	string	the end character. Usually an ellipsis
 * @return	string
 */
if (!function_exists('word_limiter')) {
	function word_limiter($str, $limit = 100, $end_char = '&#8230;') {
		if (trim($str) == '') {
			return $str;
		}
		preg_match('/^\s*+(?:\S++\s*+){1,' . (int)$limit . '}/', $str, $matches);
		if (strlen($str) == strlen($matches[0])) {
			$end_char = '';
		}
		return rtrim($matches[0]).$end_char;
	}
}

// BOF products_filters_seo
  define('TABLE_SPECIFICATION_URL', 'specification_url');
  define('TABLE_SPECIFICATION_URLEXT', 'specification_urlext');
  function filter_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true) {
//error_log(__LINE__ . ': ' . ' $parameters=' . var_export($parameters, true) . "\n", 3, __FILE__.'.log');
    $parameters = str_replace('&quot;', '"', $parameters);
//error_log(__LINE__ . ': ' . ' $parameters=' . var_export($parameters, true) . "\n", 3, __FILE__.'.log');
    return vam_href_link($page, $parameters, $connection, $add_session_id, $search_engine_safe);
  }
// EOF products_filters_seo