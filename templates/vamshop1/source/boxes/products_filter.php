<?php
/* -----------------------------------------------------------------------------------------
   $Id: infobox.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (infobox.php,v 1.7 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (infobox.php,v 1.7 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Loginbox V1.0        	Aubrey Kilian <aubrey@mycon.co.za>

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
$box = new vamTemplate;
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
$box_content='';

	require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');
    
  require_once (DIR_WS_CLASSES  . 'specifications.php');
  $spec_object = new Specifications();
    
  if (SPECIFICATIONS_FILTERS_BOX == 'True') {
    $box_text =  ''; //HTML string goes into the text part of the box
    $get_category = '';
    
    if (strstr($PHP_SELF, FILENAME_DEFAULT) && !isset($_GET['cat'])) {
     
    $specs_query_raw = "select distinct s.specifications_id,
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
                          and s.show_filter = 'True'
                          and s.show_filter_mainpage = 'True'
                          and sg.show_filter = 'True'
                          and sd.language_id = '" . $_SESSION['languages_id'] . "'
                        order by s.specification_sort_order,
                                 sd.specification_name
                      "; 
                                           
	} else {

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
                      		
	}                      
                      
    // print $specs_query_raw . "<br>\n";
    $specs_query = vamDBquery ($specs_query_raw);

    $first = true;
    while ($specs_array = vam_db_fetch_array ($specs_query, true) ) {
      // Retrieve the GET vars, sanitize, and assign to variables
      // Variable names are the letter "f" followed by the specifications_id for that spec.
      $var = 'f' . $specs_array['specifications_id'];
      $$var = '0';
      if (isset ($_GET[$var]) && $_GET[$var] != '') {
        // Decode the URL-encoded names, including arrays
        $$var = vam_decode_recursive ($_GET[$var]);
      
        // Sanitize variables to prevent hacking
        $$var = vam_clean_get__recursive ($_GET[$var]);
        
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
          $box_text .=  "<br>\n";        
        }
        $first = false;
        
        if (isset ($_GET[$var]) && $_GET[$var] != '') {
        $box_text .=  '<b>' . $specs_array['specification_name'] . '</b> <a href="'.vam_href_link (FILENAME_PRODUCTS_FILTERS, vam_get_all_get_params (array ('f' . $specs_array['specifications_id']) ) ).'"><span class="close-box">[X]</span></a><br /><br />';
        } else {
        $box_text .=  '<b>' . $specs_array['specification_name'] . '</b><br /><br />';
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
    } // while ($specs_array
if (vam_db_num_rows ($specs_query, true) > 0) {

    $box->assign('BOX_CONTENT', $box_text);
	$box->assign('language', $_SESSION['language']);
       	  // set cache ID
  if (!CacheCheck()) {
  $box->caching = 0;
  $box_infobox= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_products_filter.html');
  } else {
  $box->caching = 0;
  $box->cache_lifetime=CACHE_LIFETIME;
  $box->cache_modified_check=CACHE_CHECK;
  $cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'];
  $box_infobox= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_products_filter.html',$cache_id);
  }
    
    $vamTemplate->assign('box_FILTERS',$box_infobox);

  }
 }

    ?>