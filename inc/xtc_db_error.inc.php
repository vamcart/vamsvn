<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_db_error.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_db_error.inc.php,v 1.4 2003/08/19); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
//  function xtc_db_error($query, $errno, $error) { 
//    die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br /><br />' . $query . '<br /><br /><small><font color="#ff0000">[XT SQL Error]</font></small><br /><br /></b></font>');
//  }
  
function xtc_db_error($query, $errno, $error) {
//Start VaM db-error processing
   include(DIR_WS_LANGUAGES . 'russian/russian_db_error.php');
   $msg = "\n" . 'MYSQL QUERY ERROR REPORT' . "\n" . " - " . date("d/m/Y H:m:s",time()) . "\n" . '---------------------------------------' . "\n";
   $msg .= $errno . ' - ' . $error . "\n\n" . $query . "\n";
   $msg .= '---------------------------------------' . "\n";
   $msg .= 'Server Name: ' . $_SERVER['SERVER_NAME'] . "\n";
   $msg .= 'Remote Address: ' . $_SERVER['REMOTE_ADDR'] . "\n";
   $msg .= 'Referer: ' . $_SERVER["HTTP_REFERER"] . "\n";
   $msg .= 'Requested: ' . $_SERVER["REQUEST_URI"] . "\n";
   mail(DB_ERR_MAIL, 'Проблемы с MySQL сервером!', $msg,
        'From: db_error@'.$_SERVER["SERVER_NAME"]);
   die(DB_ERR_MSG);
}
//End VaM db-error processing
  
 ?>