<?php
/*
  $Id: comparison.php, v1.1 20101028 kymation Exp $
  $Loc: catalog/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

/*
 * This file produces the vertical product comparison table from the
 * specification data for products in a linked category. It can be included in
 * catalog/comparison.php or catalog/index.php (Admin controlled)
 *
 * For the horizontal table see catalog/includes/modules/comparison_horiz.php
 *
 * $current_category_id is required to determine which specifications to use
 */


?>
<!-- Comparison //-->
<?php

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

  if ($current_category_id != 0) {
    $title_array = array ();
    //Get the top right image and name for this category
    $title_query_raw = "
      select
        c.categories_image,
        cd.categories_name
      from
        " . TABLE_CATEGORIES . " c
        join " . TABLE_CATEGORIES_DESCRIPTION . " cd
          on cd.categories_id = c.categories_id
      where
        c.categories_id = '" . (int) $current_category_id . "'
    ";
    // print $image_query_raw . "<br>\n";
    $title_query = vam_db_query($title_query_raw);
    $title_array = vam_db_fetch_array($title_query);

if (is_array($_REQUEST["products"]))
{
    foreach($_REQUEST["products"] as $v)
    {
        if (is_numeric(intval(trim($v)))) $temp[] = $v;
    }
}

if (is_array($temp) && sizeof($temp) > 0)
{
    
?>
<div class="contentContainer">
  <div class="contentText">
<?php


    // This is used here to generate the column headings (Row 0 of the table)
    //   and later to step through the columns on each row
    $list_box_contents = array ();
    $specifications_query_raw = "
      select
        s.specifications_id,
        s.specification_sort_order,
        s.products_column_name,
        s.column_justify,
        s.filter_display,
        sd.specification_name,
        sd.specification_prefix,
        sd.specification_suffix,
        sg.specification_group_id
      from
        " . TABLE_SPECIFICATION . " s
        join " . TABLE_SPECIFICATION_DESCRIPTION . " sd
          on (sd.specifications_id = s.specifications_id
            and sd.language_id = '" . (int) $_SESSION['languages_id'] . "')
        join " . TABLE_SPECIFICATION_GROUPS . " sg
          on (sg.specification_group_id = s.specification_group_id
            and sg.show_comparison = 'True')
        join " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
          on (sg2c.specification_group_id = sg.specification_group_id)
        join " . TABLE_CATEGORIES_DESCRIPTION . " cd
          on (cd.categories_id = sg2c.categories_id)
      where
        s.show_comparison = 'True'
        and cd.categories_id = '" . (int) $current_category_id . "'
        and cd.language_id = '" . (int) $_SESSION['languages_id'] . "'
      order by s.specification_sort_order,
               sd.specification_name
    ";
    // print $specifications_query_raw . "<br>\n";
    $specifications_query = vam_db_query($specifications_query_raw);

    if (vam_db_num_rows($specifications_query) > 0) {
      $module_contents = '<div class="ui-widget infoBoxContainer">' . PHP_EOL;
    	// Start the heading output
      $module_contents .= '  <div class="ui-widget-header ui-corner-top infoBoxHeading">' . PHP_EOL;
      $module_contents .= '    <table border="0" width="100%" cellspacing="5" cellpadding="2" class="productListingHeader">' . PHP_EOL;
      $module_contents .= '      <tr>' . PHP_EOL;
        $module_contents .= '<td width="35%"></td>' . PHP_EOL;
      $specification_id_array = array ();
      while ($specifications_heading = vam_db_fetch_array($specifications_query)) {
        // Set up the heading for the table
        $box_text = '&nbsp;';
        if( $specifications_heading['specification_name'] != '' ) {
          $box_text = $specifications_heading['specification_name'];
        }

        if ($specifications_heading['specification_suffix'] != '' && SPECIFICATIONS_COMP_SUFFIX == 'True') {
          $box_text .= '<br>(' . $specifications_heading['specification_suffix'] . ')';
        }

        // Add the contents of each cell
        $module_contents .= '        <td' . (vam_not_null($specifications_heading['column_justify']) ? ' align="' . $specifications_heading['column_justify'] . '"' : '') . ' class="productListing-heading">' . $box_text . '</td>' . PHP_EOL;

        // Build an array to use as an index on the table rows
        $id = $specifications_heading['specifications_id'];
        $group_id = $specifications_heading['specification_group_id'];

        $specification_id_array[$id] = array (
          'id' => $specifications_heading['specifications_id'],
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

      // Close the heading row
      $module_contents .= '      </tr>' . PHP_EOL;
      $module_contents .= '    </table>' . PHP_EOL;
      $module_contents .= '  </div>' . PHP_EOL;
   
      ////
      // Table rows
      $products_query_raw = "
        select distinct
          p.products_id,
          p.products_tax_class_id,
          p.products_price,
          pd.products_name,
          pd.products_description,
          pd.products_short_description
        from
          " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
          join " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c
            on (p2c.categories_id = s2c.categories_id)
          join " . TABLE_PRODUCTS . " p
            on (p.products_id = p2c.products_id)
          join " . TABLE_PRODUCTS_DESCRIPTION . " pd
            on (pd.products_id = p2c.products_id)
        where
          p.products_status = 1
          and p.products_id IN (".implode(", ", $temp).")
          and p2c.categories_id = '" . (int) $current_category_id . "'
          and s2c.specification_group_id = '" . (int) $group_id . "'
        order by
          p.products_id
      ";
      // print 'Products Query: ' . $products_query_raw . "<br>\n";
      $products_query = vam_db_query($products_query_raw);

      if (vam_db_num_rows($products_query) >= SPECIFICATIONS_MINIMUM_COMPARISON) {
      	// Start the rows
        $module_contents .= '  <div class="ui-widget-content ui-corner-bottom productListTable">' . PHP_EOL;
        $module_contents .= '    <table border="0" width="100%" cellspacing="5" cellpadding="2" class="productListingData">' . PHP_EOL;

        // Add the product rows
        while ($products_array = vam_db_fetch_array($products_query)) { // Each product is a row
          $products_id = $products_array['products_id'];
          // Check to see if this product has any specifications
          $check_query_raw = "
            select
              count(products_specification_id) as total
            from
              " . TABLE_PRODUCTS_SPECIFICATIONS . "
            where
              products_id = '" . $products_id . "'
              and (specification != '')
          ";
          // print 'Check Query: ' . $check_query_raw . "<br>\n";
          $check_query = vam_db_query($check_query_raw);
          $check_total = vam_db_fetch_array($check_query);
          if ($check_total['total'] > 0 || SPECIFICATIONS_PRODUCTS_NO_SPEC == 'True') { // Show product
            reset($specification_id_array);

            // Get the existing fields data
            $field_array = vam_fill_existing_fields( $products_id, $_SESSION['languages_id'] );
            //Start the row

				if (AJAX_CART == 'true' && !vam_has_product_attributes($id)) {
				$buy_button = '<a class="button" href="'.vam_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='.$products_id.'&'.vam_get_all_get_params(array ('action')), 'NONSSL').'" onclick="doBuyNow(\''.$id.'\',\'1\'); return false;">'.vam_image_button('buy.png', '').'</a>';
				} else {
				$buy_button = '<a class="button" href="'.vam_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='.$products_id.'&'.vam_get_all_get_params(array ('action')), 'NONSSL').'">'.vam_image_button('buy.png', '').'</a>';
				}
				
				$price = $products_price = $vamPrice->GetPrice($products_id, $format = true, 1, $products_array['products_tax_class_id'], $products_array['products_price'], 1);
				$price = $products_price['formated'];
		
            $module_contents .= '      <tr>' . PHP_EOL;
            $module_contents .= '<td><a href="'.vam_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$products_id).'">'.$products_array['products_name'].'</a>&nbsp;- '.$price.$buy_button.'</td>';

            // Get the data for each specification in the row
            foreach ($specification_id_array as $specs_id => $specs_data) {
            	// Get the cell parameters
              $table_cell = vam_specification_table_cell( $specs_id, $products_id, $_SESSION['languages_id'], $field_array, $specs_data );

              // Add the contents of each cell
              $module_contents .= '        <td' . (vam_not_null($table_cell['box_align']) ? ' align="' . $table_cell['box_align'] . '"' : '') . ' >' . $table_cell['box_text'] . '</td>' . PHP_EOL;

            } // foreach ($specification_id_array

            $module_contents .= '      </tr>' . PHP_EOL;
            $module_contents .= '        </form>' . PHP_EOL;
          } // if ($check_total['total']
        } // while ($products_array

        $module_contents .= '        </table>' . PHP_EOL;
        $module_contents .= '      </div>' . PHP_EOL;
        $module_contents .= '    </div>' . PHP_EOL;
        $module_contents .= '  </div>' . PHP_EOL;
        $module_contents .= '</div>' . PHP_EOL;

      } else {
        $module_contents = TEXT_NO_COMPARISON_AVAILABLE;

      } // if (vam_db_num_rows ($products_query


    } // if (vam_db_num_rows ($category_specs_query

  } else {
    $module_contents = TEXT_NO_COMPARISON_AVAILABLE;

  } // if ($current_category_id ... else ...
  
	$vamTemplate->assign('COMPARISON', $module_contents);

	$vamTemplate->assign('BUTTON_CONTINUE', '<a class="button" href="'.vam_href_link(FILENAME_DEFAULT, 'cat='.$current_category_id).'">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');
	  
}
?>
<!-- Comparison EOF //-->