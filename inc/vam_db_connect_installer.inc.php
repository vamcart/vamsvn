<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_db_connect_installer.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.2 2002/03/02); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_db_connect_installer.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_db_connect_installer.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function vam_db_connect_installer($server, $username, $password, $link = 'db_link') {
    global $$link, $db_error;

    $db_error = false;

    if (!$server) {
      $db_error = 'No Server selected.';
      return false;
    }

    $$link = mysqli_connect($server, $username, $password, $database);

	if ($$link){
	   @mysqli_query($$link, "SET SQL_MODE= ''");
	   @mysqli_query($$link, "SET SQL_BIG_SELECTS=1");
	   @mysqli_query($$link, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
	}


    return $$link;
  }
 ?>