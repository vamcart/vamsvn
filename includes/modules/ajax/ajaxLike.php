<?php
/* -----------------------------------------------------------------------------------------
   $Id: ajaxQuickFind.php 1243 2009-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 Andrew Berezin (ajaxQuickFind.php,v 1.9 2003/08/17); zen-cart.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$likes = '';

if (filter_var($_REQUEST['products_id'], FILTER_VALIDATE_INT)) {

	vam_db_query("update ".TABLE_PRODUCTS." set likes = likes+1 where products_id = '".(int)$_REQUEST['products_id']."'");
	
   $product_likes_query = vamDBquery("select likes from " . TABLE_PRODUCTS . " where products_id = '" . vam_db_input($_GET['products_id']) . "' limit 1");
   $product_likes = vam_db_fetch_array($product_likes_query,true);
   
   if ($product_likes['likes'] > 0) $likes = $product_likes['likes'];
   
}   

echo $likes;
