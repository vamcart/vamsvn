<?php
/*
  $Id: products_specifications.php, v 0.4 2009-07-09 3:24:21 PM kymation Exp $
  $Loc: catalog/admin/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

/*
 * This file produces the product specification list on the Preview page.
 * 
 * $current_category_id and $_GET['products_id'] are required to determine which
 * specifications to show.
 */


  $products_id = 0;
  if (isset ($_GET['pID']) && (int) $_GET['pID'] != 0) {
    $products_id = (int) $_GET['pID'];
  }
  
  $specification_box_heading = array();
  $specification_box_heading[] = array ('text' => SPECIFICATION_TITLE_PRODUCTS);
  
  $specifications_query_raw = "select s.specifications_id,
                                      sd.specification_name, 
                                      sd.specification_prefix, 
                                      sd.specification_suffix                                      
                               from " . TABLE_SPECIFICATION . " s, 
                                    " . TABLE_SPECIFICATION_DESCRIPTION . " sd, 
                                    " . TABLE_SPECIFICATION_GROUPS . " sg,
                                    " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
                               where sg.show_products = 'True'
                                 and s.show_products = 'True'
                                 and s.specification_group_id = sg.specification_group_id 
                                 and sg.specification_group_id = sg2c.specification_group_id 
                                 and sd.specifications_id = s.specifications_id
                                 and sg2c.categories_id = '" . (int) $current_category_id . "' 
                                 and sd.language_id = '" . (int) $languages[$i]['id'] . "' 
                               order by s.specification_sort_order, 
                                        sd.specification_name";
// print $specifications_query_raw . "<br>\n";
  $specifications_query = vam_db_query ($specifications_query_raw);

  $count_specificatons = vam_db_num_rows ($specifications_query);
  if ( (isset ($_POST['products_specification'] ) && $_POST['products_specification'] != '') || (isset ($_GET['read']) && $_GET['read'] == 'only') ) {

    if (isset ($_GET['read']) && $_GET['read'] == 'only' && $count_specificatons > '0') {
      $specs_query_raw = "select s.specifications_id,
                                 ps.specification
                          from " . TABLE_PRODUCTS_SPECIFICATIONS . " ps,
                               " . TABLE_SPECIFICATION . " s, 
                               " . TABLE_SPECIFICATION_DESCRIPTION . " sd, 
                               " . TABLE_SPECIFICATION_GROUPS . " sg,
                               " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
                          where sg.show_products = 'True'
                            and s.show_products = 'True'
                            and s.specification_group_id = sg.specification_group_id 
                            and sg.specification_group_id = sg2c.specification_group_id 
                            and sd.specifications_id = s.specifications_id
                            and ps.specifications_id = s.specifications_id 
                            and sg2c.categories_id = '" . (int) $current_category_id . "' 
                            and sd.language_id = '" . (int) $languages[$i]['id'] . "' 
                            and ps.products_id = '" . (int) $products_id . "' 
                            and ps.language_id = '" . (int) $languages[$i]['id'] . "' 
                          order by s.specification_sort_order, 
                                   sd.specification_name";
      // print $specs_query_raw . "<br>\n";
      $specs_query = vam_db_query ($specs_query_raw);
      while ($specs_data = vam_db_fetch_array ($specs_query) ) {
        $_POST['products_specification'][$specs_data['specifications_id']][$languages[$i]['id']] = $specs_data['specification'];
      } // while ($specs_data
    } // if (isset ($_GET['read']

?>
<table border="0" width="100%" cellspacing="2" cellpadding="3">
  <tr>
    <td class="main" valign="top">
<!-- products_specifications_box //-->
<?php

    if (SPECIFICATIONS_SHOW_TITLE_PRODUCTS == 'True' && (SPECIFICATIONS_BOX_FRAME_STYLE == 'Plain' || SPECIFICATIONS_BOX_FRAME_STYLE == 'Simple') ) {
      echo '<b>' . $specification_box_heading[0]['text'] . '</b>';
    }

    $specifications_box_contents = array();
    $specification_text = '<ul class=specification_box>' . "\n";
    while ($specifications = vam_db_fetch_array ($specifications_query) ) {
      $products_specification = $_POST['products_specification'][$specifications['specifications_id']][$languages[$i]['id']];
      if (is_array ($products_specification) ) {
        $products_specification_array = $products_specification;
      } else {
        $products_specification_array = array();
        $products_specification_array[0] = $products_specification;
      } // if (is_array ... else ...

      foreach ($products_specification_array as $specification_data) {
        $specification_string = htmlspecialchars (stripslashes ($specification_data) );
        if ($specification_string != '') {
          $specification_text .= '<li>';
      
          if (SPECIFICATIONS_SHOW_NAME_PRODUCTS == 'True') {
            $specification_text .= $specifications['specification_name'] . ': ';
          }
        
          $specification_text .= $specifications['specification_prefix'] . ' ';
          $specification_text .= $specification_string . ' ';
          $specification_text .= $specifications['specification_suffix'];
          $specification_text .= '</li>' . "\n";
        } // if ($specification_string
      } // foreach ($products_specification
    } // while ($specifications
    $specification_text .= '</ul>' . "\n";
    
    $specifications_box_contents[0] = array ('align' => 'left',
                                             'params' => 'class="main" valign="middle"',
                                             'text' => $specification_text
                                            );

    // Output the box in the selected style
    switch (SPECIFICATIONS_BOX_FRAME_STYLE) {
      case 'Plain':
        new borderlessBox ($specifications_box_contents);
        break;
      case 'Simple':
        new productListingBox ($specifications_box_contents);
        break;
      case 'Stock':
      default:
        new contentBoxHeading ($specification_box_heading, false, false);
        new contentBox ($specifications_box_contents);
        break;
    } // switch
?>
<!-- products_specifications_box_eof //-->
    </td>
  </tr>
</table>
<?php
  } //if ($count_specificatons
?>