<?php
/*
  $Id: products_filter.php, v1.0.1 20110917 kymation Exp $
  $Loc: catalog/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');

  require_once (DIR_WS_CLASSES  . 'specifications.php');
  $spec_object = new Specifications();

  if (SPECIFICATIONS_FILTERS_MODULE == 'True') {
    $box_text =  ''; //HTML string goes into the text part of the box

    $specs_query_raw = "select s.specifications_id,
                               s.products_column_name,
                               s.filter_class,
                               s.filter_show_all,
                               s.filter_display,
                               sd.specification_name,
                               sd.specification_prefix,
                               sd.specification_suffix
                        from " . TABLE_SPECIFICATION . " s
                          INNER JOIN " . TABLE_SPECIFICATION_DESCRIPTION . " sd ON (sd.specifications_id = s.specifications_id AND sd.language_id = " . (int)$_SESSION['languages_id'] . "),
                             " . TABLE_SPECIFICATION_GROUPS . " sg,
                             " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c
                        where s.specification_group_id = sg.specification_group_id
                          and sg.specification_group_id = s2c.specification_group_id                          
                          and s2c.categories_id = " . (int)$current_category_id . "
                          and s.show_filter = 'True'
                          and sg.show_filter = 'True'                          
                        order by s.specification_sort_order,
                                 sd.specification_name
                      ";
    // print $specs_query_raw . "<br>\n";
    $specs_query = vamDBquery($specs_query_raw);

    $first = true;
    while ($specification = vam_db_fetch_array($specs_query, true) ) {
    $box_text .= '<div class="filter">';
      // Retrieve the GET vars, sanitize, and assign to variables
      // Variable names are the letter "f" followed by the specifications_id for that spec.
      $var = 'f' . $specification['specifications_id'];
      $$var = '0';
      if (isset ($_GET[$var]) && $_GET[$var] != '') {
        // Decode the URL-encoded names, including arrays
        $$var = vam_decode_recursive($_GET[$var]);

        // Sanitize variables to prevent hacking
//        $$var = vam_clean_get__recursive($$var);

        // Get rid of extra values if Select All is selected
        $$var = vam_select_all_override($$var);
      }
      
      if ($specification['products_column_name'] == 'manufacturers_id') {
        $subcategories_array = array($current_category_id);
        if (SPECIFICATIONS_FILTER_SUBCATEGORIES == 'True') {
          vam_get_subcategories($subcategories_array, $current_category_id);
        }
        $filters_query_raw = "SELECT m.manufacturers_id as specification_filters_id,
                                     m.manufacturers_name as filter
                              FROM " . TABLE_PRODUCTS . " p,
                                   " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c,
                                   " . TABLE_MANUFACTURERS . " m
                              WHERE p.products_status = 1
                               /* AND p.products_quantity > 0 */
                                AND p.manufacturers_id = m.manufacturers_id
                                AND p.products_id = p2c.products_id
                                AND p2c.categories_id in (" . implode(',', $subcategories_array) . ")
                              GROUP BY p.manufacturers_id
                              ORDER BY m.manufacturers_name";
        $filters_query = vamDBquery($filters_query_raw);
      } else {
        $filters_query_raw = "select sf.specification_filters_id,
                                     sf.filter_sort_order,
                                     sfd.filter
                              from " . TABLE_SPECIFICATIONS_FILTERS . " sf,
                                   " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " sfd
                              where sfd.specification_filters_id = sf.specification_filters_id
                                and sf.specifications_id = " . (int)$specification['specifications_id'] . "
                                and sfd.language_id = " . (int)$_SESSION['languages_id'] . "
                              order by sf.filter_sort_order, sfd.filter";
        $filters_query = vamDBquery($filters_query_raw);
      }     
      
      $count_filters = vam_db_num_rows($filters_query, true);
      $filters_select_array = array();
      if ($count_filters >= SPECIFICATIONS_FILTER_MINIMUM) {
        $filters_array = array();
        if ($first == false) {
          //$box_text .=  "<br />\n";
        }
        $first = false;

        if (isset($_GET[$var]) && $_GET[$var] != '') {
        $box_text .=  '<b>' . $specification['specification_name'] . '</b> <a href="' . vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_all_get_params(array('f' . $specification['specifications_id']) ) ) . '"><span class="close-box">[X]</span></a><br />';
        } else {
        $box_text .=  '<b>' . $specification['specification_name'] . '</b><br />';
        }

        $filter_index = 0;
        if ($specification['filter_show_all'] == 'True') {
          $count = 1;
          if (SPECIFICATION_FILTER_NO_RESULT != 'normal' || SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            // Filter ID is set to 0 so no filter will be applied
            $count = $spec_object->getFilterCount ('0', $specification['specifications_id'], $specification['filter_class'], $specification['products_column_name']);
          }
          // The ID value must be set as a string, not an integer
          $filters_select_array[$filter_index] = array('id' => '0',
                                                        'text' => TEXT_SHOW_ALL,
                                                        'count' => $count
                                                       );
          $filter_index++;
        }

        $previous_filter = 0;
        $previous_filter_id = 0;
        while ($filters_array = vam_db_fetch_array($filters_query, true) ) {
          $filter_id = $filters_array['filter'];

          if ($specification['products_column_name'] == 'products_price' || $specification['products_column_name'] == 'final_price') {
            //$previous_filter = $currencies->format ($previous_filter);
            //$filter_text = $currencies->format ($filters_array['filter']);
            $previous_filter = $previous_filter;
            $filter_text = $filters_array['filter'];
          } else {
            $filter_text = $specification['specification_prefix'] . ' ' . $filters_array['filter'] . ' ' . $specification['specification_suffix'];
          }
// BOF use filter_id
          if ($specification['filter_class'] != 'range') {
            $filter_id = $filters_array['specification_filters_id'];
          }
// EOF use filter_id

          if ($specification['filter_class'] == 'range') {
            $filter_text = $previous_filter . ' - ' . $filter_text;
            $filter_id = $previous_filter_id . '-' . $filters_array['filter'];

            $previous_filter = $filters_array['filter'];
            $previous_filter_id = $filters_array['filter'];
          }

          $count = 1;
          if (SPECIFICATION_FILTER_NO_RESULT != 'normal' || SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            $count = $spec_object->getFilterCount($filter_id, $specification['specifications_id'], $specification['filter_class'], $specification['products_column_name']);
          }

          $filters_select_array[$filter_index] = array('id' => urlencode($filter_id),
                                                        'text' => $filter_text,
                                                        'count' => $count
                                                       );
          $filter_index++;
        } // while ($filters_array

        // For range class only, create a filter for maximum value +
        if ($specification['filter_class'] == 'range') {
          if ($specification['products_column_name'] == 'products_price' || $specification['products_column_name'] == 'final_price') {
            //$previous_filter = $currencies->format ($previous_filter);
            $previous_filter = $previous_filter;
          }

          $count = 1;
          if (SPECIFICATION_FILTER_NO_RESULT != 'normal' || SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            $count = $spec_object->getFilterCount ($previous_filter_id, $specification['specifications_id'], $specification['filter_class'], $specification['products_column_name']);
          }
//          $filters_select_array[$filter_index] = array('id' => rawurlencode ($previous_filter_id),
          $filters_select_array[$filter_index] = array('id' =>  ($previous_filter_id),
                                                        'text' => $previous_filter . '+',
                                                        'count' => $count
                                                       );
        } // if ($specification['filter_class'] == 'range'

// BOF products_filters-multilinks
//      $box_text .= vam_get_filter_string($specification['filter_display'], $filters_select_array, FILENAME_PRODUCTS_FILTERS, $var, $$var);
        $box_text .= vam_get_filter_string($specification['filter_display'], $filters_select_array, FILENAME_PRODUCTS_FILTERS, $var, $$var, $specification['filter_class']);
// EOF products_filters-multilinks
      } // if ($count_filters
    $box_text .= '</div>';
    } // while ($specification
    $box_text .= '<div class="clear"></div>';

if (vam_db_num_rows($specs_query, true) > 0) {
	$module->assign('FILTERS', $box_text);
  }
 }
