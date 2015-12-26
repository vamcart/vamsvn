<?php
/*
  $Id: comparison.php, v1.1 20101028 kymation Exp $
  $Loc: catalog/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  
  Modified horizontal product comparsion.

  $current_category_id is required to determine which specifications to use

*/


?>
<!-- Comparison //-->
<?php

// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

if ( !defined( 'IMAGE_REQUIRED' ) ) define( 'IMAGE_REQUIRED', false );
if ( !defined( 'TEXT_POPUP' ) ) define( 'TEXT_POPUP', false );
if ( !defined( 'SPECIFICATIONS_COMP_SUFFIX' ) ) define( 'SPECIFICATIONS_COMP_SUFFIX', false );
if ( !defined( 'RM' ) ) define( 'RM', '' );


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
          on cd.categories_id = c.categories_id
      where
        c.categories_id = '" . (int) $current_category_id . "'
    ";

    $title_query = vam_db_query( $title_query_raw );
    $title_array = vam_db_fetch_array( $title_query );


    // Set up the array of product IDs that the customer has selected (if any)
    $product_ids_array = array();

    if ( isset( $_GET[ 'products' ] ) && $_GET[ 'products' ] != '' )
    {
        $product_ids_array = vam_decode_recursive ( $_GET[ 'products' ] );
        $product_ids_array = vam_clean_get__recursive( $product_ids_array );
        $product_ids_array_copy = $product_ids_array;
    };

    $category_id = '';
    if ( isset( $_GET[ 'cat' ] ) && $_GET[ 'cat' ] != '' )
    {
        $category_id = vam_decode_recursive ( $_GET[ 'cat' ] );
        $category_id = vam_clean_get__recursive( $category_id );
    };

    $given_cPath = '';
    if ( isset( $_GET[ 'cPath' ] ) && $_GET[ 'cPath' ] != '' )
    {
        $given_cPath = vam_decode_recursive ( $_GET[ 'cPath' ] );
        $given_cPath = vam_clean_get__recursive( $given_cPath );
    };


    if ( count( $product_ids_array ) > 0 ) // Customer select products
    {



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
          and cd.language_id = '" . (int) $_SESSION['languages_id'] . "'
          and sd.language_id = '" . (int) $_SESSION['languages_id'] . "'
          and sg.show_comparison = 'True'
          and s.show_comparison = 'True'
        order by
          s.specification_sort_order,
          sd.specification_name
        ";

        $specifications_query = vam_db_query( $specifications_query_raw );

        if ( vam_db_num_rows( $specifications_query ) > 0 )
        {
            

            
            $module_contents = '<div class="contentContainer">' . PHP_EOL;
            $module_contents .= '  <div class="contentText">' . PHP_EOL;

            
            $module_contents .= '<div class="ui-widget infoBoxContainer">' . PHP_EOL;

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

                $specification_id_array[ $id ] = array (
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

            
            // Write heading info/byu row
            $module_contents .= '      <tr>' . PHP_EOL;
            $module_contents .= '        <td></td>' . PHP_EOL;
            $module_contents .= '        <td></td>' . PHP_EOL;

            foreach ( $product_ids_array as $tmp_products_id )
            {
                // Get the existing fields data
                $field_array = vam_fill_existing_fields( $tmp_products_id, $_SESSION['languages_id'] );

                
                
                
                
                // get products_tax_class_id

                $products_tax_class_id_raw = "
                  select
                    p.products_tax_class_id,
                    pd.products_name,
                    p.products_image
                  from
                    " . TABLE_PRODUCTS . " p
                    join " . TABLE_PRODUCTS_DESCRIPTION . " pd
                      on (pd.products_id = p.products_id)
                  where
                    p.products_id = '" . $tmp_products_id . "'
                    and pd.language_id = '" . $_SESSION['languages_id'] . "'
                ";
                $products_tax_class_id_query = vam_db_query( $products_tax_class_id_raw );
                $products_tax_class_id_arr = vam_db_fetch_array( $products_tax_class_id_query );

                $products_tax_class_id = $products_tax_class_id_arr[ 'products_tax_class_id' ];

                $cPath_new = vam_get_product_path( $columns_array['products_id'] );
                $product_link = vam_href_link( FILENAME_PRODUCT_INFO, 'cPath=' . $cPath_new . '&products_id=' . $tmp_products_id );

                $products_image = '<a href="' . $product_link . '">' . vam_image(DIR_WS_IMAGES . 'product_images/thumbnail_images/' . trim($products_tax_class_id_arr[ 'products_image' ]), $products_tax_class_id_arr[ 'products_name' ]) . '</a>';

              
              
              
                if ( AJAX_CART == 'true' && !vam_has_product_attributes( $tmp_products_id ) )
                {
                    $buy_button = '<a class="button" href="'
                      . vam_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='
                      . $tmp_products_id.'&'.vam_get_all_get_params(array ('action')), 'NONSSL')
                      . '" onclick="doBuyNow(\''.$tmp_products_id.'\',\'1\'); return false;">' . vam_image_button('buy.png', '').'</a>';
                }
                else
                {
                    $buy_button = '<a class="button" href="'
                    . vam_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='
                    . $tmp_products_id.'&' . vam_get_all_get_params(array ('action')), 'NONSSL').'">' . vam_image_button('buy.png', '').'</a>';
                }
                
                $price = $products_price = $vamPrice->GetPrice( $tmp_products_id, $format = true, 1, $products_tax_class_id, $field_array[ 'products_price' ], 1 );
                $price = $products_price[ 'formated' ];


                // $product_ids_array_copy
                $url_new_compare_params_arr = array();
                if  ( $category_id ) $url_new_compare_params_arr[] = 'cat=' . $category_id;
                if  ( $given_cPath ) $url_new_compare_params_arr[] = 'cPath=' . $given_cPath;
                
                reset( $product_ids_array_copy );
                foreach ( $product_ids_array_copy as $tmp2_products_id )
                {
                    if ( $tmp2_products_id != $tmp_products_id ) $url_new_compare_params_arr[] = 'products[]=' . $tmp2_products_id;
                };

                $remove_button = '<a class="button" href="'
                  . vam_href_link( basename($PHP_SELF), implode( '&', $url_new_compare_params_arr ), 'NONSSL','','').'">'
                  . vam_image_button( 'delete.png', '' ) . '</a><br />';


                $module_contents .= '        <td>' . PHP_EOL;
                $module_contents .= $remove_button;
                $module_contents .= $products_image;
                $module_contents .= '<br /><a href="'.vam_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$tmp_products_id).'">'.$field_array['products_name'].'</a><br />';
                $module_contents .= $price . $buy_button;
                $module_contents .= '        </td>' . PHP_EOL;

            };  // foreach ( $product_ids_array as $tmp_products_id )

            // And end the row
            $module_contents .= '      </tr>' . PHP_EOL;

            $remove_spec_button = '<a class="button remove_spec_button" href="javascript:void(0)">' . vam_image_button( 'delete.png', '' ) . '</a>';

            
            // Get the data for each specification
            reset( $specification_id_array );
            foreach ( $specification_id_array as $specs_id => $specs_data )
            {
                //Start the row
                $module_contents .= '      <tr>' . PHP_EOL;
                $module_contents .= '          <td>' . $remove_spec_button . '          </td>' . PHP_EOL;
                $module_contents .= $specs_data[ 'heading_cell' ] . PHP_EOL;

                foreach ( $product_ids_array as $tmp_products_id )
                {
                    // Get the existing fields data
                    $field_array = vam_fill_existing_fields( $tmp_products_id, $_SESSION['languages_id'] );

                    // Get the cell parameters
                    $table_cell = vam_specification_table_cell( $specs_id, $tmp_products_id, $_SESSION['languages_id'], $field_array, $specs_data );

                    // Add the contents of each cell
                    $module_contents .= '          <td' . ( vam_not_null( $table_cell[ 'box_align' ] )
                      ? ' align="' . $table_cell[ 'box_align' ] . '"'
                      : '') . ' >' . $table_cell[ 'box_text' ] . '</td>' . PHP_EOL;

                };  // foreach ( $product_ids_array as $tmp_products_id )

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
            $module_contents .=  '$(\'.remove_spec_button\').click(function() {$(this).closest(\'tr\').hide();});' . PHP_EOL;
            $module_contents .=  '</script>' . PHP_EOL;
            
        }  // if ( vam_db_num_rows( $specifications_query ) > 0 )
        else
        {
            
            $module_contents = TEXT_NO_COMPARISON_AVAILABLE;
            
        };  // if ( vam_db_num_rows( $specifications_query ) > 0 )
        
    }  // if ( count( $product_ids_array ) > 0 )
    else
    {
        
        $module_contents = TEXT_NO_PRODUCTS_AVAILABLE;
        
    };  // if ( count( $product_ids_array ) > 0 )

}  // if ( $current_category_id != 0 )
else
{

    $module_contents = TEXT_NO_COMPARISON_AVAILABLE;

};  // if ( $current_category_id != 0 )

$vamTemplate->assign( 'COMPARISON', $module_contents );

$vamTemplate->assign( 'BUTTON_CONTINUE', '<a class="button" href="' . vam_href_link( FILENAME_DEFAULT, 'cat=' . $current_category_id ) . '">'.vam_image_button( 'back.png', IMAGE_BUTTON_BACK ) . '</a>' );
      

?>
<!-- Comparison EOF //-->
