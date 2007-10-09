<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_check_stock_attributes.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_check_stock_attributes.inc.php); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_check_stock_attributes.inc.php 2003/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function vam_check_stock_attributes($attribute_id, $products_quantity) {

       $stock_query=vam_db_query("SELECT
                                  attributes_stock
                                  FROM ".TABLE_PRODUCTS_ATTRIBUTES."
                                  WHERE products_attributes_id='".$attribute_id."'");
       $stock_data=vam_db_fetch_array($stock_query);
    $stock_left = $stock_data['attributes_stock'] - $products_quantity;
    $out_of_stock = '';

    if ($stock_left < 0) {
      $out_of_stock = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
    }

    return $out_of_stock;
  }
 ?>