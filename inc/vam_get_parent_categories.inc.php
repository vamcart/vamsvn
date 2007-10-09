<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_parent_categories.inc.php 1009 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_get_parent_categories.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_parent_categories.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Recursively go through the categories and retreive all parent categories IDs
// TABLES: categories
  function vam_get_parent_categories(&$categories, $categories_id) {
    $parent_categories_query = "select parent_id from " . TABLE_CATEGORIES . " where categories_id = '" . $categories_id . "'";
    $parent_categories_query  = vamDBquery($parent_categories_query);
    while ($parent_categories = vam_db_fetch_array($parent_categories_query,true)) {
      if ($parent_categories['parent_id'] == 0) return true;
      $categories[sizeof($categories)] = $parent_categories['parent_id'];
      if ($parent_categories['parent_id'] != $categories_id) {
        vam_get_parent_categories($categories, $parent_categories['parent_id']);
      }
    }
  }
 ?>