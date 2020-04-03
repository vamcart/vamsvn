<?php
/*
  $Id: products_specifications_input.php, v 0.9rc4 20090827 kymation Exp $
  $Loc: catalog/admin/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/


?>
        <table border="0" cellspacing="0" cellpadding="0">
<?php

      $specifications_query_raw = "select sd.specifications_id,
                                          sd.specification_name,
                                          sd.specification_description,
                                          s.enter_values
                                   from " . TABLE_SPECIFICATION . " s, 
                                        " . TABLE_SPECIFICATION_DESCRIPTION . " sd, 
                                        " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
                                   where sd.specifications_id = s.specifications_id 
                                     and sg2c.specification_group_id = s.specification_group_id 
                                     and sg2c.categories_id = '" . (int) $current_category_id . "'
                                     and language_id = '" . (int) $_SESSION['languages_id'] . "' 
                                     and s.products_column_name = ''
                                   order by specification_sort_order
                                 ";
      // print $specifications_query_raw . "<br>\n";
      $specifications_query = vam_db_query ($specifications_query_raw);

      $count_specificatons = vam_db_num_rows ($specifications_query);
      if ($count_specificatons > 0) {
        while ($specifications = vam_db_fetch_array ($specifications_query) ) {
          $id = $specifications['specifications_id'];
          $enter_values = $specifications['enter_values'];
?>
          <tr>
            <td class="main" valign="top">
<?php 
          echo $specifications['specification_name'] . '&nbsp;'; 
          echo '<br><div class="description">' . $specifications['specification_description'] . '</div>&nbsp;'; 
?>
            </td>
            <td><table border="0" cellspacing="0" cellpadding="0">
<?php
          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
            $products_query_raw = "select specification
                                   from " . TABLE_PRODUCTS_SPECIFICATIONS . "
                                   where products_id = '" . (int) $_GET['pID'] . "'
                                     and specifications_id = '" . $id . "'
                                     and language_id = '" . (int) $languages[$i]['id'] . "' 
                                 ";  
            // print $products_query_raw . "<br>\n";
            $products_query = vam_db_query ($products_query_raw);
            $count_products_specs = vam_db_num_rows ($products_query);
            $products_specification = '';
            if ($count_products_specs > 0) {
              if ($enter_values == 'multi' || $enter_values == 'checkbox' || $enter_values == 'multiimage') {
              	$products_specification = array();
                // Build an array of selected fields to pass to vam_get_values_menu
                while ($products_data = vam_db_fetch_array($products_query)) {
                  $products_specification[] = array ('id' => $products_data['specification'],
                                                     'text' => $products_data['specification']
                                                    );
                }
              } else {
                $products_data = vam_db_fetch_array ($products_query);
                $products_specification = $products_data['specification'];
              }
            }
            
?>
              <tr>
                <td class="main" valign="top">(<?php echo $languages[$i]['name']; ?>)&nbsp;</td>
                <td class="main">
<?php

            if ($enter_values != 'text') {
              $values_query_raw = "select svd.specification_value
                                   from " . TABLE_SPECIFICATIONS_VALUES . " sv,
                                        " . TABLE_SPECIFICATIONS_VALUES_DESCRIPTION . " svd
                                   where svd.specification_values_id = sv.specification_values_id
                                     and sv.specifications_id = '" . $id . "'
                                     and svd.language_id = '" . (int) $languages[$i]['id'] . "' 
                                   order by sv.value_sort_order,
                                            svd.specification_value
                                 ";  
              // print $values_query_raw . "<br>\n";
              $values_query = vam_db_query ($values_query_raw);

              $values_select_array = array();
              if (vam_db_num_rows ($values_query) > 0) {
                
                while ($values_data = vam_db_fetch_array ($values_query) ) {
                  if ($values_data['specification_value'] != '') {
                    $values_select_array[] = array ('id' => $values_data['specification_value'],
                                                    'text' => $values_data['specification_value']
                                                   );
                  }
                } //  while ($values_data
            
                echo vam_get_values_menu ($enter_values, $values_select_array, 'products_specification[' . $id . '][' . $languages[$i]['id'] . ']', $products_specification);
              } else { // No allowed values have been set
                
                echo vam_draw_textarea_field ('products_specification[' . $id . '][' . $languages[$i]['id'] . ']', 'soft', '70', '3', $products_specification,'class="notinymce"'); 
              } // if ($count_values
            } else { // Set to enter text 
              
              echo vam_draw_textarea_field ('products_specification[' . $id . '][' . $languages[$i]['id'] . ']', 'soft', '70', '3', $products_specification,'class="notinymce"'); 
            } // if ($count_products_specs
?>
                </td>
              </tr>
              <tr>
                <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
<?php
          } // for ($i=0,
?>
            </table></td>
          </tr>
            
<?php
        } //  while ($specifications
      } // if ($count_specificatons
?>
        </table>
