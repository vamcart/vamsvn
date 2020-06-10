<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_db_error.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
   (c) 2003	 nextcommerce (vam_db_error.inc.php,v 1.4 2003/08/19); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_db_error.inc.php,v 1.4 2004/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

//  function vam_db_error($query, $errno, $error) {
//    die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br /><br />' . $query . '<br /><br /><small><font color="#ff0000">[XT SQL Error]</font></small><br /><br /></b></font>');
//  }

function vam_db_error($query, $errno, $error) {
// BOF db-error processing
  include(DIR_WS_LANGUAGES . 'russian/russian_db_error.php');
  $msg = "\n" . 'MYSQL ERROR REPORT' . "\n" . " - " . date("d/m/Y H:m:s",time()) . "\n" . '---------------------------------------' . "\n";
  $msg .= $errno . ' - ' . $error . "\n\n" . $query . "\n";
  $msg .= '---------------------------------------' . "\n";
  $msg .= 'Server Name   : ' . $_SERVER['SERVER_NAME'] . "\n";
  $msg .= 'Remote Address: ' . $_SERVER['REMOTE_ADDR'] . "\n";
  $msg .= 'Referer       : ' . $_SERVER["HTTP_REFERER"] . "\n";
  $msg .= 'Requested     : ' . $_SERVER["REQUEST_URI"] . "\n";
  ob_start();
  debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
  $backtrace = ob_get_contents();
  ob_end_clean();
  $msg .= 'Trace Back    : ' . $backtrace . "\n";;
  if (defined('DEBUG') && DEBUG == true) {
  	echo(nl2br($msg));
  	die('==========================================================================');
  }
  $log = date("d/m/Y H:m:s",time()) . ' | ' . $errno . ' - ' . $error . ' | ' . $query . ' | ' . $_SERVER["REQUEST_URI"] . ' | ' . $backtrace . "\n";
  if ($query == '') {
    error_log($log, 3, DIR_FS_CATALOG . '.logs/' . 'mysql_db_error-connect.log');
  } else {
    $log_file = 'mysql_db_error';
    if (defined('DIR_FS_ADMIN')) {
      $log_file .= '-adm';
    }
    $log_file = DIR_FS_CATALOG . '.logs/' . $log_file . '-' . date('Y-m-d') . '.log';
    error_log($log, 3, $log_file);
//    error_log($log, 3, DIR_FS_CATALOG . '.logs/' . 'mysql_db_error.log');
  }
	echo(nl2br($msg));
	die('==========================================================================');
//   mail(DB_ERR_MAIL, 'MySQL DB Error!', $msg, 'From: db_error@'.$_SERVER["SERVER_NAME"]);
  if (!headers_sent() && file_exists('db_error.htm') ) {
    header('Location: db_error.htm');
     //include('db_error.htm');
  }
  die(DB_ERR_MSG);
}

// EOF db-error processing
