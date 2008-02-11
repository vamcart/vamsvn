<?php
/* --------------------------------------------------------------
   $Id: vam_get_options_mo_images.inc.php 1101 2008-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2006	 xt:Commerce (xtc_get_options_mo_images.inc.php,v 1.4 2003/08/1); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

function vam_get_options_mo_images($id = '') {
	$mo_query = "select * from " . TABLE_PRODUCTS_OPTIONS_IMAGES . " where products_options_values_id = '" . $id . "' ORDER BY image_nr";

	$products_mo_images_query = vam_db_query($mo_query);

	while ($row = vam_db_fetch_array($products_mo_images_query, true))
		$results[$row['image_nr']-1] = $row;
	if (is_array($results)) {
		return $results;
	} else {
		return false;
	}
}
?>