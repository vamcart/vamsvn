<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_check_categories_status.inc.php 1009 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003     nextcommerce (vam_check_categories_status.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_check_categories_status.inc.php,v 1.3 2003/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function vam_check_categories_status($categories_id) {

	if (!$categories_id)
		return 0;

	$categorie_query = "SELECT
	                                   parent_id,
	                                   categories_status
	                                   FROM ".TABLE_CATEGORIES."
	                                   WHERE
	                                   categories_id = '".(int) $categories_id."'";

	$categorie_query = vamDBquery($categorie_query);

	$categorie_data = vam_db_fetch_array($categorie_query, true);
	if ($categorie_data['categories_status'] == 0) {
		return 1;
	} else {
		if ($categorie_data['parent_id'] != 0) {
			if (vam_check_categories_status($categorie_data['parent_id']) >= 1)
				return 1;
		}
		return 0;
	}

}

function vam_get_categoriesstatus_for_product($product_id) {

	$categorie_query = "SELECT
	                                   categories_id
	                                   FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
	                                   WHERE products_id='".$product_id."'";

	$categorie_query = vamDBquery($categorie_query);

	while ($categorie_data = vam_db_fetch_array($categorie_query, true)) {
		if (vam_check_categories_status($categorie_data['categories_id']) >= 1) {
			return 1;
		} else {
			return 0;
		}
		echo $categorie_data['categories_id'];
	}

}
?>