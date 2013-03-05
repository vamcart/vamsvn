<?php
/*
  $Id: comparison.php, v1.1 20101028 kymation Exp $
  $Loc: catalog/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  
  Modified horizontal product comparsion.

*/


?>
<!-- Comparison Horizontal //-->
<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

define('IMAGE_REQUIRED', false);
define('TEXT_POPUP', false);



$module = new vamTemplate;
$module->assign( 'tpl_path', 'templates/' . CURRENT_TEMPLATE . '/' );

if ( $current_category_id != 0 )
{
    $title_array = array ();

    //Get the top right image and name for this category
    $title_query_raw = "
      select
        c.categories_image,
        cd.categories_name
      from
        " . TABLE_CATEGORIES . " c
        join " . TABLE_CATEGORIES_DESCRIPTION . " cd
          on (cd.categories_id = c.categories_id)
      where
        c.categories_id = '" . (int) $current_category_id . "'
    ";

    // print $image_query_raw . "<br>\n";
    $title_query = vam_db_query( $title_query_raw );
    $title_array = vam_db_fetch_array( $title_query );

    if ( is_array( $_REQUEST[ "products" ]  ) )
    {
        foreach( $_REQUEST[ "products" ] as $v )
        {
            if ( is_numeric( intval( trim( $v ) ) ) ) $temp[] = $v;
        };
    };

    if ( is_array( $temp ) && sizeof( $temp) > 0 )
    {
    
?>
<div class="contentContainer">
  <div class="contentText">
<?php


    $list_box_contents = array ();
    $customer_selected = true; // Assume the customer has selected products to compare

    // Set up the array of product IDs that the customer has selected (if any)
    $comp_array = array();

    if ( isset( $_GET[ 'comp' ] ) && $_GET[ 'comp' ] != '' )
    {
        $comp_array = vam_decode_recursive ( $_GET[ 'comp' ] );
        $comp_array = vam_clean_get__recursive( $comp_array );
    };

    if ( count( $comp_array ) < 1 )
    {
      // Customer did not select products, so show all products with specifications in this category
      $customer_selected = false;
      $products_query_raw = "
        select distinct
          p.products_id
        from
          " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
          join " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c
            on s2c.categories_id = p2c.categories_id
          join " . TABLE_PRODUCTS . " p
            on p.products_id = p2c.products_id
        where
          p.products_status = 1
          and p2c.categories_id = '" . (int) $current_category_id . "'
        order by
          p.products_id
      ";

      $products_query = vam_db_query($products_query_raw);

      while ( $products_array = vam_db_fetch_array( $products_query ) )
      { // Each product is a column
        $comp_array[] = $products_array[ 'products_id' ];
      } // while ($products_array
    } // if (count ($comp_array


    if ( count( $comp_array ) > 1 || $customer_selected == true )
    {

      $show_sql = "
         and sg.show_comparison = 'True'
         and s.show_comparison = 'True'
      ";

      $specifications_query_raw = "
        select
          s.specifications_id,
          s.specification_sort_order,
          s.products_column_name,
          s.column_justify,
          s.filter_display,
          s.enter_values,
          sd.specification_name,
          sd.specification_prefix,
          sd.specification_suffix,
          sg.specification_group_id
        from " . TABLE_SPECIFICATION . " s
          join " . TABLE_SPECIFICATION_DESCRIPTION . " sd
            on (sd.specifications_id = s.specifications_id)
          join " . TABLE_SPECIFICATION_GROUPS . " sg
            on (sg.specification_group_id = s.specification_group_id)
          join " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
            on (sg2c.specification_group_id = sg.specification_group_id)
          join " . TABLE_CATEGORIES_DESCRIPTION . " cd
            on (cd.categories_id = sg2c.categories_id)
        where
          cd.categories_id = '" . (int) $current_category_id . "'
          and cd.language_id = '" . (int) $languages_id . "'
          and sd.language_id = '" . (int) $languages_id . "'
          " . $show_sql . "
        order by
          s.specification_sort_order,
          sd.specification_name
      ";

      $specifications_query = vam_db_query( $specifications_query_raw );

      if ( vam_db_num_rows( $specifications_query ) > 0 )
      {
        $module_contents = '<div class="ui-widget infoBoxContainer">' . PHP_EOL;

          // Start the rows
        $module_contents .= '  <div class="ui-widget-content ui-corner-bottom productListTable">' . PHP_EOL;
        $module_contents .= '    <table border="0" width="100%" cellspacing="0" cellpadding="2" class="productListingData">' . PHP_EOL;

        $specification_id_array = array ();
        while ( $specifications_heading = vam_db_fetch_array( $specifications_query ) )
        {
          $box_text = $specifications_heading[ 'specification_name' ];
          if ( $box_text == '' ) $box_text = '&nbsp;';

          if ( $specifications_heading[ 'specification_suffix' ] != '' && SPECIFICATIONS_COMP_SUFFIX == 'True' )
          {
            $box_text .= '<br>(' . $specifications_heading['specification_suffix'] . ')';
          }

          $heading_cell = '        <td align="left" style="padding-left:5px;">' . $box_text . '</td>' . PHP_EOL;

          $id = $specifications_heading[ 'specifications_id' ];
          $group_id = $specifications_heading[ 'specification_group_id' ];

          $specification_id_array[$id] = array (
            'id' =>         $specifications_heading[ 'specifications_id' ],
            'sort_order' => $specifications_heading[ 'specification_sort_order' ],
            'column_name' => $specifications_heading[ 'products_column_name' ],
            'column_justify' => $specifications_heading[ 'column_justify' ],
            'name' =>       $specifications_heading[ 'specification_name' ],
            'prefix' =>     $specifications_heading[ 'specification_prefix' ],
            'suffix' =>     $specifications_heading[ 'specification_suffix' ],
            'display' =>    $specifications_heading[ 'filter_display' ],
            'enter' =>      $specifications_heading[ 'enter_values' ],
            'group_id' =>   $specifications_heading[ 'specification_group_id' ],
            'heading_cell' => $heading_cell
          );
        }; //while ($specifications_heading


        // Get the data for each specification
        reset( $specification_id_array );
        foreach ( $specification_id_array as $specs_id => $specs_data )
        {
          //Start the row
          $module_contents .= '      <tr>' . PHP_EOL;
          $module_contents .= $specs_data[ 'heading_cell' ] . PHP_EOL;

          foreach ( $comp_array as $tmp_products_id )
          {
            // Get the existing fields data
            $field_array = vam_fill_existing_fields( $tmp_products_id, $languages_id );

            $table_cell = vam_specification_table_cell( $specs_id, $tmp_products_id, $languages_id, $field_array, $specs_data );
            // Add the contents of each cell
            $module_contents .= '        <td align="center">' . $table_cell[ 'box_text' ] . '</td>' . PHP_EOL;

          }; // foreach ($comp_array

          // And end the row
          $module_contents .= '      </tr>' . PHP_EOL;

        }; // foreach ($specification_id_array

        $module_contents .= '    </table>' . PHP_EOL;
        $module_contents .= '  </div>' . PHP_EOL;
        $module_contents .= '</div>' . PHP_EOL;
        $module_contents .= '  </div>' . PHP_EOL;
        $module_contents .= '</div>' . PHP_EOL;
        
        $module_contents .=  '<script type="text/javascript">' . PHP_EOL;
        $module_contents .=  '$(\'.productListingData tr:nth-child(even)\').addClass(\'itemEven\');' . PHP_EOL;
        $module_contents .=  '</script>' . PHP_EOL;


      }
      else
      {
        $module_contents = TEXT_NO_PRODUCTS_AVAILABLE;
      }; // if (vam_db_num_rows ($products_query


    } // if (vam_db_num_rows ($category_specs_query
	else
    {
      $module_contents = TEXT_NO_COMPARISON_AVAILABLE;
	};

  }  // if ( is_array( $temp ) && sizeof( $temp) > 0 )
  else
  {
    $module_contents = TEXT_NO_PRODUCTS_AVAILABLE;
  }; // if ($current_category_id ... else ...
  
}  // if ( $current_category_id != 0 )
else
{
    $module_contents = TEXT_NO_COMPARISON_AVAILABLE;
};  // if ( $current_category_id != 0 )

$vamTemplate->assign( 'COMPARISON', $module_contents );

$vamTemplate->assign( 'BUTTON_CONTINUE', '<a class="button" href="' . vam_href_link( FILENAME_DEFAULT, 'cat=' . $current_category_id ) . '">'.vam_image_button( 'back.png', IMAGE_BUTTON_BACK ) . '</a>' );
      

?>

<script type="text/javascript">
$('.productListingData tr:nth-child(even)').addClass('itemEven');
</script>


<!-- Comparison EOF //-->