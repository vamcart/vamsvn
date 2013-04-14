<?php
/*
  $Id: specifications.php, v1.0 20090909 Yarhajile Exp $
  $Loc: catalog/includes/classes/ $
  $Mod: 1.0.1.1 20090917 kymation $
  
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General License
*/


  class Specifications {
    var $specs = array ();
    var $applied_filters = array ();
    var $current_category_id;
    var $languages_id;

    function Specifications() {
      global $current_category_id, $languages_id;

      $this->current_category_id = $current_category_id;
      $this->languages_id = $_SESSION['languages_id'];

      $this->setAppliedFilters();
    }

    function setAppliedFilters() {
      $category_sql = $this->current_category_id != 0 ? "and s2c.categories_id = '" . $this->current_category_id . "'" : '';

      // Check for filters on each applicable Specification
      $specs_query_raw = "SELECT
                            s.specifications_id,
                            s.filter_class,
                            s.products_column_name,
                            sd.specification_name
                          FROM
                            " . TABLE_SPECIFICATION . " AS s
                          INNER JOIN " . TABLE_SPECIFICATION_GROUPS . " AS sg
                            ON s.specification_group_id = sg.specification_group_id
                          INNER JOIN " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " AS s2c
                            ON sg.specification_group_id = s2c.specification_group_id
                          INNER JOIN " . TABLE_SPECIFICATION_DESCRIPTION . " sd 
                            ON sd.specifications_id = s.specifications_id
                          WHERE
                            s.show_filter = 'True'
                            AND sg.show_filter = 'True' 
                            " . $category_sql . "
                         ";

      $specs_query = vam_db_query($specs_query_raw);

      while ($specs_array = vam_db_fetch_array($specs_query)) {
        // Retrieve the GET vars used as filters
        // Variable names are the letter "f" followed by the specifications_id for that spec.
        $var = $specs_array['specifications_id'];
        $$var = '0';

        if (isset ($_GET['f' . $var]) && $_GET['f' . $var] != '') {
          // Decode the URL-encoded names, including arrays
          $$var = vam_decode_recursive ($_GET['f' . $var]);
      
          // Sanitize variables to prevent hacking
          $$var = vam_clean_get__recursive($$var);

          // Set the cporrect variable type (All _GET variables are strings by default)
          $$var = vam_set_type($$var);

          $this->applied_filters[$var] = $$var;
        } // if (isset ($_GET[$var]

      } // while ($specs_array
    }

    function getAppliedFilters() {
      return $this->applied_filters;
    }

    function getFilterCount($specification, $specifications_id, $filter_class, $products_column_name) {
      $raw_query_start = "select count(distinct p.products_id) as count ";

      $raw_query_from = " FROM (" . TABLE_PRODUCTS . " p)
INNER JOIN (" . TABLE_PRODUCTS_TO_CATEGORIES . " p2c)
INNER JOIN (" . TABLE_PRODUCTS_DESCRIPTION . " pd)
ON (p.products_id = p2c.products_id)
INNER JOIN " . TABLE_CATEGORIES . " cat
ON (cat.categories_id = p2c.categories_id)";

      $raw_query_where = " WHERE p.products_status = '1' AND cat.categories_status = '1'";

      if ($this->current_category_id != 0) { // Restrict query to the appropriate category/categories
        $subcategories_array = array();
        vam_get_subcategories ($subcategories_array, $this->current_category_id);
        
        if (SPECIFICATIONS_FILTER_SUBCATEGORIES == 'True' && count ($subcategories_array) > 0) {
          $category_ids = $this->current_category_id . ',' . implode (',', $subcategories_array);
          $raw_query_where .= '   ' . "and p2c.categories_id in (" . $category_ids . ") ";
      
        } else {
          $raw_query_where .= " and p2c.categories_id = '" . $this->current_category_id . "' ";
        }
      } // if ($this->current_category_id
      
      $raw_query_addon_array = vam_get_filter_sql ($filter_class, $specifications_id, $specification, $products_column_name, '1');

      $raw_query_from .= $raw_query_addon_array['from'];
      $raw_query_where .= $raw_query_addon_array['where'];

      $applied_filters = $this->getAppliedFilters();

      foreach ($applied_filters as $k => $v) {
        if ($k == $specifications_id) {
          continue;
        }

        $specs_array = $this->getSpecification($k);

        $raw_query_addon_array = vam_get_filter_sql ($specs_array['filter_class'], $specs_array['specifications_id'], $v, $specs_array['products_column_name'], $this->languages_id);

        $raw_query_from .= $raw_query_addon_array['from'];
        $raw_query_where .= $raw_query_addon_array['where'];
      } // foreach($applied_filters

      $raw_query = $raw_query_start . $raw_query_from . $raw_query_where;
      //print 'Raw Query: ' . $raw_query . '<br>';
      
      $filter_count_query = vam_db_query ($raw_query);
      $filter_count_results = vam_db_fetch_array ($filter_count_query);

      $count = (string) $filter_count_results['count'];

      return $count;
    }

    function getSpecification ($id) {
      if (!isset ($this->specs[$id]) ) {
        $specs_query_raw = "SELECT
                              s.specifications_id,
                              s.products_column_name,
                              s.filter_class,
                              s.filter_show_all,
                              s.filter_display,
                              sd.specification_name,
                              sd.specification_prefix,
                              sd.specification_suffix
                            FROM
                              " . TABLE_SPECIFICATION . " s
                            JOIN " . TABLE_SPECIFICATION_DESCRIPTION . " sd
                              ON s.specifications_id = sd.specifications_id
                            JOIN " . TABLE_SPECIFICATION_GROUPS . " sg
                              ON s.specification_group_id = sg.specification_group_id
                            JOIN " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c
                              ON sg.specification_group_id = s2c.specification_group_id
                            WHERE
                              s.specifications_id = '" . $id . "'
                              and s.show_filter = 'True'
                              and sg.show_filter = 'True'
                              and sd.language_id = '" . $this->languages_id . "'
                              and s2c.categories_id = '" . $this->current_category_id . "'
                           ";
        $specs_query = vam_db_query ($specs_query_raw);

        $this->specs[$id] = vam_db_fetch_array ($specs_query);
      }

      return $this->specs[$id];
    }
  }

?>