<?php
/*
  $Id: comparison.php, v1.0.1 20090917 kymation Exp $
  $Loc: catalog/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

/*
 * This file produces the product comparison table from the specification data
 * for products in a linked category. It can be included in catalog/comparison.
 * php or catalog/index.php (Admin controlled)
 * 
 * $current_category_id is required to determine which specifications to use
 */


?>
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td>
<?php
  if ($current_category_id != 0) {
    $title_array = array();
    //Get the top right image and name for this category
    $title_query_raw = "select c.categories_image,
                               cd.categories_name
                           from " . TABLE_CATEGORIES . " c,
                                " . TABLE_CATEGORIES_DESCRIPTION . " cd
                           where c.categories_id = '" . (int) $current_category_id . "'
                             and cd.categories_id = '" . (int) $current_category_id . "'
                         ";
    // print $image_query_raw . "<br>\n";
    $title_query = tep_db_query ($title_query_raw);

    if (tep_db_num_rows ($title_query) > 0) {
      $title_array = tep_db_fetch_array ($title_query);
    } // if (tep_db_num_rows ($category_query
?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo sprintf (HEADING_TITLE, $title_array['categories_name']); ?></td>
            <td align="right"><?php echo tep_image(DIR_WS_IMAGES . $title_array['categories_image'], $title_array['categories_name'], HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td>
<?php
        // This is used here to generate the column headings (Row 0 of the table)
        //   and later to step through the columns on each row
        $list_box_contents = array();
        $specifications_query_raw = "select s.specifications_id,
                                            s.specification_sort_order,
                                            s.products_column_name,
                                            s.column_justify,
                                            s.filter_display,
                                            s.enter_values,
                                            sd.specification_name,
                                            sd.specification_prefix,
                                            sd.specification_suffix,
                                            sg.specification_group_id
                                    from " . TABLE_SPECIFICATION . " s,
                                         " . TABLE_SPECIFICATION_DESCRIPTION . " sd,
                                         " . TABLE_SPECIFICATION_GROUPS . " sg,
                                         " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c,
                                         " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                    where sg.specification_group_id = sg2c.specification_group_id
                                      and cd.categories_id = sg2c.categories_id
                                      and sd.specifications_id = s.specifications_id
                                      and sg.show_comparison = 'True'
                                      and s.show_comparison = 'True'
                                      and cd.categories_id = '" . (int) $current_category_id . "'
                                      and cd.language_id = '" . (int) $languages_id . "' 
                                      and s.specification_group_id = sg.specification_group_id
                                      and sd.language_id = '" . (int) $languages_id . "' 
                                    order by s.specification_sort_order,
                                             sd.specification_name
                                  ";
        // print $specifications_query_raw . "<br>\n";
        $specifications_query = tep_db_query ($specifications_query_raw);

        if (tep_db_num_rows ($specifications_query) > 0) {
          $specification_id_array = array();
          while ($specifications_heading = tep_db_fetch_array ($specifications_query) ) {
            // Set up the heading for the table
            $box_text = $specifications_heading['specification_name'];
            if ($specifications_heading['specification_suffix'] != '' && SPECIFICATIONS_COMP_SUFFIX == 'True') {
              $box_text .= '<br>(' . $specifications_heading['specification_suffix'] . ')';
            }

            if ($specifications_heading['column_justify'] == '') {
              $specifications_heading['column_justify'] = 'left';
            }

            $list_box_contents[0][] = array ('align' => $specifications_heading['column_justify'],
                                             'params' => 'class="productListing-heading"',
                                             'text' => '&nbsp;' . $box_text . '&nbsp;'
                                            );
             
            // Build an array to use as an index on the table rows
            $id = $specifications_heading['specifications_id'];
            $group_id = $specifications_heading['specification_group_id'];
            $specification_id_array[$id] = array ('id' => $specifications_heading['specifications_id'],
                                                  'sort_order' => $specifications_heading['specification_sort_order'],
                                                  'column_name' => $specifications_heading['products_column_name'],
                                                  'column_justify' => $specifications_heading['column_justify'],
                                                  'name' => $specifications_heading['specification_name'],
                                                  'prefix' => $specifications_heading['specification_prefix'],
                                                  'suffix' => $specifications_heading['specification_suffix'],
                                                  'display' => $specifications_heading['filter_display'],
                                                  'enter' => $specifications_heading['enter_values'],
                                                  'group_id' => $specifications_heading['specification_group_id']
                                                 );
          } //while ($specifications_heading
        
////
// Table rows
          $products_query_raw = "select distinct p2c.products_id
                                 from " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c,
                                      " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c
                                 where p2c.categories_id = s2c.categories_id 
                                   and p2c.categories_id = '" . (int) $current_category_id . "'
                                   and s2c.specification_group_id = '" . (int) $group_id . "'
                               ";
          // print 'Products Query: ' . $products_query_raw . "<br>\n";
          $products_query = tep_db_query ($products_query_raw);

          if (tep_db_num_rows ($products_query) >= SPECIFICATIONS_MINIMUM_COMPARISON) {
            $row_number = 1; // Row 0 was the header
            while ($products_array = tep_db_fetch_array ($products_query) ) { // Each product is a row
              $products_id = $products_array['products_id'];
              // Check to see if this product has any specifications
              $check_query_raw = "select count(products_specification_id) as total
                                 from " . TABLE_PRODUCTS_SPECIFICATIONS . "
                                 where products_id = '" . $products_id . "'
                                   and specification != ''
                               ";
              // print 'Check Query: ' . $check_query_raw . "<br>\n";
              $check_query = tep_db_query ($check_query_raw);
              $check_total = tep_db_fetch_array ($check_query);
              if ($check_total['total'] > 0) { // Show product only if specifications are not empty
                reset ($specification_id_array);
                
                // Get the data for existing columns (All of them, so we can use what we want in the table)
                $columns_query_raw = "select p.products_id,
                                             pd.products_name,
                                             p.products_quantity,
                                             p.products_model,
                                             p.products_image,
                                             p.products_price,
                                             p.products_weight,
                                             p.products_tax_class_id,
                                             mi.manufacturers_name,
                                             IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price,
                                             IF(s.status, s.specials_new_products_price, p.products_price) as final_price
                                      from " . TABLE_PRODUCTS . " p 
                                        left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id,
                                           " . TABLE_PRODUCTS_DESCRIPTION . " pd,
                                           " . TABLE_MANUFACTURERS_INFO . " mi
                                      where p.manufacturers_id = mi.manufacturers_id
                                        and p.products_id = '" . (int) $products_id . "'
                                        and pd.products_id = '" . (int) $products_id . "'
                                        and pd.language_id = '" . (int) $languages_id . "' 
                                    ";
                // print $columns_query_raw . "<br>\n";
                $columns_query = tep_db_query ($columns_query_raw);
                $columns_array = tep_db_fetch_array ($columns_query);

                // Quantities may be used in columns or combination column
                $products_quantity = ($columns_array['products_quantity'] == '') ? TEXT_NOT_AVAILABLE : $columns_array['products_quantity'];
                $products_model = ($columns_array['products_model'] == '') ? TEXT_NOT_AVAILABLE : $columns_array['products_model'];
                $products_image = '<a href="' . tep_href_link (FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $columns_array['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $columns_array['products_image'], $columns_array['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>';
                if (tep_not_null ($columns_array['specials_new_products_price']) ) {
                  $products_price = '<s>' . $currencies->display_price ($columns_array['products_price'], tep_get_tax_rate ($columns_array['products_tax_class_id']) ) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price ($columns_array['specials_new_products_price'], tep_get_tax_rate ($columns_array['products_tax_class_id'])) . '</span>';
                } else {
                  $products_price = $currencies->display_price ($columns_array['products_price'], tep_get_tax_rate ($columns_array['products_tax_class_id']) );
                }
                $final_price = $currencies->display_price ($columns_array['final_price'], tep_get_tax_rate ($columns_array['products_tax_class_id']) );
                $products_weight = ($columns_array['products_weight'] == '') ? TEXT_NOT_AVAILABLE : $columns_array['products_weight'];
                $manufacturers_name = ($columns_array['manufacturers_name'] == '') ? TEXT_NOT_AVAILABLE : $columns_array['manufacturers_name'];
                $products_name = ($columns_array['products_name'] == '') ? TEXT_NOT_AVAILABLE : '<a href="' . tep_href_link (FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $columns_array['products_id']) . '">' . $columns_array['products_name'] . '</a>';
                $buy_now = '<a href="' . tep_href_link (basename ($PHP_SELF), tep_get_all_get_params (array ('action') ) . 'action=buy_now&products_id=' . $columns_array['products_id']) . '">' . tep_image_button ('button_buy_now.gif', IMAGE_BUTTON_BUY_NOW) . '</a>';
              
                // Get the data for each specification in the row 
                foreach ($specification_id_array as $specs_id => $specs_data) {
                  $products_specifications_query_raw = "select specification
                                                        from " . TABLE_PRODUCTS_SPECIFICATIONS . "
                                                        where specifications_id = '" . (int) $specs_id . "'
                                                          and language_id = '" . (int) $languages_id . "' 
                                                          and products_id = '" . (int) $products_id . "' 
                                                        limit 1
                                                      ";
                  // print $products_specifications_query_raw . "<br>\n";
                  $products_specifications_query = tep_db_query ($products_specifications_query_raw);

                  $products_specifications = tep_db_fetch_array ($products_specifications_query);

                  if ($products_specifications['specification'] == '') {
                    $specs_data['specification'] = TEXT_NOT_AVAILABLE;
                  } else {
                    $specs_data['specification'] = $products_specifications['specification'];
                  }

                  // Get the data for the table cell, either from an existing column or from the specification
                  switch ($specs_data['column_name']) {
                    // If an existing column was selcted, use that data
                    case 'products_quantity':
                      $box_text = '&nbsp;' . $products_quantity . '&nbsp;';
                      $box_align = 'right';
                      break;
                  
                    case 'products_model':
                      $box_text = '&nbsp;' . $products_model . '&nbsp;';
                      $box_align = 'left';
                      break;
                  
                    case 'products_image':
                      $box_text = '&nbsp;' . $products_image . '&nbsp;';
                      $box_align = 'center';
                      break;
                  
                    case 'products_price':  
                      $box_text = '&nbsp;' . $products_price . '&nbsp;';
                      $box_align = 'right';
                      break;
                  
                    case 'final_price':  
                      $box_text = '&nbsp;' . $final_price . '&nbsp;';
                      $box_align = 'right';
                      break;
                 
                    case 'products_weight':
                      $box_text = '&nbsp;' . $products_weight . '&nbsp;';
                      $box_align = 'right';
                      break;
                  
                    case 'manufacturers_id':
                      $box_text = '&nbsp;' . $manufacturers_name . '&nbsp;';
                      $box_align = 'left';
                      break;
                  
                    case 'products_name':
                      $box_text = '&nbsp;' . $products_name . '&nbsp;';
                      $box_align = 'left';
                      break;
                 
                    case 'buy_now': 
                      $box_text = '&nbsp;' . $buy_now . '&nbsp;';
                      $box_align = 'center';
                      break;
                  
                    case 'combi': // Contents of this column are set globally in the Admin Config
                      $combi_components = array();
                      if (SPECIFICATIONS_COMBO_MODEL > 0) $combi_components[SPECIFICATIONS_COMBO_MODEL] = $products_model;
                      if (SPECIFICATIONS_COMBO_IMAGE > 0) $combi_components[SPECIFICATIONS_COMBO_IMAGE] = $products_image;
                      if (SPECIFICATIONS_COMBO_PRICE > 0) $combi_components[SPECIFICATIONS_COMBO_PRICE] = $products_price;
                      if (SPECIFICATIONS_COMBO_WEIGHT > 0) $combi_components[SPECIFICATIONS_COMBO_WEIGHT] = $products_weight;
                      if (SPECIFICATIONS_COMBO_MFR > 0) $combi_components[SPECIFICATIONS_COMBO_MFR] = $manufacturers_name;
                      if (SPECIFICATIONS_COMBO_NAME > 0) $combi_components[SPECIFICATIONS_COMBO_NAME] = $products_name;
                      if (SPECIFICATIONS_COMBO_BUY_NOW > 0) $combi_components[SPECIFICATIONS_COMBO_BUY_NOW] = $buy_now;
                      ksort ($combi_components); 
                      $box_text = implode ('<br>', $combi_components);
                      $box_align = 'center';
                      break;
                  
                    case '':  // No existing column, so use specification data
                    default:
                      $box_text = $specs_data['prefix'] . ' ';
                      
                      if ($specs_data['display'] == 'image' || $specs_data['display'] == 'multiimage' || $specs_data['enter'] == 'image' || $specs_data['enter'] == 'multiimage') { 
                        tep_image (DIR_WS_IMAGES . $specs_data['specification'], $specs_data['column_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
                      } else {
                        $box_text .= $specs_data['specification'] . ' ';
                      }
                      
                      if ($specs_data['suffix'] != '' && SPECIFICATIONS_COMP_SUFFIX != 'True') {
                        $box_text .= ' ' . $specs_data['suffix'];
                      }
                      
                      $box_align = $specs_data['column_justify'];
                      break;
                  } // switch ($specs_data['column_name']
 
                  if ( ($row_number % 2) == 0) { // Even numbered row
                    $params = 'class="productListing-even"';
                  } else {
                    $params = 'class="productListing-odd"';
                  } // if ( ($row_number % 2) ... else ...
                
                  // Output each column in the current row (One product per row, one specification per column)
                  $list_box_contents[$row_number][] = array ('align' => $box_align,
                                                             'params' => $params,
                                                             'text'  => $box_text
                                                            );
                } // foreach ($specification_id_array

                $row_number++;
              } // if ($check_total['total']
            } // while ($products_array

          } else {
            $list_box_contents[0] = array ('align' => 'center',
                                           'params' => 'class="productListing-odd"',
                                           'text'  => TEXT_NO_COMPARISON_AVAILABLE
                                          );

          } // if (tep_db_num_rows ($products_query

          // Output the box in the selected style
          switch (SPECIFICATIONS_COMPARISON_STYLE) {
            case 'Plain':
              new borderlessBox ($list_box_contents);
              break;
          
            case 'Simple':
              new productListingBox ($list_box_contents);
              break;
          
            case 'Stock':
            default:
              new contentBoxHeading ($list_box_heading, false, false);
              new contentBox ($list_box_contents);
              break;
          } // switch (SPECIFICATIONS_BOX_FRAME_STYLE

        } // if (tep_db_num_rows ($category_specs_query

  } else {
    echo TEXT_NO_COMPARISON_AVAILABLE;
    
  } // if ($current_category_id ... else ...
?>
        </td>
      </tr>
    </table></td>
