<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_products_stock.inc.php 1009 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_get_products_stock.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_products_stock.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// BOF Bundled Products
////
// Return a product's stock
// TABLES: products
  function vam_get_products_stock($products_id) {
    $products_id = vam_get_prid($products_id);
    $stock_query = vam_db_query("select products_quantity, products_bundle from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'");
    $stock_values = vam_db_fetch_array($stock_query);
    if ($stock_values['products_bundle'] == 'yes') {
      $bundle_query = vam_db_query("select subproduct_id, subproduct_qty from " . TABLE_PRODUCTS_BUNDLES . " where bundle_id = " . (int)$products_id);
      $bundle_stock = array();
      while ($bundle_data = vam_db_fetch_array($bundle_query)) {
        $bundle_stock[] = intval(vam_get_products_stock($bundle_data['subproduct_id']) / $bundle_data['subproduct_qty']);
      }
      return min($bundle_stock); // return quantity of least plentiful subproduct
    } else {
      return $stock_values['products_quantity'];
    }
  }
// EOF Bundled Products

 ?>