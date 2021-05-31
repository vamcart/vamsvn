<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_db_query.inc.php 1195 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
   (c) 2003  nextcommerce (vam_db_query.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_db_query.inc.php,v 1.4 2004/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  // include needed functions
  include_once(DIR_FS_INC . 'vam_db_error.inc.php');

  function vam_db_query($query, $link = 'db_link') {
    global $$link;
    global $query_counts;
    $query_counts++;
    //$$link = mysqli_connect('localhost', 'root', '', 'vamshop');
    //echo $query.'<br>';

//if ($_SERVER['REQUEST_URI'] == '/') {

    if (STORE_DB_TRANSACTIONS == 'true' && file_exists(STORE_PAGE_PARSE_TIME_LOG)) {
      error_log('QUERY ' . $query . ";"."\n"."\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

//}
    
    $queryStartTime = microtime(true);
    $result = mysqli_query($$link, $query) or vam_db_error($query, mysqli_errno($$link), mysqli_error($$link));
    $processTime = microtime(true) - $queryStartTime;
    $log_file = '';
    if (defined('DIR_FS_ADMIN')) {
      $log_file = 'db_query_slow-adm';
      $max_time = 1.0;
    } else {
      $log_file = 'db_query_slow';
      $max_time = 2.0;
    }
    if ($processTime > $max_time) {
      $log_file = DIR_FS_CATALOG . '.logs/' . $log_file . '-' . date('Y-m-d') . '.log';
      $processTime = number_format($processTime, 6);
      $msg .= 'URI: ' . $_SERVER['REQUEST_URI'] . ";";
      $msg .= $processTime . ' ' . date('Y-m-d H:i:s') . ";" . $query . ";";
      ob_start();
      debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
      $dbg = ob_get_contents();
      ob_end_clean();
      $dbg = str_replace(DIR_FS_CATALOG, '', $dbg);
      $msg .= trim($dbg) . ";";
      $msg .= 'URI: ' . $_SERVER['REQUEST_URI'] . ";";
//      $msg .= 'IP: ' . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'not set') . ";";
      error_log('##### ' . $msg . ";", 3, $log_file);
    }
    if (substr(strtoupper($query), 0, 12) == 'ALTER TABLE ') {
      $log_file = 'db_query_alter.log';
      $log_file = DIR_FS_CATALOG . '.logs/' . $log_file;
      $processTime = number_format($processTime, 6);
      $msg = $processTime . ' ' . date('Y-m-d H:i:s') . ";" . $query . ";";
      ob_start();
      debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
      $dbg = ob_get_contents();
      ob_end_clean();
      $dbg = str_replace(DIR_FS_CATALOG, '', $dbg);
      $msg .= trim($dbg) . ";";
      $msg .= 'URI: ' . $_SERVER['REQUEST_URI'] . ";";
//      $msg .= 'IP: ' . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'not set') . ";";
      error_log('##### ' . $msg . ";", 3, $log_file);
    }


//  echo 'time: '.$processTime.' Query: '.$query.'<br>';

    $processTime = microtime(true) - $queryStartTime;
    $processTime = number_format($processTime, 6);
    $time .= 'URI: ' . $_SERVER['REQUEST_URI'] . ";";
    $time .= $processTime . '; ' . date('Y-m-d H:i:s') . ";" . $query . ";";

//if ($_SERVER['REQUEST_URI'] == '/') {


    if (STORE_DB_TRANSACTIONS == 'true' && file_exists(STORE_PAGE_PARSE_TIME_LOG)) {
       $result_error = mysqli_error($$link);
       error_log('RESULT;' . $time . ';' . $result->current_field . ';' . $result_error . ";", 3, STORE_PAGE_PARSE_TIME_LOG);
    }
    
//}    

//Start VaM db-error processing
    if (!$result) {
      vam_db_error($query, mysqli_errno($$link), mysqli_error($$link));
    }
//End VaM db-error processing

    return $result;
  }
 ?>