<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_findTitle.inc.php 1313 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_attributes); www.oscommerce.com
   (c) 2003     nextcommerce (new_attributes.php,v 1.13 2003/08/21); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_findTitle.inc.php,v 1.1 2004/08/25); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contributions:
   New Attribute Manager v4b                Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


  function vam_findTitle($current_pid, $languageFilter) {
    $query = "SELECT * FROM ".TABLE_PRODUCTS_DESCRIPTION."  where language_id = '" . $_SESSION['languages_id'] . "' AND products_id = '" . $current_pid . "'";

    $result = vam_db_query($query);

    $matches = vam_db_num_rows($result);

    if ($matches) {
      while ($line = vam_db_fetch_array($result)) {
        $productName = $line['products_name'];
      }
      return $productName;
    } else {
      return "Something isn't right....";
    }
  }
?>