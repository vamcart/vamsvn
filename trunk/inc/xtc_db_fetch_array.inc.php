<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_db_fetch_array.inc.php 864 2005-04-16 12:05:41Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_db_fetch_array.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
  /*
  function xtc_db_fetch_array($db_query) {
    return mysql_fetch_array($db_query, MYSQL_ASSOC);
  }
  */


  function xtc_db_fetch_array(&$db_query,$cq=false) {

      if (DB_CACHE=='true' && $cq) {
        if (!count($db_query)) return false;
        $curr = current($db_query);
        next($db_query);
        return $curr;
      } else {
          if (is_array($db_query)) {
          $curr = current($db_query);
          next($db_query);
          return $curr;
          }
        return mysql_fetch_array($db_query, MYSQL_ASSOC);
      }
  }

 ?>