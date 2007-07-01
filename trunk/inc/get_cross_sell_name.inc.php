<?php
/* -----------------------------------------------------------------------------------------
   $Id: get_cross_sell_name.inc.php 1232 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003     nextcommerce (get_cross_sell_name.inc.php,v 1.54 2003/08/25); www.nextcommerce.org
   (c) 2004 xt:Commerce (get_cross_sell_name.inc.php,v 1.54 2003/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
 
 function vam_get_cross_sell_name($cross_sell_group, $language_id = '') {

	if (!$language_id)
		$language_id = $_SESSION['languages_id'];
	$cross_sell_query = vam_db_query("select groupname from ".TABLE_PRODUCTS_XSELL_GROUPS." where products_xsell_grp_name_id = '".$cross_sell_group."' and language_id = '".$language_id."'");
	$cross_sell = vam_db_fetch_array($cross_sell_query);

	return $cross_sell['groupname'];
}
?>
