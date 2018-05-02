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
   (c) 2003	 nextcommerce (vam_db_query.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_db_query.inc.php,v 1.4 2004/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
  // include needed functions
  include_once(DIR_FS_INC . 'vam_db_error.inc.php');
  
  function vam_db_query($query, $link = 'db_link') {

  	if (!defined("STORE_DB_TRANSACTIONS")) define("STORE_DB_TRANSACTIONS", "false");

    global $$link;
    global $query_counts;
    $query_counts++; 
    //$$link = mysqli_connect('localhost', 'root', '', 'vamshop');
    //echo $query.'<br>';

    if (STORE_DB_TRANSACTIONS == 'true' && file_exists(STORE_PAGE_PARSE_TIME_LOG)) {
      error_log('QUERY ' . $query . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }
//    $queryStartTime = array_sum(explode(" ",microtime()));
    $result = mysqli_query($$link, $query) or vam_db_error($query, mysqli_errno($$link), mysqli_error($$link));
//	$queryEndTime = array_sum(explode(" ",microtime())); 
//	$processTime = $queryEndTime - $queryStartTime;
//	echo 'time: '.$processTime.' Query: '.$query.'<br>';


    if (STORE_DB_TRANSACTIONS == 'true' && file_exists(STORE_PAGE_PARSE_TIME_LOG)) {
       $result_error = mysqli_error($$link);
       error_log('RESULT ' . $result->current_field . ' ' . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

//Start VaM db-error processing
    if (!$result) {
      vam_db_error($query, mysqli_errno($$link), mysqli_error($$link));
    }
//End VaM db-error processing

    return $result;
  }
 ?>