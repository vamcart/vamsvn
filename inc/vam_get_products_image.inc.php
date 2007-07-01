<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_products_image.inc.php 1009 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_get_products_name.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_products_name.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function vam_get_products_image($products_id = '') {

    $product_query = "select products_image from " . TABLE_PRODUCTS . " where products_id = '" . $products_id . "'";
    $product_query  = vamDBquery($product_query);
    $products_image = vam_db_fetch_array($product_query,true);

    return $products_image['products_image'];
  }
 ?>