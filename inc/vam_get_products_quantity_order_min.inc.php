<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_products_quantity_order_min.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2004 xt:Commerce (vam_get_qty.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  function vam_get_products_quantity_order_min($product_id) {

    $the_products_quantity_order_min_query = vam_db_query("select products_id, products_quantity_min from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    $the_products_quantity_order_min = vam_db_fetch_array($the_products_quantity_order_min_query);
    return $the_products_quantity_order_min['products_quantity_min'];
  }

?>