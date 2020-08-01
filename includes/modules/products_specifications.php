<?php
/*
  $Id: products_specifications.php, v1.0.1 20120917 kymation Exp $
  $Loc: catalog/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

/*
 * This file produces the product specification list on the Product Info page.
 * 
 * $current_category_id and $_GET['products_id'] are required to determine which
 * specifications to show.
 */
  
  (!isset($_GET['products_id'])) ? $_GET['products_id'] = $product->data['products_id'] : $_GET['products_id'];
  
  $categories_query_raw = "select  sg.specification_group_id, 
                                   sg.specification_group_name, 
                                   sg.show_products
                             from " . TABLE_SPECIFICATION_GROUPS . " sg,
                                  " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
                             where sg.show_products = 'True'
                               and sg.specification_group_id = sg2c.specification_group_id
                               and sg2c.categories_id = '" . (int) $current_category_id . "' ORDER BY sg.specification_group_name
                            ";
  $categories_query = vamDBquery ($categories_query_raw);
  $count_categories = vam_db_num_rows ($categories_query, true);

  if ($count_categories > 0) {
  //print $count_categories . "<br>\n";
  
    
  $row = 0;
  $col = 0;    

  $specifications_data = array();
    
  while ($categories_data = vam_db_fetch_array ($categories_query, true) ) {    
    

 // print $categories_data['specification_group_id'] . "<br>\n";
 //   print $categories_data['specification_group_name'] . "<br>\n";
 //   print $categories_data['show_products'] . "<br>\n";
  
   
  $specifications_query_raw = "select ps.specification, 
                                      s.filter_display,
                                      s.enter_values,
                                      sd.specification_name, 
                                      sd.specification_prefix, 
                                      sd.specification_suffix,
                                      s.specification_group_id,
                                      sg.specification_group_name                                      
                               from " . TABLE_PRODUCTS_SPECIFICATIONS . " ps, 
                                    " . TABLE_SPECIFICATION . " s, 
                                    " . TABLE_SPECIFICATION_DESCRIPTION . " sd, 
                                    " . TABLE_SPECIFICATION_GROUPS . " sg,
                                    " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
                               where sg.show_products = 'True'
                                 and s.show_products = 'True'
                                 and s.specification_group_id = sg.specification_group_id 
                                 and sg.specification_group_id = sg2c.specification_group_id
                                 and sg.specification_group_id = '" . (int) $categories_data['specification_group_id'] . "' 
                                 and sd.specifications_id = s.specifications_id
                                 and ps.specifications_id = sd.specifications_id
                                 and sg2c.categories_id = '" . (int) $current_category_id . "' 
                                 and ps.products_id = '" . (int) $_GET['products_id'] . "' 
                                 and sd.language_id = '" . (int) $_SESSION['languages_id'] . "' 
                                 and ps.language_id = '" . (int) $_SESSION['languages_id'] . "' 
                               order by s.specification_sort_order, 
                                        sd.specification_name
                             ";
   
  $specifications_query = vamDBquery ($specifications_query_raw);
    //   print $specifications_query_raw . "<br>\n"; 

  
  $count_specificatons = vam_db_num_rows ($specifications_query,true);

  $info->assign('specifications', false);

  //print $count_specificatons . "<br>\n";
   if ($count_specificatons > 0) {

  $info->assign('specifications', true);

		$specifications_data[$row] = array (
		
			'GROUP_NAME' => $categories_data['specification_group_name'],
			//'DATA' => ''
		
		);
		
$col = 0;		
		
    while ($specifications = vam_db_fetch_array ($specifications_query, true) ) {
      if ($specifications['specification'] != '') {
      
        if (SPECIFICATIONS_SHOW_NAME_PRODUCTS == 'True') {
          $specification_text = $specifications['specification_name'];
        }
      
        $specification_text .= $specifications['specification_prefix'];
                      
        if ($specifications['display'] == 'image' || $specifications['display'] == 'multiimage' || $specifications['filter_display'] == 'multiimage' || $specifications['enter'] == 'image' || $specifications['enter'] == 'multiimage') { 
          $specification_text = vam_image (DIR_WS_IMAGES . $specifications['specification'], $specifications['specification_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
        } else {
          $specification_text = $specifications['specification'] . ' ';
        }

        $specification_text .= $specifications['specification_suffix'];

        
      } // if ($specifications['specification']


            //$specifications_data[$row]['DATA'] = array();
            
				$specifications_data[$row]['DATA'][$col] = array (
				
					'NAME' => $specifications['specification_name'], 
					//'VALUE' => (!empty($specifications['specification_prefix']) ? $specifications['specification_prefix'].' ' : '').$specifications['specification'].(!empty($specifications['specification_suffix']) ? ' '.$specifications['specification_suffix'] : '')
					'VALUE' => $specification_text
			
				);
				
			
			$col ++;
      

    } // while ($specifications

			$row ++;

    }
   }
   
//echo var_dump($specifications_data);

  $info->assign('specifications_count', $col);
  $info->assign('specifications_data', $specifications_data);
    
   } 
    
?>