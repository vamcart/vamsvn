<?php
// shaklov изменён запрос
// убрано в новых версиях в строке 90:
// INNER JOIN (" . TABLE_PRODUCTS_DESCRIPTION . " pd)
/*
  $Id: specifications.php, v1.0 20090909 Yarhajile Exp $
  $Loc: catalog/includes/classes/ $
  $Mod: 1.0.1.1 20090917 kymation $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General License
*/
// BOF products_filters-slider

  class Specifications {
    var $specs = array();
    var $applied_filters = array();
    var $current_category_id;
    var $languages_id;

    function __construct() {
      global $current_category_id;

      $this->current_category_id = $current_category_id;
      $this->languages_id = $_SESSION['languages_id'];

      $this->setAppliedFilters();
    }

    function setAppliedFilters() {
      $category_sql = $this->current_category_id != 0 ? "and s2c.categories_id = '" . (int)$this->current_category_id . "'" : '';

      // Check for filters on each applicable Specification
      $specs_query_raw = "SELECT
                            s.specifications_id,
                            s.filter_class,
                            s.filter_display,
                            s.products_column_name,
                            sd.specification_name
                          FROM " . TABLE_SPECIFICATION . " s
                            INNER JOIN " . TABLE_SPECIFICATION_GROUPS . " sg ON s.specification_group_id = sg.specification_group_id
                            INNER JOIN " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c ON sg.specification_group_id = s2c.specification_group_id
                            INNER JOIN " . TABLE_SPECIFICATION_DESCRIPTION . " sd ON (sd.specifications_id = s.specifications_id AND sd.language_id = " . (int)$_SESSION['languages_id'] . ")
                          WHERE s.show_filter = 'True'
                            AND sg.show_filter = 'True'
                            " . $category_sql . "";
      $specs_query = vam_db_query($specs_query_raw);

//error_log(__LINE__ . ': ' . '$_GET=' . var_export($_GET, true) . "\n", 3, __FILE__.'.log');
      while ($specs_array = vam_db_fetch_array($specs_query)) {
        // Retrieve the GET vars used as filters
        // Variable names are the letter "f" followed by the specifications_id for that spec.
        $var = $specs_array['specifications_id'];
        $$var = '0';

        if (isset($_GET['f' . $var]) && $_GET['f' . $var] != '') {
          // Decode the URL-encoded names, including arrays
//error_log(__LINE__ . ': ' . 'f . $var=' . var_export('f' . $var, true) . "\n", 3, __FILE__.'.log');
//error_log(__LINE__ . ': ' . ' $_GET[f . $var]=' . var_export($_GET['f' . $var], true) . "\n", 3, __FILE__.'.log');
          $$var = vam_decode_recursive($_GET['f' . $var]);
//error_log(__LINE__ . ': ' . ' $$var=' . var_export($$var, true) . "\n", 3, __FILE__.'.log');

          // Sanitize variables to prevent hacking
//          $$var = vam_clean_get__recursive($$var);
//error_log(__LINE__ . ': ' . ' $$var=' . var_export($$var, true) . "\n", 3, __FILE__.'.log');

          // Set the cporrect variable type (All _GET variables are strings by default)
          $$var = vam_set_type($$var);
// BOF products_filters-slider
          if ($specs_array['filter_display'] == 'slider' && is_array($_GET['f' . $var])) {
            $$var = implode('-', $_GET['f' . $var]);
          }
// EOF products_filters-slider
          $this->applied_filters[$var] = $$var;
        } // if (isset($_GET[$var]

      } // while ($specs_array
    }

    function getAppliedFilters() {
      return $this->applied_filters;
    }

    function getFilterCount($specification, $specifications_id, $filter_class, $products_column_name) {
      $raw_query_start = "select count(distinct p.products_id) as count ";
      $raw_query_from = '';
      $raw_query_where = '';

      $raw_query_addon_array = $this->getAllFilterSQL($specification, $specifications_id, $filter_class, $products_column_name);

      $raw_query_from .= $raw_query_addon_array['from'];
      $raw_query_where .= $raw_query_addon_array['where'];

      $raw_query = $raw_query_start . $raw_query_from . $raw_query_where;
      //print 'Raw Query: ' . $raw_query . '<br>';
      //$cat_path = explode('_', $_GET['cPath']);
      //echo '::'.$_GET['cPath']. var_dump($cat_path);
      
      //if ($cat_path[0] == 62 or $cat_path[1] != '' or $cat_path[2] != '' or $cat_path[3] != '' or $cat_path[4] != '' or $cat_path[5] != '') {
      $filter_count_query = vam_db_query($raw_query);

      $filter_count_results = vam_db_fetch_array($filter_count_query);

      $count = (string)$filter_count_results['count'];
      
      //} else {
      
      //$count = 1;
      	
      //}

      return $count;
    }

    function getAllFilterSQL($specification, $specifications_id, $filter_class, $products_column_name) {
      $raw_query_from = " FROM (" . TABLE_PRODUCTS . " p)
                            INNER JOIN (" . TABLE_PRODUCTS_TO_CATEGORIES . " p2c) ON (p.products_id = p2c.products_id)
                            INNER JOIN " . TABLE_CATEGORIES . " c ON (c.categories_id = p2c.categories_id)";

      $raw_query_where = "\n" . " WHERE p.products_status = 1 AND c.categories_status = 1" . "\n";

      if ($this->current_category_id != 0) { // Restrict query to the appropriate category/categories

      //$cat_path = explode('_', $_GET['cPath']);
      //if ($cat_path[1] != '' or $cat_path[2] != '' or $cat_path[3] != '' or $cat_path[4] != '' or $cat_path[5] != '') {
        $subcategories_array = array();
        vam_get_subcategories($subcategories_array, $this->current_category_id);
      //}
      
        if (SPECIFICATIONS_FILTER_SUBCATEGORIES == 'True' && count($subcategories_array) > 0) {
          $category_ids = $this->current_category_id . ',' . implode(',', $subcategories_array);
          $raw_query_where .= " and p2c.categories_id in (" . $category_ids . ") " . "\n";
        } else {
          $raw_query_where .= " and p2c.categories_id = " . (int)$this->current_category_id . " " . "\n";
        }
      } // if ($this->current_category_id

      $raw_query_addon_array = vam_get_filter_sql($filter_class, $specifications_id, $specification, $products_column_name, $this->languages_id);

      $raw_query_from .=  "\n" . $raw_query_addon_array['from'];
      $raw_query_where .= "\n" . $raw_query_addon_array['where'];

      $applied_filters = $this->getAppliedFilters();

      foreach ($applied_filters as $k => $v) {
        if ($k == $specifications_id) {
          continue;
        }

        $specs_array = $this->getSpecification($k);

        $raw_query_addon_array = vam_get_filter_sql($specs_array['filter_class'], $specs_array['specifications_id'], $v, $specs_array['products_column_name'], $this->languages_id);

        $raw_query_from .= $raw_query_addon_array['from'];
        $raw_query_where .= $raw_query_addon_array['where'];
      } // foreach($applied_filters

      $raw_query_addon_array = array('from' => $raw_query_from, 'where' => $raw_query_where);

      return $raw_query_addon_array;
    }

    function getSpecification($id) {
      if (!isset($this->specs[$id])) {
        $specs_query_raw = "SELECT
                              s.specifications_id,
                              s.products_column_name,
                              s.filter_class,
                              s.filter_show_all,
                              s.filter_display,
                              sd.specification_name,
                              sd.specification_prefix,
                              sd.specification_suffix
                            FROM " . TABLE_SPECIFICATION . " s
                              INNER JOIN " . TABLE_SPECIFICATION_DESCRIPTION . " sd ON (s.specifications_id = sd.specifications_id AND sd.language_id = " . (int)$this->languages_id . ")
                              INNER JOIN " . TABLE_SPECIFICATION_GROUPS . " sg ON s.specification_group_id = sg.specification_group_id
                              INNER JOIN " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c ON sg.specification_group_id = s2c.specification_group_id
                            WHERE s.specifications_id = '" . (int)$id . "'
                              and s.show_filter = 'True'
                              and sg.show_filter = 'True'                              
                              and s2c.categories_id = " . (int)$this->current_category_id . "";
        $specs_query = vam_db_query ($specs_query_raw);

        $this->specs[$id] = vam_db_fetch_array($specs_query);
      }

      return $this->specs[$id];
    }
  }

?>