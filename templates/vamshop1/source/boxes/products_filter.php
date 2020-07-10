<?php
// shaklov изменено оформление
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
// BOF products_filters-sort
// BOF products_filters-slider
// BOF products_filters-multilinks
// BOF crowd_filter
// BOF specifications_filters_hide_empty_filters_group

$box = new vamTemplate;
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
$box_content='';

require_once(DIR_FS_INC . 'vam_get_subcategories.inc.php');

require_once(DIR_WS_FUNCTIONS . 'products_specifications.php');

require_once(DIR_WS_CLASSES  . 'specifications.php');
$spec_object = new Specifications();

if (SPECIFICATIONS_FILTERS_BOX == 'True') {
  $box_text =  ''; //HTML string goes into the text part of the box
  $get_category = '';

	   	// Cache Roma
		// file life time
		//$cache_expire = DB_CACHE_EXPIRE; // 24 hours

		//$cache_file = DIR_FS_DOCUMENT_ROOT.'cache_filter_box/'.md5($_SERVER['REQUEST_URI']).'.box';
		//$gzcache_file = DIR_FS_DOCUMENT_ROOT.'cache_filter_box/'.md5($_SERVER['REQUEST_URI']).'.gz';

		
    //if (file_exists($cache_file) && filemtime($cache_file) > (time() - $cache_expire)) {

     // get cached resulst
        //$box_text = unserialize(implode('',file($cache_file)));

//echo 'test1';

        //} elseif (file_exists($gzcache_file) && filemtime($gzcache_file) > (time() - $cache_expire)) {

//echo 'test2';

		// get GZIP cached resulst
        //$box_text = unserialize(implode('',gzfile($gzcache_file)));

	//}	else {

//echo 'test3';

	//ob_start();		



  if (strstr($PHP_SELF, FILENAME_DEFAULT) && !isset($_GET['cat'])) {

    $specification_query_raw = "select distinct s.specifications_id,
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
                          and s.show_filter_mainpage = 'True'
                          and s.show_filter = 'True'
                          and sg.show_filter = 'True'
                        order by s.specification_sort_order,
                                 sd.specification_name";

	} else {

    $specification_query_raw = "select s.specifications_id,
                               s.products_column_name,
                               s.filter_class,
                               s.filter_show_all,
                               s.filter_display,
                               s.specification_group_id,
                               sd.specification_name,
                               sd.specification_prefix,
                               sd.specification_suffix
                        from " . TABLE_SPECIFICATION . " s
                          INNER JOIN " . TABLE_SPECIFICATION_DESCRIPTION . " sd ON (sd.specifications_id = s.specifications_id AND sd.language_id = " . (int)$_SESSION['languages_id'] . "),
                             " . TABLE_SPECIFICATION_GROUPS . " sg,
                             " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c
                        where s.specification_group_id = sg.specification_group_id
                          and sg.specification_group_id = s2c.specification_group_id
                          and s2c.categories_id = '" . (int)$current_category_id . "'
                          and s.show_filter = 'True'
                          and sg.show_filter = 'True'
                        order by s.specification_sort_order,
                                 sd.specification_name";

	}
//echo $specification_query_raw;
  $specification_query = vamDBquery($specification_query_raw);
//print_r($specification_query);
  $first = true;
  while ($specification = vam_db_fetch_array($specification_query, true)) { 
  //$specificationJN=json_encode($specification);  $specificationJN=json_decode($specificationJN, true);print_r($specificationJN);
//    error_log(__LINE__ . ': ' . ' $specification=' . var_export($specification, true) . "\n", 3, __FILE__.'.log');
    if ($specification['filter_class'] == 'range' && $specification['filter_display'] == 'slider') {
//        $specification['filter_class'] = 'slider';
    }
    // Retrieve the GET vars, sanitize, and assign to variables
    // Variable names are the letter "f" followed by the specifications_id for that spec.
    $var = 'f' . $specification['specifications_id'];
    $$var = '0';
    if (isset($_GET[$var]) && $_GET[$var] != '') {
      // Decode the URL-encoded names, including arrays
      $$var = vam_decode_recursive($_GET[$var]);

      // Sanitize variables to prevent hacking
//    $$var = vam_clean_get__recursive($_GET[$var]);
// BOF products_filters-slider
      if ($specification['filter_display'] == 'slider' && is_array($_GET[$var])) {
        $$var = implode('-', $_GET[$var]);
      }
// EOF products_filters-slider

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
                              /* AND p2c.categories_id = " . $current_category_id . " */
                            GROUP BY p.manufacturers_id
                            ORDER BY m.manufacturers_name";
      $filters_query = vamDBquery($filters_query_raw);
    } else {
      $filters_query_raw = "select sf.specification_filters_id,
                                   sf.filter_sort_order,
                                   sfd.filter
                            from " . TABLE_SPECIFICATIONS_FILTERS . " sf
                              inner join " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " sfd on (sfd.specification_filters_id = sf.specification_filters_id and sfd.language_id = " . (int)$_SESSION['languages_id'] . ")
                            where sf.specifications_id = " . (int)$specification['specifications_id'] . "
                            order by sf.filter_sort_order, sfd.filter";
//error_log(__LINE__ . ': ' . ' $specification=' . var_export($specification, true) . "\n", 3, __FILE__.'.log');
//error_log(__LINE__ . ': ' . ' $filters_query_raw=' . var_export($filters_query_raw, true) . "\n", 3, __FILE__.'.log');
      $filters_query = vamDBquery($filters_query_raw);
    }
    $count_filters = vam_db_num_rows($filters_query, true);
//error_log(__LINE__ . ': ' . ' $count_filters=' . var_export($count_filters, true) . "\n", 3, __FILE__.'.log');
    $filters_select_array = array();//echo $filters_query_raw." ||| ";
    if ($count_filters >= SPECIFICATIONS_FILTER_MINIMUM) {
      $filters_array = array();
      //if ($first == false) {
      //  $box_text .=  "<br>\n";
      //}
      $first = false;

// BOF specifications_filters_hide_empty_filters_group
      $box_head = '';
      if (isset($_GET[$var]) && $_GET[$var] != '') {
        //$box_head .= '<div class="list-radio">' . '<div class="list-radio-title-wrap filtered">' . '<h4 class="list-radio-title">' . $specification['specification_name'] . '</h4>' . '<a rel="nofollow" href="' . vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_all_get_params(array('f' . $specification['specifications_id']))) . '">' . '<span class="close">[X]</span>' . '</a>' . '</div>';
        

$box_head .= '

<div class="filter-box">
    <div class="method-title"><span class="title">'.$specification['specification_name'].'<a class="circle text-danger" title="'.TEXT_COOKIE_CLOSE.'" rel="nofollow" href="' . vam_href_link(FILENAME_PRODUCTS_FILTERS, vam_get_all_get_params(array('f' . $specification['specifications_id']))) . '">' . '<i class="fa fa-times"></i>' . '</a>' . '</div>
  <div class="filter-body text-left">

';
        
      } else {
        //$box_head .= '<div class="list-radio">' . '<div class="list-radio-title-wrap">' . '<h4 class="list-radio-title disabled">' . $specification['specification_name'] . '</h4>' . '</div>';

$box_head .= '

<div class="filter-box">
    <div class="method-title"><span class="title">'.$specification['specification_name'].'</span></div>
  <div class="filter-body text-left">

';


      }
      //$box_text .= '<div class="clear"></div>';
// EOF specifications_filters_hide_empty_filters_group


      $filter_index = 0;
      if ($specification['filter_show_all'] == 'True') {
        $count = 1;
        if (SPECIFICATION_FILTER_NO_RESULT != 'normal' || SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
        	
        	
      //$cat_path = explode('_', $_GET['cPath']);
      //echo '::'.$_GET['cPath']. var_dump($cat_path);
      
      //if ($cat_path[0] == 62 or $cat_path[1] != '' or $cat_path[2] != '' or $cat_path[3] != '' or $cat_path[4] != '' or $cat_path[5] != '') {
        	
          // Filter ID is set to 0 so no filter will be applied
          $count = $spec_object->getFilterCount('0', $specification['specifications_id'], $specification['filter_class'], $specification['products_column_name']);
          
      //}
      
        }
        // The ID value must be set as a string, not an integer
        $filters_select_array[$filter_index] = array('id' => '0',
                                                     'text' => TEXT_SHOW_ALL,
                                                     'count' => $count,
                                                     );
        $filter_index++;
      }

//      $previous_filter = 0;
//      $previous_filter_id = 0;
      unset($previous_filter);
      unset($previous_filter_id);
      while ($filters_array = vam_db_fetch_array($filters_query, true)) {
// BOF products_filters-slider
//error_log(__LINE__ . ': ' . ' $filters_array=' . var_export($filters_array, true) . "\n", 3, __FILE__.'.log');
        unset($filter_text);
        unset($filter_id);
        if ($specification['filter_display'] == 'slider' && $specification['products_column_name'] != '') {
//          $raw_query_start = "select count(distinct p.products_id) as count ";
          $raw_query_from = '';
          $raw_query_where = '';
          $raw_query_addon_array = $spec_object->getAllFilterSQL(0, $specification['specifications_id'], $specification['filter_class'], $specification['products_column_name']);
          $raw_query_from .= $raw_query_addon_array['from'];
          $raw_query_where .= $raw_query_addon_array['where'];
//          $raw_query = $raw_query_start . $raw_query_from . $raw_query_where;
          if ($specification['products_column_name'] == 'products_price' || $specification['products_column_name'] == 'final_price') {
            unset($products_function_sql);
            if ($filters_array['filter'] == 'min()' || $filters_array['filter'] == 'max()') {
              $function = $filters_array['filter'];
              $function = str_replace(array('(', ')'), '', $function);
            }
            if ($specification['products_column_name'] == 'products_price') {
              $products_function_sql = "SELECT " . $function . "(" . $specification['products_column_name'] . ") AS filter" . "\n" .
                                        $raw_query_from . "\n" .
                                        $raw_query_where;
            }
            if ($specification['products_column_name'] == 'final_price') {
              $products_function_sql = "SELECT IF(s.status, s.specials_new_products_price, p.products_price) AS filter" . "\n" .
                                        $raw_query_from . "\n" .
                                        "LEFT JOIN " . TABLE_SPECIALS . " s ON p.products_id = s.products_id" . "\n" .
                                        $raw_query_where . "\n" .
                                        "ORDER BY filter " . ($function == 'min' ? "ASC" : "DESC") . "\n" .
                                        "LIMIT 1";
            }
			
            if (!empty($products_function_sql)) {
              $products_function_query = vamDBquery($products_function_sql);
              $products_function = vam_db_fetch_array($products_function_query, true);
              if ($specification['products_column_name'] == 'products_price' || $specification['products_column_name'] == 'final_price') {
                $products_function['filter'] = number_format($products_function['filter'], $vamPrice->currencies['RUB']['decimal_places'], $vamPrice->currencies['RUB']['decimal_point'], $vamPrice->currencies['RUB']['thousands_point']);
              }
              $filters_array['filter'] = $products_function['filter'];
            }
          }
        }
// EOF products_filters-slider
//error_log(__LINE__ . ': ' . ' $filters_array=' . var_export($filters_array, true) . "\n", 3, __FILE__.'.log');
        $filter_id = $filters_array['filter'];

        if ($specification['products_column_name'] == 'products_price' || $specification['products_column_name'] == 'final_price') {
          //$previous_filter = $currencies->format($previous_filter);
          //$filter_text = $currencies->format($filters_array['filter']);
//          $previous_filter = $previous_filter;
//          $filter_text = $filters_array['filter'];
        } else {
          $filter_text = $specification['specification_prefix'] . ' ' . trim($filters_array['filter']) . ' ' . $specification['specification_suffix'];
        }
 // BOF use filter_id
        if ($specification['filter_class'] != 'range') {
          $filter_id = $filters_array['specification_filters_id'];
        }
// EOF use filter_id

        if ($specification['filter_class'] == 'range') {
          if ($specification['filter_display'] == 'slider') {
            if (!isset($previous_filter)) {
              $previous_filter = $filters_array['filter'];
              $previous_filter_id = $filters_array['filter'];
            } else {
              $filter_text = $previous_filter . ' - ' . $filters_array['filter'];
              $filter_id = $previous_filter_id . '-' . $filters_array['filter'];
            }
          } else {
            if (!isset($previous_filter)) {
              $previous_filter = 0;
              $previous_filter_id = 0;
            }
            $filter_text = $previous_filter . ' - ' . $filters_array['filter'];
            $filter_id = $previous_filter_id . '-' . $filters_array['filter'];

            $previous_filter = $filters_array['filter'];
            $previous_filter_id = $filters_array['filter'];
          }
        }

        if (isset($filter_text)) {
          $count = 1;
          if (SPECIFICATION_FILTER_NO_RESULT != 'normal' || SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
            $uri = $_SERVER['REQUEST_URI'];
            if (strpos($uri, '.html') !== false || strpos($uri, 'products_filter') !== false) {

      //$cat_path = explode('_', $_GET['cPath']);
      //echo '::'.$_GET['cPath']. var_dump($cat_path);
      
      //if ($cat_path[0] == 62 or $cat_path[1] != '' or $cat_path[2] != '' or $cat_path[3] != '' or $cat_path[4] != '' or $cat_path[5] != '') {
      	
              $count = $spec_object->getFilterCount($filter_id, $specification['specifications_id'], $specification['filter_class'], $specification['products_column_name']);
              
      //}
              
//echo "<br />filter_id:".$filter_id."<br />specifications_id:".$specification['specifications_id']."<br />filter_class:".$specification['filter_class']."<br />products_column_name:".$specification['products_column_name']."<br /><br />";              
              
            }
          }

          $filters_select_array[$filter_index] = array('id' => urlencode($filter_id),
                                                       'text' => $filter_text,
                                                       'count' => $count,
                                                       'sort' => $filters_array['filter_sort_order'],
                                                       );
          $filter_index++;
        }
      } // while ($filters_array
//error_log(__LINE__ . ': ' . ' $filters_select_array=' . var_export($filters_select_array, true) . "\n", 3, __FILE__.'.log');

      // For range class only, create a filter for maximum value +
      if ($specification['filter_class'] == 'range' && $specification['filter_display'] != 'slider') {
        if ($specification['products_column_name'] == 'products_price' || $specification['products_column_name'] == 'final_price') {
          //$previous_filter = $currencies->format($previous_filter);
          $previous_filter = $previous_filter;
        }

        $count = 1;
        if (SPECIFICATION_FILTER_NO_RESULT != 'normal' || SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
          if (strpos($uri, '.html') !== false || strpos($uri, 'products_filter') !== false) {

      //$cat_path = explode('_', $_GET['cPath']);
      //echo '::'.$_GET['cPath']. var_dump($cat_path);
      
      //if ($cat_path[0] == 62 or $cat_path[1] != '' or $cat_path[2] != '' or $cat_path[3] != '' or $cat_path[4] != '' or $cat_path[5] != '') {

            $count = $spec_object->getFilterCount($previous_filter_id, $specification['specifications_id'], $specification['filter_class'], $specification['products_column_name']);
            
      //}            
            
          }
        }

//        $filters_select_array[$filter_index] = array('id' => rawurlencode($previous_filter_id),
        $filters_select_array[$filter_index] = array('id' =>  ($previous_filter_id),
                                                     'text' => $previous_filter . '+',
                                                     'count' => $count,
                                                     );
      } // if ($specification['filter_class'] == 'range'

// BOF products_filters-sort
      if (in_array($specification['filter_class'], array('exact', 'multiple', ))) {
        $filters_select_array = filters_array_sort($specification['specifications_id'], $filters_select_array);
/*
          foreach ($filters_select_array as $i => $fsa_row) {
            $filters_select_array[$i]['text'] = '[' . $filters_select_array[$i]['sort'] . '] ' . $filters_select_array[$i]['text'];
          }
*/
// BOF specifications_filters_hide_empty_filters_group
if ($specs_array['products_column_name'] == 'manufacturers_id') {
//  error_log(var_export($filters_select_array, true) . "\n", 3, __FILE__.'.log');
}
        foreach ($filters_select_array as $i => $fsa_row) {
          if ($fsa_row['count'] == 0) {
            unset($filters_select_array[$i]);
          }
        }
// EOF specifications_filters_hide_empty_filters_group
      }
// EOF products_filters-sort
// BOF products_filters-multilinks
//      $box_text .= vam_get_filter_string($specification['filter_display'], $filters_select_array, FILENAME_PRODUCTS_FILTERS, $var, $$var) . '</div>';
// BOF specifications_filters_hide_empty_filters_group
      if (!in_array($specification['filter_class'], array('exact', 'multiple', )) || count($filters_select_array) > 1 || SPECIFICATIONS_FILTERS_HIDE_EMPTY_FILTERS_GROUP == 'False') {
        $box_text .= $box_head;
        $box_text .= vam_get_filter_string($specification['filter_display'], $filters_select_array, FILENAME_PRODUCTS_FILTERS, $var, $$var, $specification['filter_class']);
        $box_text .= '

</div>
</div>        
        
        ';
        
      }
// EOF specifications_filters_hide_empty_filters_group

//error_log(__LINE__ . ': ' . ' $filters_select_array=' . var_export($filters_select_array, true) . "\n", 3, __FILE__.'.log');
// EOF products_filters-multilinks
    } // if ($count_filters
  } // while ($specification
//    error_log(__LINE__.': '.'$box_text='.var_export($box_text, true) . "\n", 3, __FILE__.'.log');


	// Write the output to cache and echo them	
	//$output = @ob_get_contents();
	//ob_end_clean();	    
	
	
     //if (file_exists($cache_file)) @unlink($cache_file);
     //if (file_exists($gzcache_file)) @unlink($gzcache_file);

        // safe result into file.		
		//$stream = serialize($box_text);

		//if (strlen($stream) > 300) {
		//$fp2 = gzopen ($gzcache_file, 'w6');
		//gzwrite ($fp2, $stream);
		//gzclose($fp2);
		//} else {			
		//$fp = fopen($cache_file,"w");
        //fwrite($fp, $stream);
        //fclose($fp);
		//}	
    
    //}

  if (vam_db_num_rows($specification_query, true) > 0) {

    $box->assign('BOX_CONTENT', $box_text);
    $box->assign('language', $_SESSION['language']);
    // set cache ID
    if (!CacheCheck()) {
      $box->caching = 0;
      $box_infobox= $box->fetch(CURRENT_TEMPLATE . '/boxes/box_products_filter.html');
    } else {
      $box->caching = 1;
      $box->cache_lifetime = CACHE_LIFETIME;
      $box->cache_modified_check = CACHE_CHECK;
      $cache_id = $_SESSION['language'] . $_SESSION['customers_status']['customers_status_id'];
      $box_infobox = $box->fetch(CURRENT_TEMPLATE . '/boxes/box_products_filter.html', $cache_id);
    }

    $vamTemplate->assign('box_FILTERS', $box_infobox);

    // BOF crowd_filter
    //$box_crowd_filter = $box->fetch(CURRENT_TEMPLATE . '/boxes/box_crowd_filter.html');
    //$vamTemplate->assign('box_CROWD_FILTERS', $box_crowd_filter);
// EOF crowd_filter

  }
}

