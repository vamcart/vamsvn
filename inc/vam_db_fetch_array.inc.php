<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_db_fetch_array.inc.php 864 2008-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_db_fetch_array.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_db_fetch_array.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
  /*
  function vam_db_fetch_array($db_query) {
    return mysqli_fetch_array($db_query, MYSQLI_ASSOC);
  }
  */


  function vam_db_fetch_array(&$db_query,$cq=false) {

      if (DB_CACHE=='true' && $cq) {
        if (!count($db_query)) return false;
        if (is_array($db_query)) {
        $curr = current($db_query);
        next($db_query);
        }
        return $curr;
      } else {
          if (is_array($db_query)) {
          $curr = current($db_query);
          next($db_query);
          return $curr;
          }
        if (empty($db_query)) return false;
        return mysqli_fetch_array($db_query, MYSQLI_ASSOC);
      }
  }

 ?>