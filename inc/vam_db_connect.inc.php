<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_db_connect.inc.php 1248 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
   (c) 2003	 nextcommerce (vam_db_connect.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_db_connect.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
 //  include(DIR_WS_CLASSES.'/adodb/adodb.inc.php');
  function vam_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link', $use_pconnect = USE_PCONNECT, $new_link = false) {
    global $$link;

    if ($use_pconnect == 'true') {
     $server = 'p:' . $server;
    }

    $$link = mysqli_connect($server, $username, $password, $database);

if ($$link){
   @mysqli_query($$link, "SET SQL_MODE= ''");
   @mysqli_query($$link, "SET SQL_BIG_SELECTS=1");
   @mysqli_query($$link, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
}

//Start VaM db-error processing
    if (!$$link) {
      $log = date("d/m/Y H:m:s",time()) . ' | ' . mysqli_errno($$link) . ' - ' . mysqli_error($$link) . "\n";
      $log_file = 'mysql_db_connect_error';
      $log_file = DIR_FS_CATALOG . '.logs/' . $log_file . '-' . date('Y-m-d') . '.log';
      error_log($log, 3, $log_file);
      vam_db_error("connect", mysqli_errno($$link), mysqli_error($$link));
    }
//End VaM db-error processing

    return $$link;
  }
 ?>