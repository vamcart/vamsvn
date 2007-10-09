<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_count_products_in_category.inc.php 1009 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_count_products_in_category.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_count_products_in_category.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function vam_count_products_in_category($category_id, $include_inactive = false) {
    $products_count = 0;
    if ($include_inactive == true) {
      $products_query = "select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = p2c.products_id and p2c.categories_id = '" . $category_id . "'";
    } else {
      $products_query = "select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = p2c.products_id and p.products_status = '1' and p2c.categories_id = '" . $category_id . "'";
    }

    $products_query = vamDBquery($products_query);

    $products = vam_db_fetch_array($products_query,true);
    $products_count += $products['total'];

    $child_categories_query = "select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . $category_id . "'";

    $child_categories_query = vamDBquery($child_categories_query);
    if (vam_db_num_rows($child_categories_query,true)) {
      while ($child_categories = vam_db_fetch_array($child_categories_query,true)) {
        $products_count += vam_count_products_in_category($child_categories['categories_id'], $include_inactive);
      }
    }


    return $products_count;
  }
 ?>