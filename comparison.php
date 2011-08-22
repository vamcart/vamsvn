<?php
/*
  $Id: comparison.php, v1.2 20101219 kymation Exp $
  $Loc: catalog/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/
/*
 * This file displays the product comparison table from the comparison module
 *   Specific products are shown if the customer has selected one or more
 *   products, otherwise the general comparison table with all products in
 *   the category is shown.
 *
 * $current_category_id is required to display the general comparison table
 * $comp_array is required to show the selected products
 */


  require_once ('includes/application_top.php');

  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');

  require_once (DIR_WS_LANGUAGES . $language . '/' . FILENAME_COMPARISON);

  if( $current_category_id == 0 ) {
    tep_redirect( tep_href_link( FILENAME_DEFAULT ) );
  } else {
    //Get the name for this category
    $title_query_raw = "
      select
        categories_name
      from
        " . TABLE_CATEGORIES_DESCRIPTION . "
      where
        categories_id = '" . ( int )$current_category_id . "'
    ";
    // print $title_query_raw . "<br>\n";
    $title_query = tep_db_query( $title_query_raw );
    $title_array = tep_db_fetch_array( $title_query );
    $heading_title = sprintf( HEADING_TITLE, $title_array['categories_name'] );
  }

  // Set up the array of product IDs that the customer has selected (if any)
  $comp_array = array();
  if (isset ($_GET['comp']) && $_GET['comp'] != '') {
    // Decode the URL-encoded names, including arrays
    $comp_array = tep_decode_recursive ($_GET['comp']);

    // Sanitize variables to prevent hacking
    $comp_array = tep_clean_get__recursive ($comp_array);
  }

  require( DIR_WS_INCLUDES . 'template_top.php' );

?>
<div class="contentContainer">
<?php
  if (count ($comp_array) > 0 or SPECIFICATIONS_COMPARISON_LAYOUT == 'horiz') {
    require_once (DIR_WS_MODULES . 'comparison_horiz.php');
  } else {
    require_once (DIR_WS_MODULES . FILENAME_COMPARISON);
  }
?>
<?php
  $filename_back = FILENAME_DEFAULT;
  $back = sizeof( $navigation->path ) - 2;
	if( isset( $navigation->path[ $back ] ) ) {
		$filename_back = $navigation->path[ $back ][ 'page' ];
	}
?>
  <div class="buttonSet" style="float:left;">
    <span class="buttonAction"><?php echo tep_draw_button( IMAGE_BUTTON_BACK, 'triangle-1-w', tep_href_link( $filename_back ), 'primary'); ?></span>
  </div>
</div>