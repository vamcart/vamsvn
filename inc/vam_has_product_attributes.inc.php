<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_has_product_attributes.inc.php 1009 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_has_product_attributes.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_has_product_attributes.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

// Check if product has attributes
  function vam_has_product_attributes($products_id) {
    $attributes_query = "select count(*) as count from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $products_id . "'";
    $attributes_query  = vamDBquery($attributes_query);
    $attributes = vam_db_fetch_array($attributes_query,true);

    if ($attributes['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }
 ?>