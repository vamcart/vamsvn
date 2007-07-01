<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_db_test_connection.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.2 2002/03/02); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_db_test_connection.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_db_test_connection.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
function vam_db_test_connection($database) {
    global $db_error;

    $db_error = false;

    if (!$db_error) {
      if (!@vam_db_select_db($database)) {
        $db_error = mysql_error();
      } else {
        if (!@vam_db_query_installer("select count(*) from " . TABLE_CONFIGURATION . "")) {
          $db_error = mysql_error();
        }
      }
    }

    if ($db_error) {
      return false;
    } else {
      return true;
    }
  }
 ?>