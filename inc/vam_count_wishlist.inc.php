<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_count_wishlist.inc.php 975 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2004 xt:Commerce (vam_count_wishlist.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// counts total ammount of a product ID in wishlist.

function vam_count_wishlist() {

	$id_list = $_SESSION['wishlist']->get_product_id_list();

	$id_list = explode(', ', $id_list);

	$actual_content = array ();

	for ($i = 0, $n = sizeof($id_list); $i < $n; $i ++) {

		$actual_content[] = array ('id' => $id_list[$i], 'qty' => $_SESSION['wishlist']->get_quantity($id_list[$i]));

	}

	// merge product IDs
	$content = array ();
	for ($i = 0, $n = sizeof($actual_content); $i < $n; $i ++) {

		//$act_id=$actual_content[$i]['id'];
		if (strpos($actual_content[$i]['id'], '{')) {
			$act_id = substr($actual_content[$i]['id'], 0, strpos($actual_content[$i]['id'], '{'));
		} else {
			$act_id = $actual_content[$i]['id'];
		}

		$_SESSION['actual_content_wishlist'][$act_id] = array ('qty' => $_SESSION['actual_content_wishlist'][$act_id]['qty'] + $actual_content[$i]['qty']);

	}

}
?>