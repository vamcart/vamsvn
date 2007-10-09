<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_subcategories.inc.php 976 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_get_subcategories.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_subcategories.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function vam_get_subcategories(&$subcategories_array, $parent_id = 0) {
    $subcategories_query = "select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . $parent_id . "'";
    $subcategories_query  = vamDBquery($subcategories_query);
    while ($subcategories = vam_db_fetch_array($subcategories_query,true)) {
      $subcategories_array[sizeof($subcategories_array)] = $subcategories['categories_id'];
      if ($subcategories['categories_id'] != $parent_id) {
        vam_get_subcategories($subcategories_array, $subcategories['categories_id']);
      }
    }
  }
 ?>