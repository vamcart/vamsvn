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
                        from " . TABLE_SPECIFICATION . " s,
                             " . TABLE_SPECIFICATION_DESCRIPTION . " sd,
                             " . TABLE_SPECIFICATION_GROUPS . " sg,
                             " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c
                        where s.specification_group_id = sg.specification_group_id
                          and sg.specification_group_id = s2c.specification_group_id
                          and sd.specifications_id = s.specifications_id
                          and s2c.categories_id = '" . $current_category_id . "'
                          and s.show_filter = 'True'
                          and sg.show_filter = 'True'
                          and sd.language_id = '" . $_SESSION['languages_id'] . "'
                        order by s.specification_sort_order,
                                 sd.specification_name
                      ";
    // print $specs_query_raw . "<br>\n";
    $specs_query = vamDBquery ($specs_query_raw);

    $first = true;
    while ($specs_array = vam_db_fetch_array ($specs_query, true) ) {
    $box_text .= '<div class="filter">';
      // Retrieve the GET vars, sanitize, and assign to variables
      // Variable names are the letter "f" followed by the specifications_id for that spec.
      $var = 'f' . $specs_array['specifications_id'];
      $$var = '0';
      if (isset ($_GET[$var]) && $_GET[$var] != '') {
        // Decode the URL-encoded names, including arrays
        $$var = vam_decode_recursive ($_GET[$var]);
      
        // Sanitize variables to prevent hacking
        $$var = vam_clean_get__recursive ($$var);
        
        // Get rid of extra values if Select All is selected
        $$var = vam_select_all_override ($$var);
      }
      
      $filters_query_raw = "select sf.specification_filters_id,
                                   sfd.filter
                            from " . TABLE_SPECIFICATIONS_FILTERS . " sf,
                                 " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " sfd
                            where sfd.specification_filters_id = sf.specification_filters_id
                              and sf.specifications_id = '" . (int) $specs_array['specifications_id'] . "'
                              and sfd.language_id = '" . $_SESSION['languages_id'] . "'
                            order by sf.filter_sort_order,
                                     sfd.filter
                           ";
      // print $filters_query_raw . "<br>\n";
      $filters_query = vamDBquery ($filters_query_raw);
      
      $count_filters = vam_db_num_rows ($filters_query, true);
      $filters_select_array = array();
      if ($count_filters >= SPECIFICATIONS_FILTER_MINIMUM) {
        $filters_array = array();
        if ($first == false) {
          //$box_text .=  "<br />\n";        
        }
        $first = false;
        
        if (isset ($_GET[$var]) && $_GET[$var] != '') {
        $box_text .=  '<b>' . $specs_array['specification_name'] . '</b> <a href="'.vam_href_link (FILENAME_PRODUCTS_FILTERS, vam_get_all_get_params (array ('f' . $specs_array['specifications_id']) ) ).'"><span class="filter-close circle text-danger cart_delete"><i class="fas fa-times"></i></span></a><br />';
        } else {
        $box_text .=  '<b>' . $specs_array['specification_name'] . '</b><br />';
        }

        $filter_index = 0;
        if ($specs_array['filter_show_all'] == 'True') {
          $count = 1;
          if (SPECIFICATION_FILTER_NO_RESULT != 'normal' || SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            // Filter ID is set to 0 so no filter will be applied
            $count = $spec_object->getFilterCount ('0', $specs_array['specifications_id'], $specs_array['filter_class'], $specs_array['products_column_name']);
          }
          // The ID value must be set as a string, not an integer
          $filters_select_array[$filter_index] = array ('id' => '0',
                                                        'text' => TEXT_SHOW_ALL,
                                                        'count' => $count
                                                       );
          $filter_index++;
        }
        
        $previous_filter = 0;
        $previous_filter_id = 0;
        while ($filters_array = vam_db_fetch_array ($filters_query, true) ) {
          $filter_id = $filters_array['filter'];

          if ($specs_array['products_column_name'] == 'products_price' || $specs_array['products_column_name'] == 'final_price') {
            //$previous_filter = $currencies->format ($previous_filter);
            //$filter_text = $currencies->format ($filters_array['filter']);
            $previous_filter = $previous_filter;
            $filter_text = $filters_array['filter'];
          } else {
            $filter_text = $specs_array['specification_prefix'] . ' ' . $filters_array['filter'] . ' ' . $specs_array['specification_suffix'];
          }
          
          if ($specs_array['filter_class'] == 'range') {
            $filter_text = $previous_filter . ' - ' . $filter_text;
            $filter_id = $previous_filter_id . '-' . $filters_array['filter'];
            
            $previous_filter = $filters_array['filter'];
            $previous_filter_id = $filters_array['filter'];
          }

          $count = 1;
          if (SPECIFICATION_FILTER_NO_RESULT != 'normal' || SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            $count = $spec_object->getFilterCount ($filter_id, $specs_array['specifications_id'], $specs_array['filter_class'], $specs_array['products_column_name']);
          }

          $filters_select_array[$filter_index] = array ('id' => ($filter_id),
                                                        'text' => $filter_text,
                                                        'count' => $count
                                                       );
          $filter_index++;
        } // while ($filters_array

        // For range class only, create a filter for maximum value +
        if ($specs_array['filter_class'] == 'range') {
          if ($specs_array['products_column_name'] == 'products_price' || $specs_array['products_column_name'] == 'final_price') {
            //$previous_filter = $currencies->format ($previous_filter);
            $previous_filter = $previous_filter;
          }

          $count = 1;
          if (SPECIFICATION_FILTER_NO_RESULT != 'normal' || SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            $count = $spec_object->getFilterCount ($previous_filter_id, $specs_array['specifications_id'], $specs_array['filter_class'], $specs_array['products_column_name']);
          }
//          $filters_select_array[$filter_index] = array ('id' => rawurlencode ($previous_filter_id),
          $filters_select_array[$filter_index] = array ('id' =>  ($previous_filter_id),
                                                        'text' => $previous_filter . '+',
                                                        'count' => $count
                                                       );
        } // if ($specs_array['filter_class'] == 'range'

        $box_text .= vam_get_filter_string ($specs_array['filter_display'], $filters_select_array, FILENAME_PRODUCTS_FILTERS, $var, $$var);
      } // if ($count_filters
    $box_text .= '</div>';
    } // while ($specs_array
    $box_text .= '<div class="clear"></div>';
  
if (vam_db_num_rows ($specs_query, true) > 0) {  
	$module->assign('FILTERS', $box_text);
  }
 }
?>