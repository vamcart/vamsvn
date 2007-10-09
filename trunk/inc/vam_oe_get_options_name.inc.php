<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_oe_get_options_name.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_get_products_name.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_products_name.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function vam_oe_get_options_name($products_options_id, $language = '') {

    if (empty($language)) $language = $_SESSION['languages_id'];

    $product_query = vam_db_query("select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . $products_options_id . "' and language_id = '" . $language . "'");
    $product = vam_db_fetch_array($product_query);

    return $product['products_options_name'];
  }
 ?>